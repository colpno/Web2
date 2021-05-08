<?php
    require "../database/connection.php";
    require "../database/TaiKhoanDB.php";
    require "../database/KhachHangDB.php";
    $tk=new TaiKhoanDB();
    $kh=new KhachHangDB();
    if (isset($_POST['tenTK'])) {
        $name=$_POST['tenTK'];
        $tkArr=json_decode($tk->searchTenTK($name),true);
        if (count($tkArr)>=1) {
            echo "Tài khoản đã tồn tại";
        }
    }
    if (isset($_POST['tk'])) {
        $taikhoan=$_POST['tk'];
        $matkhau=password_hash($_POST['matkhau'], PASSWORD_DEFAULT );
        $ho=$_POST['ho'];
        $ten=$_POST['ten'];
        //$diachi=$_POST['diachi'];
        $sodienthoai=$_POST['sodienthoai'];
        $tk->them($taikhoan,$matkhau);
        $tkSr=json_decode($tk->searchTenTK($taikhoan),true);
        $kh->them($tkSr[0]['maTK'],$ho,$ten/*,$diachi*/,$sodienthoai);
        echo "Đăng ký thành công";
    }

    
?>