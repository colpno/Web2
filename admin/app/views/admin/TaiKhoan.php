<link rel="stylesheet" href="/Web2/admin/public/css/admin/TaiKhoanAdmin.css">

<div class="taikhoan container">
    <div class="taikhoan-report__row row ">
        <div class='taikhoan-report__row__report col-4'>
            <div class="report-item">
                <div class="report-item__text">
                    <?php
                    if (isset($_SESSION['get']['TaiKhoan'])) {
                        $soLuong = $_SESSION['get']['TaiKhoan']['TongSoTaiKhoan']['soLuong'];
                        echo "<span class='center-left taikhoan-report__number'>$soLuong</span>";
                    }
                    ?>
                    <img src="/Web2/admin/public/images/Icon/user_groups.png" />
                </div>
                <p>Tài khoản</p>
            </div>
        </div>
        <div class='taikhoan-report__row__report col-4'>
            <div class="report-item">
                <div class="report-item__text">
                    <?php
                    if (isset($_SESSION['get']['NhanVien'])) {
                        $soLuong = $_SESSION['get']['NhanVien']['TongSoNhanVien']['soLuong'];
                        echo "<span class='center-left customer-report__number'>$soLuong</span>";
                    }
                    ?>
                    <img src="/Web2/admin/public/images/Icon/customer_support_40px.png" />
                </div>
                <p>Nhân viên</p>
            </div>
        </div>
        <div class='taikhoan-report__row__report col-4'>
            <div class="report-item">
                <div class="report-item__text">
                    <?php
                    if (isset($_SESSION['get']['KhachHang'])) {
                        $soLuong = $_SESSION['get']['KhachHang']['TongSoKhachHang']['soLuong'];
                        echo "<span class='center-left customer-report__number'>$soLuong</span>";
                    }
                    ?>
                    <img src="/Web2/admin/public/images/Icon/user_40px.png" />
                </div>
                <p>Khách hàng</p>
            </div>
        </div>
    </div>
    <div class="content--show row">
        <div class="col-12">
            <div class="taikhoan__row content-row">
                <div class="content-item__header">
                    <span>Tài khoản</span>
                    <div>
                        <button class="taikhoan--add "><i class="fas fa-plus"></i></button>
                        <button class="taikhoan--filter"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                <form class="hidden add-content taikhoan__add-content" id="sua-taikhoan">
                    <div class="add-content__input taikhoan__add">
                        <div class="add-content__input-left">
                            <input type="text" name="tenTaiKhoan" placeholder="Tên tài khoản">
                            <input type="password" name="matKhau" placeholder="Mật khẩu">
                        </div>
                        <div class="add-content__input-right">
                            <select name="maQuyen" onchange="changeQuyen(this)">
                                <option value="">Quyền</option>
                                <?php
                                if (isset($_SESSION['get']['TaiKhoan'])) {
                                    $data = $_SESSION['get']['TaiKhoan']['HienThiSelect'];
                                    foreach ($data as $key => $value) {
                                        echo '<option value="' . $value['maQuyen'] . '">' . $value['maQuyen'] . ' - ' . $value['tenQuyen'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <input type="file" name="anhDaiDien">
                        </div>
                    </div>
                    <div class="nhanvien-taikhoan__add-content hidden">
                        <div class="add-content__input">
                            <div class="add-content__input-left">
                                <?php
                                if (isset($_SESSION['get']['HienThiSelect'])) {
                                    $ma = end($_SESSION['get']['HienThiSelect'])['maTK'];
                                    echo '<input type="text" name="maTK" value="' . $ma . '" hidden>';
                                }
                                ?>
                                <input type="text" name="ho" placeholder="Họ">
                                <input type="text" name="ten" placeholder="Tên">
                                <input type="text" name="ngaySinh" placeholder="Ngày sinh">
                            </div>
                            <div class="add-content__input-right">
                                <input type="text" name="diaChi" placeholder="Địa chỉ">
                                <input type="text" name="soDienThoai" placeholder="Số điện thoại">
                                <input type="text" name="luong" placeholder="Lương">
                            </div>
                        </div>
                    </div>
                    <div class="khachhang-taikhoan__add-content hidden">
                        <div class="add-content__input">
                            <div class="add-content__input-left">
                                <?php
                                if (isset($_SESSION['get']['HienThiSelect'])) {
                                    $ma = end($_SESSION['get']['HienThiSelect'])['maTK'];
                                    echo '<input type="text" name="maTK" value="' . $ma . '" hidden>';
                                }
                                ?>
                                <input type="text" name="maTK" value="1" hidden>
                                <input type="text" name="ho" placeholder="Họ">
                                <input type="text" name="ten" placeholder="Tên">
                                <input type="text" name="ngaySinh" placeholder="Ngày sinh">
                            </div>
                            <div class="add-content__input-right">
                                <input type="text" name="diaChi" placeholder="Địa chỉ">
                                <input type="text" name="soDienThoai" placeholder="Số điện thoại">
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Thêm">
                </form>
                <form class="hidden filter-content taikhoan__filter-content">
                    <select name="filterCol" style="margin-right: 0;">
                        <option value="thoiGianTao">Thời gian tạo</option>
                    </select>
                    <div>
                        <input type="text" name="from" placeholder="Từ">
                        <i class="fas fa-long-arrow-alt-right"></i>
                        <input type="text" name="to" placeholder="Đến">
                    </div>
                    <input type="submit" value="Lọc">
                </form>
                <div class="title--border">
                    <div class="taikhoan__title row">
                        <div class="center checkbox taikhoan-item-title col-1">
                            <i class="taikhoan--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="taikhoan__master-checkbox" onclick=" checkAll(this)">
                        </div>
                        <h6 class="center taikhoan-item-title col-1">Quyền</h6>
                        <h6 class="center taikhoan-item-title col-2">Tài khoản</h6>
                        <h6 class="center taikhoan-item-title col-2">Mật khẩu</h6>
                        <h6 class="center taikhoan-item-title col-2">Ảnh đại diện</h6>
                        <h6 class="center taikhoan-item-title col-1 trangThai-header">Trạng thái bị cấm
                            <select id="trangThaiTaiKhoan">
                                <option value="">Tất cả</option>
                                <option value="0">Bị cấm</option>
                                <option value="1">Không bị cấm</option>
                            </select>
                        </h6>
                        <h6 class="center taikhoan-item-title col-1">Đăng nhập</h6>
                        <h6 class="center taikhoan-item-title col-1">Thời gian tạo</h6>
                        <h6 class="center taikhoan-item-title col-1">Thao tác</h6>
                    </div>
                </div>
                <div class="taikhoan--show row">
                    <?php
                    if (isset($_SESSION['get']['TaiKhoan'])) {
                        $TaiKhoan = $_SESSION['get']['TaiKhoan']['Data']['data'];
                        $length = count($TaiKhoan);

                        $onerror =  "this.removeAttribute('onError');this.setAttribute('src','/Web2/admin/public/images/no-img.png')";
                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <div class="checkbox col-1  ">
                                    <input type="checkbox" class="taikhoan__checkbox" value="' . $TaiKhoan[$i]['maTK'] . '"></input>
                                </div>
                                <span class="hidden row-' . $TaiKhoan[$i]['maTK'] . ' maQuyen">' . $TaiKhoan[$i]['quyen']['maQuyen'] . '</span>
                                <span class="center-left col-1 ">' . $TaiKhoan[$i]['quyen']['tenQuyen'] . '</span>
                                <span class="center-left col-2  row-' . $TaiKhoan[$i]['maTK'] . ' tenTaiKhoan">' . $TaiKhoan[$i]['tenTaiKhoan'] . '</span>
                                <span class="center-left line-break col-2  row-' . $TaiKhoan[$i]['maTK'] . ' matKhau">' . $TaiKhoan[$i]['matKhau'] . '</span>
                                <div class="center col-2 ">
                                    <img class="taikhoan-' . $TaiKhoan[$i]['maTK'] . ' row-' . $TaiKhoan[$i]['maTK'] . ' anhDaiDien" src="' . $TaiKhoan[$i]['anhDaiDien'] . '" onError="' . $onerror . ';"></img>
                                </div>
                                <span class="center col-1  row-' . $TaiKhoan[$i]['maTK'] . ' trangThai">';

                            if ($TaiKhoan[$i]['trangThai'] == 0) {
                                echo '<input type="checkbox" checked class="center col-1 check-trangThai  row-' . $TaiKhoan[$i]['maTK'] . ' trangThai" onclick="capNhatTrangThai(this)">' . $TaiKhoan[$i]['trangThai'] . '</input>';
                            } else {
                                echo '<input type="checkbox" class="center col-1 check-trangThai  row-' . $TaiKhoan[$i]['maTK'] . ' trangThai" onclick="capNhatTrangThai(this)">' . $TaiKhoan[$i]['trangThai'] . '</input>';
                            }

                            echo '
                                </span>
                                <span class="center col-1  row-' . $TaiKhoan[$i]['maTK'] . ' dangNhap">' . $TaiKhoan[$i]['dangNhap'] . '</span>
                                <span class="center-left col-1  row-' . $TaiKhoan[$i]['maTK'] . ' thoiGianTao">' . $TaiKhoan[$i]['thoiGianTao'] . '</span>
                                <div class="center col-1  row-' . $TaiKhoan[$i]['maTK'] . ' ">
                                    <a href="#sua-taikhoan" class="taikhoan-' . $TaiKhoan[$i]['maTK'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="taikhoan-' . $TaiKhoan[$i]['maTK'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
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
                            if (isset($_SESSION['get']['TaiKhoan'])) {
                                $length = $_SESSION['get']['TaiKhoan']['Data']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1) echo '<li onclick="paginate(this)" class="taikhoan-' . $i . ' current-page">' . $i . '</li>';
                                    else echo '<li onclick="paginate(this)" class="taikhoan-' . $i . '">' . $i . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="nhanvien__row content-row">
                <div class="content-item__header">
                    <span>Nhân viên</span>
                    <button class="nhanvien--filter"><i class="fas fa-filter"></i></button>
                </div>
                <form class="hidden add-content nhanvien__add-content" id="sua-nhanvien">
                    <div class="add-content__input">
                        <div class="add-content__input-left">
                            <?php
                            if (isset($_SESSION['get']['HienThiSelect'])) {
                                $ma = end($_SESSION['get']['HienThiSelect'])['maTK'];
                                echo '<input type="text" name="maTK" value="' . $ma . '" hidden>';
                            }
                            ?>
                            <input type="text" name="ho" placeholder="Họ">
                            <input type="text" name="ten" placeholder="Tên">
                            <input type="text" name="ngaySinh" placeholder="Ngày sinh">
                        </div>
                        <div class="add-content__input-right">
                            <input type="text" name="diaChi" placeholder="Địa chỉ">
                            <input type="text" name="soDienThoai" placeholder="Số điện thoại">
                            <input type="text" name="luong" placeholder="Lương">
                        </div>
                    </div>
                    <div>
                        <input type="submit" value="Thêm">
                        <button class="nhanvien--add button-huy">Hủy</button>
                    </div>
                </form>
                <form class="hidden filter-content nhanvien__filter-content">
                    <select name="filterCol" style="margin-right: 0;">
                        <option value="ngaySinh">Ngày sinh</option>
                        <option value="luong">Lương</option>
                    </select>
                    <div>
                        <input type="text" name="from" placeholder="Từ">
                        <i class="fas fa-long-arrow-alt-right"></i>
                        <input type="text" name="to" placeholder="Đến">
                    </div>
                    <input type="submit" value="Lọc">
                </form>
                <div class="title--border">
                    <div class="nhanvien__title row">
                        <div class="center nhanvien-item-title checkbox col-1">
                            <i class="nhanvien--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="nhanvien__master-checkbox" onclick="checkAll(this)"></input>
                        </div>
                        <h6 class="center nhanvien-item-title col-1">Tài khoản</h6>
                        <h6 class="center nhanvien-item-title col-1">Họ</h6>
                        <h6 class="center nhanvien-item-title col-1">Tên</h6>
                        <h6 class="center nhanvien-item-title col-2">Ngày sinh</h6>
                        <h6 class="center nhanvien-item-title col-3">Địa chỉ</h6>
                        <h6 class="center nhanvien-item-title col-1">Số điện thoai</h6>
                        <h6 class="center nhanvien-item-title col-1">Lương</h6>
                        <h6 class="center nhanvien-item-title col-1">Thao tác</h6>
                    </div>
                </div>
                <div class="nhanvien--show row">
                    <?php
                    if (isset($_SESSION['get']['NhanVien'])) {
                        $NhanVien = $_SESSION['get']['NhanVien']['Data']['data'];
                        $length = count($NhanVien);

                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <div class="checkbox col-1  ">
                                    <input type="checkbox" class="nhanvien__checkbox" value="' . $NhanVien[$i]['maNV'] . '"></input>
                                </div>
                                <span class="hidden row-' . $NhanVien[$i]['maNV'] . ' maTK">' . $NhanVien[$i]['taikhoan']['maTK'] . '</span>
                                <span class="center-left col-1 ">' . $NhanVien[$i]['taikhoan']['tenTaiKhoan'] . '</span>
                                <span class="center-left col-1  row-' . $NhanVien[$i]['maNV'] . ' ho">' . $NhanVien[$i]['ho'] . '</span>
                                <span class="center-left col-1  row-' . $NhanVien[$i]['maNV'] . ' ten">' . $NhanVien[$i]['ten'] . '</span>
                                <span class="center col-2  row-' . $NhanVien[$i]['maNV'] . ' ngaySinh">' . $NhanVien[$i]['ngaySinh'] . '</span>
                                <span class="center-left col-3  row-' . $NhanVien[$i]['maNV'] . ' diaChi">' . $NhanVien[$i]['diaChi'] . '</span>
                                <span class="center col-1  row-' . $NhanVien[$i]['maNV'] . ' soDienThoai">' . $NhanVien[$i]['soDienThoai'] . '</span>
                                <span class="center col-1  row-' . $NhanVien[$i]['maNV'] . ' luong">' . $NhanVien[$i]['luong'] . '</span>
                                <div class="center col-1 ">
                                    <a href="#sua-nhanvien" class="nhanvien-' . $NhanVien[$i]['maNV'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="nhanvien-' . $NhanVien[$i]['maNV'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
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
                            if (isset($_SESSION['get']['NhanVien'])) {
                                $length = $_SESSION['get']['NhanVien']['Data']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="nhanvien-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="nhanvien-' . $i . '">' . $i . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="khachhang__row content-row">
                <div class="content-item__header">
                    <span>Khách hàng</span>
                    <button class="khachhang--filter"><i class="fas fa-filter"></i></button>
                </div>
                <form class="hidden add-content khachhang__add-content" id="sua-khachhang">
                    <div class="add-content__input">
                        <div class="add-content__input-left">
                            <?php
                            if (isset($_SESSION['get']['HienThiSelect'])) {
                                $ma = end($_SESSION['get']['HienThiSelect'])['maTK'];
                                echo '<input type="text" name="maTK" value="' . $ma . '" hidden>';
                            }
                            ?>
                            <input type="text" name="maTK" value="1" hidden>
                            <input type="text" name="ho" placeholder="Họ">
                            <input type="text" name="ten" placeholder="Tên">
                            <input type="text" name="ngaySinh" placeholder="Ngày sinh">
                        </div>
                        <div class="add-content__input-right">
                            <input type="text" name="diaChi" placeholder="Địa chỉ">
                            <input type="text" name="soDienThoai" placeholder="Số điện thoại">
                        </div>
                    </div>
                    <div>
                        <input type="submit" value="Thêm">
                        <button class="khachhang--add button-huy">Hủy</button>
                    </div>
                </form>
                <form class="hidden filter-content khachhang__filter-content">
                    <select name="filterCol" style="margin-right: 0;">
                        <option value="ngaySinh">Ngày sinh</option>
                    </select>
                    <div>
                        <input type="text" name="from" placeholder="Từ">
                        <i class="fas fa-long-arrow-alt-right"></i>
                        <input type="text" name="to" placeholder="Đến">
                    </div>
                    <input type="submit" value="Lọc">
                </form>
                <div class="title--border">
                    <div class="khachhang__title row">
                        <div class="center khachhang-item-title checkbox col-1">
                            <i class="khachhang--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="khachhang__master-checkbox" onclick="checkAll(this)"></input>
                        </div>
                        <h6 class="center khachhang-item-title col-1">Tài khoản</h6>
                        <h6 class="center khachhang-item-title col-1">Họ</h6>
                        <h6 class="center khachhang-item-title col-1">Tên</h6>
                        <h6 class="center khachhang-item-title col-2">Ngày sinh</h6>
                        <h6 class="center khachhang-item-title col-3">Địa chỉ</h6>
                        <h6 class="center khachhang-item-title col-1">Số điện thoai</h6>
                        <h6 class="center khachhang-item-title col-2">Thao tác</h6>
                    </div>
                </div>
                <div class="khachhang--show row">
                    <?php
                    if (isset($_SESSION['get']['KhachHang'])) {
                        $KhachHang = $_SESSION['get']['KhachHang']['Data']['data'];
                        $length = count($KhachHang);

                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <div class="checkbox col-1  ">
                                    <input type="checkbox" class="khachhang__checkbox" value="' . $KhachHang[$i]['maKH'] . '"></input>
                                </div>
                                <span class="center-left col-1 ">' . $KhachHang[$i]['taikhoan']['tenTaiKhoan'] . '</span>
                                <span class="hidden row-' . $KhachHang[$i]['maKH'] . ' maTK">' . $KhachHang[$i]['taikhoan']['maTK'] . '</span>
                                <span class="center-left col-1  row-' . $KhachHang[$i]['maKH'] . ' ho">' . $KhachHang[$i]['ho'] . '</span>
                                <span class="center-left col-1  row-' . $KhachHang[$i]['maKH'] . ' ten">' . $KhachHang[$i]['ten'] . '</span>
                                <span class="center col-2  row-' . $KhachHang[$i]['maKH'] . ' ngaySinh">' . $KhachHang[$i]['ngaySinh'] . '</span>
                                <span class="center-left col-3  row-' . $KhachHang[$i]['maKH'] . ' diaChi">' . $KhachHang[$i]['diaChi'] . '</span>
                                <span class="center col-1  row-' . $KhachHang[$i]['maKH'] . ' soDienThoai">' . $KhachHang[$i]['soDienThoai'] . '</span>
                                <div class="center col-2 ">
                                    <a href="#sua-khachhang" class="khachhang-' . $KhachHang[$i]['maKH'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="khachhang-' . $KhachHang[$i]['maKH'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
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
                            if (isset($_SESSION['get']['KhachHang'])) {
                                $length = $_SESSION['get']['KhachHang']['Data']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="khachhang-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="khachhang-' . $i . '">' . $i . '</li>';
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
</div>

<script src="/Web2/admin/public/scripts/Admin.js"></script>
<script src="/Web2/admin/public/scripts/TaiKhoanAdmin.js"></script>
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

    function changeQuyen(ele) {
        ajaxChangeQuyen(ele)
    }

    function capNhatTrangThai(ele) {
        ajaxCapNhatTrangThai(ele)
    }
</script>