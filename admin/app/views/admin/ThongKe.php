<link rel="stylesheet" href="/Web2/admin/public/css/admin/ThongKeAdmin.css">

<div class="thongke container">
    <div class="content--show row">
        <div class="col-12 chart-header">
            <div>
                <div class="chart-header__item">
                    <span><i class="far fa-chart-bar"></i>Thống kê</span>
                    <select name="" id="" onchange="changeReport(this)">
                        <option value="tongthu">Lợi nhuận</option>
                        <option value="doanhthu">Thu từ hóa đơn</option>
                        <option value="taikhoan-report">Số lượng khách mới</option>
                        <!-- <option value="sanphamban">Số lượng sản phẩm bán ra</option> -->
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 tongthu">
            <div class="content-row">
                <div class="chart-head">Lợi nhuận</div>
                <div class="chart">
                    <div class="chart-layout">
                        <?php
                        $doanhThu = [];
                        $tienNhap = [];
                        $tongThu = [];
                        $date = date("Y");
                        for ($i = 2015; $i <= $date; $i++) {
                            $doanhThu[$i] = [];
                            $tienNhap[$i] = [];
                            for ($j = 0; $j <= 12; $j++) {
                                array_push($doanhThu[$i], 0);
                                array_push($tienNhap[$i], 0);
                            }
                        }
                        foreach ($_SESSION['get']['HoaDon']['Data'] as $key => $value) {
                            $thang = (int) substr($value['ngayLapHoaDon'], strpos($value['ngayLapHoaDon'], '-') + 1, 2);
                            $nam = (int) substr($value['ngayLapHoaDon'], 0, 4);
                            $doanhThu[$nam][$thang] =  $doanhThu[$nam][$thang] + (int) $value['tongTien'];
                        }
                        foreach ($_SESSION['get']['PhieuNhapHang']['Data'] as $key => $value) {
                            $thang = (int) substr($value['ngayNhap'], strpos($value['ngayNhap'], '-') + 1, 2);
                            $nam = (int) substr($value['ngayNhap'], 0, 4);
                            $tienNhap[$nam][$thang] =  $tienNhap[$nam][$thang] + (int) $value['tongTien'];
                        }
                        $tongLuong = 0;
                        foreach ($_SESSION['get']['NhanVien']['Data'] as $key => $value) {
                            $tongLuong += $value['luong'];
                        }
                        for ($i = 2015; $i <= $date; $i++) {
                            $tongThu[$i] = [];
                            for ($j = 1; $j <= 12; $j++) {
                                $tongThu[$i][$j] = $doanhThu[$i][$j] - $tienNhap[$i][$j] - $tongLuong;
                                // Random số
                                // $tongThu[$i][$j] = rand(500000, 3000000);
                            }
                        }

                        $max = max($tongThu[$date]);
                        $thangMax = array_keys($tongThu[$date], $max)[0];
                        foreach ($tongThu[$date] as $thang => $tien) {
                            $percent = 0;
                            if ($thang == $thangMax) {
                                $max = $max > 0 ? $max : 0;
                                $formated = number_format($max);
                                echo "
                                    <div class='chart-column'>
                                        <div class='chart-layout__item thang-$thangMax' style='--percent: 100%'><p>$formated</p></div>
                                        <span>$thangMax</span>
                                    </div>";
                            }
                            if ($thang != 0 && $thang != $thangMax) {
                                if ($tien < 0 || $max < 0) {
                                    $tien = 0;
                                }
                                $formated = number_format($tien);
                                if ($tien > 0 && $max > 0) {
                                    $percent = bcdiv($tien, $max, 2) * 100;
                                }
                                echo "
                                    <div class='chart-column'>
                                        <div class='chart-layout__item thang-$thang' style='--percent: $percent%'><p>$formated</p></div>
                                        <span>$thang</span>
                                    </div>";
                            }
                        }

                        $tong = 0;
                        foreach ($tongThu[$date] as $thang => $tien) {
                            $tong += $tien;
                        }
                        $_SESSION['tongThuNhap'] = number_format($tong);
                        ?>
                    </div>
                    <div class="chart-info">
                        <p>Năm:
                            <select name="" id="tongthu-chart" onchange="changeYear(this)">
                                <?php
                                $year = date('Y');
                                for ($i = $year; $i >= 2015; $i--) {
                                    if ($i == $year) {
                                        echo "<option value=$i selected>$i</option>";
                                    } else {
                                        echo "<option value=$i>$i</option>";
                                    }
                                }
                                ?>
                            </select>
                        </p>
                        <p>Đơn vị tính: <span><?php echo $_SESSION['get']['SanPham']['Data'][0]['donViTinh'] ?></span></p>
                        <p>Tổng: <span class="summary-tongthu"><?php echo $_SESSION['tongThuNhap'] ?></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 doanhthu hidden">
            <div class="content-row">
                <div class="chart-head">Tiền thu được từ hóa đơn</div>
                <div class="chart">
                    <div class="chart-layout">
                        <?php
                        $doanhThu = [];
                        $date = date("Y");
                        for ($i = 2015; $i <= $date; $i++) {
                            $doanhThu[$i] = [];
                            for ($j = 0; $j <= 12; $j++) {
                                array_push($doanhThu[$i], 0);
                            }
                        }
                        foreach ($_SESSION['get']['HoaDon']['Data'] as $key => $value) {
                            $thang = (int) substr($value['ngayLapHoaDon'], strpos($value['ngayLapHoaDon'], '-') + 1, 2);
                            $nam = (int) substr($value['ngayLapHoaDon'], 0, 4);
                            $doanhThu[$nam][$thang] =  $doanhThu[$nam][$thang] + (int) $value['tongTien'];
                        }

                        $max = max($doanhThu[$date]);
                        $thangMax = array_keys($doanhThu[$date], $max)[0];
                        foreach ($doanhThu[$date] as $thang => $tien) {
                            $percent = 0;
                            if ($thang != 0 && $thang != $thangMax) {
                                if ($tien < 0 || $max < 0) {
                                    $tien = 0;
                                }
                                $formated = number_format($tien);
                                if ($tien > 0 && $max > 0) {
                                    $percent = bcdiv($tien, $max, 2) * 100;
                                }
                                echo "
                                    <div class='chart-column'>
                                        <div class='chart-layout__item thang-$thang' style='--percent: $percent%'><p>$formated</p></div>
                                        <span>$thang</span>
                                    </div>";
                            }
                            if ($thang == $thangMax) {
                                $formated = 0;
                                if ($max > 0) {
                                    $formated = number_format($max);
                                    $percent = 100;
                                }
                                echo "
                            <div class='chart-column'>
                                <div class='chart-layout__item thang-$thangMax' style='--percent: $percent%'><p>$formated</p></div>
                                <span>$thangMax</span>
                            </div>";
                            }
                        }

                        $tong = 0;
                        foreach ($doanhThu[$date] as $thang => $tien) {
                            $tong += $tien;
                        }
                        $_SESSION['tongDoanhThu'] = number_format($tong);
                        ?>
                    </div>
                    <div class="chart-info">
                        <p>Năm:
                            <select name="" id="doanhthu-chart" onchange="changeYear(this)">
                                <?php
                                $year = date('Y');
                                for ($i = $year; $i >= 2015; $i--) {
                                    if ($i == $year) {
                                        echo "<option value=$i selected>$i</option>";
                                    } else {
                                        echo "<option value=$i>$i</option>";
                                    }
                                }
                                ?>
                            </select>
                        </p>
                        <p>Đơn vị tính: <span><?php echo $_SESSION['get']['SanPham']['Data'][0]['donViTinh'] ?></span></p>
                        <p>Tổng: <span class="summary-doanhthu"><?php echo $_SESSION['tongDoanhThu'] ?></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 taikhoan-report hidden">
            <div class="content-row">
                <div class="chart-head">Khách hàng mới</div>
                <div class="chart">
                    <div class="chart-layout">
                        <?php
                        $taiKhoanTaoHangThang = [];
                        $date = date("Y");
                        for ($i = 2015; $i <= $date; $i++) {
                            $taiKhoanTaoHangThang[$i] = [];
                            for ($j = 0; $j <= 12; $j++) {
                                array_push($taiKhoanTaoHangThang[$i], 0);
                            }
                        }

                        foreach ($_SESSION['get']['TaiKhoan']['Data'] as $key => $value) {
                            $thang = (int) substr($value['thoiGianTao'], strpos($value['thoiGianTao'], '-') + 1, 2);
                            $nam = (int) substr($value['thoiGianTao'], 0, 4);
                            if ($value['maQuyen'] == 3) {
                                $taiKhoanTaoHangThang[$nam][$thang]++;
                            }
                        }

                        // Random số
                        // foreach ($taiKhoanTaoHangThang[$date] as $thang => $soLuong) {
                        //     $taiKhoanTaoHangThang[$nam][$thang] = rand(1, 50);
                        // }

                        $max = max($taiKhoanTaoHangThang[$date]);
                        $thangMax = array_keys($taiKhoanTaoHangThang[$date], $max)[0];
                        foreach ($taiKhoanTaoHangThang[$date] as $thang => $soLuong) {
                            $percent = 0;
                            if ($thang != 0 && $thang != $thangMax) {
                                if ($soLuong > 0 && $max > 0) {
                                    $percent = bcdiv($soLuong, $max, 2) * 100;
                                }
                                echo "
                                    <div class='chart-column'>
                                        <div class='chart-layout__item thang-$thang' style='--percent: $percent%'><p>$soLuong</p></div>
                                        <span>$thang</span>
                                    </div>";
                            }
                            if ($thang == $thangMax) {
                                if ($max > 0) {
                                    $percent = 100;
                                }
                                echo "
                            <div class='chart-column'>
                                <div class='chart-layout__item thang-$thangMax' style='--percent: $percent%'><p>$max</p></div>
                                <span>$thangMax</span>
                            </div>";
                            }
                        }

                        $tong = 0;
                        foreach ($taiKhoanTaoHangThang[$date] as $thang => $tien) {
                            $tong += $tien;
                        }
                        $_SESSION['tongTaiKhoan'] = number_format($tong);
                        ?>
                    </div>
                    <div class="chart-info">
                        <p>Năm:
                            <select name="" id="taikhoan-report-chart" onchange="changeYear(this)">
                                <?php
                                $year = date('Y');
                                for ($i = $year; $i >= 2015; $i--) {
                                    if ($i == $year) {
                                        echo "<option value=$i selected>$i</option>";
                                    } else {
                                        echo "<option value=$i>$i</option>";
                                    }
                                }
                                ?>
                            </select>
                        </p>
                        <p>Đơn vị tính: <span>khách</span></p>
                        <p>Tổng: <span class="summary-taikhoan-report"><?php echo $_SESSION['tongTaiKhoan'] ?></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 sanphamban ">
            <div class="content-row" style="overflow: hidden;">
                <div class="chart-head">Số sản phẩm bán ra</div>
                <div class="asd" style="display: flex;justify-content: flex-end;align-items: flex-end;padding: 0 50px 20px 20px">
                    <!-- <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" id="sanphamban-search-input" name="search" placeholder="Search" oninput="thongKeSanPhamSearch(this)">
                        <select name="item-search" id="sanphamban-search-select">
                            <?php
                            // $SanPham = [
                            //     [
                            //         'value' => 'tenSP',
                            //         'display' => 'Tên bánh'
                            //     ],
                            //     [
                            //         'value' => 'maSP',
                            //         'display' => 'Mã sản phẩm'
                            //     ],
                            // ];
                            // foreach ($SanPham as $key => $value) {
                            //     echo '<option value="' . $value['value'] . '">' . $value['display'] . '</option>';
                            // }
                            ?>
                        </select>
                    </div> -->
                    <span>Năm:
                        <select name="" id="sanphamban-nam-select" onchange="changeYear(this)">
                            <?php
                            $year = date('Y');
                            for ($i = $year; $i >= 2015; $i--) {
                                if ($i == $year) {
                                    echo "<option value=$i selected>$i</option>";
                                } else {
                                    echo "<option value=$i>$i</option>";
                                }
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <div class="title--border">
                    <div class="sanphamban__title row">
                        <h6 class="center sanphamban-item-title col-1">Mã SP</h6>
                        <h6 class="center sanphamban-item-title col-3">Tên sản phẩm</h6>
                        <div class="col-8 row">
                            <h6 class="center sanphamban-item-title col-1">Th1</h6>
                            <h6 class="center sanphamban-item-title col-1">Th2</h6>
                            <h6 class="center sanphamban-item-title col-1">Th3</h6>
                            <h6 class="center sanphamban-item-title col-1">Th4</h6>
                            <h6 class="center sanphamban-item-title col-1">Th5</h6>
                            <h6 class="center sanphamban-item-title col-1">Th6</h6>
                            <h6 class="center sanphamban-item-title col-1">Th7</h6>
                            <h6 class="center sanphamban-item-title col-1">Th8</h6>
                            <h6 class="center sanphamban-item-title col-1">Th9</h6>
                            <h6 class="center sanphamban-item-title col-1">Th10</h6>
                            <h6 class="center sanphamban-item-title col-1">Th11</h6>
                            <h6 class="center sanphamban-item-title col-1">Th12</h6>
                        </div>
                    </div>
                </div>
                <div class="sanphamban--show row">
                    <?php
                    $SanPham = $_SESSION['get']['SanPham']['Data'];
                    $HoaDon = $_SESSION['get']['HoaDon']['Data'];
                    $ChiTietHoaDon = $_SESSION['get']['chiTietHoaDon']['Data'];

                    // Khoi tao mang
                    $SoSanPham = [];
                    $crYear = date("Y");
                    for ($i = 2015; $i <= $crYear; $i++) {
                        $SoSanPham[$i] = [];
                        $length = count($SanPham);
                        for ($j = 0; $j <= $length; $j++) {
                            array_push($SoSanPham[$i], 0);
                            $SoSanPham[$i][$j] = [];
                            for ($k = 0; $k <= 12; $k++) {
                                array_push($SoSanPham[$i][$j], 0);
                            }
                            unset($SoSanPham[$i][$j][0]);
                        }
                        unset($SoSanPham[$i][0]);
                    }

                    // Tinh toan so luong
                    foreach ($HoaDon as $key => $hd) {
                        $thang = (int) substr($hd['ngayLapHoaDon'], strpos($hd['ngayLapHoaDon'], '-') + 1, 2);
                        $nam = (int) substr($hd['ngayLapHoaDon'], 0, 4);
                        foreach ($SanPham as $key => $sp) {
                            foreach ($ChiTietHoaDon as $key => $cthd) {
                                if ($cthd['maHD'] == $hd['maHD'] && $cthd['maSP'] == $sp['maSP']) {
                                    $SoSanPham[$nam][$sp['maSP']][$thang] += (int) $cthd['soLuong'];
                                }
                            }
                        }
                    }

                    $length = count($SanPham);
                    for ($i = 0; $i < $length; $i++) {
                        $style = $i % 2 == 1 ? 'style="background: #eaeaea;' : 'style="';
                        echo "
                            <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style\">" . $SanPham[$i]["maSP"] . "</span>
                            <span class='center-left col-3 row-" . $SanPham[$i]["maSP"] . "' $style\">" . $SanPham[$i]["tenSP"] . "</span>
                            <div class='col-8 row'>
                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][1] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][1] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][2] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][2] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][3] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][3] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][4] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][4] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][5] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][5] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][6] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][6] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][7] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][7] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][8] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][8] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][9] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][9] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][10] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][10] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][11] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][11] . "</span>

                                <span class='center col-1 row-" . $SanPham[$i]["maSP"] . "' $style";
                        echo $SoSanPham[$crYear][$i + 1][12] == 0 ? 'color: #c0c0c0' : '';
                        echo "\">" . $SoSanPham[$crYear][$i + 1][12] . "</span>
                            </div>
                        ";
                    }
                    ?>
                </div>
                <!-- <div class="content-item__pagination row">
                    <div>
                        <ul class="text-center center paginate">
                            <?php
                            // if (isset($_SESSION['get']['SanPham'])) {
                            //     $length = $_SESSION['get']['SanPham']['Data']['pages'];
                            //     for ($i = 1; $i <= $length; $i++) {
                            //         if ($i == 1)
                            //             echo '<li onclick="paginate(this)" class="sanphamban-' . $i . ' current-page">' . $i . '</li>';
                            //         else
                            //             echo '<li onclick="paginate(this)" class="sanphamban-' . $i . '">' . $i . '</li>';
                            //     }
                            // }
                            ?>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
        <div style="margin: 40px;"></div>
    </div>
</div>

<script src="/Web2/admin/public/scripts/Admin.js"></script>
<script src="/Web2/admin/public/scripts/ThongKeAdmin.js"></script>
<script>
    function changeYear(ele) {
        ajaxChangeYear(ele)
    }

    function changeReport(ele) {
        ajaxChangeReport(ele)

    }

    let timer = 0;

    function thongKeSanPhamSearch(ele) {
        if (timer) {
            clearTimeout(timer);
        }
        timer = setTimeout(() => {
            find(ele.value, 'sanpham')
        }, 300);
    }
</script>