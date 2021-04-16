<?php
class ChiTietKhuyenMaiController extends BaseController
{
    private $chiTietKhuyenMaiModel;
    private $AllRowLength;
    private $uploadInstance;
    private $alert;

    public function __construct()
    {
        $this->chiTietKhuyenMaiModel = new ChiTietKhuyenMaiModel();

        $this->alert = new Other();
    }

    public function findMax($col)
    {
        $found = $this->chiTietKhuyenMaiModel->getMaxCol($col);

        return $found;
    }

    public function findMin($col)
    {
        $found = $this->chiTietKhuyenMaiModel->getMinCol($col);

        return $found;
    }

    public function countRow($col)
    {
        $number = $this->chiTietKhuyenMaiModel->countRow($col);

        return $number;
    }

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->chiTietKhuyenMaiModel->countRow())[0];
        }
        $chiTietKhuyenMai = $this->chiTietKhuyenMaiModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages();

        $this->dieIfPageNotValid($numOfPages);

        return [
            'CTKMArr' => $chiTietKhuyenMai,
            'CTKMPages' => $numOfPages
        ];
    }

    public function add($data)
    {
        if (
            $data['maKM']
            && $data['maSP']
            && $data['hinhThucKhuyenMai']
            && $data['phanTramKhuyenMai']
        ) {
            $maxID = array_values($this->chiTietKhuyenMaiModel->getMaxCol())[0];
            $fileName = "CTKM-" .  ($maxID + 1);

            $values = $this->getValues($data);;
            $this->chiTietKhuyenMaiModel->post($values, $maxID + 1);
            return $this->get();
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
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maSP']
        ) {
            $this->chiTietKhuyenMaiModel->delete($data['maSP']);
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTKMFound' => $found,
                'CTKMFoundPages' => $numOfPages
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
            $found = $this->chiTietKhuyenMaiModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTKMFound' => $found,
                'CTKMFoundPages' => $numOfPages
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
            $found = $this->chiTietKhuyenMaiModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTKMFound' => $found,
                'CTKMFoundPages' => $numOfPages
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
            $found = $this->chiTietKhuyenMaiModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTKMFound' => $found,
                'CTKMFoundPages' => $numOfPages
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
            $filtered = $this->chiTietKhuyenMaiModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTKMFiltered' => $filtered,
                'CTKMFilteredPages' => $numOfPages
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
            $sorted = $this->chiTietKhuyenMaiModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTKMSorted' => $sorted,
                'CTKMSortedPages' => $numOfPages
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
            $filtered = $this->chiTietKhuyenMaiModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTKMFiltered' => $filtered,
                'CTKMFilteredPages' => $numOfPages
            ];
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