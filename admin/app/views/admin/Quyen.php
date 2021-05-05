<link rel="stylesheet" href="/Web2/admin/public/css/admin/QuyenAdmin.css">

<div class="quyen container">
    <div class="content--show row">
        <div class="col-12">
            <div class="quyen__row content-row">
                <div class="content-item__header">
                    <span>Phân quyền</span>
                    <div>
                        <button class="quyen--add "><i class="fas fa-plus"> Quyền</i></button>
                        <button class="chucnang--add "><i class="fas fa-plus"> Chức năng</i></button>
                    </div>
                </div>
                <form class="hidden add-content quyen__add-content">
                    <input type="text" name="tenQuyen" placeholder="Tên quyền">
                    <input type="submit" value="Thêm">
                </form>
                <form class="hidden add-content chucnang__add-content">
                    <input type="text" name="tenCN" placeholder="Tên chức năng">
                    <input type="submit" value="Thêm">
                </form>
                <form id="sua-quyenchucnang">
                    <?php
                    $k = 1;
                    foreach ($_SESSION['get']['Quyen']['data'] as $key => $value) {
                        $maQuyen = $value['maQuyen'];
                        $tenQuyen = $value['tenQuyen'];
                        echo '
                        <div class="section">
                        <div class="chonQuyen">
                            <input type="radio" value="' . $value['maQuyen'] . '" name="maQuyen" class="maQuyen-' . $k . '"" onclick=chonQuyen(this)>
                            <label for="radioQuyen">' . $value['tenQuyen'] . '</label>
                        </div>
                        <div class="chonChucNang quyen-' . $k . ' ">
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

                                // if ($maQuyen == $value['quyen']['maQuyen'] && $maCN == $value['chucNang']['maCN'] && $value['hienThi'] == 0) {
                                //     echo '<input type="checkbox" value="' . $maCN . '" name="maCN"';
                                //     break;
                                // }

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
        ajaxChonQuyen(ele)
    }
</script>