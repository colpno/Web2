<?php
class QuyenController extends BaseController
{
    private $quyenModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->quyenModel = new QuyenModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->quyenModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->quyenModel->countRow())[0];
        }
        $quyen   = [];
        if (!empty($page)) {
            $quyen  = $this->quyenModel->get($page);
        } else {
            $quyen = $this->quyenModel->get($this->getPage());
        }
        $numOfPages = $this->getNumOfPages($quyen['pages']);

        $quyen['pages'] = $numOfPages;



        return $quyen;
    }

    public function add($data)
    {
        if (
            $data['tenQuyen']
        ) {
            require_once(__DIR__ . '/../../models/ChucNangModel.php');

            $chucNangModel = new ChucNangModel();
            $chucNang  = $chucNangModel->get($this->getPage());

            $values = $this->getValues($data);
            $this->quyenModel->post($values, $chucNang);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maQuyen']
            && $data['tenQuyen']
        ) {
            $id = $data['maSP'];
            //  
            $values = $this->getValues($data);
            $this->quyenModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maQuyen']
        ) {
            $remove = [
                'id' => $data['maQuyen'],
            ];
            $this->quyenModel->delete($remove);
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
            $found = $this->quyenModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;



            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->quyenModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->quyenModel->getMinCol($col);


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
            $filtered = $this->quyenModel->filter($filterValues, $this->getPage());
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
            $sorted = $this->quyenModel->sort($sortValues, $this->getPage());
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
            'tenQuyen' => $data['tenQuyen'],
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
        return $this->quyenModel->selectDisplay();
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
