<?php
class KhuyenMaiController extends BaseController
{
    private $khuyenMaiModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->khuyenMaiModel = new KhuyenMaiModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->khuyenMaiModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->khuyenMaiModel->countRow())[0];
        }
        $khuyenMai   = [];
        if (!empty($page)) {
            $khuyenMai  = $this->khuyenMaiModel->get($page);
        } else {
            $khuyenMai = $this->khuyenMaiModel->get($this->getPage(), '');
        }
        $numOfPages = $this->getNumOfPages($khuyenMai['pages']);

        $khuyenMai['pages'] = $numOfPages;



        return $khuyenMai;
    }

    public function selectDisplay()
    {
        return $this->sanPhamModel->selectDisplay();
    }

    public function add($data)
    {
        if (
            $data['tenKM']
            && $data['ngayBatDau']
            && $data['ngayKetThuc']
        ) {
            $values = $this->getValues($data);
            $this->khuyenMaiModel->post($values);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maKM']
            && $data['tenKM']
            && $data['ngayBatDau']
            && $data['ngayKetThuc']
        ) {
            $id = $data['maKM'];
            //  
            $values = $this->getValues($data);
            $this->khuyenMaiModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maKM']
        ) {
            $remove = [
                'id' => $data['maKM'],
            ];
            $this->khuyenMaiModel->delete($remove);
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
            $found = $this->khuyenMaiModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;



            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->khuyenMaiModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->khuyenMaiModel->getMinCol($col);


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
            $filtered = $this->khuyenMaiModel->filter($filterValues, $this->getPage());
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
            $sorted = $this->khuyenMaiModel->sort($sortValues, $this->getPage());
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
            'tenKM' => $data['tenKM'],
            'ngayBatDau' => $data['ngayBatDau'],
            'ngayKetThuc' => $data['ngayKetThuc'],
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
