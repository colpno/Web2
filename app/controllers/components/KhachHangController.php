<?php
class KhachHangController extends BaseController
{
    private $khachHangModel;
    private $taikhoanModel;
    private $AllRowLength;
    private $uploadInstance;
    private $alert;

    public function __construct()
    {
        $this->khachHangModel = new KhachHangModel();

        $this->alert = new Other();
    }

    public function findMax($col)
    {
        $found = $this->khachHangModel->getMaxCol($col);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->khachHangModel->getMinCol($col);

        return $found;
    }

    public function countRow($col)
    {
        $number = $this->khachHangModel->countRow($col);

        return $number;
    }

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->khachHangModel->countRow())[0];
        }
        $khachHang = $this->khachHangModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages();

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($khachHang);

        return [
            'KHArr' => $khachHang,
            'KHPages' => $numOfPages
        ];
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
            $maxID = array_values($this->khachHangModel->getMaxCol())[0];
            $fileName = "KH-" .  ($maxID + 1);

            $values = $this->getValues($data);;
            $this->khachHangModel->post($values, $maxID + 1);
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
            $values = $this->getValues($data);
            $this->khachHangModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maKH']
        ) {
            $this->khachHangModel->delete($data['maKH']);
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'KHFound' => $found,
                'KHFoundPages' => $numOfPages
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findWithFilter($data)
    {
        if (
            $data['search']
            && $data['filterCol']
            && $data['from']
            && $data['to']
        ) {
            $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
            $found = $this->khachHangModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'KHFound' => $found,
                'KHFoundPages' => $numOfPages
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findWithSort($data)
    {
        if (
            $data['search']
            && $_GET['sortCol']
            && $_GET['order']
        ) {
            $sortValues = $this->getSortValues();
            $found = $this->khachHangModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'KHFound' => $found,
                'KHFoundPages' => $numOfPages
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findWithFilterAndSort($data)
    {
        if (
            $data['search']
            && $data['filterCol']
            && $data['from']
            && $data['to']
        ) {
            $sortValues = $this->getSortValues();
            $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
            $found = $this->khachHangModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'KHFound' => $found,
                'KHFoundPages' => $numOfPages
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
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
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'KHFiltered' => $filtered,
                'KHFilteredPages' => $numOfPages
            ];
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
            $numOfPages = $this->getNumOfPages($sorted);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($sorted);

            return [
                'KHSorted' => $sorted,
                'KHSortedPages' => $numOfPages
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    public function filterAndSort($data)
    {
        if (
            $data['filterCol']
            && $data['from']
            && $data['to']
            && $_GET['sortCol']
            && $_GET['order']
        ) {
            $sortValues = $this->getSortValues();
            $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
            $filtered = $this->khachHangModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'KHFiltered' => $filtered,
                'KHFilteredPages' => $numOfPages
            ];
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

    private function getNumOfPages($list = [])
    {
        if (empty($list)) {
            return ceil($this->AllRowLength / $this->getPage()['limit']);
        } else {
            return ceil(count($list) / $this->getPage()['limit']);
        }
    }

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->getPage()['current'] > $numOfPages) {
            die('ERROR');
        }
    }

    private function changeProp(&$list)
    {
        require_once(__DIR__ . '/../models/TaiKhoanModel.php');

        $this->taikhoanModel = new TaiKhoanModel();

        $length = count($list);
        for ($i = 0; $i < $length; $i++) {
            $list[$i]['taikhoan'] = $this->taikhoanModel->getRow('maTK', $list[$i]['maTK']);
            unset($list[$i]['maTK']);
        }
        return $list;
    }

    private function getPage()
    {
        return [
            'current' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => 15
        ];
    }
}
