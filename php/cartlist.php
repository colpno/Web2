<?php
    session_start();
    require "./database/connection.php";
    require "./database/SanPhamDB.php";
    $spDB=new SanPhamDB();
    
    if (isset($_SESSION['giohang'])) {
        $cartArr=$_SESSION['giohang'];
    }
    else {
        $cartArr=array();
    }
    if (isset($_POST['muahang'])) {
        if (isset($_GET['maSP'])) {
            if ($_POST['soLuong']!="" || $_POST['soLuong']!=0) {

                $spArr=json_decode($spDB->searchMaSP($_GET['maSP']),true);
                $soluongsp=$spArr[0]['soLuong'];
                $soluongsp-=$_POST['soLuong'];
                $spDB->updateSoLuong($_GET['maSP'],$soluongsp);

                $cart['maSP']=$_GET['maSP'];
                $cart['soLuong']=$_POST['soLuong'];
                foreach ($cartArr as $key=> &$value) {
                    if ($cart['maSP']==$value['maSP']) {
                        $value['soLuong']+=$cart['soLuong'];
                        unset($cart);
                        break;
                    }
                }
                if (isset($cart)) {
                    $cartArr[]=$cart;  
                }
                $_SESSION['giohang']=$cartArr;
                header('Location: http://localhost:8080/web2/index.php?content=sanpham');
            }
        }
    }
?>


