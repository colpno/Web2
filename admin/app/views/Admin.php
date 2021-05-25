    <link rel="stylesheet" href="/Web2/admin/public/css/admin/Admin.css">

    <?php
    if (isset($_GET['uri'])) {
        $splitUri = explode('/',  $_GET['uri']);
        if (isset($splitUri[0])) {
            $change = strtolower($splitUri[0]);
            echo "
        <style>
            .sidebar-menu__item.$change {
                background-color: #fff;
            }
            .sidebar-menu__item.$change i,
            .sidebar-menu__item.$change li {
                color: var(--primary-color);
            }
            .sidebar-menu__item.$change li {
                font-weight: 400;
            }
        </style>
    ";
        }
    }
    ?>
    <input type="checkbox" class="hidden" id="sidebar--toggle">
    <nav class="sidebar-menu">
        <a href="sanpham" class="brand">
            <img src="/Web2/img/logo.png" alt="logo">
        </a>
        <ul class="sidebar-menu__list">
            <?php
            if (isset($_COOKIE['user']) && $_COOKIE['user'] == 'null') {
                echo "
            <script>
                window.location='http://localhost:8080/Web2';
            </script>
        ";
            }
            if (isset($_SESSION['user'])) {
                if (isset($_COOKIE['user'])) {
                    setcookie("user", '', time() - 60 * 60);
                    $_COOKIE['user'] = "";
                }
                setcookie("user", json_encode($_SESSION['user']), time() + 86400);
                $_COOKIE['user'] = json_encode($_SESSION['user']);
            }
            $userC = json_decode($_COOKIE['user'], true);


            foreach ($_SESSION['quyen']['QuyenChucNang']['data'] as $key => $value) {
                if ($value['quyen']['maQuyen'] == $userC['quyen'] && $value['hienThi'] == 1) {
                    $href = '';
                    $icon = '';
                    switch ($value['chucNang']['tenCN']) {
                        case 'Sản phẩm':
                            $href = 'sanpham';
                            $icon = 'fas fa-box-open';
                            break;
                        case 'Nhập xuất':
                            $href = 'nhapxuat';
                            $icon = 'fas fa-truck-moving';
                            break;
                        case 'Tài khoản':
                            $href = 'taikhoan';
                            $icon = 'far fa-user-circle';
                            break;
                        case 'Đối tác':
                            $href = 'doitac';
                            $icon = 'far fa-handshake';
                            break;
                        case 'Thống kê':
                            $href = 'thongke';
                            $icon = 'far fa-chart-bar';
                            break;
                        case 'Phân quyền':
                            $href = 'quyen';
                            $icon = 'fas fa-cog';
                            break;
                    }
                    echo '
            <a href="' . $href . '" class="sidebar-menu__item ' . $href . '">
                    <i class="' . $icon . '"></i>
                    <li>' . $value['chucNang']['tenCN'] . '</li>
                </a>
            ';
                }
            }
            ?>



            <!--  
            <a href="nhapxuat" class="sidebar-menu__item nhapxuat">
                <i class="fas fa-truck-moving"></i>
                <li>Nhập xuất</li>
            </a>
            <a href="taikhoan" class="sidebar-menu__item taikhoan">
                <i class=""></i>
                <li>Tài khoản</li>
            </a>
            <a href="doitac" class="sidebar-menu__item doitac">
                <i class=""></i>
                <li>Đối tác</li>
            </a>
            <a href="thongke" class="sidebar-menu__item thongke">
                <i class=""></i>
                <li>Thống kê</li>
            </a>
            <a href="quyen" class="sidebar-menu__item quyen">
                <i class=""></i>
                <li>Phân quyền</li>
            </a>-->
        </ul>
    </nav>
    <div class="main-content">
        <header>
            <label for="sidebar--toggle">
                <i class="fas fa-bars"></i>
                <span>Menu</span>
            </label>

            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchSanPham" name="search" placeholder="Search" oninput="onInput()">
                <select name="item-search" id="itemSearch">
                    <?php
                    $SanPham = [
                        [
                            'value' => 'sanpham',
                            'display' => 'Sản phẩm ( tên bánh )'
                        ],
                        [
                            'value' => 'loai',
                            'display' => 'Loại ( tên loại )'
                        ],
                    ];
                    $NhapXuat = [
                        [
                            'value' => 'phieunhaphang',
                            'display' => 'Phiếu nhập hàng ( tên nhân viên )'
                        ],
                        [
                            'value' => 'phieunhaphang',
                            'display' => 'Hóa đơn ( tên nhân viên )'
                        ],
                    ];
                    $TaiKhoan = [
                        [
                            'value' => 'taikhoan',
                            'display' => 'Tài khoản ( tài khoản )'
                        ],
                        [
                            'value' => 'nhanvien',
                            'display' => 'Nhân viên ( tên nhân viên )'
                        ],
                        [
                            'value' => 'khachhang',
                            'display' => 'Khách hàng ( tên khách hàng )'
                        ]
                    ];
                    $DoiTac = [
                        [
                            'value' => 'nhacungcap',
                            'display' => 'Nhà cung cấp ( tên nhà cung cấp )'
                        ],
                        [
                            'value' => 'nhasanxuat',
                            'display' => 'Nhà sản xuất ( tên nhà sản xuất )'
                        ],
                    ];
                    $uri = isset($_GET['uri']) ? $_GET['uri'] : '';
                    $splitUri = explode('/', $uri);

                    switch ($splitUri[0]) {
                        case 'sanpham':
                        case 'SanPham': {
                                foreach ($SanPham as $key => $value) {
                                    echo '<option value="' . $value['value'] . '">' . $value['display'] . '</option>';
                                }
                                break;
                            }
                        case 'nhapxuat':
                        case 'NhapXuat': {
                                foreach ($NhapXuat as $key => $value) {
                                    echo '<option value="' . $value['value'] . '">' . $value['display'] . '</option>';
                                }
                                break;
                            }
                        case 'taikhoan':
                        case 'TaiKhoan': {
                                foreach ($TaiKhoan as $key => $value) {
                                    echo '<option value="' . $value['value'] . '">' . $value['display'] . '</option>';
                                }
                                break;
                            }
                        case 'doitac':
                        case 'DoiTac': {
                                foreach ($DoiTac as $key => $value) {
                                    echo '<option value="' . $value['value'] . '">' . $value['display'] . '</option>';
                                }
                                break;
                            }
                        case 'thongke':
                        case 'ThongKe': {
                                echo '<script>$(".search-wrapper").remove()</script>';
                                break;
                            }
                        case 'quyen':
                        case 'Quyen': {
                                echo '<script>$(".search-wrapper").remove()</script>';
                                break;
                            }
                    }
                    ?>
                </select>
            </div>

            <div class="user-wrapper">
                <div class="user-console hidden">
                    <span onclick="quit()">Đăng xuất</span>
                </div>
                <img src="<?php echo $userC['anh'] ?>" alt="user-image" onclick="openUserConsole()">
                <div class="user-info">
                    <span class="username"><?php echo $userC['ho'] . " " . $userC['ten']; ?></span>
                    <span class="user-rank">
                        <?php
                        echo $userC['tenQuyen'];
                        ?>
                    </span>
                </div>
            </div>
        </header>
        <main>
            <?php
            $uri = isset($_GET['uri']) ? $_GET['uri'] : "";
            $splitUri = explode("/", $uri);
            switch ($splitUri[0]) {
                case 'sanpham':
                case 'SanPham': {
                        include_once 'admin/SanPham.php';
                        break;
                    }
                case 'nhapxuat':
                case 'NhapXuat': {
                        include_once 'admin/NhapXuat.php';
                        break;
                    }
                case 'taikhoan':
                case 'TaiKhoan': {
                        include_once 'admin/TaiKhoan.php';
                        break;
                    }
                case 'doitac':
                case 'DoiTac': {
                        include_once 'admin/DoiTac.php';
                        break;
                    }
                case 'thongke':
                case 'ThongKe': {
                        include_once 'admin/ThongKe.php';
                        break;
                    }
                case 'quyen':
                case 'Quyen': {
                        include_once 'admin/Quyen.php';
                        break;
                    }
            }
            ?>
        </main>
    </div>

    <script src="/Web2/admin/public/scripts/Admin.js"></script>
    <script>
        function onInput() {
            const search = $('#searchSanPham').val();
            const table = $('#itemSearch').val();
            find(search, table)
        }

        function quit() {
            <?php
            Session_destroy();
            ?>
            window.location = "http://localhost:8080/web2/";

        }

        function openUserConsole() {
            $('.user-console').toggleClass('hidden')
        }
    </script>