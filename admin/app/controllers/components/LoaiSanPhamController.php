<?php
class LoaiSanPhamController extends BaseController
{
    private $loaiSanPhamModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->loaiSanPhamModel = new LoaiSanPhamModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->loaiSanPhamModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->loaiSanPhamModel->countRow())[0];
        }
        $loaiSanPham      = [];
        if (!empty($page)) {
            $loaiSanPham   = $this->loaiSanPhamModel->get($page);
        } else {
            $loaiSanPham = $this->loaiSanPhamModel->get($this->getPage());
        }
        $numOfPages = $this->getNumOfPages($loaiSanPham['pages']);

        $loaiSanPham['pages'] = $numOfPages;



        return $loaiSanPham;
    }

    public function selectDisplay()
    {
        return $this->loaiSanPhamModel->selectDisplay();
    }

    public function add($data)
    {
        if (
            $data['tenLoai']
        ) {
            $values = $this->getValues($data);
            $this->loaiSanPhamModel->post($values);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maLoai']
            && $data['tenLoai']
        ) {
            $id = $data['maLoai'];
            //  
            $values = $this->getValues($data);
            $this->loaiSanPhamModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maLoai']
        ) {
            $remove = [
                'id' => $data['maLoai'],
            ];
            $this->loaiSanPhamModel->delete($remove);
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
            $found = $this->loaiSanPhamModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;



            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->loaiSanPhamModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->loaiSanPhamModel->getMinCol($col);


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
            $filtered = $this->loaiSanPhamModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;



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
            $sorted = $this->loaiSanPhamModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted['pages']);

            $sorted['pages'] = $numOfPages;



            return $sorted;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    private function getValues($data)
    {
        return [
            'tenLoai' => $data['tenLoai'],
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

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->getPage()['current'] > $numOfPages) {
            die('ERROR');
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
