
<?php
    // Đã xóa trên header
    /*if (isset($_GET['action'])) {
        if ($_GET['action']=="xoa" && isset($_GET['masp'])) {
            $cartArr=$_SESSION['giohang'];
            foreach ($cartArr as $key=>$value) {
                if ($value['maSP']==$_GET['masp']) {
                    unset($_SESSION['giohang'][$key]);
                    break;
                }
            }
        }
    }*/

    if (isset($_SESSION['user'])) {
        if (isset($_SESSION['giohang'])) {
            if (empty($_SESSION['giohang'])) {
               echo '<div class="container-fluid bg-light">
                        <div class="cart  py-5 px-3 border-top border-bottom">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 mb-4 text-center">
                                    <div class="cart-list-none-header">Giỏ hàng trống!</div>
                                    <div class="cart-list-none-content">Vui lòng quay lại mua hàng!</div>
                                    <a href="index.php?content=sanpham" class="cart-list-none-link">Xem sản phẩm</a></div>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            else {
                echo '<div class="container-fluid bg-light">
                    <div class="cart  py-5 px-3 border-top border-bottom">
                        <div class="row">
                            <div class="col-md-8 col-sm-12 mb-4">
                                <h4>Danh sách sản phẩm</h4>';
                                    $sum=0;
                                    $spDB=new SanPhamDB();
                                    $cartArr=$_SESSION['giohang'];
                                    foreach ($cartArr as $key=>$value) {
                                        $sp=json_decode($spDB->searchMaSP($value['maSP']),true);
                                        echo '<div class="cart-list py-3 border-top border-bottom">
                                                <div class="col-md-3 ">
                                                    <img src="'.".".substr($sp[0]["anhDaiDien"],5).'" class="cart-list-img ">
                                                </div>
                                                <div class="cart-list__content col-md-6 ">
                                                    <div class="cart-list-item__name ">'.$sp[0]["tenSP"].'</div>
                                                    <div class="cart-list-item__price">
                                                        <div class="cart-list-item__price-number">'.$sp[0]["donGia"].'</div>
                                                        <div class="cart-list-item__price-icon"> VNĐ</div>
                                                    </div>
                                                    <div class="cart-list-input-number">Số lượng '.$value['soLuong'].'</div>
                                                </div>
                                                
                                                <div class="col-md-3 cart-list-sub">
                                                    <div class="cart-list__subprice">
                                                        <div class="cart-list__subprice-number">'.$sp[0]["donGia"]*$value['soLuong'].'</div>
                                                        <div class="cart-list__subprice-icon"> VNĐ</div>
                                                    </div>
                                                    <button type="button" class="btn close" data-toggle="modal" data-target="'."#exampleModal".$key.'">
                                                    &times;
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="'."exampleModal".$key.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Xóa sản phẩm khỏi giỏ hàng!</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Bạn có chắc là muốn xóa sản phẩm này khỏi giỏ hàng?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                            <button type="button" class="btn btn-danger" onclick="deletecart('.$sp[0]["maSP"].')">Xóa</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>';
                                        $sum+=$sp[0]["donGia"]*$value['soLuong'];
                                    }
                        echo'</div>
                            <div class="col-md-4 col-sm-12 mb-4">
                                <h4>Hóa đơn</h4>
                                <div class="cart-order border-top border-bottom py-3">
                                    <div class="cart-list-subtotal py-2">
                                        <div class="cart-list-subtotal__content">Tổng cộng</div>
                                        <div class="cart-list-subtotal__number">
                                            <div class="cart-list-subtotal__number__price">'.$sum.'</div>
                                            <div class="cart-list-subtotal__number__icon">VNĐ</div>
                                        </div>
                                    </div>
                                    <div class="cart-list-shipping py-3">
                                        <div class="cart-list-shipping__content">Shipping</div>
                                        <div class="cart-list-shipping__number">FREE</div>
                                    </div>
                                </div>
                                <div class="cart-list-total py-3">
                                    <div class="cart-list-total__content">Tổng</div>
                                    <div class="cart-list-total__number">
                                        <div class="cart-list-total__number__price">'.$sum.'</div>
                                        <div class="cart-list-total__number__icon">VNĐ</div>
                                    </div>
                                </div>
                                <div class="cart-list-info-customer my-3">
                                    <input type="text" id="cart-info-phone" class="cart-list-info-customer__item form-control my-3" placeholder="Số điện thoại liên lạc">
                                    <div id="cart-info-phone-error"></div>
                                    <input type="text" id="cart-info-address" class="cart-list-info-customer__item form-control mb-3" placeholder="Địa chỉ nhận hàng">
                                    <div id="cart-info-address-error"></div>
                                </div>
                                <div class="text-center mt-3">
                                    <button id="pay" type="button" class="btn btn-outline-primary ">Thanh toán</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }
        else {
            echo '<div class="container-fluid bg-light">
            <div class="cart  py-5 px-3 border-top border-bottom">
                <div class="row">
                    <div class="col-md-12 col-sm-12 mb-4 text-center">
                        <div class="cart-list-none-header">Giỏ hàng trống!</div>
                        <div class="cart-list-none-content">Vui lòng quay lại mua hàng!</div>
                        <a href="index.php?content=sanpham" class="cart-list-none-link">Xem sản phẩm</a></div>
                    </div>
                </div>
            </div>
        </div>';
        }
    }
    else {
        echo '<div class="container-fluid bg-light">
            <div class="cart  py-5 px-3 border-top border-bottom">
                <div class="row">
                    <div class="col-md-12 col-sm-12 mb-4 text-center">
                        <div class="cart-list-none-user">Vui lòng đăng nhập trước để mua hàng!</div>
                    </div>
                </div>
            </div>
        </div>';
    }

?>