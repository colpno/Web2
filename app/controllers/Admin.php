<?php
class admin
{
    private $sanPham;
    private $loai;
    private $khuyenMai;
    private $chiTietKM;
    private $nhaSanXuat;
    public function sanpham($data = [])
    {
        $components = ['SanPham', 'LoaiSanPham', 'KhuyenMai', 'ChiTietKhuyenMai', 'NhaSanXuat'];
        foreach ($components as  $component) {
            require_once(__DIR__ . '/components/' . $component . 'Controller.php');
            require_once(__DIR__ . '/../models/' . $component . 'Model.php');
        }
        $components = array_map(function ($component) {
            return $component . 'Controller';
        }, $components);

        $this->sanPham = new $components[0];
        $this->loai = new $components[1];
        $this->khuyenMai = new $components[2];
        $this->chiTietKM = new $components[3];
        $this->nhaSanXuat = new $components[4];

        $returnBack = [
            'SanPham' => [
                'SPData' => $this->sanPham->get([], 'desc'),
                'SPMin' => $this->sanPham->findMin('soLuong'),
                'TongSoSanPham' => $this->sanPham->countRow('maSP'),
                'selectDisplay' => $this->sanPham->selectDisplay(),
            ],
            'Loai' => [
                'LoaiData' => $this->loai->get(),
                'TongSoLoai' => $this->loai->countRow('maLoai'),
                'selectDisplay' => $this->loai->selectDisplay(),
            ],
            'KhuyenMai' => [
                'KMData' => $this->khuyenMai->get(),
                'TongSoKhuyenMai' => $this->khuyenMai->countRow('maKM'),
                'selectDisplay' => $this->loai->selectDisplay(),

            ],
            'NhaSanXuat' => $this->nhaSanXuat->selectDisplay(),
        ];
        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        }

        return $returnBack;
    }

    private function action($uri, $action, $data)
    {
        switch ($uri) {
            case 'sanpham': {
                    return $this->sanPham->$action($data);
                    break;
                }
            case 'loai': {
                    return $this->loai->$action($data);
                    break;
                }
            case 'khuyenmai': {
                    return $this->khuyenMai->$action($data);
                    break;
                }
            case 'chitietkhuyenmai': {
                    return $this->chiTietKM->$action($data);
                    break;
                }
        }
    }
}
