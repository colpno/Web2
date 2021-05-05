<link rel="stylesheet" href="/Web2/admin/public/css/admin/SanPhamAdmin.css">

<div class="doi-tac container">
    <div class="doi-tac-report__row row ">
        <div class='doi-tac-report__row__report col-6'>
            <div class="report-item">
                <div class="report-item__text">
                    <?php
                    if (isset($_SESSION['get']['NhaCungCap'])) {
                        $soLuong = $_SESSION['get']['NhaCungCap']['TongSoNhaCungCap']['soLuong'];
                        echo "<span class='center-left doi-tac-report__number'>$soLuong</span>";
                    }
                    ?>
                    <img src="/Web2/admin/public/images/Icon/supplier_40px.png" />
                </div>
                <p>Nhà cung cấp</p>
            </div>
        </div>
        <div class='doi-tac-report__row__report col-6'>
            <div class="report-item">
                <div class="report-item__text">
                    <?php
                    if (isset($_SESSION['get']['NhaSanXuat'])) {
                        $soLuong = $_SESSION['get']['NhaSanXuat']['TongSoNhaSanXuat']['soLuong'];
                        echo "<span class='center-left customer-report__number'>$soLuong</span>";
                    }
                    ?>
                    <img src="/Web2/admin/public/images/Icon/deployment_40px.png" />
                </div>
                <p>Nhà sản xuất</p>
            </div>
        </div>
    </div>
    <div class="content--show row">
        <div class="col-12">
            <div class="nhacungcap__row content-row">
                <div class="content-item__header">
                    <span>Nhà cung cấp</span>
                    <button class="nhacungcap--add "><i class="fas fa-plus"></i></button>
                </div>
                <form class="hidden add-content nhacungcap__add-content" id="sua-nhacungcap">
                    <input type="text" name="tenNCC" placeholder="Tên nhà cung cấp">
                    <input type="text" name="diaChi" placeholder="Địa chỉ">
                    <input type="text" name="soDienThoai" placeholder="Số điện thoại">
                    <input type="submit" value="Thêm">
                </form>
                <div class="title--border">
                    <div class="nhacungcap__title row">
                        <div class="center checkbox nhacungcap-item-title col-1">
                            <i class="nhacungcap--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="nhacungcap__master-checkbox" onclick=" checkAll(this)">
                        </div>
                        <h6 class="center nhacungcap-item-title col-3">Tên nhà cung cấp</h6>
                        <h6 class="center nhacungcap-item-title col-4">Địa chỉ</h6>
                        <h6 class="center nhacungcap-item-title col-2">Số điện thoại</h6>
                        <h6 class="center nhacungcap-item-title col-2">Thao tác</h6>
                    </div>
                </div>
                <div class="nhacungcap--show row">
                    <?php
                    if (isset($_SESSION['get']['NhaCungCap'])) {
                        $NhaCungCap = $_SESSION['get']['NhaCungCap']['Data']['data'];
                        $length = count($NhaCungCap);

                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <div class="checkbox col-1 ">
                                    <input type="checkbox" class="nhacungcap__checkbox" value="' . $NhaCungCap[$i]['maNCC'] . '"></input>
                                </div>
                                <span class="center-left col-3 row-' . $NhaCungCap[$i]['maNCC'] . ' tenNCC">' . $NhaCungCap[$i]['tenNCC'] . '</span>
                                <span class="center-left col-4 row-' . $NhaCungCap[$i]['maNCC'] . ' diaChi">' . $NhaCungCap[$i]['diaChi'] . '</span>
                                <span class="center col-2 row-' . $NhaCungCap[$i]['maNCC'] . ' soDienThoai">' . $NhaCungCap[$i]['soDienThoai'] . '</span>
                                <div class="center col-2">
                                    <a href="#sua-nhacungcap" class="nhacungcap-' . $NhaCungCap[$i]['maNCC'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="nhacungcap-' . $NhaCungCap[$i]['maNCC'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                </div>
                            ';
                        }
                    }
                    ?>
                </div>
                <div class="content-item__pagination row">
                    <div>
                        <ul class="text-center center paginate">
                            <?php
                            if (isset($_SESSION['get']['NhaCungCap'])) {
                                $length = $_SESSION['get']['NhaCungCap']['Data']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="nhacungcap-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="nhacungcap-' . $i . '">' . $i . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="nhasanxuat__row content-row">
                <div class="content-item__header">
                    <span>Nhà sản xuất</span>
                    <button class="nhasanxuat--add "><i class="fas fa-plus"></i></button>
                </div>
                <form class="hidden add-content nhasanxuat__add-content" id="sua-nhasanxuat">
                    <input type="text" name="tenNSX" placeholder="Tên nhà sản xuất">
                    <input type="text" name="diaChi" placeholder="Địa chỉ">
                    <input type="text" name="soDienThoai" placeholder="Số điện thoại">
                    <input type="submit" value="Thêm">
                </form>
                <div class="title--border">
                    <div class="nhasanxuat__title row">
                        <div class="center nhasanxuat-item-title checkbox col-1">
                            <i class="nhasanxuat--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="nhasanxuat__master-checkbox" onclick="checkAll(this)"></input>
                        </div>
                        <h6 class="center nhasanxuat-item-title col-3">Tên nhà sản xuất</h6>
                        <h6 class="center nhasanxuat-item-title col-4">Địa chỉ</h6>
                        <h6 class="center nhasanxuat-item-title col-2">Số điện thoại</h6>
                        <h6 class="center nhasanxuat-item-title col-2">Thao tác</h6>
                    </div>
                </div>
                <div class="nhasanxuat--show row">
                    <?php
                    if (isset($_SESSION['get']['NhaSanXuat'])) {
                        $NhaSanXuat = $_SESSION['get']['NhaSanXuat']['Data']['data'];
                        $length = count($NhaSanXuat);

                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <div class="checkbox col-1 ">
                                    <input type="checkbox" class="nhasanxuat__checkbox" value="' . $NhaSanXuat[$i]['maNSX'] . '"></input>
                                </div>
                                <span class="center-left col-3 row-' . $NhaSanXuat[$i]['maNSX'] . ' tenNSX">' . $NhaSanXuat[$i]['tenNSX'] . '</span>
                                <span class="center-left col-4 row-' . $NhaSanXuat[$i]['maNSX'] . ' diaChi">' . $NhaSanXuat[$i]['diaChi'] . '</span>
                                <span class="center col-2 row-' . $NhaSanXuat[$i]['maNSX'] . ' soDienThoai">' . $NhaSanXuat[$i]['soDienThoai'] . '</span>
                                <div class="center col-2">
                                    <a href="#sua-nhasanxuat" class="nhasanxuat-' . $NhaSanXuat[$i]['maNSX'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="nhasanxuat-' . $NhaSanXuat[$i]['maNSX'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                </div>
                            ';
                        }
                    }
                    ?>
                </div>
                <div class="content-item__pagination row">
                    <div>
                        <ul class="text-center center paginate">
                            <?php
                            if (isset($_SESSION['get']['NhaSanXuat'])) {
                                $length = $_SESSION['get']['NhaSanXuat']['Data']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="nhasanxuat-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="nhasanxuat-' . $i . '">' . $i . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin: 40px;"></div>
    </div>

    <script src="/Web2/admin/public/scripts/Admin.js"></script>
    <script src="/Web2/admin/public/scripts/DoiTacAdmin.js"></script>
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