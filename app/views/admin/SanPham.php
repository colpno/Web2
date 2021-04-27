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
                        <div>
                            <button class="product--add "><i class="fas fa-plus"></i></button>
                            <button class="product--filter"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                    <form class="hidden add-content product__add-content">
                        <select name="maLoai">
                            <option value="default">Loại</option>
                            <?php
                            $data = $_SESSION['get']['Loai']['selectDisplay'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maLoai'] . '">' . $value['maLoai'] . ' - ' . $value['tenLoai'] . '</option>';
                            }
                            ?>
                        </select>
                        <select name="maNSX">
                            <option value="default">Nhà sản xuất</option>
                            <?php
                            $data = $_SESSION['get']['NhaSanXuat'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maNSX'] . '">' . $value['maNSX'] . ' - ' . $value['tenNSX'] . '</option>';
                            }
                            ?>
                        </select>
                        <div class="add-content__input">
                            <div class="add-content__input-left">
                                <input type="text" name="tenSP" placeholder="Tên sản phẩm">
                                <input type="text" name="soLuong" placeholder="Số lượng">
                            </div>
                            <div class="add-content__input-add__content-right">
                                <div>
                                    <input type="text" name="donGia" placeholder="Giá">
                                    <select name="donViTinh">
                                        <?php
                                        $array = $_SESSION['get']['SanPham']['selectDisplay'];
                                        $data = [];
                                        foreach ($array as $key => $value) {
                                            array_push($data, $value['donViTinh']);
                                        }

                                        $data = array_unique($data);
                                        foreach ($data as $key => $value) {
                                            echo '<option value="' . $value . '">' . $value . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="file" accept="image/*" name="anhDaiDien">
                            </div>
                        </div>
                        <input type="submit" value="Thêm">
                    </form>
                    <form class="hidden filter-content product__filter-content">
                        <div>
                            <select name="filterCol">
                                <option value="donGia">Giá</option>
                                <option value="soLuong">Số lượng</option>
                            </select>
                            <input type="text" name="from" placeholder="Từ">
                            <i class="fas fa-long-arrow-alt-right"></i>
                            <input type="text" name="to" placeholder="Đến">
                        </div>
                        <input type="submit" value="Lọc">
                    </form>
                    <div class="title--border">
                        <div class="product__title row">
                            <div class="center checkbox product-item-title col-lg-1">
                                <input type="checkbox" class="product__master-checkbox" onclick=" checkAll(this)">
                                </input>
                                <i class="product--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            </div>
                            <h6 class="center product-item-title col-lg-2">Hình ảnh</h6>
                            <h6 class="center product-item-title col-lg-3">Tên bánh</h6>
                            <h6 class="center product-item-title col-lg-2">Số tiền</h6>
                            <h6 class="center product-item-title col-lg-2">Số lượng</h6>
                            <h6 class="center product-item-title col-lg-2">Thao tác</h6>
                        </div>
                    </div>
                    <div class="product--show row">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $SanPham = $_SESSION['get']['SanPham']['SPData']['data'];
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
                                <span class="center-right col-lg-2 col-md-1 col-sm-12">' . $SanPham[$i]['donGia'] . ' ' . $SanPham[$i]['donViTinh'] . '</span>
                                <span class="center col-lg-2 col-md-2 col-sm-12">' . $SanPham[$i]['soLuong'] . '</span>
                                <div class="center col-lg-2 col-md-3 col-sm-12">
                                    <button class="product-' . $SanPham[$i]['maSP'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                                    <button class="product-' . $SanPham[$i]['maSP'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                </div>
                            ';
                            }
                        }
                        ?>
                    </div>
                    <div class="content-item__pagination row">
                        <div>
                            <ul class="text-center center paginate">
                                <li class="sanpham-first"></li>
                                <li class="sanpham-prev"></li>
                                <?php
                                $length = $_SESSION['get']['SanPham']['SPData']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="sanpham-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="sanpham-' . $i . '">' . $i . '</li>';
                                }
                                ?>
                                <li class="sanpham-next"></li>
                                <li class="sanpham-last"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="category__row">
                    <div class="content-item__header">
                        <span>Loại</span>
                        <button class="category--add "><i class="fas fa-plus"></i></button>
                    </div>
                    <form class="hidden add-content category__add-content">
                        <input type="text" name="tenLoai" placeholder="Tên loại">
                        <input type="submit" value="Thêm">
                    </form>
                    <div class="title--border">
                        <div class="category__title row">
                            <div class="center category-item-title checkbox col-lg-2">
                                <input type="checkbox" class="category__master-checkbox" onclick="checkAll(this)"></input>
                                <i class="category--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            </div>
                            <h6 class="center category-item-title col-lg-6">Loại bánh</h6>
                            <h6 class="center category-item-title col-lg-4">Thao tác</h6>
                        </div>
                    </div>
                    <div class="category--show row">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $Loai = $_SESSION['get']['Loai']['LoaiData']['data'];
                            $length = count($Loai);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                                    <input type="checkbox" class="category__checkbox" value="' . $Loai[$i]['maLoai'] . '"></input>
                                </div>
                                <span class="center-left col-lg-6 col-md-4 col-sm-12">' . $Loai[$i]['tenLoai'] . '</span>
                                <div class="center col-lg-4 col-md-3 col-sm-12">
                                    <button class="category-' . $Loai[$i]['maLoai'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                                    <button class="category-' . $Loai[$i]['maLoai'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                </div>
                            ';
                            }
                        }
                        ?>
                    </div>
                    <div class="content-item__pagination row">
                        <div>
                            <ul class="text-center center paginate">
                                <li class="loai-first"></li>
                                <li class="loai-prev"></li>
                                <?php
                                $length = $_SESSION['get']['Loai']['LoaiData']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="loai-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="loai-' . $i . '">' . $i . '</li>';
                                }
                                ?>
                                <li class="loai-next"></li>
                                <li class="loai-last"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="promotion__row">
                    <div class="content-item__header">
                        <span>Khuyến mãi</span>
                        <div>
                            <button class="promotion--add "><i class="fas fa-plus"></i></button>
                            <button class="promotion--filter"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                    <form class="hidden add-content promotion__add-content">
                        <div class="add-content__input">
                            <label for="tenKM">Khuyến mãi:</label>
                            <textarea name="tenKM" cols="70" rows="5"></textarea>
                            <div>
                                <input type="text" name="ngayBatDau" placeholder="Ngày bắt đầu">
                                <i class="fas fa-long-arrow-alt-right"></i>
                                <input type="text" name="ngayKetThuc" placeholder="Ngày kết thúc">
                            </div>
                        </div>
                        <input type="submit" value="Thêm">
                    </form>
                    <form class="hidden filter-content promotion__filter-content">
                        <div>
                            <select name="filterCol">
                                <option value="ngayBatDau">Ngày bắt đầu</option>
                                <option value="ngayKetThuc">Ngày kết thúc</option>
                            </select>
                            <input type="text" name="from" placeholder="Từ">
                            <i class="fas fa-long-arrow-alt-right"></i>
                            <input type="text" name="to" placeholder="Đến">
                        </div>
                        <input type="submit" value="Lọc">
                    </form>
                    <div class="title--border">
                        <div class="promotion__title row">
                            <div class="center promotion-item-title checkbox col-lg-1">
                                <input type="checkbox" class="promotion__master-checkbox" onclick="checkAll(this)"></input>
                                <i class="promotion--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            </div>
                            <h6 class="center promotion-item-title col-lg-5">Khuyến mãi</h6>
                            <h6 class="center promotion-item-title col-lg-2">Bắt đầu</h6>
                            <h6 class="center promotion-item-title col-lg-2">Kết thúc</h6>
                            <h6 class="center promotion-item-title col-lg-2">Thao tác</h6>
                        </div>
                    </div>
                    <div class="promotion--show row">
                        <?php
                        if (isset($_SESSION['get'])) {
                            $KhuyenMai = $_SESSION['get']['KhuyenMai']['KMData']['data'];
                            $length = count($KhuyenMai);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                                    <input type="checkbox" class="promotion__checkbox" value="' . $KhuyenMai[$i]['maKM'] . '"></input>
                                </div>
                                <span class="center-left col-lg-5 col-md-4 col-sm-12">' . $KhuyenMai[$i]['tenKM'] . '</span>
                                <span class="center col-lg-2 col-md-4 col-sm-12">' . $KhuyenMai[$i]['ngayBatDau'] . '</span>
                                <span class="center col-lg-2 col-md-4 col-sm-12">' . $KhuyenMai[$i]['ngayKetThuc'] . '</span>
                                <div class="center col-lg-2 col-md-3 col-sm-12">
                                    <button class="promotion-' . $KhuyenMai[$i]['maKM'] . ' btn " onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                                    <button class="promotion-' . $KhuyenMai[$i]['maKM'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                    <button class="promotion-' . $KhuyenMai[$i]['maKM'] . ' btn" onclick="openDetail(this)"><i class="fas fa-arrow-circle-right"></i></button>
                                </div>
                            ';
                            }
                        }
                        ?>
                    </div>
                    <div class="content-item__pagination row">
                        <div>
                            <ul class="text-center center paginate">
                                <li class="khuyenmai-first"></li>
                                <li class="khuyenmai-prev"></li>
                                <?php
                                $length = $_SESSION['get']['KhuyenMai']['KMData']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="khuyenmai-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="khuyenmai-' . $i . '">' . $i . '</li>';
                                }
                                ?>
                                <li class="khuyenmai-next"></li>
                                <li class="khuyenmai-last"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="detail-promotion__row">
                    <div class="content-item__header">
                        <span>Chi tiết khuyến mãi</span>
                        <div>
                            <button class="detail-promotion--add "><i class="fas fa-plus"></i></button>
                            <button class="detail-promotion--filter"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                    <form class="hidden add-content detail-promotion__add-content">
                        <select name="maSP">
                            <option value="default">Sản phẩm</option>
                            <?php
                            $data = $_SESSION['get']['SanPham']['selectDisplay'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maSP'] . '">' . $value['maSP'] . ' - ' . $value['tenSP'] . '</option>';
                            }
                            ?>
                        </select>
                        <input type="text" name="hinhThucKhuyenMai" placeholder="Hình thức khuyến mãi">
                        <input type="text" name="phanTramKhuyenMai" placeholder="%">
                        <input type="submit" value="Thêm">
                    </form>
                    <form class="hidden filter-content detail-promotion__filter-content">
                        <select name="filterCol" style="margin-right: 0;">
                            <option value="donGia">Giá</option>
                            <option value="soLuong">Số lượng</option>
                        </select>
                        <div>
                            <input type="text" name="from" placeholder="Từ">
                            <i class="fas fa-long-arrow-alt-right"></i>
                            <input type="text" name="to" placeholder="Đến">
                        </div>
                        <input type="submit" value="Lọc">
                    </form>
                    <div class="title--border">
                        <div class="detail-promotion__title row">
                            <div class="center detail-promotion-item-title checkbox col-lg-2">
                                <input type="checkbox" class="detail-promotion__master-checkbox" onclick="checkAll(this)"></input>
                                <i class="detail-promotion--delete far fa-trash-alt" onclick="multiDel(this)"></i>
                            </div>
                            <h6 class="center detail-promotion-item-title col-lg-6">Hình thức khuyến mãi</h6>
                            <h6 class="center detail-promotion-item-title col-lg-1">%</h6>
                            <h6 class="center detail-promotion-item-title col-lg-3">Thao tác</h6>
                        </div>
                    </div>
                    <div class="detail-promotion--show row">
                        <div style="display:flex;align-items: center;justify-content: center;height: 200px;">
                            <h1>Empty</h1>
                        </div>
                    </div>
                    <div class="content-item__pagination row"></div>
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

        function openDetail(ele) {
            ajaxOpenDetail(ele)
        }

        function multiDel(ele) {
            ajaxMultiDel(ele)
        }

        function paginate(ele) {
            ajaxPaginate(ele)
        }
    </script>