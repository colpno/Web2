<?php 
    

    

if (isset($_SESSION['user'])) {
    require "./php/database/HoaDonDB.php";
    require "./php/database/ChiTietHoaDonDB.php";

    $hd=new HoaDonDB();
    $cthd=new ChiTietHoaDonDB();
    $sp=new SanPhamDB();
        echo '<div class="container">
            <div class="info-cart-list table-responsive-lg">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Mã Hoá đơn</th>
                        <th scope="col">Ngày đặt mua</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>';
        $hdArr=json_decode($hd->listMaKH($_SESSION['user']['maKH']),true);
        if (!empty($hdArr)) {
            foreach ($hdArr as $key=>$value) {
                $cthdArr=json_decode($cthd->listHD($value['maHD']),true);
                echo '<tr data-toggle="collapse" data-target="#infocartlist'.$key.'" class="row-click">
                            <th scope="row">'.($key+1).'</th>
                            <td>'.$value['maHD'].'</td>
                            <td>'.$value['ngayLapHoaDon'].'</td>
                            <td>'.$value['diaChi'].'</td>
                            <td>'.$value['tongTien'].'</td>
                        </tr>
                        <tr id="infocartlist'.$key.'" class="collapse">
                            <td class="info-cart bg-light" colspan="5">
                                <div class="row info-cart__header">
                                    <div class="col-4 ">Tên sản phẩm</div>
                                    <div class="col-3 ">Giá tiền(VNĐ)</div>
                                    <div class="col-2 text-center">Số lượng</div>
                                    <div class="col-3 text-right">Thành tiền(VNĐ)</div>
                                </div>';

                foreach ($cthdArr as $ten=>$giatri) {
                    $spArr=json_decode($sp->searchMaSP($giatri['maSP']),true);
                    echo '      <div class="row info-cart__item py-1">
                                    <div class="col-4">'.$spArr[0]['tenSP'].'</div>
                                    <div class="col-3 ">'.$giatri['donGia'].'</div>
                                    <div class="col-2 text-center">'.$giatri['soLuong'].'</div>
                                    <div class="col-3 text-right">'.$giatri['thanhTien'].'</div>
                                </div>';
                }
                echo    '</td>
                    </tr>';
                
            }
        }
        echo            '</tbody>
                </table>
            </div>
        </div>';
    }
    else {
        require "./php/container.php"; 
        exit();
    }
    
?>



