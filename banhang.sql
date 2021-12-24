-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2021 at 07:32 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banhang`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `stt` int(11) NOT NULL,
  `maHD` int(5) UNSIGNED NOT NULL,
  `maSP` int(5) UNSIGNED NOT NULL,
  `soLuong` int(5) UNSIGNED NOT NULL,
  `donGia` int(10) NOT NULL,
  `thanhTien` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`stt`, `maHD`, `maSP`, `soLuong`, `donGia`, `thanhTien`) VALUES
(1, 2, 1, 4, 8000, 32000),
(2, 2, 14, 5, 12000, 60000),
(3, 2, 28, 4, 27000, 108000),
(4, 2, 15, 6, 115000, 690000),
(5, 3, 6, 5, 30000, 150000),
(6, 3, 7, 2, 120000, 240000),
(7, 3, 5, 5, 15000, 75000),
(8, 4, 1, 3, 8000, 24000),
(9, 4, 20, 4, 135000, 540000),
(10, 4, 2, 4, 10000, 40000),
(11, 4, 9, 5, 125000, 625000),
(12, 4, 4, 10, 100000, 1000000),
(13, 4, 5, 15, 15000, 225000),
(14, 4, 20, 20, 135000, 2700000),
(15, 5, 2, 30, 10000, 300000),
(16, 5, 5, 23, 15000, 345000),
(17, 6, 4, 15, 100000, 1500000),
(18, 7, 9, 11, 125000, 1375000),
(19, 7, 8, 8, 110000, 880000);

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieunhaphang`
--

CREATE TABLE `chitietphieunhaphang` (
  `stt` int(11) NOT NULL,
  `maSP` int(5) UNSIGNED NOT NULL,
  `maPhieu` int(5) UNSIGNED NOT NULL,
  `soLuong` int(5) UNSIGNED NOT NULL,
  `donGiaGoc` int(10) NOT NULL,
  `thanhTien` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chitietphieunhaphang`
--

INSERT INTO `chitietphieunhaphang` (`stt`, `maSP`, `maPhieu`, `soLuong`, `donGiaGoc`, `thanhTien`) VALUES
(1, 15, 4, 20, 40000, 800000),
(2, 4, 4, 4, 1111, 4444),
(3, 14, 4, 20, 30000, 600000);

-- --------------------------------------------------------

--
-- Table structure for table `chucnang`
--

CREATE TABLE `chucnang` (
  `maCN` int(5) UNSIGNED NOT NULL,
  `tenCN` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chucnang`
--

INSERT INTO `chucnang` (`maCN`, `tenCN`) VALUES
(1, 'Sản phẩm'),
(2, 'Nhập xuất'),
(3, 'Tài khoản'),
(4, 'Đối tác'),
(5, 'Thống kê'),
(6, 'Phân quyền');

-- --------------------------------------------------------

--
-- Table structure for table `hoadon`
--

CREATE TABLE `hoadon` (
  `maHD` int(5) UNSIGNED NOT NULL,
  `maNV` int(5) UNSIGNED DEFAULT NULL,
  `maKH` int(5) UNSIGNED NOT NULL,
  `ngayLapHoaDon` date NOT NULL,
  `tongTien` int(10) NOT NULL,
  `diaChi` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `soDienThoai` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `tinhTrang` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hoadon`
--

INSERT INTO `hoadon` (`maHD`, `maNV`, `maKH`, `ngayLapHoaDon`, `tongTien`, `diaChi`, `soDienThoai`, `tinhTrang`) VALUES
(2, NULL, 1, '2021-05-04', 890000, '247 chung cư', '0989795452', 0),
(3, NULL, 1, '2021-05-04', 465000, '24 Phan aaa', '0989794547', 0),
(4, NULL, 2, '2021-05-04', 604000, '444 phường 1 quận 3', '0978979547', 0),
(5, NULL, 1, '2021-11-26', 645000, 'dsadsa', '0392843989', 0),
(6, NULL, 1, '2021-09-26', 1500000, 'feoiwuf', '0321652563', 0),
(7, NULL, 1, '2021-11-26', 2255000, 'dasd dsa', '0215645568', 0);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `maKH` int(5) UNSIGNED NOT NULL,
  `maTK` int(5) UNSIGNED NOT NULL,
  `ho` varchar(30) DEFAULT NULL,
  `ten` varchar(15) NOT NULL,
  `soDienThoai` varchar(10) NOT NULL,
  `ngaySinh` date NOT NULL,
  `diaChi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`maKH`, `maTK`, `ho`, `ten`, `soDienThoai`, `ngaySinh`, `diaChi`) VALUES
(1, 1, 'Nguyễn', 'Văn A', '0954036541', '0000-00-00', 'dasd dsa'),
(2, 4, 'Vũ', 'Tài', '0989781546', '0000-00-00', '444 phường 1 quận 3');

-- --------------------------------------------------------

--
-- Table structure for table `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `maLoai` int(5) UNSIGNED NOT NULL,
  `tenLoai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `loaisanpham`
--

INSERT INTO `loaisanpham` (`maLoai`, `tenLoai`) VALUES
(1, 'CupCake'),
(2, 'Gato'),
(3, 'Teramisu'),
(4, 'Các loại bánh khác');

-- --------------------------------------------------------

--
-- Table structure for table `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `maNCC` int(5) UNSIGNED NOT NULL,
  `tenNCC` varchar(255) NOT NULL,
  `diaChi` varchar(255) NOT NULL,
  `soDienThoai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhacungcap`
--

INSERT INTO `nhacungcap` (`maNCC`, `tenNCC`, `diaChi`, `soDienThoai`) VALUES
(1, 'Carrols Restaurant Group, Inc.', '82 Bonner Pass', '1867362576'),
(2, 'ARMOUR Residential REIT, Inc.', '883 Eliot Court', '5219191686'),
(3, 'Archrock Partners, L.P.', '1707 Northview Court', '7125106628'),
(4, 'Rollins, Inc.', '5078 Springview Street', '9399751110'),
(5, 'UNITIL Corporation', '007 Portage Point', '3893498634'),
(6, 'Cherokee Inc.', '89 Crescent Oaks Point', '1878123896'),
(7, 'Legg Mason, Inc.', '67 1st Plaza', '4226868338'),
(8, 'Morgan Stanley', '03385 Debs Park', '8073799502'),
(9, 'Cheetah Mobile Inc.', '6476 Butterfield Drive', '7279468049'),
(10, 'Aspen Insurance Holdings Limited', '71706 Everett Court', '5432221068'),
(11, 'Tupperware Brands Corporation', '784 Towne Hill', '4529893663'),
(12, 'General Electric Capital Corporation', '0310 Moose Street', '2336173118'),
(13, 'Powell Industries, Inc.', '5 Huxley Alley', '2478402465'),
(14, 'Sanmina Corporation', '0501 David Trail', '5927580928'),
(15, 'IES Holdings, Inc.', '845 Continental Point', '5008261090'),
(16, 'AnaptysBio, Inc.', '6 Macpherson Drive', '6993967482'),
(17, 'Oxford Lane Capital Corp.', '153 Emmet Drive', '9499391906'),
(18, 'Crown Crafts, Inc.', '9969 Gulseth Street', '8581615208'),
(19, 'Ingersoll-Rand plc (Ireland)', '75031 Green Point', '1695737757'),
(20, 'ARMOUR Residential REIT, Inc.', '38405 Thompson Road', '6563404351'),
(21, 'Duke Energy Corporation', '3 Oak Center', '4303961858'),
(22, 'U.S. Bancorp', '30 Gina Park', '1783287690'),
(23, 'Sunshine Bancorp, Inc.', '90038 Buena Vista Lane', '9576642377'),
(24, 'Macerich Company (The)', '8 Calypso Parkway', '1522049015'),
(25, 'The First Bancshares, Inc.', '7278 Di Loreto Plaza', '8055604502'),
(26, 'Patriot National, Inc.', '87638 Spohn Circle', '2088184891'),
(27, 'China Information Technology, Inc.', '2 Coleman Court', '9458993355'),
(28, 'Royal Caribbean Cruises Ltd.', '4031 Gerald Drive', '3844235705'),
(29, 'Infinity Pharmaceuticals, Inc.', '750 Kropf Lane', '8513146644'),
(30, 'Principal U.S. Small Cap Index ETF', '89087 Northfield Parkway', '4193765221'),
(31, 'Redwood Trust, Inc.', '9208 Laurel Drive', '8429630083'),
(32, 'Great Plains Energy Inc', '88891 Sunnyside Circle', '1254056700'),
(33, 'Axalta Coating Systems Ltd.', '0984 Hanover Place', '2613036436'),
(34, 'Check Point Software Technologies Ltd.', '1 Village Green Junction', '3641509214');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `maNV` int(5) UNSIGNED NOT NULL,
  `maTK` int(5) UNSIGNED NOT NULL,
  `ho` varchar(30) DEFAULT NULL,
  `ten` varchar(15) NOT NULL,
  `diaChi` varchar(255) NOT NULL,
  `ngaySinh` date NOT NULL,
  `soDienThoai` varchar(10) NOT NULL,
  `luong` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`maNV`, `maTK`, `ho`, `ten`, `diaChi`, `ngaySinh`, `soDienThoai`, `luong`) VALUES
(1, 2, 'Chủ', 'Tịch', '214 Q5', '0000-00-00', '0998784541', 1000000),
(2, 3, 'Vũ', 'T', '244 chung cư', '0000-00-00', '0998745107', 500000);

-- --------------------------------------------------------

--
-- Table structure for table `nhasanxuat`
--

CREATE TABLE `nhasanxuat` (
  `maNSX` int(5) UNSIGNED NOT NULL,
  `tenNSX` varchar(255) NOT NULL,
  `diaChi` varchar(255) NOT NULL,
  `soDienThoai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nhasanxuat`
--

INSERT INTO `nhasanxuat` (`maNSX`, `tenNSX`, `diaChi`, `soDienThoai`) VALUES
(1, 'Nhà máy bánh TP.HCM', '225/5A đường Tên Lửa Phường 2 Quận 8 Tp.HCM', '0908061504'),
(2, 'Nhà máy bánh Vạn Hưng', '11 đường An Dương Vương phường 3 Quận 5 Tp.HCM', '0781239456'),
(3, 'Nhà máy bánh AMA', '22 đường Nguyễn Trãi phường 5 quận 3 Tp.HCM', '0385219432');

-- --------------------------------------------------------

--
-- Table structure for table `phieunhaphang`
--

CREATE TABLE `phieunhaphang` (
  `maPhieu` int(5) UNSIGNED NOT NULL,
  `maNCC` int(5) UNSIGNED NOT NULL,
  `maNV` int(5) UNSIGNED NOT NULL,
  `ngayNhap` date NOT NULL,
  `tongTien` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phieunhaphang`
--

INSERT INTO `phieunhaphang` (`maPhieu`, `maNCC`, `maNV`, `ngayNhap`, `tongTien`) VALUES
(1, 4, 1, '2020-06-06', 0),
(2, 20, 2, '2020-10-21', 0),
(3, 1, 2, '2020-07-24', 0),
(4, 18, 1, '2021-05-07', 1404444);

-- --------------------------------------------------------

--
-- Table structure for table `quyen`
--

CREATE TABLE `quyen` (
  `maQuyen` int(5) UNSIGNED NOT NULL,
  `tenQuyen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quyen`
--

INSERT INTO `quyen` (`maQuyen`, `tenQuyen`) VALUES
(1, 'admin'),
(2, 'nhân viên'),
(3, 'khách hàng');

-- --------------------------------------------------------

--
-- Table structure for table `quyenchucnang`
--

CREATE TABLE `quyenchucnang` (
  `maCN` int(5) UNSIGNED NOT NULL,
  `maQuyen` int(5) UNSIGNED NOT NULL,
  `hienThi` tinyint(1) NOT NULL,
  `stt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quyenchucnang`
--

INSERT INTO `quyenchucnang` (`maCN`, `maQuyen`, `hienThi`, `stt`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 1, 3),
(4, 1, 1, 4),
(5, 1, 1, 5),
(6, 1, 1, 6),
(1, 2, 1, 7),
(2, 2, 1, 8),
(3, 2, 0, 9),
(4, 2, 1, 10),
(5, 2, 1, 11),
(6, 2, 0, 12),
(1, 3, 1, 13),
(2, 3, 0, 14),
(3, 3, 0, 15),
(4, 3, 0, 16),
(5, 3, 0, 17),
(6, 3, 0, 18);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `maSP` int(5) UNSIGNED NOT NULL,
  `maLoai` int(5) UNSIGNED NOT NULL,
  `maNSX` int(5) UNSIGNED NOT NULL,
  `tenSP` varchar(255) NOT NULL,
  `donGia` int(10) NOT NULL,
  `donViTinh` varchar(100) NOT NULL,
  `soLuong` int(10) UNSIGNED NOT NULL,
  `moTa` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `anhDaiDien` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`maSP`, `maLoai`, `maNSX`, `tenSP`, `donGia`, `donViTinh`, `soLuong`, `moTa`, `anhDaiDien`) VALUES
(1, 1, 3, 'CupCake vani', 8000, 'vnđ', 201, 'Bánh CupCake hương vị vani', '/Web2/admin/public/images/SanPham/SP-1.jpg'),
(2, 1, 3, 'CupCake green', 10000, 'vnđ', 85, 'Bánh CupCake lạ mắt', '/Web2/admin/public/images/SanPham/SP-2.jpg'),
(3, 1, 3, 'CupCake milk', 8000, 'vnđ', 129, 'Bánh CupCake sữa tươi', '/Web2/admin/public/images/SanPham/SP-3.jpg'),
(4, 4, 1, 'Pancake', 100000, 'vnđ', 18, 'Bánh pancake', '/Web2/admin/public/images/SanPham/SP-4.jpg'),
(5, 4, 2, 'Dorayaki', 15000, 'vnđ', 36, 'Bánh rán nhân đậu đỏ', '/Web2/admin/public/images/SanPham/SP-5.jpg'),
(6, 4, 2, 'Donut ', 30000, 'vnđ', 16, 'Bánh donut kẹo', '/Web2/admin/public/images/SanPham/SP-6.jpg'),
(7, 2, 1, 'Gato cherry', 120000, 'vnđ', 32, 'Bánh kem cherry', '/Web2/admin/public/images/SanPham/SP-7.jpg'),
(8, 2, 2, 'Gato socola', 110000, 'vnđ', 0, 'Bánh kem socola', '/Web2/admin/public/images/SanPham/SP-8.jpg'),
(9, 2, 3, 'Gato socola cherry', 125000, 'vnđ', 26, 'Bánh kem socola cherry', '/Web2/admin/public/images/SanPham/SP-9.jpg'),
(10, 1, 2, 'CupCake sea', 11000, 'vnđ', 43, 'Bánh CupCake xanh ngọc', '/Web2/admin/public/images/SanPham/SP-10.jpg'),
(11, 2, 2, 'Gato vani cherry', 130000, 'vnđ', 32, 'Bánh kem vani cherry', '/Web2/admin/public/images/SanPham/SP-11.jpg'),
(12, 1, 1, 'CupCake socola', 10000, 'vnđ', 49, 'Bánh CupCake vị socola đen', '/Web2/admin/public/images/SanPham/SP-12.jpg'),
(13, 1, 1, 'CupCake valentine', 9000, 'vnđ', 56, 'Bánh CupCake kem dâu ', '/Web2/admin/public/images/SanPham/SP-13.jpg'),
(14, 4, 3, 'Donut', 12000, 'vnđ', 37, 'Bánh donut đường', '/Web2/admin/public/images/SanPham/SP-14.jpg'),
(15, 2, 2, 'Gato white socola', 115000, 'vnđ', 17, 'Bánh kem socola trắng', '/Web2/admin/public/images/SanPham/SP-15.jpg'),
(16, 1, 1, 'CupCake socola vani', 7000, 'vnđ', 27, 'Bánh Cupcake socola kem vani', '/Web2/admin/public/images/SanPham/SP-16.jpg'),
(17, 1, 1, 'CupCake cafe', 8500, 'vnđ', 85, 'Bánh Cupcake vị cafe', '/Web2/admin/public/images/SanPham/SP-17.jpg'),
(18, 1, 2, 'CupCake lemon', 6000, 'vnđ', 100, 'Bánh Cupcake vị chanh', '/Web2/admin/public/images/SanPham/SP-18.jpg'),
(19, 2, 2, 'Gato cafe', 90000, 'vnđ', 23, 'Bánh kem cafe', '/Web2/admin/public/images/SanPham/SP-19.jpg'),
(20, 2, 3, 'Gato strawberry', 135000, 'vnđ', 100, 'Bánh kem dâu tây', '/Web2/admin/public/images/SanPham/SP-20.jpg'),
(21, 2, 2, 'Gato strawberry vani', 110000, 'vnđ', 11, 'Bánh kem vani dâu tây', '/Web2/admin/public/images/SanPham/SP-21.jpg'),
(22, 1, 1, 'CupCake honey', 7000, 'vnđ', 42, 'Bánh CupCake mật ong', '/Web2/admin/public/images/SanPham/SP-22.jpg'),
(23, 3, 1, 'Teramisu socola', 20000, 'vnđ', 46, 'Bánh socola mềm, nhân kem vani', '/Web2/admin/public/images/SanPham/SP-23.jpg'),
(24, 2, 2, 'Gato oreo', 105000, 'vnđ', 16, 'Bánh kem socola bánh oreo', '/Web2/admin/public/images/SanPham/SP-24.jpg'),
(25, 2, 2, 'Gato vani', 120000, 'vnđ', 43, 'Bánh kem vani bánh quế', '/Web2/admin/public/images/SanPham/SP-25.jpg'),
(26, 4, 2, 'Mochi matcha', 30000, 'vnđ', 25, 'Bánh mochi Nhật vị matcha', '/Web2/admin/public/images/SanPham/SP-26.jpg'),
(27, 2, 2, 'Gato black socola', 115000, 'vnđ', 27, 'Bánh kem socola đen ', '/Web2/admin/public/images/SanPham/SP-27.jpg'),
(28, 3, 2, 'Teramisu vani', 27000, 'vnđ', 16, 'Bánh vị vani', '/Web2/admin/public/images/SanPham/SP-28.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `maTK` int(5) UNSIGNED NOT NULL,
  `maQuyen` int(5) UNSIGNED NOT NULL,
  `tenTaiKhoan` varchar(255) NOT NULL,
  `matKhau` varchar(255) NOT NULL,
  `trangThai` tinyint(1) NOT NULL DEFAULT 1,
  `anhDaiDien` varchar(255) DEFAULT NULL,
  `dangNhap` tinyint(1) NOT NULL DEFAULT 0,
  `thoiGianTao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`maTK`, `maQuyen`, `tenTaiKhoan`, `matKhau`, `trangThai`, `anhDaiDien`, `dangNhap`, `thoiGianTao`) VALUES
(1, 3, 'khach', '$2y$10$gbmWO5zUnnAE3LDxUqtjHefKxfs8NXbGg5Z4MlkrRHjUabhhLHPOy', 1, '/Web2/admin/public/images/TaiKhoan/TK-1.jpg', 0, '2021-05-04'),
(2, 1, 'admin', '$2y$10$KjRc21x2cqB6r59jBeXL7eL3yhmtw7LVX4vOHrW9nT/NDRCf3XT8u', 1, '/Web2/admin/public/images/TaiKhoan/TK-2.jpg', 0, '2021-05-04'),
(3, 2, 'nv1', '$2y$10$gwiuVn1821TLlRs2KdRmrOM9qOglB2elxOiHmAQFdIndr3nGfxBzq', 1, '/Web2/admin/public/images/TaiKhoan/TK-3.jpg', 0, '2021-05-04'),
(4, 3, 'tai1', '$2y$10$c4UbIWH86KH1sAf4L6/ZX.V7Kk7A7RKtdSJ9Is9hZgr0nEu90TXAK', 1, '/Web2/admin/public/images/TaiKhoan/TK-4.jpg', 0, '2021-05-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`stt`),
  ADD KEY `maSP` (`maSP`),
  ADD KEY `maHD` (`maHD`);

--
-- Indexes for table `chitietphieunhaphang`
--
ALTER TABLE `chitietphieunhaphang`
  ADD PRIMARY KEY (`stt`),
  ADD KEY `maSP` (`maSP`),
  ADD KEY `maPhieu` (`maPhieu`);

--
-- Indexes for table `chucnang`
--
ALTER TABLE `chucnang`
  ADD PRIMARY KEY (`maCN`);

--
-- Indexes for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`maHD`),
  ADD KEY `maNV` (`maNV`),
  ADD KEY `maKH` (`maKH`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`maKH`),
  ADD UNIQUE KEY `maTK_2` (`maTK`),
  ADD KEY `maTK` (`maTK`);

--
-- Indexes for table `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`maLoai`);

--
-- Indexes for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`maNCC`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`maNV`),
  ADD KEY `maTK` (`maTK`);

--
-- Indexes for table `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  ADD PRIMARY KEY (`maNSX`);

--
-- Indexes for table `phieunhaphang`
--
ALTER TABLE `phieunhaphang`
  ADD PRIMARY KEY (`maPhieu`),
  ADD KEY `maNCC` (`maNCC`),
  ADD KEY `maNV` (`maNV`);

--
-- Indexes for table `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`maQuyen`);

--
-- Indexes for table `quyenchucnang`
--
ALTER TABLE `quyenchucnang`
  ADD PRIMARY KEY (`stt`),
  ADD KEY `maQuyen` (`maQuyen`),
  ADD KEY `maChucNang` (`maCN`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`maSP`),
  ADD KEY `maLoai` (`maLoai`),
  ADD KEY `maNSX` (`maNSX`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`maTK`),
  ADD UNIQUE KEY `tenTaiKhoan` (`tenTaiKhoan`),
  ADD KEY `maQuyen` (`maQuyen`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  MODIFY `stt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `chitietphieunhaphang`
--
ALTER TABLE `chitietphieunhaphang`
  MODIFY `stt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chucnang`
--
ALTER TABLE `chucnang`
  MODIFY `maCN` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hoadon`
--
ALTER TABLE `hoadon`
  MODIFY `maHD` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `maKH` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `maLoai` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `maNCC` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `maNV` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  MODIFY `maNSX` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `phieunhaphang`
--
ALTER TABLE `phieunhaphang`
  MODIFY `maPhieu` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quyen`
--
ALTER TABLE `quyen`
  MODIFY `maQuyen` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quyenchucnang`
--
ALTER TABLE `quyenchucnang`
  MODIFY `stt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `maSP` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `maTK` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD CONSTRAINT `chitiethoadon_ibfk_1` FOREIGN KEY (`maHD`) REFERENCES `hoadon` (`maHD`),
  ADD CONSTRAINT `chitiethoadon_ibfk_2` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`);

--
-- Constraints for table `chitietphieunhaphang`
--
ALTER TABLE `chitietphieunhaphang`
  ADD CONSTRAINT `chitietphieunhaphang_ibfk_1` FOREIGN KEY (`maSP`) REFERENCES `sanpham` (`maSP`),
  ADD CONSTRAINT `chitietphieunhaphang_ibfk_2` FOREIGN KEY (`maPhieu`) REFERENCES `phieunhaphang` (`maPhieu`);

--
-- Constraints for table `hoadon`
--
ALTER TABLE `hoadon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`maKH`) REFERENCES `khachhang` (`maKH`),
  ADD CONSTRAINT `hoadon_ibfk_2` FOREIGN KEY (`maNV`) REFERENCES `nhanvien` (`maNV`);

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`maTK`) REFERENCES `taikhoan` (`maTK`);

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`maTK`) REFERENCES `taikhoan` (`maTK`);

--
-- Constraints for table `phieunhaphang`
--
ALTER TABLE `phieunhaphang`
  ADD CONSTRAINT `phieunhaphang_ibfk_1` FOREIGN KEY (`maNCC`) REFERENCES `nhacungcap` (`maNCC`),
  ADD CONSTRAINT `phieunhaphang_ibfk_2` FOREIGN KEY (`maNV`) REFERENCES `nhanvien` (`maNV`);

--
-- Constraints for table `quyenchucnang`
--
ALTER TABLE `quyenchucnang`
  ADD CONSTRAINT `quyenchucnang_ibfk_1` FOREIGN KEY (`maCN`) REFERENCES `chucnang` (`maCN`),
  ADD CONSTRAINT `quyenchucnang_ibfk_2` FOREIGN KEY (`maQuyen`) REFERENCES `quyen` (`maQuyen`);

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`maLoai`) REFERENCES `loaisanpham` (`maLoai`),
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`maNSX`) REFERENCES `nhasanxuat` (`maNSX`),
  ADD CONSTRAINT `sanpham_ibfk_3` FOREIGN KEY (`maSP`) REFERENCES `chitietkhuyenmai` (`maSP`);

--
-- Constraints for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD CONSTRAINT `taikhoan_ibfk_1` FOREIGN KEY (`maQuyen`) REFERENCES `quyen` (`maQuyen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
