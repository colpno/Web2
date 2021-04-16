<?php
class SanPhamController extends BaseController
{
    private $sanPhamModel;
    private $loaiSanPhamModel;
    private $nhaSanXuatModel;
    private $AllRowLength;
    private $uploadInstance;
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

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->sanPhamModel->countRow())[0];
        }
        $sanPham = $this->sanPhamModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages();

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($sanPham);

        return [
            'SPArr' => $sanPham,
            'SPPages' => $numOfPages,

        ];
    }

    public function add($data)
    {
        if (
            $data['maLoai']
            && $data['maNSX']
            && $data['tenSP']
            && $data['donGia']
            && $data['donViTinh']
            && $data['soLuong']
            && $data['anhDaiDien']
        ) {
            $maxID = array_values($this->sanPhamModel->getMaxCol())[0];
            $fileName = "SP-" .  ($maxID + 1);
            $this->uploadInstance->upload($fileName);

            $values = $this->getValues($data);;
            $this->sanPhamModel->post($values);
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
            && $data['donViTinh']
            && $data['soLuong']
            && $data['anhDaiDien']
        ) {
            $id = $data['maSP'];
            // $this->uploadInstance->upload("SP-" . $id);
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'SPFound' => $found,
                'SPFoundPages' => $numOfPages
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->sanPhamModel->getMaxCol($col);

        $this->changeProp($found);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->sanPhamModel->getMinCol($col);

        $this->changeProp($found);

        return $found;
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
            $found = $this->sanPhamModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'SPFound' => $found,
                'SPFoundPages' => $numOfPages
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
            $found = $this->sanPhamModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'SPFound' => $found,
                'SPFoundPages' => $numOfPages
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
            $found = $this->sanPhamModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'SPFound' => $found,
                'SPFoundPages' => $numOfPages
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
            $filtered = $this->sanPhamModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'SPFiltered' => $filtered,
                'SPFilteredPages' => $numOfPages
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
            $sorted = $this->sanPhamModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($sorted);

            return [
                'SPSorted' => $sorted,
                'SPSortedPages' => $numOfPages
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
            $filtered = $this->sanPhamModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'SPFiltered' => $filtered,
                'SPFilteredPages' => $numOfPages
            ];
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
            'donViTinh' => $data['donViTinh'],
            'soLuong' => $data['soLuong'],
            'anhDaiDien' => '/Web2/' . $this->uploadInstance->noiChuaFile,
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
            'limit' => 15
        ];
    }
}
