<link rel="stylesheet" href="/Web2/admin/public/css/admin/ThongKeAdmin.css">

<div class="thongke container">
    <div class="content--show row">
        <div class="col-12 chart-header">
            <div>
                <div class="chart-header__item">
                    <span><i class="far fa-chart-bar"></i>Thống kê</span>
                    <select name="" id="" onchange="changeReport(this)">
                        <option value="tongthu">Tổng thu</option>
                        <option value="doanhthu">Doanh thu</option>
                        <option value="taikhoan">Số lượng khách mới</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 tongthu">
            <div class="content-row">
                <div class="chart-head">Tổng thu</div>
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
                            }
                        }

                        $max = max($tongThu[$date]);
                        $thangMax = array_keys($tongThu[$date], $max)[0];
                        foreach ($tongThu[$date] as $thang => $tien) {
                            $percent = 0;
                            if ($thang != 0 && $thang != $thangMax) {
                                if ($tien < 0 || $max < 0) {
                                    $tien = 0;
                                    $max = 0;
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
                <div class="chart-head">Doanh thu</div>
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
                                    $max = 0;
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
        <div class="col-12 taikhoan hidden">
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
                        ?>
                    </div>
                    <div class="chart-info">
                        <p>Năm:
                            <select name="" id="taikhoan-chart" onchange="changeYear(this)">
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
                        <p>Tổng: <span class="summary-taikhoan"><?php echo $_SESSION['tongTaiKhoan'] ?></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin: 40px;"></div>
    </div>
</div>

<script src="/Web2/admin/public/scripts/ThongKeAdmin.js"></script>
<script>
    function changeYear(ele) {
        ajaxChangeYear(ele)
    }

    function changeReport(ele) {
        ajaxChangeReport(ele)
    }
</script>