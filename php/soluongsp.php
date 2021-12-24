<?php
    session_start();
    require "./database/connection.php";
    require "./database/SanPhamDB.php";
    $sp=new SanPhamDB();

    if (isset($_SESSION['giohang'])) {
        $cart=$_SESSION['giohang'];
    }
    
    if (isset($_POST['prevsp'])) {
        $masp=$_POST['prevsp'];
        $spArr=json_decode($sp->searchMaSP($masp),true);
        foreach ($cart as $key=>&$value) {
            if ($value['maSP']==$masp) {
                $value['soLuong']-=1;
            }
        }
        $_SESSION['giohang']=$cart;
        $sl=$spArr[0]['soLuong']+1;
        $sp->updateSoLuong($masp,$sl);
    }
    
    if (isset($_POST['nextsp'])) {
        $masp=$_POST['nextsp'];
        $spArr=json_decode($sp->searchMaSP($masp),true);
        foreach ($cart as $key=>&$value) {
            if ($value['maSP']==$masp) {
                $value['soLuong']+=1;
            }
        }
        $_SESSION['giohang']=$cart;
        $sl=$spArr[0]['soLuong']-1;
        $sp->updateSoLuong($masp,$sl);
    }

    if (isset($_POST['inputsp'])) {
        $masp=$_POST['inputsp'];
        $slbd=$_POST['slbd'];
        $slht=$_POST['sl'];
        $spArr=json_decode($sp->searchMaSP($masp),true);
        foreach ($cart as $key=>&$value) {
            if ($value['maSP']==$masp) {
                $value['soLuong']=$value['soLuong']-$slbd+$slht;;
            }
        }
        $_SESSION['giohang']=$cart;
        $sl=$spArr[0]['soLuong']+$slbd-$slht;
        $sp->updateSoLuong($masp,$sl);
    }
?>