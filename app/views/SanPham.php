<div class="product container">
    <div class="product-report__row row ">
        <div class='product-report__row__report col-3'>
            <div class="report-item">
                <div class="report-item__text">
                    <span class="customer-report__number">34</span>
                    <img src="public/images/Icon/user_groups.png" />
                </div>
                <p>Customer</p>
            </div>
        </div>
        <div class='product-report__row__report col-3'>
            <div class="report-item">
                <div class="report-item__text">
                    <span class="product-report__number">25</span>
                    <img src="public/images/Icon/shortlist.png" />
                </div>
                <p>Product</p>
            </div>
        </div>
        <div class='product-report__row__report col-3'>
            <div class="report-item">
                <div class="report-item__text">
                    <span class="bill-report__number">76</span>
                    <img src="public/images/Icon/shopping-bag.png" />
                </div>
                <p>Bill</p>
            </div>
        </div>
        <div class='product-report__row__report col-3'>
            <div class="report-item">
                <div class="report-item__text">
                    <span class="income-report__number">59</span>
                    <img src="public/images/Icon/increase.png" />
                </div>
                <p>Income</p>
            </div>
        </div>
    </div>
    <div class="product__title row">
        <input type="checkbox" class="hidden product-item-title col-lg-1"></input>
        <h5 class="hidden product-item-title col-lg-2">Hình ảnh</h5>
        <h5 class="hidden product-item-title col-lg-3">Tên bánh</h5>
        <h5 class="hidden product-item-title col-lg-2">Số tiền</h5>
        <h5 class="hidden product-item-title col-lg-2">Số lượng</h5>
        <h5 class="hidden product-item-title col-lg-2">Chỉnh sửa</h5>
    </div>
    <hr>
    <div class="product--show row">
        <?php
        if (isset($SPArr)) {
            $length = count($SPArr);
            for ($i = 0; $i < $length; $i++) {
                echo '
                <input type="checkbox" value="' . $SPArr[$i]['maSP'] . '" class="cake__id col-lg-1 col-md-12 col-sm-12"></input>
                <div class="cake__img col-lg-2 col-md-2 col-sm-12">
                    <img src="' . $SPArr[$i]['anhDaiDien'] . '" onerror="this.src="images/no-img.png""  />
                </div>
                <span class="cake__name col-lg-3 col-md-4 col-sm-12">' . $SPArr[$i]['tenSP'] . '</span>
                <span class="cake__money col-lg-2 col-md-1 col-sm-12">' . $SPArr[$i]['donGia'] . ' ' . $SPArr[$i]['donViTinh'] . '</span>
                <span class="cake__type col-lg-2 col-md-2 col-sm-12">' . $SPArr[$i]['soLuong'] . '</span>
                <div class="cake__cmd col-lg-2 col-md-3 col-sm-12">
                    <button class="btn primary-btn cake__update" onclick="updateCake(this)"><i class="las la-edit"></i></button>
                    <button class="btn danger-btn cake__delete" onclick="deleteCake(this)"><i class="las la-trash-alt"></i></button>
                </div>
            ';
            }
        }
        ?>
    </div>
</div>
<?php
if (isset($SPFound)) {
    echo "<pre>";
    print_r($SPFound);
    echo "</pre>";
}
