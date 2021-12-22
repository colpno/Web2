<?php
class NhaSanXuatController extends BaseController
{
    private $nhaSanXuatModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->nhaSanXuatModel = new NhaSanXuatModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->nhaSanXuatModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->nhaSanXuatModel->countRow())[0];
        }
        $nhaSanXuat = [];
        if (!empty($page)) {
            $nhaSanXuat = $this->nhaSanXuatModel->get($page);
        } else {
            $nhaSanXuat = $this->nhaSanXuatModel->get($this->getPage());
        }
        $numOfPages = $this->getNumOfPages($nhaSanXuat['pages']);

        $nhaSanXuat['pages'] = $numOfPages;



        return $nhaSanXuat;
    }

    public function selectDisplay()
    {
        return $this->nhaSanXuatModel->selectDisplay();
    }

    public function add($data)
    {
        if (
            $data['tenNSX']
            && $data['diaChi']
            && $data['soDienThoai']
        ) {
            $values = $this->getValues($data);
            $this->nhaSanXuatModel->post($values);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maNSX']
            && $data['tenNSX']
            && $data['diaChi']
            && $data['soDienThoai']
        ) {
            $id = $data['maNSX'];
            $values = $this->getValues($data);
            $this->nhaSanXuatModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maNSX']
        ) {
            $remove = [
                'id' => $data['maNSX'],
            ];
            $this->nhaSanXuatModel->delete($remove);
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
            $found = $this->nhaSanXuatModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;



            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->nhaSanXuatModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->nhaSanXuatModel->getMinCol($col);


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
            $filtered = $this->nhaSanXuatModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;



            return $filtered;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    public function sort($data)
    {
        if (
            $data['sortCol']
            && $data['order']
        ) {
            $sorted = $this->nhaSanXuatModel->sort($data, $this->getPage());
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
            'tenNSX' => $data['tenNSX'],
            'diaChi' => $data['diaChi'],
            'soDienThoai' => $data['soDienThoai'],
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
            die('NhaSanXuat - 199: ERROR');
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
