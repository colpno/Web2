<?php
require "./database/connection.php";
require "./database/SanPhamDB.php";
$spDB = new SanPhamDB();
$sosp1trang = 9;

$trang = $_POST['trang'];
$loai = $_POST['loai'];
$search = $_POST['search'];
$from = $_POST['from'];
$to = $_POST['to'];
$sort = $_POST['sort'];

settype($trang, "int");

$spArr = json_decode($spDB->page($trang, $sosp1trang, $loai, $search, $from, $to, $sort), true);

$sosp = json_decode($spDB->countSearch($loai, $search, $from, $to, $sort), true)[0]['sosp'];

if (count($spArr) < 1) {
    echo '<div class="container-fluid"><h3 class="text-center">Không có sản phẩm</h3></div>';
} else {
    foreach ($spArr as $key => $value) {
        if ($value['soLuong'] > 0) {
            echo "<a href='index.php?content=chitietsanpham&maSP=" . $value['maSP'] . "' target='_self' class='col-xl-4 col-lg-6 col-md-12 col-sm-6'>";
        } else {
            echo "<a class='col-xl-4 col-lg-6 col-md-12 col-sm-6'>";
        }

        echo "  <div class='product-item mb-4'>
                    <div class='product-item__img'";
        if (strpos($value['anhDaiDien'], 'Web2') !== false) {
            echo " style='background-image:url(" .  $value['anhDaiDien'] . ");'>";
        } else {
            echo " style='padding: 0'><img src='/Web2/admin/" .  $value['anhDaiDien'] . "'>";
        }
        echo "</div><div class='product-item__content'>
                        <div class='product-item__name'>" . $value['tenSP'] . "</div>
                        <div class='product-item__price'>
                            <div class='product-item__price__content'>
                                <div class='product-item__price-number'>" . $value['donGia'] . " VNĐ</div>";
        if ($value['soLuong'] > 0) {
            echo "<div class='product-item__amount'>Còn hàng</div>";
        } else {
            echo "<div class='product-item__amount no-product'>Hết hàng</div>";
        }

        echo                   "</div>
                            <button type='button' class='product-item__price__button '>Mua</button>
                        </div>
                    </div>
                </div>
            </a>";
    }
    echo "<div class='container-fluid'> <ul class='pagination pl-4'>";
    $soluongtrang = ceil($sosp / $sosp1trang);
    if ($soluongtrang > 1) {
        for ($i = 1; $i <= $soluongtrang; $i++) {
            if ($i == $trang) {
                echo "<li class='page-item active' onclick='page(" . $i . "),scrollpage()' ><div class='page-link'>" . $i . "</div></li>";
            } else {
                echo "<li class='page-item' onclick='page(" . $i . "),scrollpage()' ><div class='page-link'>" . $i . "</div></li>";
            }
        }
    }
    echo "</ul></div>";
}
