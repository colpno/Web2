<?php
class ChiTietHoaDonController extends BaseController
{
    private $chiTietHoaDonModel;
    private $sanPhamModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->chiTietHoaDonModel = new ChiTietHoaDonModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->chiTietHoaDonModel->countRow($col);

        return $number;
    }

    public function get($id = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->chiTietHoaDonModel->countRow())[0];
        }
        if (!empty($id)) {
            $chiTietHoaDon = $this->chiTietHoaDonModel->get($this->getPage(), $id);
            $numOfPages = $this->getNumOfPages($chiTietHoaDon['pages']);

            $chiTietHoaDon['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($chiTietHoaDon['data']);

            return $chiTietHoaDon;
        }
    }

    public function add($data)
    {
        if (
            $data['maHD']
            && $data['maSP']
            && $data['soLuong']
            && $data['donGia']
            && $data['thanhTien']
        ) {
            $maxID = array_values($this->chiTietHoaDonModel->getMaxCol())[0];



            $values = $this->getValues($data);
            $this->chiTietHoaDonModel->post($values);
            return;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maHD']
            && $data['maSP']
            && $data['soLuong']
            && $data['donGia']
            && $data['thanhTien']
        ) {
            $id = $data['maSP'];
            //  
            $values = $this->getValues($data);
            $this->chiTietHoaDonModel->update($values, $id);
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
            return [
                'error' => $this->chiTietHoaDonModel->delete($remove),
                'data' => $this->get()
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để xóa");
        }
    }

    public function find($data)
    {
        if (
            $data['search']
        ) {
            $found = $this->chiTietHoaDonModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);

            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->chiTietHoaDonModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->chiTietHoaDonModel->getMinCol($col);


        return $found;
    }

    public function findWithFilter($data)
    {
        if (
            $data['search']
            && $data['filterCol']
            && $data['from']
            && $data['to']
            && $data['maHD']
        ) {
            $filterValues = $this->getFilterValues($data);
            $found = $this->chiTietHoaDonModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found['data']);

            return $found;
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
            $found = $this->chiTietHoaDonModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);

            return $found;
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
            && $data['maHD']
        ) {
            $sortValues = $this->getSortValues();
            $filterValues = $this->getFilterValues($data);
            $found = $this->chiTietHoaDonModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found['data']);

            return $found;
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
            && $data['maHD']
        ) {
            $filterValues = $this->getFilterValues($data);
            $filtered = $this->chiTietHoaDonModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered['data']);

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
            $sorted = $this->chiTietHoaDonModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted['pages']);

            $sorted['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);

            return $sorted;
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
            && $data['maHD']
        ) {
            $sortValues = $this->getSortValues();
            $filterValues = $this->getFilterValues($data);
            $filtered = $this->chiTietHoaDonModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered['data']);

            return $filtered;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    private function getValues($data)
    {
        return [
            'maHD' => $data['maHD'],
            'maSP' => $data['maSP'],
            'soLuong' => $data['soLuong'],
            'donGia' => $data['donGia'],
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

    private function getFilterValues($data)
    {
        $data['col'] = 'maHD';
        $data['id'] = $data['maHD'];
        return $data;
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

    private function changeProp(&$list)
    {
        require_once(__DIR__ . '/../../models/SanPhamModel.php');

        $this->sanPhamModel = new SanPhamModel();

        $length = count($list);
        for ($i = 0; $i < $length; $i++) {
            $list[$i]['sanPham'] = $this->sanPhamModel->getRow('maSP', $list[$i]['maSP']);
            unset($list[$i]['maSP']);
        }
        return $list;
    }

    private function getPage()
    {
        return [
            'current' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => $this->limit
        ];
    }
}
