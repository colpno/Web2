<?php
class ChiTietKhuyenMaiController extends BaseController
{
    private $chiTietKhuyenMaiModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->chiTietKhuyenMaiModel = new ChiTietKhuyenMaiModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->chiTietKhuyenMaiModel->countRow($col);

        return $number;
    }

    public function get($id = [], $page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->chiTietKhuyenMaiModel->countRow())[0];
        }
        $chiTietKhuyenMai      = [];
        if (!empty($page)) {
            $chiTietKhuyenMai   = $this->chiTietKhuyenMaiModel->get($page, $id);
        } else {
            $chiTietKhuyenMai = $this->chiTietKhuyenMaiModel->get($this->getPage(), $id);
        }
        $numOfPages = $this->getNumOfPages($chiTietKhuyenMai['pages']);

        $chiTietKhuyenMai['pages'] = $numOfPages;



        return $chiTietKhuyenMai;
    }

    public function add($data)
    {
        if (
            $data['maKM']
            && $data['maSP']
            && $data['hinhThucKhuyenMai']
            && $data['phanTramKhuyenMai']
        ) {
            $values = $this->getValues($data);
            $this->chiTietKhuyenMaiModel->post($values);
            return;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maKM']
            && $data['maSP']
            && $data['hinhThucKhuyenMai']
            && $data['phanTramKhuyenMai']
        ) {
            $id = $data['maSP'];
            $values = $this->getValues($data);
            $this->chiTietKhuyenMaiModel->update($values, $id);
            return;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maSP']
        ) {
            $remove = [
                'id' => $data['maSP'],
            ];
            $this->chiTietKhuyenMaiModel->delete($remove);
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
            $found = $this->chiTietKhuyenMaiModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;



            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->chiTietKhuyenMaiModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->chiTietKhuyenMaiModel->getMinCol($col);


        return $found;
    }

    public function filter($data)
    {
        if (
            $data['filterCol']
            && $data['from']
            && $data['to']
            && $data['maKM']
        ) {
            $filterValues = $this->getFilterValues($data);
            $filtered = $this->chiTietKhuyenMaiModel->filter($filterValues, $this->getPage());
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
            $sorted = $this->chiTietKhuyenMaiModel->sort($sortValues, $this->getPage());
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
            'maKM' => $data['maKM'],
            'maSP' => $data['maSP'],
            'hinhThucKhuyenMai' => $data['hinhThucKhuyenMai'],
            'phanTramKhuyenMai' => $data['phanTramKhuyenMai'],
        ];
    }

    private function getSortValues()
    {
        return [
            'sortCol' => $_GET['sortCol'],
            'order' => $_GET['order']
        ];
    }

    private function getFilterValues($data)
    {
        $data['col'] = 'maKM';
        $data['id'] = $data['maKM'];
        return $data;
    }

    private function getNumOfPages($number)
    {
        return ceil((int) $number / $this->getPage()['limit']);
    }

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->getPage()['current'] > $numOfPages) {
            die('chitietkhuyenmai: ERROR');
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
