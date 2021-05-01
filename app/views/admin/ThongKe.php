<link rel="stylesheet" href="/Web2/public/css/admin/ThongKeAdmin.css">

<div class="thongke container">
    <div class="content--show row">
        <div class="col-12">
            <div class="doanhThu content-row">
                <div class="chart-layout__header"></div>
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
                        $doanhThu[$nam][$thang] = (int) $doanhThu[$nam][$thang] + (int) $value['tongTien'];
                    }

                    $max = max($doanhThu[$date]);
                    $thangMax = array_keys($doanhThu[$date], $max)[0];
                    $formated = number_format($max);
                    echo "<div class='chart-layout__item thang-$thangMax' style='--percent: 100%'>$formated</div>";
                    foreach ($doanhThu[$date] as $thang => $tien) {
                        if ($thang != 0 && $thang != $thangMax) {
                            $percent = bcdiv($tien, $max, 2) * 100;
                            $formated = number_format($tien);
                            echo "<div class='chart-layout__item thang-$thang' style='--percent: $percent%'>$formated</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/Web2/public/scripts/ThongKeAdmin.js"></script>