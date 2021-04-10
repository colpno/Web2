<?php
class SanPhamController extends BaseController
{
    private $sanPhamModel;
    private $loaiModel;
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

    public function index()
    {
        $sanPham = $this->get();


        return $this->view('SanPham', [
            'SPArr' => $sanPham['SPArr'],
            'SPPages' => $sanPham['SPPages']
        ]);
    }

    protected function get()
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
            'SPPages' => $numOfPages
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
            $this->sanPhamModel->post($values, $maxID + 1);
            $this->get();
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
            $this->uploadInstance->upload("SP-" . $id);
            $values = $this->getValues($data);
            $this->sanPhamModel->update($values, $id);
            $this->get();
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
            $this->get();
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

            return $this->view('SanPham', [
                'SPFound' => $found,
                'SPFoundPages' => $numOfPages
            ]);
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
            $found = $this->sanPhamModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return $this->view('SanPham', [
                'SPFound' => $found,
                'SPFoundPages' => $numOfPages
            ]);
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

            return $this->view('SanPham', [
                'SPFound' => $found,
                'SPFoundPages' => $numOfPages
            ]);
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findWithFilterAndSort($data)
    {
        $sortValues = $this->getSortValues();
        $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
        $found = $this->sanPhamModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
        $numOfPages = $this->getNumOfPages($found);

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($found);

        return $this->view('SanPham', [
            'SPFound' => $found,
            'SPFoundPages' => $numOfPages
        ]);
    }

    public function filter($data)
    {
        $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
        $filtered = $this->sanPhamModel->filter($filterValues, $this->getPage());
        $numOfPages = $this->getNumOfPages($filtered);

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($filtered);

        return $this->view('SanPham', [
            'SPFiltered' => $filtered,
            'SPFilteredPages' => $numOfPages
        ]);
    }

    public function sort()
    {
        $sortValues = $this->getSortValues();
        $sorted = $this->sanPhamModel->sort($sortValues, $this->getPage());
        $numOfPages = $this->getNumOfPages($sorted);

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($sorted);

        return $this->view('SanPham', [
            'SPSorted' => $sorted,
            'SPSortedPages' => $numOfPages
        ]);
    }

    public function filterAndSort($data)
    {
        $sortValues = $this->getSortValues();
        $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
        $filtered = $this->sanPhamModel->filterAndSort($sortValues, $filterValues, $this->getPage());
        $numOfPages = $this->getNumOfPages($filtered);

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($filtered);

        return $this->view('SanPham', [
            'SPFiltered' => $filtered,
            'SPFilteredPages' => $numOfPages
        ]);
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
            'anhDaiDien' => $this->uploadInstance->noiChuaFile,
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
        require_once(__DIR__ . '/../models/LoaiModel.php');
        require_once(__DIR__ . '/../models/NhaSanXuatModel.php');

        $this->loaiModel = new LoaiModel();
        $this->nhaSanXuatModel = new NhaSanXuatModel();

        $length = count($list);
        for ($i = 0; $i < $length; $i++) {
            $list[$i]['nhaSanXuat'] = $this->nhaSanXuatModel->getRow('maNSX', $list[$i]['maNSX']);
            unset($list[$i]['maNSX']);

            $list[$i]['loai'] = $this->loaiModel->getRow('maLoai', $list[$i]['maLoai']);
            unset($list[$i]['maLoai']);
        }
        return $list;
    }

    private function getPage()
    {
        return [
            'current' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => 10
        ];
    }
}
