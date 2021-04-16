<?php
class ChucNangController extends BaseController
{
    private $chucNangModel;
    private $AllRowLength;
    private $uploadInstance;
    private $alert;

    public function __construct()
    {
        $this->chucNangModel = new ChucNangModel();

        $this->alert = new Other();
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

    public function countRow($col)
    {
        $number = $this->chucNangModel->countRow($col);

        return $number;
    }

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->chucNangModel->countRow())[0];
        }
        $chucNang = $this->chucNangModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages();

        $this->dieIfPageNotValid($numOfPages);

        return [
            'CNArr' => $chucNang,
            'CNPages' => $numOfPages
        ];
    }

    public function add($data)
    {
        if (
            $data['tenCN']
        ) {
            $maxID = array_values($this->chucNangModel->getMaxCol())[0];
            $fileName = "CN-" .  ($maxID + 1);

            $values = $this->getValues($data);;
            $this->chucNangModel->post($values, $maxID + 1);
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
            $id = $data['maCN'];
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
            $this->chucNangModel->delete($data['maCN']);
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CNFound' => $found,
                'CNFoundPages' => $numOfPages
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
            $found = $this->chucNangModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CNFound' => $found,
                'CNFoundPages' => $numOfPages
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
            $found = $this->chucNangModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CNFound' => $found,
                'CNFoundPages' => $numOfPages
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
            $found = $this->chucNangModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CNFound' => $found,
                'CNFoundPages' => $numOfPages
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
            $filtered = $this->chucNangModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CNFiltered' => $filtered,
                'CNFilteredPages' => $numOfPages
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
            $sorted = $this->chucNangModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CNSorted' => $sorted,
                'CNSortedPages' => $numOfPages
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
            $filtered = $this->chucNangModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CNFiltered' => $filtered,
                'CNFilteredPages' => $numOfPages
            ];
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

    private function getPage()
    {
        return [
            'current' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => 15
        ];
    }
}
