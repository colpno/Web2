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
                    <span>Phiếu nhập hàng mới nhất</span>
                    <div>
                        <button class="phieunhaphang--add "><i class="fas fa-plus"></i></button>
                        <button class="phieunhaphang--filter"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                <form class="hidden add-content phieunhaphang__add-content" id="sua-phieunhaphang">
                    <select name="maNCC">
                        <?php
                        if (isset($_SESSION['get']['PhieuNhapHang'])) {
                            $data = $_SESSION['get']['PhieuNhapHang']['HienThiSelect']['NhaCungCap'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maNCC'] . '">' . $value['maNCC'] . ' - ' . $value['tenNCC'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <select name="maNV">
                        <?php
                        if (isset($_SESSION['get']['PhieuNhapHang'])) {
                            $data = $_SESSION['get']['PhieuNhapHang']['HienThiSelect']['NhanVien'];
                            foreach ($data as $key => $value) {
                                echo '<option value="' . $value['maNV'] . '">' . $value['maNV'] . ' - ' . $value['ho'] . ' ' . $value['ten'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <input type="text" name="ngayNhap" placeholder="Ngày nhập">
                    <input type="submit" value="Thêm">
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
                        <h6 class="center phieunhaphang-item-title col-3">Tên nhà cung cấp</h6>
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
                                <span class="hidden row-' . $PhieuNhapHang[$i]['maPhieu'] . ' maNV">' . $PhieuNhapHang[$i]['nhanVien']['maNV'] . '</span>
                                <span class="center-left col-3">' . $PhieuNhapHang[$i]['nhaCungCap']['tenNCC'] . '</span>
                                <span class="center-left col-2">' . $PhieuNhapHang[$i]['nhanVien']['ho'] . ' ' . $PhieuNhapHang[$i]['nhanVien']['ten'] . '</span>
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
                    <div>
                        <button class="chitietphieunhaphang--add "><i class="fas fa-plus"></i></button>
                        <button class="chitietphieunhaphang--filter"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                <form class="hidden add-content chitietphieunhaphang__add-content" id="sua-chitietphieunhaphang">
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
                    <input type="text" name="donGiaGoc" placeholder="Đơn giá gốc">
                    <input type="submit" value="Thêm">
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
                        <h6 class="center chitietphieunhaphang-item-title col-2">Dơn giá gốc</h6>
                        <h6 class="center chitietphieunhaphang-item-title col-2">Thành tiền</h6>
                        <h6 class="center chitietphieunhaphang-item-title col-2">Thao tác</h6>
                    </div>
                </div>
                <div class="chitietphieunhaphang--show row" style="display:flex;align-items: center;justify-content: center;height: 200px;">
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
                    <div>
                        <button class="chitiethoadon--add hidden"><i class="fas fa-plus"></i></button>
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
                        <h6 class="center chitiethoadon-item-title col-3">Thành tiền</h6>
                    </div>
                </div>
                <div class="chitiethoadon--show row" style="display:flex;align-items: center;justify-content: center;height: 200px;">
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
                    <span>Hóa đơn mới nhất</span>
                    <div>
                        <button class="hoadon--add hidden"><i class="fas fa-plus"></i></button>
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
                        <div class="center hoadon-item-title checkbox col-1">
                            <i class="hoadon--delete far fa-trash-alt " onclick="multiDel(this)"></i>
                            <input type="checkbox" class="hoadon__master-checkbox" onclick="checkAll(this)"></input>
                        </div>
                        <!--<h6 class="center hoadon-item-title col-1">Họ tên nhân viên</h6>-->
                        <h6 class="center-left hoadon-item-title col-2">Họ tên khách hàng</h6>
                        <h6 class="center hoadon-item-title col-1">Số điện thoại</h6>
                        <h6 class="center hoadon-item-title col-3">Địa chỉ</h6>
                        <h6 class="center hoadon-item-title col-2">Ngày lập hóa đơn</h6>
                        <h6 class="center hoadon-item-title col-1">Tổng tiền</h6>
                        <h6 class="center hoadon-item-title col-1 tinhTrang-header">Tình trạng
                            <select id="tinhTrangDon">
                                <option value="">Tất cả</option>
                                <option value="0">Chưa xử lý</option>
                                <option value="1">Đã xử lý</option>
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
                                <div class="checkbox col-1 ">
                                    <input type="checkbox" class="hoadon__checkbox" value="' . $HoaDon[$i]['maHD'] . '"></input>
                                </div>
                                
                                <span class="hidden row-' . $HoaDon[$i]['maHD'] . ' maKH">' . $HoaDon[$i]['khachHang']['maKH'] . '</span>

                                <span class="center-left col-2">' . $HoaDon[$i]['khachHang']['ho'] . ' ' . $HoaDon[$i]['khachHang']['ten'] . '</span>
                                <span class="center col-1 row-' . $HoaDon[$i]['maHD'] . ' soDienThoai">' . $HoaDon[$i]['soDienThoai'] . '</span>
                                <span class="center-left col-3 row-' . $HoaDon[$i]['maHD'] . ' diaChi">' . $HoaDon[$i]['diaChi'] . '</span>
                                <span class="center col-2 row-' . $HoaDon[$i]['maHD'] . ' ngayLapHoaDon">' . $HoaDon[$i]['ngayLapHoaDon'] . '</span>
                                <span class="center col-1 row-' . $HoaDon[$i]['maHD'] . ' tongTien">' . $HoaDon[$i]['tongTien'] . '</span>
                                <span class="center col-1 row-' . $HoaDon[$i]['maHD'] . ' tinhTrang">';

                            if ($HoaDon[$i]['tinhTrang'] == 0) {
                                echo '<input type="checkbox" class="check-tinhTrang hoadon-' . $HoaDon[$i]['maHD'] . '" onclick="capNhatHoaDon(this)">';
                            } else {
                                echo '<input type="checkbox" class="check-tinhTrang hoadon-' . $HoaDon[$i]['maHD'] . '" checked onclick="capNhatHoaDon(this)">';
                            }

                            echo '
                                </span>
                                <div class="center col-1">
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
</script>