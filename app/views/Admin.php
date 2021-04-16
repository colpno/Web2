    <link rel="stylesheet" href="/Web2/public/css/admin/Admin.css">

    <?php
    if (isset($_GET['uri'])) {
        $splitUri = explode('/',  $_GET['uri']);
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

    <script>
        function onInput() {
            const search = $('#searchSanPham').val();
            const table = $('#itemSearch').val();
            const url = window.location.href;
            const params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';
            let htmls = '',
                action = 'find';

            $.ajax({
                url: '/Web2/app/index.php' + params,
                type: 'post',
                data: {
                    search,
                    table,
                    action: 'find',
                },
                success: function(data) {
                    const parsed = JSON.parse(data)[0];
                    switch (Object.keys(parsed)[0]) {
                        case 'SPFound': {
                            const SPFound = parsed.SPFound;
                            for (let i = 0; i < SPFound.length; i++) {
                                htmls += `
                                    <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${SPFound[i].maSP}" ></input>
                                    </div>
                                    <div class="center col-lg-2 col-md-2 col-sm-12">
                                        <img src="${SPFound[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                                    </div>
                                    <span class="center-left col-lg-3 col-md-4 col-sm-12">${SPFound[i].tenSP}</span>
                                    <span class="center col-lg-2 col-md-1 col-sm-12">${SPFound[i].donGia} ${SPFound[i].donViTinh}</span>
                                    <span class="center col-lg-2 col-md-2 col-sm-12">${SPFound[i].loaiSanPham.tenloai}</span>
                                    <div class="center col-lg-2 col-md-3 col-sm-12">
                                        <button class="btn " onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn " onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                            }
                            $('.product--show').html(htmls)
                            break;
                        }
                        case 'LSPFound': {
                            const LSPFound = parsed.LSPFound;
                            for (let i = 0; i < LSPFound.length; i++) {
                                htmls += `
                                    <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${LSPFound[i].maLoai}"></input>
                                    </div>
                                    <span class="center-left col-lg-6 col-md-4 col-sm-12">${LSPFound[i].tenLoai}</span>
                                    <div class="center cake__cmd col-lg-4 col-md-3 col-sm-12">
                                        <button class="btn cake__update" onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn cake__delete" onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                            }
                            $('.category--show').html(htmls)
                            break;
                        }
                        case 'KMFound': {
                            const KMFound = parsed.KMFound;
                            for (let i = 0; i < KMFound.length; i++) {
                                htmls += `
                                    <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${KhuyenMai[i].maKM}"></input>
                                    </div>
                                    <span class="center-left col-lg-5 col-md-4 col-sm-12">${KhuyenMai[i].tenKM}</span>
                                    <span class="center col-lg-2 col-md-4 col-sm-12">${KhuyenMai[i].ngayBatDau}</span>
                                    <span class="center col-lg-2 col-md-4 col-sm-12">${KhuyenMai[i].ngayKetThuc}</span>
                                    <div class="center cake__cmd col-lg-2 col-md-3 col-sm-12">
                                        <button class="btn cake__update" onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn cake__delete" onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                            }
                            $('.promotion--show').html(htmls)
                            break;
                        }
                    }
                },
                error: function(err) {
                    alert(err);
                },
            });
        }
    </script>