<link rel="stylesheet" href="/Web2/admin/public/css/admin/NhapXuatAdmin.css">

<div class="nhap-xuat container">
    <div class="nhap-xuat-report__row row ">
        <div class='nhap-xuat-report__row__report col-6'>
            <div class="report-item">
                <div class="report-item__text">
                    <?php
                    if (isset($_SESSION['get']['PhieuNhapHang'])) {
                        $soLuong = $_SESSION['get']['PhieuNhapHang']['TongSoPhieuNhapHang']['soLuong'];
                        echo "<span class='center-left nhap-xuat-report__number'>$soLuong</span>";
                    }
                    ?>
                    <img src="/Web2/admin/public/images/Icon/shortlist.png" />
                </div>
                <p>Phiếu nhập hàng</p>
            </div>
        </div>
        <div class='nhap-xuat-report__row__report col-6'>
            <div class="report-item">
                <div class="report-item__text">
                    <?php
                    if (isset($_SESSION['get']['HoaDon'])) {
                        $soLuong = $_SESSION['get']['HoaDon']['TongSoHoaDon']['soLuong'];
                        echo "<span class='center-left customer-report__number'>$soLuong</span>";
                    }
                    ?>
                    <img src="/Web2/admin/public/images/Icon/shortlist.png" />
                </div>
                <p>Hóa đơn</p>
            </div>
        </div>
    </div>
    <div class="content--show row">
        <div class="col-12">
            <div class="phieunhaphang__row content-row">
                <div class="content-item__header">
                    <span>Phiếu nhập hàng</span>
                    <div class="content-item__header__tools">
                        <button class="phieunhaphang--add "><i class="fas fa-plus"></i></button>
                        <button class="phieunhaphang--sort "><i class="fas fa-sort"></i></button>
                        <button class="phieunhaphang--filter"><i class="fas fa-filter"></i></button>
                        <!-- <button onclick="duDoanNhapKho()">Dự đoán nhập kho</button> -->
                    </div>
                </div>
                <form class="hidden add-content phieunhaphang__add-content" id="sua-phieunhaphang">
                    <select name="maNCC">
                        <?php
                        if (isset($_SESSION['get']['PhieuNhapHang'])) {
                            $data = $_SESSION['get']['PhieuNhapHang']['HienThiSelect']['NhaCungCap'];
                            echo '<option value="" disabled>Chọn nhà cung cấp</option>';
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maNCC'] . '">' . $value['maNCC'] . ' - ' . $value['tenNCC'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <?php
                    if ($userC['quyen'] != 1) {
                        echo '<span class="hidden" name="maNV">' . $userC['maKH'] . '</span>';
                    } else {
                        echo '<span class="hidden" name="maNV">NULL</span>';
                    }
                    ?>
                    <!-- <select name="maNV" title="ok">
                    </select> -->
                    <?php
                    echo '<input type="text" id="ngayNhapHang" name="ngayNhap" disabled style="color: rgb(170, 170, 170);border-color: rgba(118, 118, 118, 0.3);">';
                    ?>
                    <input type="submit" value="Thêm">
                </form>
                <form class="hidden sort-content phieunhaphang__sort-content">
                    <select class="sort-col" name="sortCol">
                        <option value="ngayNhap">Ngày nhập</option>
                        <option value="tongTien">Tổng tiền</option>
                    </select>
                    <select class="sort-order" name="order">
                        <option value="asc">Tăng dần</option>
                        <option value="desc">Giảm dần</option>
                    </select>
                    <input type="submit" value="Sắp xếp">
                </form>
                <form class="hidden filter-content phieunhaphang__filter-content">
                    <select name="filterCol" style="margin-right: 0;">
                        <option value="ngayNhap">Ngày nhập</option>
                        <option value="tongTien">Tổng tiền</option>
                    </select>
                    <div>
                        <input type="text" name="from" placeholder="Từ">
                        <i class="fas fa-long-arrow-alt-right"></i>
                        <input type="text" name="to" placeholder="Đến">
                    </div>
                    <input type="submit" value="Lọc">
                </form>
                <div class="title--border">
                    <div class="phieunhaphang__title row">
                        <div class="center checkbox phieunhaphang-item-title col-1">
                            <i class="phieunhaphang--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="phieunhaphang__master-checkbox" onclick=" checkAll(this)">
                        </div>
                        <h6 class="center phieunhaphang-item-title col-1">Mã phiếu</h6>
                        <h6 class="center phieunhaphang-item-title col-2">Tên nhà cung cấp</h6>
                        <h6 class="center phieunhaphang-item-title col-2">Họ tên nhân viên</h6>
                        <h6 class="center phieunhaphang-item-title col-2">Ngày nhập</h6>
                        <h6 class="center phieunhaphang-item-title col-2">Tổng tiền</h6>
                        <h6 class="center phieunhaphang-item-title col-2">Thao tác</h6>
                    </div>
                </div>
                <div class="phieunhaphang--show row">
                    <?php
                    if (isset($_SESSION['get']['PhieuNhapHang'])) {
                        $PhieuNhapHang = $_SESSION['get']['PhieuNhapHang']['Data']['data'];
                        $length = count($PhieuNhapHang);

                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <div class="checkbox col-1">
                                    <input type="checkbox" class="phieunhaphang__checkbox" value="' . $PhieuNhapHang[$i]['maPhieu'] . '"></input>
                                </div>
                                <span class="hidden row-' . $PhieuNhapHang[$i]['maPhieu'] . ' maPhieu">' . $PhieuNhapHang[$i]['maPhieu'] . '</span>
                                <span class="hidden row-' . $PhieuNhapHang[$i]['maPhieu'] . ' maNCC">' . $PhieuNhapHang[$i]['nhaCungCap']['maNCC'] . '</span>
                                <span class="hidden row-' . $PhieuNhapHang[$i]['maPhieu'] . ' maNV">';

                            if (isset($PhieuNhapHang[$i]['nhanVien']['maTK']) && $PhieuNhapHang[$i]['nhanVien']['maTK'] != 2) {
                                echo $PhieuNhapHang[$i]['nhanVien']['maNV'];
                            } else {
                                echo NULL;
                            }
                            echo '
                                </span>
                                <span class="center col-1 row-' . $PhieuNhapHang[$i]['maPhieu'] . '">' . $PhieuNhapHang[$i]['maPhieu'] . '</span>
                                <span class="center-left col-2">' . $PhieuNhapHang[$i]['nhaCungCap']['tenNCC'] . '</span>
                                <span class="center-left col-2">';
                            if (isset($PhieuNhapHang[$i]['nhanVien']['maTK']) && $PhieuNhapHang[$i]['nhanVien']['maTK'] != 2) {
                                echo $PhieuNhapHang[$i]['nhanVien']['ho'] . ' ' . $PhieuNhapHang[$i]['nhanVien']['ten'];
                            } else {
                                echo 'Admin';
                            }
                            echo '
                                </span>
                                <span class="center col-2 row-' . $PhieuNhapHang[$i]['maPhieu'] . ' ngayNhap">' . $PhieuNhapHang[$i]['ngayNhap'] . '</span>
                                <span class="center col-2 row-' . $PhieuNhapHang[$i]['maPhieu'] . ' tongTien">' . $PhieuNhapHang[$i]['tongTien'] . '</span>
                                <div class="center col-2">
                                    <a href="#sua-phieunhaphang" class="phieunhaphang-' . $PhieuNhapHang[$i]['maPhieu'] . ' btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                                    <button class="phieunhaphang-' . $PhieuNhapHang[$i]['maPhieu'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                    <button class="phieunhaphang-' . $PhieuNhapHang[$i]['maPhieu'] . ' btn" onclick="openDetail(this)"><i class="fas fa-arrow-circle-right"></i></button>
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
                            if (isset($_SESSION['get']['PhieuNhapHang'])) {
                                $length = $_SESSION['get']['PhieuNhapHang']['Data']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="phieunhaphang-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="phieunhaphang-' . $i . '">' . $i . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="chitietphieunhaphang__row content-row">
                <div class="content-item__header">
                    <span>Chi Tiết Phiếu nhập hàng</span>
                    <div class="content-item__header__tools">
                        <button class="chitietphieunhaphang--add "><i class="fas fa-plus"></i></button>
                        <button class="chitietphieunhaphang--sort "><i class="fas fa-sort"></i></button>
                        <button class="chitietphieunhaphang--filter"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                <form class="hidden add-content chitietphieunhaphang__add-content" id="sua-chitietphieunhaphang">
                    <select name="maSP" class="selectSanPham">
                        <option value="" disabled selected>Chọn sản phẩm cần nhập</option>
                        <?php
                        if (isset($_SESSION['get']['ChiTietPhieuNhapHang'])) {
                            $data = $_SESSION['get']['ChiTietPhieuNhapHang']['HienThiSelect'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maSP'] . '">' . $value['maSP'] . ' - ' . $value['tenSP'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <div class="add-content__input" style="margin-top: 10px">
                        <input type=" text" name="soLuong" placeholder="Số lượng" class="soLuongSanPhamNhap">
                        <button type="button" class="DuDoanOpen" onclick="duDoan()">Dự đoán</button>
                    </div>
                    <input type=" text" style="width: 300px;margin-top: 17px" name="gia" class="chitietphieunhap-gia" placeholder="Thành tiền" disabled>
                    <input type="submit" value="Thêm">
                </form>
                <form class="hidden sort-content chitietphieunhaphang__sort-content">
                    <select class="sort-col" name="sortCol">
                        <option value="soLuong">Số lượng</option>
                        <option value="donGiaGoc">Giá gốc</option>
                        <option value="thanhTien">Thành tiền</option>
                    </select>
                    <select class="sort-order" name="order">
                        <option value="asc">Tăng dần</option>
                        <option value="desc">Giảm dần</option>
                    </select>
                    <input type="submit" value="Sắp xếp">
                </form>
                <form class="hidden filter-content chitietphieunhaphang__filter-content">
                    <select name="filterCol" style="margin-right: 0;">
                        <option value="soLuong">Số lượng</option>
                        <option value="donGiaGoc">Đơn giá</option>
                        <option value="thanhTien">Thành tiền</option>
                    </select>
                    <div>
                        <input type="text" name="from" placeholder="Từ">
                        <i class="fas fa-long-arrow-alt-right"></i>
                        <input type="text" name="to" placeholder="Đến">
                    </div>
                    <input type="submit" value="Lọc">
                </form>
                <div class="title--border">
                    <div class="chitietphieunhaphang__title row">
                        <div class="center checkbox chitietphieunhaphang-item-title col-2">
                            <i class="chitietphieunhaphang--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="chitietphieunhaphang__master-checkbox" onclick=" checkAll(this)">
                        </div>
                        <h6 class="center chitietphieunhaphang-item-title col-3">Tên sản phẩm</h6>
                        <h6 class="center chitietphieunhaphang-item-title col-1">Số lượng</h6>
                        <h6 class="center chitietphieunhaphang-item-title col-2">Đơn giá gốc</h6>
                        <h6 class="center chitietphieunhaphang-item-title col-2">Thành tiền</h6>
                        <h6 class="center chitietphieunhaphang-item-title col-2">Thao tác</h6>
                    </div>
                </div>
                <div class="chitietphieunhaphang--show row" style="display:flex;align-items: center;justify-content: center;min-height: 200px;">
                    <div>
                        <h3>Mở phiếu nhập để xem</h3>
                    </div>
                </div>
                <div class="content-item__pagination row">
                    <div>
                        <ul class="text-center center paginate"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="chitiethoadon__row content-row">
                <div class="content-item__header">
                    <span>Chi Tiết Hóa Đơn</span>
                    <div class="content-item__header__tools">
                        <button class="chitiethoadon--add hidden"><i class="fas fa-plus"></i></button>
                        <button class="chitiethoadon--sort "><i class="fas fa-sort"></i></button>
                        <button class="chitiethoadon--filter"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                <form class="hidden add-content chitiethoadon__add-content" id="sua-chitiethoadon">
                    <select name="maSP">
                        <?php
                        if (isset($_SESSION['get']['ChiTietPhieuNhapHang'])) {
                            $data = $_SESSION['get']['ChiTietPhieuNhapHang']['HienThiSelect'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maSP'] . '">' . $value['maSP'] . ' - ' . $value['tenSP'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <input type="text" name="soLuong" placeholder="Số lượng">
                    <input type="text" name="donGia" placeholder="Đơn giá">
                    <input type="text" name="thanhTien" placeholder="Thành tiền">
                    <input type="submit" value="Sửa">
                </form>
                <form class="hidden sort-content chitiethoadon__sort-content">
                    <select class="sort-col" name="sortCol">
                        <option value="soLuong">Số lượng</option>
                        <option value="donGia">Đơn giá</option>
                        <option value="thanhTien">Thành tiền</option>
                    </select>
                    <select class="sort-order" name="order">
                        <option value="asc">Tăng dần</option>
                        <option value="desc">Giảm dần</option>
                    </select>
                    <input type="submit" value="Sắp xếp">
                </form>
                <form class="hidden filter-content chitiethoadon__filter-content">
                    <select name="filterCol" style="margin-right: 0;">
                        <option value="soLuong">Số lượng</option>
                        <option value="donGia">Giá</option>
                        <option value="thanhTien">Thành tiền</option>
                    </select>
                    <div>
                        <input type="text" name="from" placeholder="Từ">
                        <i class="fas fa-long-arrow-alt-right"></i>
                        <input type="text" name="to" placeholder="Đến">
                    </div>
                    <input type="submit" value="Lọc">
                </form>
                <div class="title--border">
                    <div class="chitiethoadon__title row">
                        <h6 class="center chitietphieunhaphang-item-title col-5">Tên sản phẩm</h6>
                        <h6 class="center chitiethoadon-item-title col-2">Số lượng</h6>
                        <h6 class="center chitiethoadon-item-title col-2">Giá</h6>
                        <h6 class="center chitiethoadon-item-title col-2">Thành tiền</h6>
                    </div>
                </div>
                <div class="chitiethoadon--show row" style="display:flex;align-items: center;justify-content: center;min-height: 200px;">
                    <div>
                        <h3>Mở hóa đơn để xem</h3>
                    </div>
                </div>
                <div class="content-item__pagination row">
                    <div>
                        <ul class="text-center center paginate"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="hoadon__row content-row">
                <div class="content-item__header">
                    <span>Hóa đơn</span>
                    <div class="content-item__header__tools">
                        <button class="hoadon--add hidden"><i class="fas fa-plus"></i></button>
                        <button class="hoadon--sort "><i class="fas fa-sort"></i></button>
                        <button class="hoadon--filter"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                <form class="hidden add-content hoadon__add-content" id="sua-hoadon">
                    <select name="maNV">
                        <?php
                        if (isset($_SESSION['get']['HoaDon'])) {
                            $data = $_SESSION['get']['HoaDon']['HienThiSelect']['NhanVien'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maNV'] . '">' . $value['maNV'] . ' - ' . $value['ho'] . ' ' . $value['ten'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <select name="maKH">
                        <?php
                        if (isset($_SESSION['get']['HoaDon'])) {
                            $data = $_SESSION['get']['HoaDon']['HienThiSelect']['KhachHang'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maKH'] . '">' . $value['maKH'] . ' - ' . $value['ho'] . ' ' . $value['ten'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <input type="text" name="ngayLapHoaDon" placeholder="Ngày lập">
                    <input type="text" name="tongTien" placeholder="Tổng tiền">
                    <input type="submit" value="Sửa">
                </form>
                <form class="hidden sort-content hoadon__sort-content">
                    <select class="sort-col" name="sortCol">
                        <option value="ngayLapHoaDon">Ngày lập hóa đơn</option>
                        <option value="tongTien">Tổng tiền</option>
                    </select>
                    <select class="sort-order" name="order">
                        <option value="asc">Tăng dần</option>
                        <option value="desc">Giảm dần</option>
                    </select>
                    <input type="submit" value="Sắp xếp">
                </form>
                <form class="hidden filter-content hoadon__filter-content">
                    <select name="filterCol" style="margin-right: 0;">
                        <option value="ngayLapHoaDon">Ngày lập hóa đơn</option>
                        <option value="tongTien">Tổng tiền</option>
                    </select>
                    <div>
                        <input type="text" name="from" placeholder="Từ">
                        <i class="fas fa-long-arrow-alt-right"></i>
                        <input type="text" name="to" placeholder="Đến">
                    </div>
                    <input type="submit" value="Lọc">
                </form>
                <div class="title--border">
                    <div class="hoadon__title row">
                        <!--<h6 class="center hoadon-item-title col-1">Họ tên nhân viên</h6>-->
                        <div class="center checkbox hoadon-item-title col-1">
                            <i class="hoadon--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="hoadon__master-checkbox" onclick=" checkAll(this)">
                        </div>
                        <h6 class="center hoadon-item-title col-1">Mã hóa đơn</h6>
                        <h6 class="center-left hoadon-item-title col-1">Họ tên khách hàng</h6>
                        <h6 class="center-left hoadon-item-title col-1">Họ tên nhân viên</h6>
                        <h6 class="center hoadon-item-title col-1">Số điện thoại</h6>
                        <h6 class="center hoadon-item-title col-2">Địa chỉ</h6>
                        <h6 class="center hoadon-item-title col-1">Ngày lập hóa đơn</h6>
                        <h6 class="center hoadon-item-title col-1">Tổng tiền</h6>
                        <h6 class="center hoadon-item-title col-2 tinhTrang-header">Tình trạng
                            <select id="tinhTrangDon">
                                <option value="">Tất cả</option>
                                <option value="1">Chưa giải quyết</option>
                                <option value="2">Đã xử lý</option>
                                <option value="3">Vận chuyển</option>
                                <option value="4">Hoàn thành</option>
                            </select>
                        </h6>
                        <h6 class="center hoadon-item-title col-1">Thao tác</h6>
                    </div>
                </div>
                <div class="hoadon--show row">
                    <?php
                    if (isset($_SESSION['get']['HoaDon'])) {
                        $HoaDon = $_SESSION['get']['HoaDon']['Data']['data'];
                        $length = count($HoaDon);
                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <div class="checkbox col-1">
                                    <input name="maHD" type="checkbox" class="hoadon__checkbox" value="' . $HoaDon[$i]['maHD'] . '"></input>
                                </div>
                                <span class="hidden row-' . $HoaDon[$i]['maHD'] . ' maKH">' . $HoaDon[$i]['khachHang']['maKH'] . '</span>

                                <span class="center col-1 row-' . $HoaDon[$i]['maHD'] . ' maHD">' . $HoaDon[$i]['maHD'] . '</span>
                                <span class="center-left col-1">' . $HoaDon[$i]['khachHang']['ho'] . ' ' . $HoaDon[$i]['khachHang']['ten'] . '</span>
                                <span class="center-left col-1">';
                            if (isset($HoaDon[$i]['nhanVien']['maTK']) && $HoaDon[$i]['nhanVien']['maTK'] != 2) {
                                echo $HoaDon[$i]['nhanVien']['ho'] . ' ' . $HoaDon[$i]['nhanVien']['ten'];
                            } else {
                                echo 'Admin';
                            }
                            echo '</span>
                                <span class="center col-1 row-' . $HoaDon[$i]['maHD'] . ' soDienThoai">' . $HoaDon[$i]['soDienThoai'] . '</span>
                                <span class="center-left col-2 row-' . $HoaDon[$i]['maHD'] . ' diaChi">' . $HoaDon[$i]['diaChi'] . '</span>
                                <span class="center col-1 row-' . $HoaDon[$i]['maHD'] . ' ngayLapHoaDon">' . $HoaDon[$i]['ngayLapHoaDon'] . '</span>
                                <span class="center col-1 row-' . $HoaDon[$i]['maHD'] . ' tongTien">' . $HoaDon[$i]['tongTien'] . '</span>
                                <div class="center col-2">';
                            switch ($HoaDon[$i]['tinhTrang']) {
                                case 1: {
                                        echo '<span class="center row-' . $HoaDon[$i]['maHD'] . ' bill-status-1 confirmed tinhTrang" onclick="openBillProgress(this)">Chưa giải quyết</span>';
                                        break;
                                    }
                                case 2: {
                                        echo '<span class="center row-' . $HoaDon[$i]['maHD'] . ' bill-status-2 confirmed tinhTrang" onclick="openBillProgress(this)">Đã xử lý</span>';
                                        break;
                                    }
                                case 3: {
                                        echo '<span class="center row-' . $HoaDon[$i]['maHD'] . ' bill-status-3 confirmed tinhTrang" onclick="openBillProgress(this)">Vận chuyển</span>';
                                        break;
                                    }
                                case 4: {
                                        echo '<span class="center row-' . $HoaDon[$i]['maHD'] . ' bill-status-4 confirmed tinhTrang" onclick="openBillProgress(this)">Hoàn thành</span>';
                                        break;
                                    }
                                default: {
                                        echo '<span class="center row-' . $HoaDon[$i]['maHD'] . ' tinhTrang" onclick="openBillProgress(this)"></span>';
                                        break;
                                    }
                            }
                            echo '
                                </div>
                                <div class="center col-1">
                                    <button class="hoadon-' . $HoaDon[$i]['maHD'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                                    <button class="hoadon-' . $HoaDon[$i]['maHD'] . ' btn" onclick="openDetail(this)"><i class="fas fa-arrow-circle-right"></i></button>
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
                            if (isset($_SESSION['get']['HoaDon'])) {
                                $length = $_SESSION['get']['HoaDon']['Data']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="hoadon-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="hoadon-' . $i . '">' . $i . '</li>';
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

<div class="hidden dudoan-container">
    <span class="dudoan-container--close"><i class="fas fa-times" onclick="closeDuDoan()"></i></span>
    <p>Dự đoán số lượng nhập</p>
    <!-- <select name="ngayBan" class="selectNgayBan">
        <option value="0" disabled selected>Chọn số ngày đã bán</option>
        <option value="5">5 ngày trước</option>
        <option value="15">15 ngày trước</option>
        <option value="30">30 ngày trước (1 tháng)</option>
        <option value="60">60 ngày trước (2 tháng)</option>
    </select> -->
    <label>Thời gian để tính số lượng đã bán</label>
    <div class="thoiGianTinh">
        <input type="date" class="inputDateTu">
        <input type="date" class="inputDateDen">
    </div>
    <label class="mt-2">Tồn kho</label>
    <input type="text" class="duDoan-tonKho" disabled>
    <label class="mt-2">Số ngày bán sắp tới</label>
    <select name="ngayToi" class="selectNgayToi">
        <option value="30" selected>Nhập hàng bán trong 30 ngày</option>
        <!-- <option value="1">5 ngày</option>
        <option value="2">15 ngày</option>
        <option value="3">30 ngày</option>
        <option value="4">60 ngày</option> -->
    </select>
    <button type="button" onclick="xacNhanDuDoan(this)">Xác nhận</button>
</div>

<div class="bill-progress hidden">
    <span class="hidden maHoaDon"></span>
    <span class="hidden tinhTrang"></span>
    <span class="hidden user"><?php if ($userC['quyen'] != 1) echo $userC['maKH'];
                                else echo 'NULL'; ?>
    </span>
    <span class="bill-progress--close"><i class="fas fa-times" onclick="closeBillProgress()"></i></span>
    <h2>Tiến trình đặt hàng</h2>
    <div class="bill-progress__container">
        <div class="bill-progress__status">
            <div class="bill-progress__status__drawing">
                <div class="bill-progress__status__circle bill-status bill-status-1 confirmed" onclick="changeBillState(this)">
                    <span class="bill-progress__status__text">Chưa giải quyết</span>
                </div>
                <div class="bill-progress__status__horizontal-line bill-status bill-status-1 confirmed"></div>
                <div class="bill-progress__status__vertical-line bill-status bill-status-1 confirmed"></div>
            </div>
            <div class="bill-progress__status__confirm-date"><span></span></div>
        </div>
        <div class="bill-progress__status">
            <div class="bill-progress__status__drawing">
                <div class="bill-progress__status__circle bill-status bill-status-2" onclick="changeBillState(this)">
                    <span class="bill-progress__status__text">Đã xử lý</span>
                </div>
                <div class="bill-progress__status__horizontal-line bill-status bill-status-2"></div>
                <div class="bill-progress__status__vertical-line bill-status bill-status-2"></div>
            </div>
            <div class="bill-progress__status__confirm-date"><span></span></div>
        </div>
        <div class="bill-progress__status">
            <div class="bill-progress__status__drawing">
                <div class="bill-progress__status__circle bill-status bill-status-3" onclick="changeBillState(this)">
                    <span class="bill-progress__status__text">Vận chuyển</span>
                </div>
                <div class="bill-progress__status__horizontal-line bill-status bill-status-3"></div>
                <div class="bill-progress__status__vertical-line bill-status bill-status-3"></div>
            </div>
            <div class="bill-progress__status__confirm-date"><span></span></div>
        </div>
        <div class="bill-progress__status">
            <div class="bill-progress__status__drawing">
                <div class="bill-progress__status__circle bill-status bill-status-4" onclick="changeBillState(this)">
                    <span class="bill-progress__status__text">Hoàn thành</span>
                </div>
                <div class="bill-progress__status__horizontal-line bill-status bill-status-4"></div>
                <div class="bill-progress__status__vertical-line bill-status bill-status-4"></div>
            </div>
            <div class="bill-progress__status__confirm-date"><span></span></div>
        </div>
    </div>
</div>

<script src="/Web2/admin/public/scripts/Admin.js"></script>
<script src="/Web2/admin/public/scripts/NhapXuatAdmin.js"></script>
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

    function capNhatHoaDon(ele) {
        ajaxCapNhatHoaDon(ele)
    }

    function duDoan() {
        if ($('.selectSanPham').val() > 0) {
            $(".dudoan-container").removeClass("hidden")
            const fd = new FormData();
            fd.append('table', 'string');
            fd.append('action', 'dudoan');
            const params = '?controller=admin&action=dudoan';
            $.ajax({
                url: '/Web2/admin/app/index.php' + params,
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (isJson(data) && data != null) {
                        const json = JSON.parse(data),
                            sanPham = json.SanPham['Data'],
                            maSPh = $('.selectSanPham').val();
                        const tonKho = sanPham.find((sp) => sp.maSP == maSPh).soLuong;
                        $('.duDoan-tonKho').val(tonKho)
                    } else {
                        alert(data);
                    }
                },
            });
        } else {
            alert('Cần chọn sản phẩm trước khi thực hiện dự đoán.')
        }
    }

    function closeDuDoan() {
        $(".dudoan-container").addClass("hidden")
    }

    function xacNhanDuDoan(ele) {
        ajaxXacNhanDuDoan()
    }

    function closeBillProgress() {
        $(".bill-progress").addClass("hidden")
        const tongSoTinhTrang = $('.bill-progress__status__confirm-date');
        for (let i = 0; i < tongSoTinhTrang.length; i++) {
            tongSoTinhTrang[i].querySelector('span').textContent = ''
        }
    }

    function openBillProgress(ele) {
        const that = $(ele),
            clas = that.attr('class').replace(' ', '.'),
            maHoaDon = clas.substring(
                clas.lastIndexOf('row-') + 'row-'.length,
                clas.lastIndexOf('row-') + 'row-'.length + 1,
            ),
            tinhTrang = clas.substring(
                clas.lastIndexOf('bill-status-') + 'bill-status-'.length,
                clas.lastIndexOf('bill-status-') + 'bill-status-'.length + 1
            ),
            tongSoTinhTrang = $('.bill-progress__status__circle').length;
        $('.bill-progress .maHoaDon').text(maHoaDon)
        $('.bill-progress .tinhTrang').text(tinhTrang)

        for (let i = 1; i <= tongSoTinhTrang; i++) {
            $(`.bill-progress .bill-status-${i}`).removeClass('confirmed');
        }
        for (let i = 1; i <= tinhTrang; i++) {
            $(`.bill-progress .bill-status-${i}`).addClass('confirmed');
        }

        const fd = new FormData();
        fd.append('table', 'hoadon');
        fd.append('action', 'get');
        const params = '?controller=admin&action=nhapxuat';
        $.ajax({
            url: '/Web2/admin/app/index.php' + params,
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
                if (isJson(data) && data != null) {
                    const json = JSON.parse(data),
                        hoaDons = json.data,
                        hoaDon = hoaDons.find((hd) => hd.maHD == maHoaDon);
                    let parent = '';
                    for (let i = 1; i <= tongSoTinhTrang; i++) {
                        parent = $(`.bill-status-${i}`).parent().parent();
                        switch (i) {
                            case 1: {
                                parent[parent.length - 1].querySelector('.bill-progress__status__confirm-date span').textContent = hoaDon.ngayLapHoaDon;
                                break;
                            }
                            case 2: {
                                parent[parent.length - 1].querySelector('.bill-progress__status__confirm-date span').textContent = hoaDon.ngayXuLy;
                                break;
                            }
                            case 3: {
                                parent[parent.length - 1].querySelector('.bill-progress__status__confirm-date span').textContent = hoaDon.ngayVanChuyen;
                                break;
                            }
                            case 4: {
                                parent[parent.length - 1].querySelector('.bill-progress__status__confirm-date span').textContent = hoaDon.ngayHoanThanh;
                                break;
                            }
                            default: {
                                break;
                            }
                        }
                    }
                } else {
                    alert(data);
                }
            },
        });

        $(".bill-progress").removeClass("hidden")
    }

    function changeBillState(ele) {
        ajaxChangeBillState(ele)
    }
</script>