<?php
class NhanVienController extends BaseController
{
    private $nhanVienModel;
    private $taikhoanModel;
    private $AllRowLength;
    private $uploadInstance;
    private $alert;

    public function __construct()
    {
        $this->nhanVienModel = new NhanVienModel();

        $this->alert = new Other();
    }

    public function findMax($col)
    {
        $found = $this->nhanVienModel->getMaxCol($col);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->nhanVienModel->getMinCol($col);

        return $found;
    }

    public function countRow($col)
    {
        $number = $this->nhanVienModel->countRow($col);

        return $number;
    }

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->nhanVienModel->countRow())[0];
        }
        $nhanVien = $this->nhanVienModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages();

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($nhanVien);

        return [
            'NVArr' => $nhanVien,
            'NVPages' => $numOfPages
        ];
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
            $maxID = array_values($this->nhanVienModel->getMaxCol())[0];
            $fileName = "NV-" .  ($maxID + 1);

            $values = $this->getValues($data);;
            $this->nhanVienModel->post($values, $maxID + 1);
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
            $this->nhanVienModel->delete($data['maNV']);
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'NVFound' => $found,
                'NVFoundPages' => $numOfPages
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
            $found = $this->nhanVienModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'NVFound' => $found,
                'NVFoundPages' => $numOfPages
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
            $found = $this->nhanVienModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'NVFound' => $found,
                'NVFoundPages' => $numOfPages
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
            $found = $this->nhanVienModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'NVFound' => $found,
                'NVFoundPages' => $numOfPages
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
            $filtered = $this->nhanVienModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'NVFiltered' => $filtered,
                'NVFilteredPages' => $numOfPages
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
            $sorted = $this->nhanVienModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($sorted);

            return [
                'NVSorted' => $sorted,
                'NVSortedPages' => $numOfPages
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
            $filtered = $this->nhanVienModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'NVFiltered' => $filtered,
                'NVFilteredPages' => $numOfPages
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
