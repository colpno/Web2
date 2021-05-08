<?php
class NhanVienController extends BaseController
{
    private $nhanVienModel;
    private $taikhoanModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->nhanVienModel = new NhanVienModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->nhanVienModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->nhanVienModel->countRow())[0];
        }
        $nhanVien   = [];
        if (!empty($page)) {
            $nhanVien  = $this->nhanVienModel->get($page);
        } else {
            $nhanVien = $this->nhanVienModel->get($this->getPage());
        }
        $numOfPages = $this->getNumOfPages($nhanVien['pages']);

        $nhanVien['pages'] = $numOfPages;


        $this->changeProp($nhanVien['data']);

        return $nhanVien;
    }

    public function add($data)
    {
        if (
            $data['maTK']
            && $data['ho']
            && $data['ten']
            && $data['ngaySinh']
            && $data['diaChi']
            && $data['soDienThoai']
            && $data['luong']
        ) {
            $values = $this->getValues($data);
            $this->nhanVienModel->post($values);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maNV']
            && $data['maTK']
            && $data['ho']
            && $data['ten']
            && $data['soDienThoai']
            && $data['ngaySinh']
            && $data['diaChi']
            && $data['luong']
        ) {
            $id = $data['maNV'];
            //  
            $values = $this->getValues($data);
            $this->nhanVienModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maNV']
        ) {
            $remove = [
                'id' => $data['maNV'],
            ];
            $this->nhanVienModel->delete($remove);
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
            $found = $this->nhanVienModel->find($data['search'], $this->getPage());
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
        $found = $this->nhanVienModel->getMaxCol($col);

        $this->changeProp($found['data']);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->nhanVienModel->getMinCol($col);

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
            $filtered = $this->nhanVienModel->filter($filterValues, $this->getPage());
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
            $sorted = $this->nhanVienModel->sort($sortValues, $this->getPage());
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
            'ngaySinh' => $data['ngaySinh'],
            'diaChi' => $data['diaChi'],
            'soDienThoai' => $data['soDienThoai'],
            'luong' => $data['luong'],
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
        return $this->nhanVienModel->selectDisplay();
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

    public function thongke($year = null, $yearCol = null, ...$cols)
    {
        return $this->nhanVienModel->thongke($year, $yearCol, ...$cols);
    }
}
