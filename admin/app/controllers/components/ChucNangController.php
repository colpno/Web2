<?php
class ChucNangController extends BaseController
{
    private $chucNangModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->chucNangModel = new ChucNangModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->chucNangModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->chucNangModel->countRow())[0];
        }
        $chucNang   = [];
        if (!empty($page)) {
            $chucNang  = $this->chucNangModel->get($page);
        } else {
            $chucNang = $this->chucNangModel->get($this->getPage());
        }
        $numOfPages = $this->getNumOfPages($chucNang['pages']);

        $chucNang['pages'] = $numOfPages;



        return $chucNang;
    }

    public function add($data)
    {
        if (
            $data['tenCN']
        ) {
            require_once(__DIR__ . '/../../models/QuyenModel.php');

            $quyenModel = new QuyenModel();
            $quyen  = $quyenModel->get($this->getPage());

            $values = $this->getValues($data);
            $this->chucNangModel->post($values, $quyen);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maCN']
            && $data['tenCN']
        ) {
            $id = $data['maSP'];
            //  
            $values = $this->getValues($data);
            $this->chucNangModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maCN']
        ) {
            $remove = [
                'id' => $data['maSP'],
                'imgPath' => $data['anhDaiDien']
            ];
            $this->chucNangModel->delete($remove);
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
            $found = $this->chucNangModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;



            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->chucNangModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->chucNangModel->getMinCol($col);


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
            $filtered = $this->chucNangModel->filter($filterValues, $this->getPage());
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
            $sorted = $this->chucNangModel->sort($sortValues, $this->getPage());
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
            'tenCN' => $data['tenCN'],
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
