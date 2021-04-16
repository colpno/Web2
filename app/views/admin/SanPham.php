    <link rel="stylesheet" href="/Web2/public/css/admin/SanPhamAdmin.css">

    <div class="product container">
        <div class="product-report__row row ">
            <div class='product-report__row__report col-3'>
                <div class="report-item">
                    <div class="report-item__text">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $soLuong = $_SESSION['get']['SanPham']['TongSoSanPham']['tongSoLuong'];
                            echo "<span class='center-left product-report__number'>$soLuong</span>";
                        }
                        ?>
                        <img src="/Web2/public/images/Icon/shortlist.png" />
                    </div>
                    <p>Sản phẩm</p>
                </div>
            </div>
            <div class='product-report__row__report col-3'>
                <div class="report-item">
                    <div class="report-item__text">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $soLuong = $_SESSION['get']['Loai']['TongSoLoai']['tongSoLuong'];
                            echo "<span class='center-left customer-report__number'>$soLuong</span>";
                        }
                        ?>
                        <img src="/Web2/public/images/Icon/user_groups.png" />
                    </div>
                    <p>Loại</p>
                </div>
            </div>
            <div class='product-report__row__report col-3'>
                <div class="report-item">
                    <div class="report-item__text">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $soLuong = $_SESSION['get']['KhuyenMai']['TongSoKhuyenMai']['tongSoLuong'];
                            echo "<span class='center-left promotion-report__number'>$soLuong</span>";
                        }
                        ?>
                        <img src="/Web2/public/images/Icon/shopping-bag-promotion.png" />
                    </div>
                    <p>Khuyến mãi</p>
                </div>
            </div>
            <div class='product-report__row__report col-3'>
                <div class="report-item">
                    <div class="report-item__text">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $length = $_SESSION['get']['SanPham']['SPMin']['soLuong'];
                            echo "<span class='center-left bill-report__number'>$length</span>";
                        }
                        ?>
                        <img src="/Web2/public/images/Icon/increase.png" />
                    </div>
                    <p>Số lượng sản phẩm ít nhất</p>
                </div>
            </div>
        </div>
        <div class="content--show row">
            <div class="col-lg-8">
                <div class="product__row">
                    <div class="content-item__header">
                        <span>Sản phẩm mới</span>
                        <button>See all <i class="fas fa-long-arrow-alt-right"></i></button>
                    </div>
                    <div class="title--border">
                        <div class="product__title row">
                            <div class="center checkbox product-item-title col-lg-1">
                                <input type="checkbox" class="product__master-checkbox" onclick=" checkAll(this)"></input>
                                <i class="product--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            </div>
                            <h6 class="center product-item-title col-lg-2">Hình ảnh</h6>
                            <h6 class="center product-item-title col-lg-3">Tên bánh</h6>
                            <h6 class="center product-item-title col-lg-2">Số tiền</h6>
                            <h6 class="center product-item-title col-lg-2">Số lượng</h6>
                            <h6 class="center product-item-title col-lg-2">Chỉnh sửa</h6>
                        </div>
                    </div>
                    <div class="product--show row">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $SanPham = $_SESSION['get']['SanPham']['SPData']['SPArr'];
                            $length = count($SanPham);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                                    <input type="checkbox" class="product__checkbox" value="' . $SanPham[$i]['maSP'] . '"></input>
                                </div>
                                <div class="center col-lg-2 col-md-2 col-sm-12">
                                    <img class="product-' . $SanPham[$i]['maSP'] . '" src="' . $SanPham[$i]['anhDaiDien'] . '" onerror="this.src="images/no-img.png""  />
                                </div>
                                <span class="center-left col-lg-3 col-md-4 col-sm-12">' . $SanPham[$i]['tenSP'] . '</span>
                                <span class="center col-lg-2 col-md-1 col-sm-12">' . $SanPham[$i]['donGia'] . ' ' . $SanPham[$i]['donViTinh'] . '</span>
                                <span class="center col-lg-2 col-md-2 col-sm-12">' . $SanPham[$i]['soLuong'] . '</span>
                                <div class="center cake__cmd col-lg-2 col-md-3 col-sm-12">
                                    <button class="product-' . $SanPham[$i]['maSP'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                                    <button class="product-' . $SanPham[$i]['maSP'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                </div>
                            ';
                            }
                        }
                        ?>
                    </div>
                    <div class="content-item__pagination row">
                        <div class="text-center center paginate">
                            <button></button>
                            <button></button>
                            <button class="current-page">1</button>
                            <button>2</button>
                            <button>3</button>
                            <button></button>
                            <button></button>
                        </div>
                        <?php
                        if (isset($_SESSION['get'])) {
                            $length = $_SESSION['get']['SanPham']['SPData']['SPPages'];

                            for ($i = 0; $i < $length; $i++) {
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="category__row">
                    <div class="content-item__header">
                        <span>Loại</span>
                        <button>See all <i class="fas fa-long-arrow-alt-right"></i></button>
                    </div>
                    <div class="title--border">
                        <div class="category__title row">
                            <div class="center category-item-title checkbox col-lg-2">
                                <input type="checkbox" class="category__master-checkbox" onclick="checkAll(this)"></input>
                                <i class="category--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            </div>
                            <h6 class="center category-item-title col-lg-6">Loại bánh</h6>
                            <h6 class="center category-item-title col-lg-4">Chỉnh sửa</h6>
                        </div>
                    </div>
                    <div class="category--show row">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $Loai = $_SESSION['get']['Loai']['LoaiData']['LSPArr'];
                            $length = count($Loai);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                                    <input type="checkbox" class="category__checkbox" value="' . $Loai[$i]['maLoai'] . '"></input>
                                </div>
                                <span class="center-left col-lg-6 col-md-4 col-sm-12">' . $Loai[$i]['tenLoai'] . '</span>
                                <div class="center cake__cmd col-lg-4 col-md-3 col-sm-12">
                                    <button class="category-' . $Loai[$i]['maLoai'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                                    <button class="category-' . $Loai[$i]['maLoai'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                </div>
                            ';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="promotion__row">
                    <div class="content-item__header">
                        <span>Khuyến mãi</span>
                        <button>See all <i class="fas fa-long-arrow-alt-right"></i></button>
                    </div>
                    <div class="title--border">
                        <div class="promotion__title row">
                            <div class="center promotion-item-title checkbox col-lg-1">
                                <input type="checkbox" class="promotion__master-checkbox" onclick="checkAll(this)"></input>
                                <i class="promotion--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            </div>
                            <h6 class="center promotion-item-title col-lg-5">Khuyến mãi</h6>
                            <h6 class="center promotion-item-title col-lg-2">Bắt đầu</h6>
                            <h6 class="center promotion-item-title col-lg-2">Kết thúc</h6>
                            <h6 class="center promotion-item-title col-lg-2">Chỉnh sửa</h6>
                        </div>
                    </div>
                    <div class="promotion--show row">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $KhuyenMai = $_SESSION['get']['KhuyenMai']['Data']['KMArr'];
                            $length = count($KhuyenMai);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                                    <input type="checkbox" class="promotion__checkbox" value="' . $KhuyenMai[$i]['maKM'] . '"></input>
                                </div>
                                <span class="center-left col-lg-5 col-md-4 col-sm-12">' . $KhuyenMai[$i]['tenKM'] . '</span>
                                <span class="center col-lg-2 col-md-4 col-sm-12">' . $KhuyenMai[$i]['ngayBatDau'] . '</span>
                                <span class="center col-lg-2 col-md-4 col-sm-12">' . $KhuyenMai[$i]['ngayKetThuc'] . '</span>
                                <div class="center cake__cmd col-lg-2 col-md-3 col-sm-12">
                                    <button class="promotion-' . $KhuyenMai[$i]['maKM'] . ' btn " onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                                    <button class="promotion-' . $KhuyenMai[$i]['maKM'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                </div>
                            ';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="detail-promotion__row">
                    <div class="content-item__header">
                        <span>Chi tiết khuyến mãi</span>
                        <button>See all <i class="fas fa-long-arrow-alt-right"></i></button>
                    </div>
                    <div class="title--border">
                        <div class="detail-promotion__title row">
                            <div class="center detail-promotion-item-title checkbox col-lg-2">
                                <input type="checkbox" class="detail-promotion__master-checkbox" onclick="checkAll(this)"></input>
                                <i class="detail-promotion--delete far fa-trash-alt" onclick="multiDel(this)"></i>
                            </div>
                            <h6 class="center detail-promotion-item-title col-lg-6">Hình thức khuyến mãi</h6>
                            <h6 class="center detail-promotion-item-title col-lg-1">%</h6>
                            <h6 class="center detail-promotion-item-title col-lg-3">Chỉnh sửa</h6>
                        </div>
                    </div>
                    <div class="detail-promotion--show row mb-5">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $CTKhuyenMai = $_SESSION['get']['ChiTietKM']['CTKMArr'];
                            $length = count($CTKhuyenMai);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                                    <input type="checkbox" class="detail-promotion__checkbox" value="' . $CTKhuyenMai[$i]['maSP'] . '"></input>
                                </div>
                                <span class="center-left col-lg-6 col-md-4 col-sm-12">' . $CTKhuyenMai[$i]['hinhThucKhuyenMai'] . '</span>
                                <span class="center col-lg-1 col-md-4 col-sm-12">' . $CTKhuyenMai[$i]['phanTramKhuyenMai'] . '</span>
                                <div class="center cake__cmd col-lg-3 col-md-3 col-sm-12">
                                    <button class="detail-promotion-' . $CTKhuyenMai[$i]['maSP'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                                    <button class="detail-promotion-' . $CTKhuyenMai[$i]['maSP'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                </div>
                            ';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/Web2/public/scripts/SanPhamAdmin.js"></script>
    <script>
        function checkAll(ele) {
            ajaxCheckAll(ele);
        }

        function updateOne(ele) {
            ajaxUpdateOne(ele)
        }

        function deleteOne(ele) {
            ajaxDeleteOne(ele)
        }

        function multiDel(ele) {
            ajaxMultiDel(ele)
        }
    </script>