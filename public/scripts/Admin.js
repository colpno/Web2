$(document).ready(function () {});

function ajaxCheckAll(element) {
    const clas = element.getAttribute('class');
    const str = clas.substr(0, clas.indexOf('_'));
    const checkboxes = document.querySelectorAll(`.${str}__checkbox`);

    if (element.checked) {
        checkboxes.forEach((element) => {
            element.checked = true;
        });
    } else {
        checkboxes.forEach((element) => {
            element.checked = false;
        });
    }
}

function find(search, table) {
    const url = window.location.href;
    const uri = url.substring(0, url.indexOf('?'));
    const params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';
    let htmls = '',
        action = 'find';

    $.ajax({
        url: uri + 'app/index.php' + params,
        type: 'post',
        data: {
            search,
            table,
            action: 'find',
        },
        success: function (data) {
            if (isJson(data)) {
                const parsed = JSON.parse(data);
                switch (table) {
                    case 'sanpham': {
                        const SPFound = parsed.data;
                        for (let i = 0; i < SPFound.length; i++) {
                            htmls += `
                                    <div class="center checkbox col-lg-1 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${SPFound[i].maSP}" ></input>
                                    </div>
                                    <div class="center col-lg-2 col-md-2 col-sm-12">
                                        <img src="${SPFound[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                                    </div>
                                    <span class="center-left col-lg-3 col-md-4 col-sm-12">${SPFound[i].tenSP}</span>
                                    <span class="center-right col-lg-2 col-md-1 col-sm-12">${SPFound[i].donGia} ${SPFound[i].donViTinh}</span>
                                    <span class="center col-lg-2 col-md-2 col-sm-12">${SPFound[i].soLuong}</span>
                                    <div class="center col-lg-2 col-md-3 col-sm-12">
                                        <button class="btn " onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn " onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                        }
                        $('.product--show').html(htmls);
                        break;
                    }
                    case 'loai': {
                        const LSPFound = parsed.data;
                        for (let i = 0; i < LSPFound.length; i++) {
                            htmls += `
                                    <div class="center checkbox col-lg-2 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${LSPFound[i].maLoai}"></input>
                                    </div>
                                    <span class="center-left col-lg-6 col-md-4 col-sm-12">${LSPFound[i].tenLoai}</span>
                                    <div class="center cake__cmd col-lg-4 col-md-3 col-sm-12">
                                        <button class="btn cake__update" onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn cake__delete" onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                        }
                        $('.category--show').html(htmls);
                        break;
                    }
                    case 'khuyenmai': {
                        const KMFound = parsed.data;
                        for (let i = 0; i < KMFound.length; i++) {
                            htmls += `
                                    <div class="center checkbox col-lg-1 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${KMFound[i].maKM}"></input>
                                    </div>
                                    <span class="center-left col-lg-5 col-md-4 col-sm-12">${KMFound[i].tenKM}</span>
                                    <span class="center col-lg-2 col-md-4 col-sm-12">${KMFound[i].ngayBatDau}</span>
                                    <span class="center col-lg-2 col-md-4 col-sm-12">${KMFound[i].ngayKetThuc}</span>
                                    <div class="center cake__cmd col-lg-2 col-md-3 col-sm-12">
                                        <button class="btn cake__update" onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn cake__delete" onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                        }
                        $('.promotion--show').html(htmls);
                        break;
                    }
                }
            }
        },
        error: function (err) {
            alert(err);
        },
    });
}

function sanPhamHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
                    <div class="center checkbox col-lg-1 col-md-12 col-sm-12">
                        <input type="checkbox" class="sanpham__checkbox" value="${list[i].maSP}" ></input>
                    </div>
                    <div class="center col-lg-2 col-md-2 col-sm-12">
                        <img src="${list[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                    </div>
                    <span class="hidden row-${list[i].maSP} maLoai">${list[i].loaiSanPham.maLoai}</span>
                    <span class="hidden row-${list[i].maSP} maaNSX">${list[i].nhaSanXuat.maNSX}</span>
                    <span class="center-left col-lg-3 col-md-4 col-sm-12 row-${list[i].maSP} tenSP">${list[i].tenSP}</span>
                    <span class="center-right col-lg-2 col-md-1 col-sm-12 row-${list[i].maSP} donGia">${list[i].donGia} ${list[i].donViTinh}</span>
                    <span class="center col-lg-2 col-md-2 col-sm-12 row-${list[i].maSP} soLuong">${list[i].soLuong}</span>
                    <div class="center col-lg-2 col-md-3 col-sm-12">
                        <a href="#sua-sanpham" class="btn " onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                        <button class="btn " onclick="delOneete(this)"><i class="far fa-trash-alt"></i></button>
                    </div>
                `;
    }
    return htmls;
}

function loaiHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                <input type="checkbox" class="loai__checkbox" value="${list[i].maLoai}"></input>
            </div>
            <span class="center-left col-lg-6 col-md-4 col-sm-12 row-${list[i].maLoai} tenLoai">${list[i].tenLoai}</span>
            <div class="center cake__cmd col-lg-4 col-md-3 col-sm-12">
                <a href="#sua-loai" class="loai-${list[i].maLoai} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="loai-${list[i].maLoai} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function khuyenMaiHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                <input type="checkbox" class="khuyenmai__checkbox" value="${list[i].maKM}"></input>
            </div>
            <span class="center-left col-lg-5 col-md-4 col-sm-12 row-${list[i].maKM} tenKM">${list[i].tenKM}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12 row-${list[i].maKM} ngayBatDau">${list[i].ngayBatDau}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12 row-${list[i].maKM} ngayKetThuc">${list[i].ngayKetThuc}</span>
            <div class="center cake__cmd col-lg-2 col-md-3 col-sm-12">
                <a href="#sua-khuyenmai" class="khuyenmai-${list[i].maKM} btn " onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="khuyenmai-${list[i].maKM} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                <button class="khuyenmai-${list[i].maKM} btn" onclick="openDetail(this)"><i class="fas fa-arrow-circle-right"></i></button>
            </div>
        `;
    }
    return htmls;
}

function chiTietKhuyenMaiHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                <input type="checkbox" class="chitietkhuyenmai__checkbox" value="${list[i].maSP}"></input>
            </div>
            <span class="hidden row-${list[i].maKM} maKM">${list[i].maKM}</span>
            <span class="hidden row-${list[i].maSP} maSP">${list[i].maSP}</span>
            <span class="center-left col-lg-6 col-md-4 col-sm-12 row-${list[i].maSP} hinhThucKhuyenMai">${list[i].hinhThucKhuyenMai}</span>
            <span class="center col-lg-1 col-md-4 col-sm-12 row-${list[i].maSP} phanTramKhuyenMai">${list[i].phanTramKhuyenMai}</span>
            <div class="center cake__cmd col-lg-3 col-md-3 col-sm-12">
                <a href="#sua-chitietkhuyenmai" class="chitietkhuyenmai-${list[i].maSP} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="chitietkhuyenmai-${list[i].maSP} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function phieuNhapHangHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                <input type="checkbox" class="phieunhaphang__checkbox" value="${list[i].maPhieu}"></input>
            </div>
            <span class="center-left col-lg-3 col-md-3 col-sm-12 row-${list[i].maPhieu} tenNCC">${list[i].nhaCungCap.tenNCC}</span>
            <span class="center-left col-lg-2 col-md-3 col-sm-12 row-${list[i].maPhieu} ho">${list[i].nhanVien.ho} ${list[i].nhanVien.ten}</span>
            <span class="hidden row-${list[i].maPhieu} ten">${list[i].nhanVien.ten}</span>
            <span class="center col-lg-2 col-md-2 col-sm-12 row-${list[i].maPhieu} ngayNhap">${list[i].ngayNhap}</span>
            <span class="center col-lg-2 col-md-2 col-sm-12 row-${list[i].maPhieu} tongTien">${list[i].tongTien}</span>
            <div class="center col-lg-2 col-md-3 col-sm-12">
                <a href="#sua-phieunhaphang" class="phieunhaphang-${list[i].maPhieu} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="phieunhaphang-${list[i].maPhieu} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                <button class="phieunhaphang-${list[i].maPhieu} btn" onclick="openDetail(this)"><i class="fas fa-arrow-circle-right"></i></button>
            </div>
        `;
    }
    return htmls;
}

function chiTietPhieuNhapHangHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                <input type="checkbox" class="chitietphieunhaphang__checkbox" value="${list[i].sanPham.maSP}"></input>
            </div>
            <span class="hidden row-${list[i].sanPham.maSP} maPhieu">${list[i].maPhieu}</span>
            <span class="hidden row-${list[i].sanPham.maSP} maSP">${list[i].sanPham.maSP}</span>
            <span class="center-left col-lg-3 col-md-3 col-sm-12">${list[i].sanPham.tenSP}</span>
            <span class="center col-lg-1 col-md-1 col-sm-12 row-${list[i].sanPham.maSP} soLuong">${list[i].soLuong}</span>
            <span class="center col-lg-2 col-md-2 col-sm-12 row-${list[i].sanPham.maSP} donGiaGoc">${list[i].donGiaGoc}</span>
            <span class="center col-lg-2 col-md-2 col-sm-12 row-${list[i].sanPham.maSP} thanhTien">${list[i].thanhTien}</span>
            <div class="center col-lg-2 col-md-3 col-sm-12">
                <a href="#sua-chitietphieunhaphang" class="chitietphieunhaphang-${list[i].sanPham.maSP} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="chitietphieunhaphang-${list[i].sanPham.maSP} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function hoaDonHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                <input type="checkbox" class="hoadon__checkbox" value="${list[i].maHD}"></input>
            </div>
            <span class="center-left col-lg-3 col-md-4 col-sm-12">${list[i].nhanVien.ho} ${list[i].nhanVien.ten}</span>
            <span class="hidden row-${list[i].maHD} maNV">${list[i].nhanVien.maNV}</span>
            <span class="center-left col-lg-2 col-md-4 col-sm-12">${list[i].khachHang.ho} ${list[i].khachHang.ten}</span>
            <span class="hidden row-${list[i].maHD} maKH">${list[i].khachHang.maKM}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12 row-${list[i].maHD} ngayLapHoaDon">${list[i].ngayLapHoaDon}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12 row-${list[i].maHD} tongTien">${list[i].tongTien}</span>
            <div class="center col-lg-2 col-md-3 col-sm-12">
                <a href="#sua-hoadon" class="hoadon-${list[i].maHD} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="hoadon-${list[i].maHD} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                <button class="hoadon-${list[i].maHD} btn" onclick="openDetail(this)"><i class="fas fa-arrow-circle-right"></i></button>
            </div>
        `;
    }
    return htmls;
}

function chiTietHoaDonHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                <input type="checkbox" class="chitiethoadon__checkbox" value="${list[i].sanPham.maSP}"></input>
            </div>
            <span class="hidden row-${list[i].sanPham.maSP} maHD">${list[i].maHD}</span>
            <span class="hidden row-${list[i].sanPham.maSP} maSP">${list[i].sanPham.maSP}</span>
            <span class="center-left col-lg-3 col-md-3 col-sm-12">${list[i].sanPham.tenSP}</span>
            <span class="center col-lg-1 col-md-3 col-sm-12 row-${list[i].sanPham.maSP} soLuong">${list[i].soLuong}</span>
            <span class="center col-lg-2 col-md-2 col-sm-12 row-${list[i].sanPham.maSP} donGia">${list[i].donGia}</span>
            <span class="center col-lg-2 col-md-2 col-sm-12 row-${list[i].sanPham.maSP} thanhTien">${list[i].thanhTien}</span>
            <div class="center col-lg-2 col-md-3 col-sm-12">
                <a href="#sua-chitiethoadon" class="chitiethoadon-${list[i].sanPham.maSP} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="chitiethoadon-${list[i].sanPham.maSP} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function taiKhoanHTML(list) {
    let htmls = '';
    const length = list.length;

    for (let i = 0; i < length; i++) {
        htmls += `
            <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                <input type="checkbox" class="taikhoan__checkbox" value="${list[i].maTK}"></input>
            </div>
            <span class="center-left col-lg-1 col-md-4 col-sm-12">${list[i].quyen.tenQuyen}</span>
            <span class="hidden row-${list[i].maTK} maQuyen">${list[i].quyen.maQuyen}</span>
            <span class="center-left col-lg-2 col-md-1 col-sm-12 row-${list[i].maTK} tenTaiKhoan">${list[i].tenTaiKhoan}</span>
            <span class="center-left col-lg-2 col-md-2 col-sm-12 row-${list[i].maTK} matKhau">${list[i].matKhau}</span>
            <div class="center col-lg-2 col-md-2 col-sm-12">
            <img class="row-${list[i].maTK} anhDaiDien" src="${list[i].anhDaiDien}"></img>
            </div>
            <span class="center col-lg-1 col-md-2 col-sm-12 row-${list[i].maTK} trangThai">${list[i].trangThai}</span>
            <span class="center col-lg-1 col-md-2 col-sm-12 row-${list[i].maTK} dangNhap">${list[i].dangNhap}</span>
            <span class="center-left col-lg-1 col-md-2 col-sm-12 row-${list[i].maTK} thoiGianTao">${list[i].thoiGianTao}</span>
            <div class="center col-lg-1 col-md-3 col-sm-12">
                <a href="#sua-taikhoan" class="taikhoan-${list[i].maTK} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="taikhoan-${list[i].maTK} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function nhanVienHTML(list) {
    let htmls = '';
    const length = list.length;

    for (let i = 0; i < length; i++) {
        htmls += `
            <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                <input type="checkbox" class="nhanvien__checkbox" value="${list[i].maNV}"></input>
            </div>
            <span class="center-left col-lg-1 col-md-4 col-sm-12">${list[i].taikhoan.tenTaiKhoan}</span>
            <span class="hidden row-${list[i].taikhoan.maTK} maTK">${list[i].taikhoan.maTK}</span>
            <span class="center-left col-lg-1 col-md-4 col-sm-12 row-${list[i].maNV} ho">${list[i].ho}</span>
            <span class="center-left col-lg-1 col-md-4 col-sm-12 row-${list[i].maNV} ten">${list[i].ten}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12 row-${list[i].maNV} ngaySinh">${list[i].ngaySinh}</span>
            <span class="center-left col-lg-3 col-md-4 col-sm-12 row-${list[i].maNV} diaChi">${list[i].diaChi}</span>
            <span class="center col-lg-1 col-md-4 col-sm-12 row-${list[i].maNV} soDienThoai">${list[i].soDienThoai}</span>
            <span class="center col-lg-1 col-md-4 col-sm-12 row-${list[i].maNV} luong">${list[i].luong}</span>
            <div class="center col-lg-1 col-md-3 col-sm-12">
                <a href="#sua-nhanvien" class="nhanvien-${list[i].maNV} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="nhanvien-${list[i].maNV} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function khachHangHTML(list) {
    let htmls = '';
    const length = list.length;

    for (let i = 0; i < length; i++) {
        htmls += `
            <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                <input type="checkbox" class="khachhang__checkbox" value="${list[i].maKH}"></input>
            </div>
            <span class="center-left col-lg-1 col-md-4 col-sm-12">${list[i].taikhoan.tenTaiKhoan}</span>
            <span class="hidden row-${list[i].taikhoan.maTK} maTK">${list[i].taikhoan.maTK}</span>
            <span class="center-left col-lg-1 col-md-4 col-sm-12 row-${list[i].maKH} ho">${list[i].ho}</span>
            <span class="center-left col-lg-1 col-md-4 col-sm-12 row-${list[i].maKH} ten">${list[i].ten}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12 row-${list[i].maKH} ngaySinh">${list[i].ngaySinh}</span>
            <span class="center-left col-lg-3 col-md-4 col-sm-12 row-${list[i].maKH} diaChi">${list[i].diaChi}</span>
            <span class="center col-lg-1 col-md-4 col-sm-12 row-${list[i].maKH} soDienThoai">${list[i].soDienThoai}</span>
            <div class="center col-lg-2 col-md-3 col-sm-12">
                <a href="#sua-khachhang" class="khachhang-${list[i].maKH} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="khachhang-${list[i].maKH} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function nhaCungCapHTML(list) {
    let htmls = '';
    const length = list.length;

    for (let i = 0; i < length; i++) {
        htmls += `
            <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                <input type="checkbox" class="nhacungcap__checkbox" value="${list[i].maNCC}"></input>
            </div>
            <span class="center-left col-lg-3 col-md-4 col-sm-12 row-${list[i].maNCC} tenNCC">${list[i].tenNCC}</span>
            <span class="center-left col-lg-4 col-md-1 col-sm-12 row-${list[i].maNCC} diaChi">${list[i].diaChi}</span>
            <span class="center col-lg-2 col-md-2 col-sm-12 row-${list[i].maNCC} soDienThoai">${list[i].soDienThoai}</span>
            <div class="center col-lg-2 col-md-3 col-sm-12">
                <a href="#sua-nhacungcap" class="nhacungcap-${list[i].maNCC} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="nhacungcap-${list[i].maNCC} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function nhaSanXuatHTML(list) {
    let htmls = '';
    const length = list.length;

    for (let i = 0; i < length; i++) {
        htmls += `
            <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                <input type="checkbox" class="nhasanxuat__checkbox" value="${list[i].maNSX}"></input>
            </div>
            <span class="center-left col-lg-3 col-md-4 col-sm-12 row-${list[i].maNSX} tenNSX">${list[i].tenNSX}</span>
            <span class="center-left col-lg-4 col-md-4 col-sm-12 row-${list[i].maNSX} diaChi">${list[i].diaChi}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12 row-${list[i].maNSX} soDienThoai">${list[i].soDienThoai}</span>
            <div class="center col-lg-2 col-md-3 col-sm-12">
                <a href="#sua-nhasanxuat" class="nhasanxuat-${list[i].maNSX} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="nhasanxuat-${list[i].maNSX} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}
