<?php
class SanPhamController extends BaseController
{
    private $sanPhamModel;
    private $loaiSanPhamModel;
    private $nhaSanXuatModel;
    private $AllRowLength;
    private $uploadInstance;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->sanPhamModel = new SanPhamModel();

        $this->uploadInstance = new UploadImage("SanPham");
        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->sanPhamModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->sanPhamModel->countRow())[0];
        }
        $sanPham = [];
        if (!empty($page)) {
            $sanPham = $this->sanPhamModel->get($page, 'desc');
        } else {
            $sanPham = $this->sanPhamModel->get($this->getPage(), 'desc');
        }
        $numOfPages = $this->getNumOfPages($sanPham['pages']);

        $sanPham['pages'] = $numOfPages;


        $this->changeProp($sanPham['data']);

        return $sanPham;
    }

    public function selectDisplay()
    {
        return $this->sanPhamModel->selectDisplay();
    }

    public function add($data = [])
    {
        if (
            $data['maLoai']
            && $data['maNSX']
            && $data['tenSP']
            && $data['donGia']
            && $data['donViTinh']
            && $data['soLuong']
            && $data['moTa']
            && $data['anhDaiDien']
        ) {
            $values = $this->getValues($data);
            $maxID = array_values($this->sanPhamModel->getMaxCol())[0];
            $this->sanPhamModel->post($values, $maxID);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maSP']
            && $data['maLoai']
            && $data['maNSX']
            && $data['tenSP']
            && $data['donGia']
            && $data['moTa']
            && $data['donViTinh']
            && $data['soLuong']
            && $data['anhDaiDien']
        ) {
            $id = $data['maSP'];
            $values = $this->getValues($data);
            $this->sanPhamModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maSP']
            && $data['anhDaiDien']
        ) {
            $remove = [
                'id' => $data['maSP'],
                'imgPath' => $data['anhDaiDien']
            ];
            $this->sanPhamModel->delete($remove);
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
            $found = $this->sanPhamModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;


            $this->changeProp($found['data']);

            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->sanPhamModel->getMaxCol($col);

        $this->changeProp($found['data']);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->sanPhamModel->getMinCol($col);

        $this->changeProp($found['data']);

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
            $filtered = $this->sanPhamModel->filter($filterValues, $this->getPage());
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
            $sorted = $this->sanPhamModel->sort($data, $this->getPage());
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
            'maLoai' => $data['maLoai'],
            'maNSX' => $data['maNSX'],
            'tenSP' => $data['tenSP'],
            'donGia' => $data['donGia'],
            'moTa' => $data['moTa'],
            'donViTinh' => $data['donViTinh'],
            'soLuong' => $data['soLuong'],
            'anhDaiDien' => $data['anhDaiDien'],
        ];
    }

    private function getFilterValues($col, $from, $to)
    {
        return [
            'filterCol' => $_GET['filterCol'],
            'from' => $_GET['from'],
            'to' => $_GET['to']
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

    private function changeProp(&$list)
    {
        require_once(__DIR__ . '/../../models/LoaiSanPhamModel.php');
        require_once(__DIR__ . '/../../models/NhaSanXuatModel.php');

        $this->loaiSanPhamModel = new LoaiSanPhamModel();
        $this->nhaSanXuatModel = new NhaSanXuatModel();

        if ($list != null) {
            $length = count($list);
            for ($i = 0; $i < $length; $i++) {
                if (isset($list[$i])) {
                    $list[$i]['nhaSanXuat'] = $this->nhaSanXuatModel->getRow('maNSX', $list[$i]['maNSX']);
                    unset($list[$i]['maNSX']);

                    $list[$i]['loaiSanPham'] = $this->loaiSanPhamModel->getRow('maLoai', $list[$i]['maLoai']);
                    unset($list[$i]['maLoai']);
                }
            }
            return $list;
        }
    }

    private function getPage()
    {
        return [
            'current' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => $this->limit
        ];
    }

    public function thongke($year = null, $yearCol = null, ...$cols)
    {
        return $this->sanPhamModel->thongke($year, $yearCol, ...$cols);
    }
}
