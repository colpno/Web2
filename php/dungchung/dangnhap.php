<?php
    session_start();
    require "../database/connection.php";
    require "../database/TaiKhoanDB.php";
    require "../database/KhachHangDB.php";
    require "../database/NhanVienDB.php";
    require "../database/QuyenDB.php";
    require "../database/SanPhamDB.php";
    $tk=new TaiKhoanDB();
    $kh=new KhachHangDB();
    $nv=new NhanVienDB();
    $q=new QuyenDB();
    $sp=new SanPhamDB();

    if (isset($_POST['tentk'])) {
        $result=0;
        $name=$_POST['tentk'];
        $user=array();
        if ($tkArr=json_decode($tk->searchTenTK($name),true)) {
            $nvArr;
            $khArr;
            $tenQuyen=json_decode($q->searchQuyen($tkArr[0]['maQuyen']),true);
            if ($nvArr=json_decode($nv->searchMaNV($tkArr[0]['maTK']),true)) {
                $user['maKH']=$nvArr[0]['maNV'];
                $user['ho']=$nvArr[0]['ho'];
                $user['ten']=$nvArr[0]['ten'];
            }
            if ($khArr=json_decode($kh->searchMaKH($tkArr[0]['maTK']),true)) {
                $user['maKH']=$khArr[0]['maKH'];
                $user['ho']=$khArr[0]['ho'];
                $user['ten']=$khArr[0]['ten'];
            }
            if (count($tkArr)>=1) {
                if (password_verify($_POST['matkhau'],$tkArr[0]['matKhau'])) {
                    if ($tkArr[0]['trangThai']==0) {
                        $result=-1;
                    }
                    else {
                        if ($tkArr[0]['maQuyen']!=3) {
                            $result=2;
                        }
                        else {
                            $result=1;
                        }
                        $user['maTK']=$tkArr[0]['maTK'];
                        $user['quyen']=$tkArr[0]['maQuyen'];
                        $user['anh']=$tkArr[0]['anhDaiDien'];
                        $user['tenQuyen']=$tenQuyen[0]['tenQuyen'];
                        $_SESSION['user']=$user;
                    }
                }
            }
        }
        echo $result;
    }
    if (isset($_POST['exit'])) {
        if ($_SESSION['giohang']) {
            $spArr=$_SESSION['giohang'];
            if (count($spArr)>0) {
                foreach ($spArr as $key=>$value) {
                    $spSr=json_decode($sp->searchMaSP($value['maSP']),true);
                    $soluongsp=$spSr[0]['soLuong']+$value['soLuong'];
                    $sp->updateSoLuong($value['maSP'],$soluongsp);
                }
            }
        }
        session_destroy();
    }
