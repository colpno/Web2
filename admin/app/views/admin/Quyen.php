<link rel="stylesheet" href="/Web2/admin/public/css/admin/QuyenAdmin.css">

<div class="phanquyen container">
    <div class="content--show row">
        <div class="col-lg-6 col-sm-12">
            <div class="quyen__row content-row">
                <div class="content-item__header">
                    <span>Quyền</span>
                    <button class="quyen--add "><i class="fas fa-plus"></i></button>
                </div>
                <form class="hidden add-content quyen__add-content">
                    <input type="text" name="tenQuyen" placeholder="Tên quyenền">
                    <input type="submit" value="Thêm">
                </form>
                <div class="title--border">
                    <div class="quyen__title row">
                        <h6 class="center quyen-item-title col-10">Tên quyền</h6>
                        <h6 class="center quyen-item-title col-2">Thao tác</h6>
                    </div>
                </div>
                <div class="quyen--show row">
                    <?php
                    if (isset($_SESSION['get']['Quyen'])) {
                        $Quyen = $_SESSION['get']['Quyen']['data'];
                        $length = count($Quyen);

                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <span class="hidden maQuyen" name="maQuyen" value"' . $Quyen[$i]['maQuyen'] . '">' . $Quyen[$i]['maQuyen'] . '</span>
                                <span class="center-left col-10 tenQuyen">' . $Quyen[$i]['tenQuyen'] . '</span>
                                <div class="center col-2">
                                    <button class="quyen-' . $Quyen[$i]['maQuyen'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
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
                            if (isset($_SESSION['get']['Quyen'])) {
                                $length = $_SESSION['get']['Quyen']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="quyen-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="quyen-' . $i . '">' . $i . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="chucnang__row content-row">
                <div class="content-item__header">
                    <span>Chức năng</span>
                    <button class="chucnang--add "><i class="fas fa-plus"></i></button>
                </div>
                <form class="hidden add-content chucnang__add-content">
                    <input type="text" name="tenCN" placeholder="Tên chức năng">
                    <input type="submit" value="Thêm">
                </form>
                <div class="title--border">
                    <div class="chucnang__title row">
                        <h6 class="center chucnang-item-title col-10">Tên chức năng</h6>
                        <h6 class="center chucnang-item-title col-2">Thao tác</h6>
                    </div>
                </div>
                <div class="chucnang--show row">
                    <?php
                    if (isset($_SESSION['get']['ChucNang'])) {
                        $ChucNang = $_SESSION['get']['ChucNang']['data'];
                        $length = count($ChucNang);

                        for ($i = 0; $i < $length; $i++) {
                            echo '
                                <span class="center-left col-10 tenChucNang" name="tenChucNang">' . $ChucNang[$i]['tenCN'] . '</span>
                                <div class="center col-2">
                                    <button class="chucnang-' . $ChucNang[$i]['maCN'] . ' btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
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
                            if (isset($_SESSION['get']['ChucNang'])) {
                                $length = $_SESSION['get']['ChucNang']['pages'];
                                for ($i = 1; $i <= $length; $i++) {
                                    if ($i == 1)
                                        echo '<li onclick="paginate(this)" class="chucnang-' . $i . ' current-page">' . $i . '</li>';
                                    else
                                        echo '<li onclick="paginate(this)" class="chucnang-' . $i . '">' . $i . '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="phanquyen__row content-row">
                <div class="phanquyen-header">
                    <span>Phân quyền</span>
                </div>
                <form id="sua-phanquyenchucnang">
                    <?php
                    $k = 1;
                    foreach ($_SESSION['get']['Quyen']['data'] as $key => $value) {
                        $maQuyen = $value['maQuyen'];
                        $tenQuyen = $value['tenQuyen'];
                        echo '
                        <div class="section">
                        <div class="chonQuyen">
                            <div>
                                <input type="radio" value="' . $value['maQuyen'] . '" name="maQuyen" class="maQuyen-' . $k . '"" onclick=chonQuyen(this)>
                                <label for="radioQuyen">' . $value['tenQuyen'] . '</label>
                            </div>
                            <div class="checkAll hidden">
                                <input type="checkbox" class="' . $value['maQuyen'] . '" onclick=chonHetChucNang(this)>
                                <label>Check All</label>
                            </div>
                        </div>
                        <div class="hidden chonChucNang phanquyen-' . $k . ' ">
                    ';
                        foreach ($_SESSION['get']['ChucNang']['data'] as $key => $value) {
                            $maCN = $value['maCN'];
                            $tenCN = $value['tenCN'];

                            echo '<div>';

                            foreach ($_SESSION['get']['QuyenChucNang']['data'] as $key => $value) {

                                if ($maQuyen == $value['quyen']['maQuyen'] && $maCN == $value['chucNang']['maCN'] && $value['hienThi'] == 1) {
                                    echo '<input type="checkbox" checked value="' . $maCN . '" name="maCN"';
                                    break;
                                }

                                echo '<input type="checkbox" value="' . $maCN . '" name="maCN"';
                            }

                            echo '<label for="maCN">' . $tenCN . '</label>
                                </div>';
                        }
                        echo '</div></div>';
                        $k++;
                    }
                    ?>
                    <input type="submit" value="Sửa">
                </form>
            </div>
            <div class="chucnang__row">
            </div>
        </div>
        <div style="margin: 40px;"></div>
    </div>
</div>

<script src="/Web2/admin/public/scripts/Admin.js"></script>
<script src="/Web2/admin/public/scripts/QuyenAdmin.js"></script>
<script>
    function chonQuyen(ele) {
        $('.checkAll').addClass('hidden')
        ele.parentNode.parentNode.querySelector('.hidden').classList.remove('hidden')

        ajaxChonQuyen(ele)
    }

    function chonHetChucNang(ele) {
        const clas = ele.getAttribute('class'),
            checkboxes = $(`.phanquyen-${clas} input`);

        for (let i = 0; i < checkboxes.length; i++) {
            if (ele.checked == true) {
                checkboxes[i].checked = true;
            } else {
                checkboxes[i].checked = false;
            }
        }

    }

    function deleteOne(ele) {
        ajaxDeleteOne(ele)
    }
</script>