<?php
class admin
{
    private $sanPham;
    private $loai;
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
    private $quyenChucNang;
    private $chucNang;

    public function sanpham($data = [])
    {
        $components = ['SanPham', 'LoaiSanPham', 'NhaSanXuat'];
        foreach ($components as  $component) {
            require_once(__DIR__ . '/components/' . $component . 'Controller.php');
            require_once(__DIR__ . '/../models/' . $component . 'Model.php');
        }
        $components = array_map(function ($component) {
            return $component . 'Controller';
        }, $components);

        $this->sanPham = new $components[0];
        $this->loai = new $components[1];
        $this->nhaSanXuat = new $components[2];

        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        } else
            $returnBack = [
                'SanPham' => [
                    'SPData' => $this->sanPham->get($this->getPage()),
                    'SPMin' => $this->sanPham->findMin('soLuong'),
                    'TongSoSanPham' => $this->sanPham->countRow('maSP'),
                    'selectDisplay' => $this->sanPham->selectDisplay(),
                ],
                'Loai' => [
                    'LoaiData' => $this->loai->get($this->getPage()),
                    'TongSoLoai' => $this->loai->countRow('maLoai'),
                    'selectDisplay' => $this->loai->selectDisplay(),
                ],
                'NhaSanXuat' => $this->nhaSanXuat->selectDisplay(),
            ];

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

        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        } else
            $returnBack = [
                'NhaCungCap' => [
                    'Data' => $this->nhaCungCap->get($this->getPage()),
                    'TongSoNhaCungCap' => $this->nhaCungCap->countRow('maNCC'),
                ],
                'NhaSanXuat' => [
                    'Data' => $this->nhaSanXuat->get($this->getPage()),
                    'TongSoNhaSanXuat' => $this->nhaSanXuat->countRow('maNSX'),
                ]
            ];

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

        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        } else
            $returnBack = [
                'PhieuNhapHang' => [
                    'Data' => $this->phieuNhapHang->get($this->getPage()),
                    'TongSoPhieuNhapHang' => $this->phieuNhapHang->countRow('maPhieu'),
                    'HienThiSelect' => [
                        'NhanVien' => $this->nhanVien->selectDisplay(),
                        'NhaCungCap' => $this->nhaCungCap->selectDisplay(),
                    ]
                ],
                'ChiTietPhieuNhapHang' => [
                    'Data' => $this->chiTietPhieuNhapHang->get([], $this->getPage()),
                    'HienThiSelect' => $this->sanPham->selectDisplay(),
                ],
                'HoaDon' => [
                    'Data' => $this->hoaDon->get($this->getPage()),
                    'TongSoHoaDon' => $this->hoaDon->countRow('maHD'),
                    'HienThiSelect' => [
                        'NhanVien' => $this->nhanVien->selectDisplay(),
                        'KhachHang' => $this->khachHang->selectDisplay(),
                    ]
                ],
                'ChiTietHoaDon' => [
                    'Data' => $this->chiTietHoaDon->get([], $this->getPage()),
                ]
            ];

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

        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        } else
            $returnBack = [
                'TaiKhoan' => [
                    'Data' => $this->taiKhoan->get($this->getPage()),
                    'TongSoTaiKhoan' => $this->taiKhoan->countRow('maTK'),
                    'HienThiSelect' => $this->quyen->selectDisplay(),
                ],
                'HienThiSelect' => $this->taiKhoan->selectDisplay(),
                'NhanVien' => [
                    'Data' => $this->nhanVien->get($this->getPage()),
                    'TongSoNhanVien' => $this->nhanVien->countRow('maNV'),
                ],
                'KhachHang' => [
                    'Data' => $this->khachHang->get($this->getPage()),
                    'TongSoKhachHang' => $this->khachHang->countRow('maKH'),
                ]
            ];

        return $returnBack;
    }

    public function thongke($data = [])
    {
        $components = ['TaiKhoan',  'NhanVien', 'HoaDon', 'PhieuNhapHang', 'SanPham', 'ChiTietHoaDon'];
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
        $this->sanPham = new $components[4];
        $this->chiTietHoaDon = new $components[5];

        if (isset($data['action'], $data['table'])) {
            $returnBack = [
                'TaiKhoan' => $this->taiKhoan->thongke($data['year'], 'thoiGianTao', 'maQuyen'),
                'NhanVien' => $this->nhanVien->thongke(null, null, 'luong'),
                'HoaDon' => $this->hoaDon->thongke($data['year'], 'ngayLapHoaDon', 'tongTien'),
                'PhieuNhapHang' => $this->phieuNhapHang->thongke($data['year'], 'ngayNhap', 'tongTien'),
                'SanPham' => $this->sanPham->thongke(null, null, 'donViTinh'),
                'chiTietHoaDon' => $this->chiTietHoaDon->getAll(),
            ];
        } else
            $returnBack = [
                'TaiKhoan' => $this->taiKhoan->thongke(null, null, 'thoiGianTao', 'maQuyen'),
                'NhanVien' => $this->nhanVien->thongke(null, null, 'luong'),
                'HoaDon' => $this->hoaDon->thongke(null, null, 'maHD', 'ngayLapHoaDon', 'tongTien'),
                'PhieuNhapHang' => $this->phieuNhapHang->thongke(null, null, 'ngayNhap', 'tongTien'),
                'SanPham' => $this->sanPham->thongke(null, null, 'donViTinh', 'maSP', 'tenSP'),
                'chiTietHoaDon' => $this->chiTietHoaDon->getAll(),
            ];

        return $returnBack;
    }

    public function quyen($data = [])
    {
        $components = ['Quyen',  'QuyenChucNang', 'ChucNang'];
        foreach ($components as  $component) {
            require_once(__DIR__ . '/components/' . $component . 'Controller.php');
            require_once(__DIR__ . '/../models/' . $component . 'Model.php');
        }
        $components = array_map(function ($component) {
            return $component . 'Controller';
        }, $components);

        $this->quyen = new $components[0];
        $this->quyenChucNang = new $components[1];
        $this->chucNang = new $components[2];

        if (isset($data['action'], $data['table'])) {
            $returnBack = $this->action($data['table'], $data['action'], $data);
        } else
            $returnBack = [
                'Quyen' => $this->quyen->get($this->getPage()),
                'QuyenChucNang' => $this->quyenChucNang->get($this->getPage()),
                'ChucNang' => $this->chucNang->get($this->getPage()),
            ];

        return $returnBack;
    }

    public function dudoan($data)
    {
        $components = ['HoaDon', 'ChiTietHoaDon', 'SanPham'];
        foreach ($components as  $component) {
            require_once(__DIR__ . '/components/' . $component . 'Controller.php');
            require_once(__DIR__ . '/../models/' . $component . 'Model.php');
        }
        $components = array_map(function ($component) {
            return $component . 'Controller';
        }, $components);

        $this->hoaDon = new $components[0];
        $this->chiTietHoaDon = new $components[1];
        $this->sanPham = new $components[2];

        $returnBack = [
            'HoaDon' => $this->hoaDon->getAll(),
            'ChiTietHoaDon' => $this->chiTietHoaDon->getAll(),
            'SanPham' => $this->sanPham->thongke(null, null, 'maSP', 'tenSP', 'soLuong', 'donGia', 'donViTinh'),
        ];

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
            case 'quyen': {
                    return $this->quyen->$action($data);
                    break;
                }
            case 'quyenchucnang': {
                    return $this->quyenChucNang->$action($data);
                    break;
                }
            case 'chucnang': {
                    return $this->chucNang->$action($data);
                    break;
                }
        }
    }

    private function getPage()
    {
        return [
            'current' => 1,
            'limit' => 15
        ];
    }
}
