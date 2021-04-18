    <link rel="stylesheet" href="/Web2/public/css/admin/Admin.css">

    <?php
    if (isset($_GET['uri'])) {
        $splitUri = explode('/',  $_GET['uri']);
        if (isset($_GET['action'])) {
            $change = strtolower($_GET['action']);
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
    <!-- <nav class="sidebar-menu">
        <a class="brand">
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
    </nav> -->
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
                    <option value="sanpham">Sản phẩm</option>
                    <option value="loai">Loại</option>
                    <option value="khuyenmai">Khuyến mãi</option>
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
            <?php include_once 'admin/SanPham.php'; ?>
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