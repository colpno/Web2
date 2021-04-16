<?php
class Admin
{
    private $sanPham;
    private $loai;
    private $khuyenMai;
    private $chiTietKM;
    public function sanpham($data = [])
    {
        $components = ['SanPham', 'LoaiSanPham', 'KhuyenMai', 'ChiTietKhuyenMai'];
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

        $returnBack = [
            'SanPham' => [
                'SPData' => $this->sanPham->get(),
                'SPMin' => $this->sanPham->findMin('soLuong'),
                'TongSoSanPham' => $this->sanPham->countRow('maSP'),
            ],
            'Loai' => [
                'LoaiData' => $this->loai->get(),
                'TongSoLoai' => $this->loai->countRow('maLoai'),
            ],
            'KhuyenMai' => [
                'Data' => $this->khuyenMai->get(),
                'TongSoKhuyenMai' => $this->khuyenMai->countRow('maKM'),

            ],
            'ChiTietKM' => $this->chiTietKM->get(),
        ];

        if (isset($data['action'])) {
            if ($data['table']) {
                $returnBack = $this->action($data['table'], $data['action'], $data);
            } else {
                $returnBack = $this->action($data['table'], $data['action'], $data);
            }
        }

        return $returnBack;
    }

    private function action($uri, $action, $data)
    {
        switch ($uri) {
            case 'product': {
                    return [
                        $this->sanPham->$action($data),
                    ];
                    break;
                }
            case 'category': {
                    return [
                        $this->loai->$action($data),
                    ];
                    break;
                }
            case 'promotion': {
                    return [
                        $this->khuyenMai->$action($data),
                    ];
                    break;
                }
            case 'detail-promotion': {
                    return [
                        $this->chiTietKM->$action($data),
                    ];
                    break;
                }
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
