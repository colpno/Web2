<?php
class admin
{
    private $sanPham;
    private $loai;
    private $khuyenMai;
    private $chiTietKM;
    private $nhaSanXuat;
    private $phieuNhapHang;
    private $chiTietPhieuNhapHang;
    private $hoaDon;
    private $chiTietHoaDon;
    private $nhaCungCap;
    private $taiKhoan;
    private $nhanVien;
    private $khachHang;
    private $quyen;

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
                'SPData' => $this->sanPham->get(),
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

    public function doitac($data = [])
    {
        $components = ['NhaCungCap', 'NhaSanXuat'];
        foreach ($components as  $component) {
            require_once(__DIR__ . '/components/' . $component . 'Controller.php');
            require_once(__DIR__ . '/../models/' . $component . 'Model.php');
        }
        $components = array_map(function ($component) {
            return $component . 'Controller';
        }, $components);

        $this->nhaCungCap = new $components[0];
        $this->nhaSanXuat = new $components[1];

        $returnBack = [
            'NhaCungCap' => [
                'Data' => $this->nhaCungCap->get(),
                'TongSoNhaCungCap' => $this->nhaCungCap->countRow('maNCC'),
            ],
            'NhaSanXuat' => [
                'Data' => $this->nhaSanXuat->get(),
                'TongSoNhaSanXuat' => $this->nhaSanXuat->countRow('maNSX'),
            ]
        ];
        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        }

        return $returnBack;
    }

    public function nhapxuat($data = [])
    {
        $components = ['PhieuNhapHang', 'ChiTietPhieuNhapHang', 'HoaDon', 'ChiTietHoaDon', 'NhanVien', 'KhachHang', 'NhaCungCap', 'SanPham'];
        foreach ($components as  $component) {
            require_once(__DIR__ . '/components/' . $component . 'Controller.php');
            require_once(__DIR__ . '/../models/' . $component . 'Model.php');
        }
        $components = array_map(function ($component) {
            return $component . 'Controller';
        }, $components);

        $this->phieuNhapHang = new $components[0];
        $this->chiTietPhieuNhapHang = new $components[1];
        $this->hoaDon = new $components[2];
        $this->chiTietHoaDon = new $components[3];
        $this->nhanVien = new $components[4];
        $this->khachHang = new $components[5];
        $this->nhaCungCap = new $components[6];
        $this->sanPham = new $components[7];

        $returnBack = [
            'PhieuNhapHang' => [
                'Data' => $this->phieuNhapHang->get(),
                'TongSoPhieuNhapHang' => $this->phieuNhapHang->countRow('maPhieu'),
                'HienThiSelect' => [
                    'NhanVien' => $this->nhanVien->selectDisplay(),
                    'NhaCungCap' => $this->nhaCungCap->selectDisplay(),
                ]
            ],
            'ChiTietPhieuNhapHang' => [
                'Data' => $this->chiTietPhieuNhapHang->get(),
                'HienThiSelect' => $this->sanPham->selectDisplay(),
            ],
            'HoaDon' => [
                'Data' => $this->hoaDon->get(),
                'TongSoHoaDon' => $this->hoaDon->countRow('maHD'),
                'HienThiSelect' => [
                    'NhanVien' => $this->nhanVien->selectDisplay(),
                    'KhachHang' => $this->khachHang->selectDisplay(),
                ]
            ],
            'ChiTietHoaDon' => [
                'Data' => $this->chiTietHoaDon->get(),
            ]
        ];
        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        }

        return $returnBack;
    }

    public function taikhoan($data = [])
    {
        $components = ['TaiKhoan', 'NhanVien', 'KhachHang', 'Quyen'];
        foreach ($components as  $component) {
            require_once(__DIR__ . '/components/' . $component . 'Controller.php');
            require_once(__DIR__ . '/../models/' . $component . 'Model.php');
        }
        $components = array_map(function ($component) {
            return $component . 'Controller';
        }, $components);

        $this->taiKhoan = new $components[0];
        $this->nhanVien = new $components[1];
        $this->khachHang = new $components[2];
        $this->quyen = new $components[3];

        $returnBack = [
            'TaiKhoan' => [
                'Data' => $this->taiKhoan->get(),
                'TongSoTaiKhoan' => $this->taiKhoan->countRow('maTK'),
                'HienThiSelect' => $this->quyen->selectDisplay(),
            ],
            'HienThiSelect' => $this->taiKhoan->selectDisplay(),
            'NhanVien' => [
                'Data' => $this->nhanVien->get(),
                'TongSoNhanVien' => $this->nhanVien->countRow('maNV'),
            ],
            'KhachHang' => [
                'Data' => $this->khachHang->get(),
                'TongSoKhachHang' => $this->khachHang->countRow('maKH'),
            ]
        ];
        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        }

        return $returnBack;
    }

    public function thongke($data = [])
    {
        $components = ['TaiKhoan',  'NhanVien', 'HoaDon', 'PhieuNhapHang'];
        foreach ($components as  $component) {
            require_once(__DIR__ . '/components/' . $component . 'Controller.php');
            require_once(__DIR__ . '/../models/' . $component . 'Model.php');
        }
        $components = array_map(function ($component) {
            return $component . 'Controller';
        }, $components);

        $this->taiKhoan = new $components[0];
        $this->nhanVien = new $components[1];
        $this->hoaDon = new $components[2];
        $this->phieuNhapHang = new $components[3];

        $returnBack = [
            'TaiKhoan' => $this->taiKhoan->thongke(),
            'NhanVien' => $this->nhanVien->thongke(),
            'HoaDon' => $this->hoaDon->thongke(),
            'PhieuNhapHang' => $this->phieuNhapHang->thongke(),
        ];
        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        }

        return $returnBack;
    }

    private function action($uri, $action, $data)
    {
        if (sizeof($data) == 2) {
            $data = "";
        }
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
            case 'nhacungcap': {
                    return $this->nhaCungCap->$action($data);
                    break;
                }
            case 'nhasanxuat': {
                    return $this->nhaSanXuat->$action($data);
                    break;
                }
            case 'taikhoan': {
                    return $this->taiKhoan->$action($data);
                    break;
                }
            case 'nhanvien': {
                    return $this->nhanVien->$action($data);
                    break;
                }
            case 'khachhang': {
                    return $this->khachHang->$action($data);
                    break;
                }
            case 'phieunhaphang': {
                    return $this->phieuNhapHang->$action($data);
                    break;
                }
            case 'chitietphieunhaphang': {
                    return $this->chiTietPhieuNhapHang->$action($data);
                    break;
                }
            case 'hoadon': {
                    return $this->hoaDon->$action($data);
                    break;
                }
            case 'chitiethoadon': {
                    return $this->chiTietHoaDon->$action($data);
                    break;
                }
        }
    }
}
