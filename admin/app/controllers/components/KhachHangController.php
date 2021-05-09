<?php
class KhachHangController extends BaseController
{
    private $khachHangModel;
    private $taikhoanModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->khachHangModel = new KhachHangModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->khachHangModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->khachHangModel->countRow())[0];
        }
        $khachHang   = [];
        if (!empty($page)) {
            $khachHang  = $this->khachHangModel->get($page);
        } else {
            $khachHang = $this->khachHangModel->get($this->getPage());
        }
        $numOfPages = $this->getNumOfPages($khachHang['pages']);

        $khachHang['pages'] = $numOfPages;


        $this->changeProp($khachHang['data']);

        return $khachHang;
    }

    public function add($data)
    {
        if (
            $data['maTK']
            && $data['ho']
            && $data['ten']
            && $data['soDienThoai']
            && $data['ngaySinh']
            && $data['diaChi']
        ) {
            $values = $this->getValues($data);
            $this->khachHangModel->post($values);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maKH']
            && $data['maTK']
            && $data['ho']
            && $data['ten']
            && $data['soDienThoai']
            && $data['ngaySinh']
            && $data['diaChi']
        ) {
            $id = $data['maKH'];
            //  
            $values = $this->getValues($data);
            $this->khachHangModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (isset($data['maTK'])) {
            $data['maKH'] = $data['maTK'];
        }
        if (
            $data['maKH']
        ) {
            $remove = [
                'id' => $data['maKH'],
            ];
            if (isset($data['maTK'])) {
                return $this->khachHangModel->delete($remove, 'maTK');
            }
            $this->khachHangModel->delete($remove, 'maKH');
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để xóa");
        }
    }

    public function find($data)
    {
        if (
            $data['search']
        ) {
            $found = $this->khachHangModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;


            $this->changeProp($found['data']);

            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->khachHangModel->getMaxCol($col);

        $this->changeProp($found['data']);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->khachHangModel->getMinCol($col);

        $this->changeProp($found['data']);

        return $found;
    }

    public function filter($data)
    {
        if (
            $data['filterCol']
            && $data['from']
            && $data['to']
        ) {
            $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
            $filtered = $this->khachHangModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;


            $this->changeProp($filtered['data']);

            return $filtered;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    public function sort()
    {
        if (
            $_GET['sortCol']
            && $_GET['order']
        ) {
            $sortValues = $this->getSortValues();
            $sorted = $this->khachHangModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted['pages']);

            $sorted['pages'] = $numOfPages;


            $this->changeProp($sorted['data']);

            return $sorted;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    private function getValues($data)
    {
        return [
            'maTK' => $data['maTK'],
            'ho' => $data['ho'],
            'ten' => $data['ten'],
            'soDienThoai' => $data['soDienThoai'],
            'ngaySinh' => $data['ngaySinh'],
            'diaChi' => $data['diaChi'],
        ];
    }

    private function getSortValues()
    {
        return [
            'sortCol' => $_GET['sortCol'],
            'order' => $_GET['order']
        ];
    }

    private function getFilterValues($col, $from, $to)
    {
        return [
            'filterCol' => $col,
            'from' => $from,
            'to' => $to
        ];
    }

    private function getNumOfPages($number)
    {
        return ceil((int) $number / $this->getPage()['limit']);
    }

    public function selectDisplay()
    {
        return $this->khachHangModel->selectDisplay();
    }

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->getPage()['current'] > $numOfPages) {
            die('ERROR');
        }
    }

    private function changeProp(&$list)
    {
        require_once(__DIR__ . '/../../models/TaiKhoanModel.php');

        $this->taikhoanModel = new TaiKhoanModel();

        if ($list != null) {
            $length = count($list);
            for ($i = 0; $i < $length; $i++) {
                $list[$i]['taikhoan'] = $this->taikhoanModel->getRow('maTK', $list[$i]['maTK']);
                unset($list[$i]['maTK']);
            }
            return $list;
        }
    }

    private function getPage()
    {
        return [
            'current' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => $this->limit
        ];
    }
}
