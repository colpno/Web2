<?php
$spDB = new SanPhamDB();
$spArr = json_decode($spDB->searchMaSP($_GET['maSP']), true);
$spLoai = json_decode($spDB->searchTenLoai($spArr[0]['maLoai']), true);

if (isset($_SESSION['user'])) {
    echo "<div class='container'>
            <div class='row'>
                <div class='col-12 my-4 '>
                    <a href='index.php?content=sanpham' class='pl-4 lead product-back col-md-2 col-sm-4 '>
                        <i class='fas fa-long-arrow-alt-left'></i>
                        <div class='pl-4'>Quay lại</div>
                    </a>
                </div>
            </div>
            <div class='row detail'>
                <div class='col-md-6 col-sm-12'>
                    <div class='detail-img' style='background-image:url(" . $spArr[0]['anhDaiDien'] . ");'></div>
                </div>
                <div class='col-md-6 col-sm-12'>
                    <form action='./php/cartlist.php?maSP=" . $spArr[0]['maSP'] . "' method='POST'>
                        <div class='detail-name'>" . $spArr[0]['tenSP'] . "</div>
                        <div class='detail-category'>Loại: " . $spLoai[0]['tenLoai'] . "</div>
                        <div class='detail-price'>" . $spArr[0]['donGia'] . " VNĐ</div>
                        <div class='detail-input cart-list-input'>
                            <div class='cart-list-input__prev' onclick='prevNumber()'>-</div>
                            <input autocomplete='off' type='text' id='slNumber' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onchange='inputnumber(" . $spArr[0]['soLuong'] . ")' name='soLuong' class='cart-list-input__text' value='1'>
                            <div class='cart-list-input__next' onclick='nextNumber(" . $spArr[0]['soLuong'] . ")'>+</div>
                        </div>
                        <div class='detail-description'>" . $spArr[0]['moTa'] . "</div>
                        <input autocomplete='off' type='submit' name='muahang' value='Mua hàng' class='detail-submit'>
                    </form>
                </div>
            </div>
        </div>";
} else {
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
