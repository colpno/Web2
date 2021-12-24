<?php
class ChiTietPhieuNhapHangController extends BaseController
{
    private $chiTietPhieuNhapHangModel;
    private $sanPhamModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->chiTietPhieuNhapHangModel = new ChiTietPhieuNhapHangModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->chiTietPhieuNhapHangModel->countRow($col);

        return $number;
    }

    public function get($id = [], $page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->chiTietPhieuNhapHangModel->countRow())[0];
        }
        if (!empty($id)) {
            if (isset($id['maSP'])) {
                $id['col'] = 'maPhieu';
                $id['id'] = $id['maPhieu'];
            }
            $chiTietPhieuNhapHang      = [];
            if (!empty($page)) {
                $chiTietPhieuNhapHang   = $this->chiTietPhieuNhapHangModel->get($page, $id);
            } else {
                $chiTietPhieuNhapHang = $this->chiTietPhieuNhapHangModel->get($this->getPage(), $id);
            }
            $numOfPages = $this->getNumOfPages($chiTietPhieuNhapHang['pages']);

            $chiTietPhieuNhapHang['pages'] = $numOfPages;


            $this->changeProp($chiTietPhieuNhapHang['data']);

            return $chiTietPhieuNhapHang;
        }
    }

    public function add($data)
    {
        if (
            $data['maSP']
            && $data['maPhieu']
            && $data['soLuong']
        ) {
            require_once(__DIR__ . '/../../models/SanPhamModel.php');

            $this->sanPhamModel = new SanPhamModel();
            $sanpham = $this->sanPhamModel->getRow('maSP', $data['maSP']);
            $data['donGiaGoc'] = $sanpham['donGia'];

            $values = $this->getValues($data);
            $this->chiTietPhieuNhapHangModel->post($values);

            return $this->get($data);
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
        ) {
            $id = $data['maSP'];
            $values = $this->getValues($data);
            $this->chiTietPhieuNhapHangModel->update($values, $id);
            return $this->get($data);
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maSP']
            && $data['maPhieu']
        ) {
            $remove = [
                'col' => 'maPhieu',
                'value' => $data['maPhieu'],
                'colChiTiet' => 'maSP',
                'valueChiTiet' => $data['maSP'],
            ];
            $this->chiTietPhieuNhapHangModel->delete($remove);
            return $this->get($data);
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
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;



            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->chiTietPhieuNhapHangModel->getMaxCol($col);


        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->chiTietPhieuNhapHangModel->getMinCol($col);


        return $found;
    }

    public function filter($data)
    {
        if (
            $data['filterCol']
            && $data['from']
            && $data['to']
            && $data['maPhieu']
        ) {
            $filterValues = $this->getFilterValues($data);
            $filtered = $this->chiTietPhieuNhapHangModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;


            $this->changeProp($filtered['data']);

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
            $sorted = $this->chiTietPhieuNhapHangModel->sort($data, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted['pages']);

            $sorted['pages'] = $numOfPages;

            $this->changeProp($sorted['data']);


            return $sorted;
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
        ];
    }

    private function getFilterValues($data)
    {
        $data['col'] = 'maPhieu';
        $data['id'] = $data['maPhieu'];
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
