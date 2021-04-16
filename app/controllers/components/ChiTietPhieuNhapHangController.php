<?php
class ChiTietPhieuNhapHangController extends BaseController
{
    private $chiTietPhieuNhapHangModel;
    private $AllRowLength;
    private $uploadInstance;
    private $alert;

    public function __construct()
    {
        $this->chiTietPhieuNhapHangModel = new ChiTietPhieuNhapHangModel();

        $this->alert = new Other();
    }

    public function findMax($col)
    {
        $found = $this->chiTietPhieuNhapHangModel->getMaxCol($col);

        return $found;
    }

    public function findMin($col)
    {
        $found = $this->chiTietPhieuNhapHangModel->getMinCol($col);

        return $found;
    }

    public function countRow($col)
    {
        $number = $this->chiTietPhieuNhapHangModel->countRow($col);

        return $number;
    }

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->chiTietPhieuNhapHangModel->countRow())[0];
        }
        $chiTietPhieuNhapHang = $this->chiTietPhieuNhapHangModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages();

        $this->dieIfPageNotValid($numOfPages);

        return [
            'CTPNHArr' => $chiTietPhieuNhapHang,
            'CTPNHPages' => $numOfPages
        ];
    }

    public function add($data)
    {
        if (
            $data['maSP']
            && $data['maPhieu']
            && $data['soLuong']
            && $data['donGiaGoc']
            && $data['thanhTien']
        ) {
            $maxID = array_values($this->chiTietPhieuNhapHangModel->getMaxCol())[0];
            $fileName = "CTPNH-" .  ($maxID + 1);

            $values = $this->getValues($data);;
            $this->chiTietPhieuNhapHangModel->post($values, $maxID + 1);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maSP']
            && $data['maPhieu']
            && $data['soLuong']
            && $data['donGiaGoc']
            && $data['thanhTien']
        ) {
            $id = $data['maSP'];
            $values = $this->getValues($data);
            $this->chiTietPhieuNhapHangModel->update($values, $id);
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
            $this->chiTietPhieuNhapHangModel->delete($data['maSP']);
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
            $found = $this->chiTietPhieuNhapHangModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTPNHFound' => $found,
                'CTPNHFoundPages' => $numOfPages
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
            $found = $this->chiTietPhieuNhapHangModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTPNHFound' => $found,
                'CTPNHFoundPages' => $numOfPages
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
            $found = $this->chiTietPhieuNhapHangModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTPNHFound' => $found,
                'CTPNHFoundPages' => $numOfPages
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
            $found = $this->chiTietPhieuNhapHangModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTPNHFound' => $found,
                'CTPNHFoundPages' => $numOfPages
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
            $filtered = $this->chiTietPhieuNhapHangModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTPNHFiltered' => $filtered,
                'CTPNHFilteredPages' => $numOfPages
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
            $sorted = $this->chiTietPhieuNhapHangModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTPNHSorted' => $sorted,
                'CTPNHSortedPages' => $numOfPages
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
            $filtered = $this->chiTietPhieuNhapHangModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);

            return [
                'CTPNHFiltered' => $filtered,
                'CTPNHFilteredPages' => $numOfPages
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    private function getValues($data)
    {
        return [
            'maSP' => $data['maSP'],
            'maPhieu' => $data['maPhieu'],
            'soLuong' => $data['soLuong'],
            'donGiaGoc' => $data['donGiaGoc'],
            'thanhTien' => $data['thanhTien'],
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
