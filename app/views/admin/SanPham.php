    <link rel="stylesheet" href="/Web2/public/css/admin/SanPhamAdmin.css">

    <div class="product container">
        <div class="product-report__row row ">
            <div class='product-report__row__report col-3'>
                <div class="report-item">
                    <div class="report-item__text">
                        <?php
                        if (isset($_SESSION['get']['SanPham'])) {
                            $soLuong = $_SESSION['get']['SanPham']['TongSoSanPham']['soLuong'];
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
                        if (isset($_SESSION['get']['Loai'])) {
                            $soLuong = $_SESSION['get']['Loai']['TongSoLoai']['soLuong'];
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
                        if (isset($_SESSION['get']['KhuyenMai'])) {
                            $soLuong = $_SESSION['get']['KhuyenMai']['TongSoKhuyenMai']['soLuong'];
                            echo "<span class='center-left khuyenmai-report__number'>$soLuong</span>";
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
                        if (isset($_SESSION['get']['SanPham'])) {
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
                <div class="sanpham__row content-row">
                    <div class="content-item__header">
                        <span>Sản phẩm mới</span>
                        <div>
                            <button class="sanpham--add "><i class="fas fa-plus"></i></button>
                            <button class="sanpham--filter"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                    <form class="hidden add-content sanpham__add-content" id="sua-sanpham">
                        <select name="maLoai">
                            <option value="">Loại</option>
                            <?php
                            if (isset($_SESSION['get']['Loai'])) {
                                $data = $_SESSION['get']['Loai']['selectDisplay'];
                                foreach ($data as $key => $value) {
                                    echo '<option value="' . $value['maLoai'] . '">' . $value['maLoai'] . ' - ' . $value['tenLoai'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <select name="maNSX">
                            <option value="">Nhà sản xuất</option>
                            <?php
                            if (isset($_SESSION['get']['NhaSanXuat'])) {
                                $data = $_SESSION['get']['NhaSanXuat'];
                                foreach ($data as $key => $value) {
                                    echo '<option value="' . $value['maNSX'] . '">' . $value['maNSX'] . ' - ' . $value['tenNSX'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <div class="add-content__input">
                            <div class="add-content__input-left">
                                <input type="text" name="tenSP" placeholder="Tên sản phẩm">
                                <input type="text" name="soLuong" placeholder="Số lượng">
                            </div>
                            <div class="add-content__input-right">
                                <div>
                                    <input type="text" name="donGia" placeholder="Giá">
                                    <select name="donViTinh">
                                        <option value="">Đơn vị</option>
                                        <?php
                                        if (isset($_SESSION['get']['SanPham'])) {
                                            $array = $_SESSION['get']['SanPham']['selectDisplay'];
                                            $data = [];
                                            foreach ($array as $key => $value) {
                                                array_push($data, $value['donViTinh']);
                                            }

                                            $data = array_unique($data);
                                            foreach ($data as $key => $value) {
                                                echo '<option value="' . $value . '">' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="file" accept="image/*" name="anhDaiDien">
                            </div>
                        </div>
                        <input type="submit" value="Thêm">
                    </form>
                    <form class="hidden filter-content sanpham__filter-content">
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
                        <div class="sanpham__title row">
                            <div class="center checkbox sanpham-item-title col-lg-1">
                                <i class="sanpham--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                                <input type="checkbox" class="sanpham__master-checkbox" onclick=" checkAll(this)">
                            </div>
                            <h6 class="center sanpham-item-title col-lg-2">Hình ảnh</h6>
                            <h6 class="center sanpham-item-title col-lg-3">Tên bánh</h6>
                            <h6 class="center sanpham-item-title col-lg-2">Số tiền</h6>
                            <h6 class="center sanpham-item-title col-lg-2">Số lượng</h6>
                            <h6 class="center sanpham-item-title col-lg-2">Thao tác</h6>
                        </div>
                    </div>
                    <div class="sanpham--show row">
                        <?php
                        if (isset($_SESSION['get']['SanPham'])) {
                            $SanPham = $_SESSION['get']['SanPham']['SPData']['data'];
                            $length = count($SanPham);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                                    <input type="checkbox" class="sanpham__checkbox row-' . $SanPham[$i]['maSP'] . '" value="' . $SanPham[$i]['maSP'] . '"></input>
                                </div>
                                <div class="center col-lg-2 col-md-2 col-sm-12">
                                    <img class="sanpham-' . $SanPham[$i]['maSP'] . ' row-' . $SanPham[$i]['maSP'] . ' anhDaiDien" src="' . $SanPham[$i]['anhDaiDien'] . '" onerror="this.src="images/no-img.png""  />
                                </div>
                                <span class="hidden row-' . $SanPham[$i]['maSP'] . ' maLoai">' . $SanPham[$i]['loaiSanPham']['maLoai'] . '</span>
                                <span class="hidden row-' . $SanPham[$i]['maSP'] . ' maNSX">' . $SanPham[$i]['nhaSanXuat']['maNSX'] . '</span>
                                <span class="center-left col-lg-3 col-md-4 col-sm-12 row-' . $SanPham[$i]['maSP'] . ' tenSP">' . $SanPham[$i]['tenSP'] . '</span>
                                <span class="center-right col-lg-2 col-md-1 col-sm-12 row-' . $SanPham[$i]['maSP'] . ' donGia">' . $SanPham[$i]['donGia'] . ' ' . $SanPham[$i]['donViTinh'] . '</span>
                                <span class="center col-lg-2 col-md-2 col-sm-12 row-' . $SanPham[$i]['maSP'] . ' soLuong">' . $SanPham[$i]['soLuong'] . '</span>
                                <div class="center col-lg-2 col-md-3 col-sm-12">
                                    <a href="#sua-sanpham" class="sanpham-' . $SanPham[$i]['maSP'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="sanpham-' . $SanPham[$i]['maSP'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
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
                                if (isset($_SESSION['get']['SanPham'])) {
                                    $length = $_SESSION['get']['SanPham']['SPData']['pages'];
                                    for ($i = 1; $i <= $length; $i++) {
                                        if ($i == 1)
                                            echo '<li onclick="paginate(this)" class="sanpham-' . $i . ' current-page">' . $i . '</li>';
                                        else
                                            echo '<li onclick="paginate(this)" class="sanpham-' . $i . '">' . $i . '</li>';
                                    }
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
                <div class="loai__row content-row">
                    <div class="content-item__header">
                        <span>Loại</span>
                        <button class="loai--add "><i class="fas fa-plus"></i></button>
                    </div>
                    <form class="hidden add-content loai__add-content" id="sua-loai">
                        <input type="text" name="tenLoai" placeholder="Tên loại">
                        <input type="submit" value="Thêm">
                    </form>
                    <div class="title--border">
                        <div class="loai__title row">
                            <div class="center loai-item-title checkbox col-lg-2">
                                <i class="loai--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                                <input type="checkbox" class="loai__master-checkbox" onclick="checkAll(this)">
                            </div>
                            <h6 class="center loai-item-title col-lg-6">Loại bánh</h6>
                            <h6 class="center loai-item-title col-lg-4">Thao tác</h6>
                        </div>
                    </div>
                    <div class="loai--show row">
                        <?php
                        if (isset($_SESSION['get']['Loai'])) {
                            $Loai = $_SESSION['get']['Loai']['LoaiData']['data'];
                            $length = count($Loai);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                                    <input type="checkbox" class="loai__checkbox row-' . $Loai[$i]['maLoai'] . '" value="' . $Loai[$i]['maLoai'] . '"></input>
                                </div>
                                <span class="center-left col-lg-6 col-md-4 col-sm-12 row-' . $Loai[$i]['maLoai'] . ' tenLoai">' . $Loai[$i]['tenLoai'] . '</span>
                                <div class="center col-lg-4 col-md-3 col-sm-12">
                                    <a href="#sua-loai" class="loai-' . $Loai[$i]['maLoai'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="loai-' . $Loai[$i]['maLoai'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
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
                                if (isset($_SESSION['get']['Loai'])) {
                                    $length = $_SESSION['get']['Loai']['LoaiData']['pages'];
                                    for ($i = 1; $i <= $length; $i++) {
                                        if ($i == 1)
                                            echo '<li onclick="paginate(this)" class="sanpham-' . $i . ' current-page">' . $i . '</li>';
                                        else
                                            echo '<li onclick="paginate(this)" class="sanpham-' . $i . '">' . $i . '</li>';
                                    }
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
                <div class="khuyenmai__row content-row">
                    <div class="content-item__header">
                        <span>Khuyến mãi</span>
                        <div>
                            <button class="khuyenmai--add "><i class="fas fa-plus"></i></button>
                            <button class="khuyenmai--filter"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                    <form class="hidden add-content khuyenmai__add-content" id="sua-khuyenmai">
                        <label for="tenKM">Khuyến mãi:</label>
                        <textarea name="tenKM" cols="70" rows="5"></textarea>
                        <div class="add-content__input">
                            <input type="text" name="ngayBatDau" placeholder="Ngày bắt đầu">
                            <i class="fas fa-long-arrow-alt-right"></i>
                            <input type="text" name="ngayKetThuc" placeholder="Ngày kết thúc">
                        </div>
                        <input type="submit" value="Thêm">
                    </form>
                    <form class="hidden filter-content khuyenmai__filter-content">
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
                        <div class="khuyenmai__title row">
                            <div class="center khuyenmai-item-title checkbox col-lg-1">
                                <i class="khuyenmai--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                                <input type="checkbox" class="khuyenmai__master-checkbox" onclick="checkAll(this)"></input>
                            </div>
                            <h6 class="center khuyenmai-item-title col-lg-5">Khuyến mãi</h6>
                            <h6 class="center khuyenmai-item-title col-lg-2">Bắt đầu</h6>
                            <h6 class="center khuyenmai-item-title col-lg-2">Kết thúc</h6>
                            <h6 class="center khuyenmai-item-title col-lg-2">Thao tác</h6>
                        </div>
                    </div>
                    <div class="khuyenmai--show row">
                        <?php
                        if (isset($_SESSION['get']['KhuyenMai'])) {
                            $KhuyenMai = $_SESSION['get']['KhuyenMai']['KMData']['data'];
                            $length = count($KhuyenMai);

                            for ($i = 0; $i < $length; $i++) {
                                echo '
                                <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                                    <input type="checkbox" class="khuyenmai__checkbox row-' . $KhuyenMai[$i]['maKM'] . ' maKM" value="' . $KhuyenMai[$i]['maKM'] . '"></input>
                                </div>
                                <span class="center-left col-lg-5 col-md-4 col-sm-12 row-' . $KhuyenMai[$i]['maKM'] . ' tenKM">' . $KhuyenMai[$i]['tenKM'] . '</span>
                                <span class="center col-lg-2 col-md-4 col-sm-12 row-' . $KhuyenMai[$i]['maKM'] . ' ngayBatDau">' . $KhuyenMai[$i]['ngayBatDau'] . '</span>
                                <span class="center col-lg-2 col-md-4 col-sm-12 row-' . $KhuyenMai[$i]['maKM'] . ' ngayKetThuc">' . $KhuyenMai[$i]['ngayKetThuc'] . '</span>
                                <div class="center col-lg-2 col-md-3 col-sm-12">
                                    <a href="#sua-khuyenmai" class="khuyenmai-' . $KhuyenMai[$i]['maKM'] . ' btn " onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="khuyenmai-' . $KhuyenMai[$i]['maKM'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                    <button class="khuyenmai-' . $KhuyenMai[$i]['maKM'] . ' btn" onclick="openDetail(this)"><i class="fas fa-arrow-circle-right"></i></button>
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
                                if (isset($_SESSION['get']['KhuyenMai'])) {
                                    $length = $_SESSION['get']['KhuyenMai']['KMData']['pages'];
                                    for ($i = 1; $i <= $length; $i++) {
                                        if ($i == 1)
                                            echo '<li onclick="paginate(this)" class="sanpham-' . $i . ' current-page">' . $i . '</li>';
                                        else
                                            echo '<li onclick="paginate(this)" class="sanpham-' . $i . '">' . $i . '</li>';
                                    }
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
                <div class="chitietkhuyenmai__row content-row">
                    <div class="content-item__header">
                        <span>Chi tiết khuyến mãi</span>
                        <div>
                            <button class="chitietkhuyenmai--add "><i class="fas fa-plus"></i></button>
                            <button class="chitietkhuyenmai--filter"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                    <form class="hidden add-content chitietkhuyenmai__add-content" id="sua-chitietkhuyenmai">
                        <select name="maSP">
                            <option value="">Sản phẩm</option>
                            <?php
                            if (isset($_SESSION['get']['SanPham'])) {
                                $data = $_SESSION['get']['SanPham']['selectDisplay'];
                                foreach ($data as $key => $value) {
                                    echo '<option value="' . $value['maSP'] . '">' . $value['maSP'] . ' - ' . $value['tenSP'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <input type="text" name="hinhThucKhuyenMai" placeholder="Hình thức khuyến mãi">
                        <input type="text" name="phanTramKhuyenMai" placeholder="%">
                        <input type="submit" value="Thêm">
                    </form>
                    <form class="hidden filter-content chitietkhuyenmai__filter-content">
                        <select name="filterCol" style="margin-right: 0;">
                            <option value="phanTramKhuyenMai">%</option>
                        </select>
                        <div>
                            <input type="text" name="from" placeholder="Từ">
                            <i class="fas fa-long-arrow-alt-right"></i>
                            <input type="text" name="to" placeholder="Đến">
                        </div>
                        <input type="submit" value="Lọc">
                    </form>
                    <div class="title--border">
                        <div class="chitietkhuyenmai__title row">
                            <div class="center chitietkhuyenmai-item-title checkbox col-lg-2">
                                <i class="chitietkhuyenmai--delete far fa-trash-alt" onclick="multiDel(this)"></i>
                                <input type="checkbox" name="maSP" class="chitietkhuyenmai__master-checkbox" onclick="checkAll(this)"></input>
                            </div>
                            <h6 class="center chitietkhuyenmai-item-title col-lg-6">Hình thức khuyến mãi</h6>
                            <h6 class="center chitietkhuyenmai-item-title col-lg-1">%</h6>
                            <h6 class="center chitietkhuyenmai-item-title col-lg-3">Thao tác</h6>
                        </div>
                    </div>
                    <div class="chitietkhuyenmai--show row">
                        <div style="display:flex;align-items: center;justify-content: center;height: 200px;">
                            <h1>Trống</h1>
                        </div>
                    </div>
                    <div class="content-item__pagination row"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="/Web2/public/scripts/Admin.js"></script>
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