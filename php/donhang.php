<?php
    session_start();

    require "./database/connection.php";
    require "./database/SanPhamDB.php";
    require "./database/HoaDonDB.php";
    require "./database/ChiTietHoaDonDB.php";
    require "./database/KhachHangDB.php";

    $sp=new SanPhamDB();
    $hd=new HoaDonDB();
    $cthd=new ChiTietHoaDonDB();
    $kh=new KhachHangDB();

    $tong=$_POST['tong'];
    $diachi=$_POST['diachi'];
    $sodienthoai=$_POST['sodienthoai'];
    
    $maKH=$_SESSION['user']['maKH'];
    $ngay=date("Y-m-d");
        $hd->themHD($maKH,$ngay,$tong,$diachi,$sodienthoai);
        $maHD=json_decode($hd->searchMaHD(),true);
        $kh->updateDiaChi($maKH,$diachi);
        $arr=array();
        $cartArr=$_SESSION['giohang'];
    
        foreach ($cartArr as $key=>$value) {
            $spArr=json_decode($sp->searchMaSP($value['maSP']),true);
    
            $spCart['maSP']=$value['maSP'];
            $spCart['soLuong']=$value['soLuong'];
            $spCart['donGia']=$spArr[0]['donGia'];
            $spCart['thanhTien']=$spArr[0]['donGia']*$value['soLuong'];
            $arr[]=$spCart;
        }
            $cthd->themChiTietHD($maHD[0]['maHDN']-1,$arr);
            unset($_SESSION['giohang']);
?>