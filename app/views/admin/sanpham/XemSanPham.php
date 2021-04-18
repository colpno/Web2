    <link rel="stylesheet" href="/Web2/public/css/admin/sanpham/XemSanPham.css">
    <div class="container">
        <?php print_r($_POST['title']) ?>
        <div class="product--show row">
            <?php
            foreach ($_POST['data']['SPArr'] as $key => $value) {
                echo '
                        <div class="center checkbox col-lg-1 col-md-12 col-sm-12">
                            <input class="product__checkbox" type="checkbox" value="' . $value['maSP'] . '" ></input>
                        </div>
                        <div class="center col-lg-2 col-md-2 col-sm-12">
                            <img src="' . $value['anhDaiDien'] . '" onerror="this.src="images/no-img.png""  />
                        </div>
                        <span class="center-left col-lg-3 col-md-4 col-sm-12">' . $value['tenSP'] . '</span>
                        <span class="center-right col-lg-2 col-md-1 col-sm-12">' . $value['donGia'] . ' ' . $value['donViTinh'] . '</span>
                        <span class="center col-lg-2 col-md-2 col-sm-12">' . $value['soLuong'] . '</span>
                        <div class="center col-lg-2 col-md-3 col-sm-12">
                            <button class="btn " onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                            <button class="btn " onclick="delOneete(this)"><i class="far fa-trash-alt"></i></button>
                        </div>
                    ';
            }
            ?>
        </div>
    </div>