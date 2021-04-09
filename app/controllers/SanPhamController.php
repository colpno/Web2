<?php
class SanPhamController extends BaseController
{
    private $sanPhamModel;
    private $page;
    private $uploadInstance;

    public function __construct()
    {
        $this->page = [
            'current' => isset($_REQUEST['page']) ? $_REQUEST['page'] : 1,
            'limit' =>  10
        ];
        $this->sanPhamModel = new SanPhamModel;
        $this->uploadInstance = new UploadImage("SanPham");
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
        $sanPham = $this->sanPhamModel->get($this->page);
        $this->count = count($sanPham);
        $numOfPages = $this->getNumOfPages($sanPham);

        $this->dieIfPageNotValid($numOfPages);

        return [
            'SPArr' => $sanPham,
            'SPPages' => $numOfPages
        ];
    }

    public function add($data)
    {
        // $this->uploadInstance->upload("SP-1");

        // $values = $this->getValues($data);
        // $this->sanPhamModel->post($values);
    }

    public function update($data)
    {
        $values = $this->getValues($data);
        $id = $data['maSP'];
        $this->sanPhamModel->update($values, $id);
    }

    public function delete($data)
    {
        $id = $data['checked_id'];
        $this->sanPhamModel->delete($id);
    }

    public function find($data)
    {
        $found = $this->sanPhamModel->find($data['search'], $this->page);
        $numOfPages = $this->getNumOfPages($found);

        $this->dieIfPageNotValid($numOfPages);

        return $this->view('SanPham', [
            'SPArr' => $found,
            'SPPages' => $numOfPages
        ]);
    }

    public function findWithFilter($data)
    {
        $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
        $found = $this->sanPhamModel->findWithFilter($data['search'], $filterValues, $this->page);
        $numOfPages = $this->getNumOfPages($found);

        $this->dieIfPageNotValid($numOfPages);

        return $this->view('SanPham', [
            'SPArr' => $found,
            'SPPages' => $numOfPages
        ]);
    }

    public function findWithSort($data)
    {
        $sortValues = $this->getSortValues();
        $found = $this->sanPhamModel->findWithSort($data['search'], $sortValues, $this->page);
        $numOfPages = $this->getNumOfPages($found);

        $this->dieIfPageNotValid($numOfPages);

        return $this->view('SanPham', [
            'SPArr' => $found,
            'SPPages' => $numOfPages
        ]);
    }

    public function findWithFilterAndSort($data)
    {
        $sortValues = $this->getSortValues();
        $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
        $found = $this->sanPhamModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->page);
        $numOfPages = $this->getNumOfPages($found);

        $this->dieIfPageNotValid($numOfPages);

        return $this->view('SanPham', [
            'SPArr' => $found,
            'SPPages' => $numOfPages
        ]);
    }

    public function filter($data)
    {
        $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
        $filtered = $this->sanPhamModel->filter($filterValues, $this->page);
        $numOfPages = $this->getNumOfPages($filtered);

        $this->dieIfPageNotValid($numOfPages);

        return $this->view('SanPham', [
            'SPArr' => $filtered,
            'SPPages' => $numOfPages
        ]);
    }

    public function sort()
    {
        $sortValues = $this->getSortValues();
        $sorted = $this->sanPhamModel->sort($sortValues, $this->page);
        $numOfPages = $this->getNumOfPages($sorted);

        $this->dieIfPageNotValid($numOfPages);

        return $this->view('SanPham', [
            'SPArr' => $sorted,
            'SPPages' => $numOfPages
        ]);
    }

    public function sortAndFilter($data)
    {
        $sortValues = $this->getSortValues();
        $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
        $filtered = $this->sanPhamModel->sortAndFilter($sortValues, $filterValues, $this->page);
        $numOfPages = $this->getNumOfPages($filtered);

        $this->dieIfPageNotValid($numOfPages);

        return $this->view('SanPham', [
            'SPArr' => $filtered,
            'SPPages' => $numOfPages
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
            'anhDaiDien' => $this->uploadInstance->duongDanDenFile,
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

    private function getNumOfPages($list)
    {
        return ceil(count($list) / $this->page['limit']);
    }

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->page['current'] > $numOfPages) {
            die('ERROR');
        }
    }
}
