<?php
class NhaCungCapController extends BaseController
{
    private $nhaCungCapModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->nhaCungCapModel = new NhaCungCapModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->nhaCungCapModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->nhaCungCapModel->countRow())[0];
        }
        $nhaCungCap      = [];
        if (!empty($page)) {
            $nhaCungCap   = $this->nhaCungCapModel->get($page);
        } else {
            $nhaCungCap = $this->nhaCungCapModel->get($this->getPage());
        }
        $numOfPages = $this->getNumOfPages($nhaCungCap['pages']);

        $nhaCungCap['pages'] = $numOfPages;



        return $nhaCungCap;
    }

    public function add($data)
    {
        if (
            $data['tenNCC']
            && $data['diaChi']
            && $data['soDienThoai']
        ) {
            $values = $this->getValues($data);
            $this->nhaCungCapModel->post($values);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maNCC']
            && $data['tenNCC']
            && $data['diaChi']
            && $data['soDienThoai']
        ) {
            $id = $data['maNCC'];
            $values = $this->getValues($data);
            $this->nhaCungCapModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maNCC']
        ) {
            $remove = [
                'id' => $data['maNCC'],
            ];
            $this->nhaCungCapModel->delete($remove);
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
            $found = $this->nhaCungCapModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;



            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->nhaCungCapModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->nhaCungCapModel->getMinCol($col);


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
            $filtered = $this->nhaCungCapModel->filter($filterValues, $this->getPage());
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
            $sorted = $this->nhaCungCapModel->sort($data, $this->getPage());
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
            'tenNCC' => $data['tenNCC'],
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

    public function selectDisplay()
    {
        return $this->nhaCungCapModel->selectDisplay();
    }

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->getPage()['current'] > $numOfPages) {
            die('NhaCungCap - 202: ERROR');
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
