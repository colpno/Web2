    <link rel="stylesheet" href="/Web2/public/css/admin/Admin.css">

    <?php
    if (isset($_GET['uri'])) {
        $splitUri = explode('/',  $_GET['uri']);
        if (isset($splitUri[1])) {
            $change = strtolower($splitUri[1]);
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
        <a href="/Web2/admin/sanpham" class="brand">
            <img src="/Web2/public/images/TaiKhoan/TK-1.jpg" alt="logo">
            <h1>Nhãn</h1>
        </a>
        <ul class="sidebar-menu__list">
            <a href="sanpham" class="sidebar-menu__item sanpham">
                <i class="fas fa-box-open"></i>
                <li>Sản phẩm</li>
            </a>
            <a href="nhapxuat" class="sidebar-menu__item nhapxuat">
                <i class="fas fa-truck-moving"></i>
                <li>Nhập xuất</li>
            </a>
            <a href="taikhoan" class="sidebar-menu__item taikhoan">
                <i class="far fa-user-circle"></i>
                <li>Tài khoản</li>
            </a>
            <a href="doitac" class="sidebar-menu__item doitac">
                <i class="far fa-handshake"></i>
                <li>Đối tác</li>
            </a>
            <a href="thongke" class="sidebar-menu__item thongke">
                <i class="far fa-chart-bar"></i>
                <li>Thống kê</li>
            </a>
        </ul>
    </nav>
    <div class="main-content">
        <header>
            <label for="sidebar--toggle">
                <i class="fas fa-bars"></i>
                Menu
            </label>

            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchSanPham" name="search" placeholder="Search" oninput="onInput()">
                <select name="item-search" id="itemSearch">
                    <?php
                    $SanPham = [
                        [
                            'value' => 'sanpham',
                            'display' => 'Sản phẩm'
                        ],
                        [
                            'value' => 'loai',
                            'display' => 'Loại'
                        ],
                        [
                            'value' => 'khuyenmai',
                            'display' => 'Khuyễn mãi'
                        ],
                    ];
                    $TaiKhoan = [
                        [
                            'value' => 'taikhoan',
                            'display' => 'Tài khoản'
                        ],
                        [
                            'value' => 'nhanvien',
                            'display' => 'Nhân viên'
                        ],
                        [
                            'value' => 'khachhang',
                            'display' => 'Khách hàng'
                        ]
                    ];
                    $DoiTac = [
                        [
                            'value' => 'nhacungcap',
                            'display' => 'Nhà cung cấp'
                        ],
                        [
                            'value' => 'nhasanxuat',
                            'display' => 'Nhà sản xuất'
                        ],
                    ];
                    $uri = isset($_GET['uri']) ? $_GET['uri'] : '';
                    $splitUri = explode('/', $uri);

                    switch ($splitUri[1]) {
                        case 'sanpham':
                        case 'SanPham': {
                                foreach ($SanPham as $key => $value) {
                                    echo '<option value="' . $value['value'] . '">' . $value['display'] . '</option>';
                                }
                                break;
                            }
                        case 'nhapxuat':
                        case 'NhapXuat': {
                                echo '<script>$(".search-wrapper").remove()</script>';
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
                    }
                    ?>
                </select>
            </div>

            <div class="user-wrapper">
                <img src="/Web2/public/images/TaiKhoan/TK-1.jpg" alt="user-image">
                <div class="user-info">
                    <span class="username">Họ và tên</span>
                    <span class="user-rank">Vai trò</span>
                </div>
            </div>
        </header>
        <main>
            <?php
            $uri = isset($_GET['uri']) ? $_GET['uri'] : "";
            $splitUri = explode("/", $uri);
            switch ($splitUri[1]) {
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
            }
            ?>
        </main>
    </div>

    <script src="/Web2/public/scripts/Admin.js"></script>
    <script>
        function onInput() {
            const search = $('#searchSanPham').val();
            const table = $('#itemSearch').val();
            find(search, table)
        }
    </script>