// $(document).ready(function () {});

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
    const uri = url.substring(url.indexOf('admin/'));
    const paramAction = uri.substring(uri.indexOf('/') + 1);
    const params = `?controller=admin&action=${paramAction}&search=${search}`;

    if (search.length > 0) {
        $.ajax({
            url: '/Web2/admin/app/index.php' + params,
            type: 'post',
            data: {
                search,
                table,
                action: 'find',
            },
            success: function (data) {
                if (isJson(data) && data != null) {
                    const json = JSON.parse(data);
                    $(`.${table}--show`).html(getHTML(table, json.data));

                    let page = `
                    <div>
                    </div>
                `;
                    $(`.${table}__row .content-item__pagination`).html(page);

                    if (table != 'loai') {
                        $(`.content--show`).prepend($(`.${table}__row`).parent());
                    }
                } else {
                    alert(data);
                }
            },
        });
    } else {
        location.reload();
    }
}

function sanPhamHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
                    <div class="center checkbox col-1">
                        <input type="checkbox" class="sanpham__checkbox" value="${list[i].maSP}" ></input>
                    </div>
                    <div class="center col-2">
                        <img src="${list[i].anhDaiDien}" class="anhDaiDien" onerror="this.removeAttribute('onError');this.setAttribute('src','/Web2/admin/public/images/no-img.png')"/>
                    </div>
                    <span class="hidden row-${list[i].maSP} maLoai">${list[i].loaiSanPham.maLoai}</span>
                    <span class="hidden row-${list[i].maSP} maNSX">${list[i].nhaSanXuat.maNSX}</span>
                    <span class="hidden row-${list[i].maSP} moTa">${list[i].moTa}</span>
                    <span class="center-left col-3 row-${list[i].maSP} tenSP">${list[i].tenSP}</span>
                    <span class="center-right col-2 row-${list[i].maSP} donGia">${list[i].donGia} ${list[i].donViTinh}</span>
                    <span class="center col-2 row-${list[i].maSP} soLuong">${list[i].soLuong}</span>
                    <div class="center col-2">
                        <a href="#sua-sanpham" class="sanpham-${list[i].maSP} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                        <button class="btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                    </div>
                `;
    }
    return htmls;
}

function loaiHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-2">
                <input type="checkbox" class="loai__checkbox" value="${list[i].maLoai}"></input>
            </div>
            <span class="center-left col-6 row-${list[i].maLoai} tenLoai">${list[i].tenLoai}</span>
            <div class="center cake__cmd col-4">
                <a href="#sua-loai" class="loai-${list[i].maLoai} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="loai-${list[i].maLoai} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function phieuNhapHangHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-1">
                <input type="checkbox" class="phieunhaphang__checkbox" value="${list[i].maPhieu}"></input>
            </div>
            <span class="hidden row-${list[i].maPhieu} ten">${list[i].nhanVien.ten}</span>
            <span class="hidden row-${list[i].maPhieu} maPhieu">${list[i].maPhieu}</span>
            <span class="hidden row-${list[i].maPhieu} maNCC">${list[i].nhaCungCap.maNCC}</span>
            <span class="hidden row-${list[i].maPhieu} maNV">${list[i].nhanVien.maNV}</span>
            <span class="center-left col-3 row-${list[i].maPhieu} tenNCC">${list[i].nhaCungCap.tenNCC}</span>
            <span class="center-left col-2 row-${list[i].maPhieu} ho">${list[i].nhanVien.ho} ${list[i].nhanVien.ten}</span>
            <span class="center col-2 row-${list[i].maPhieu} ngayNhap">${list[i].ngayNhap}</span>
            <span class="center col-2 row-${list[i].maPhieu} tongTien">${list[i].tongTien}</span>
            <div class="center col-2">
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
            <div class="checkbox col-2">
                <input type="checkbox" class="chitietphieunhaphang__checkbox" value="${list[i].sanPham.maSP}"></input>
            </div>
            <span class="hidden row-${list[i].sanPham.maSP} maPhieu">${list[i].maPhieu}</span>
            <span class="hidden row-${list[i].sanPham.maSP} maSP">${list[i].sanPham.maSP}</span>
            <span class="center-left col-3 tenSP">${list[i].sanPham.tenSP}</span>
            <span class="center col-1 row-${list[i].sanPham.maSP} soLuong">${list[i].soLuong}</span>
            <span class="center col-2 row-${list[i].sanPham.maSP} donGiaGoc">${list[i].donGiaGoc}</span>
            <span class="center col-2 row-${list[i].sanPham.maSP} thanhTien">${list[i].thanhTien}</span>
            <div class="center col-2">
                <a href="#sua-chitietphieunhaphang" class="chitietphieunhaphang-${list[i].sanPham.maSP} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="chitietphieunhaphang-${list[i].sanPham.maSP} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function hoaDonHTML(list) {
    //<span class="center-left col-1">${list[i].nhanVien.ho} ${list[i].nhanVien.ten}</span><span class="hidden row-${list[i].maHD} maNV">${list[i].nhanVien.maNV}</span>
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-1">
                <input type="checkbox" class="hoadon__checkbox" value="${list[i].maHD}"></input>
            </div>
            
            <span class="hidden row-${list[i].maHD} maKH">${list[i].khachHang.maKM}</span>
            
            <span class="center-left col-2">${list[i].khachHang.ho} ${list[i].khachHang.ten}</span>
            <span class="center col-1 row-${list[i].maHD} soDienThoai">${list[i].soDienThoai}</span>
            <span class="center-left col-3 row-${list[i].maHD} diaChi">${list[i].diaChi}</span>
            <span class="center col-2 row-${list[i].maHD} ngayLapHoaDon">${list[i].ngayLapHoaDon}</span>
            <span class="center col-1 row-${list[i].maHD} tongTien">${list[i].tongTien}</span>
            <span class="center col-1 row-${list[i].maHD} tinhTrang">`;

        if (list[i].tinhTrang == 0) {
            htmls += `<input type="checkbox" class="check-tinhTrang hoadon-${list[i].maHD}" onclick="capNhatHoaDon(this)">`;
        } else {
            htmls += `<input type="checkbox" class="check-tinhTrang hoadon-${list[i].maHD}" onclick="capNhatHoaDon(this)" checked>`;
        }

        htmls += `
            </span>
            <div class="center ine-break col-1">
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
            <span class="hidden row-${list[i].sanPham.maSP} maHD">${list[i].maHD}</span>
            <span class="hidden row-${list[i].sanPham.maSP} maSP">${list[i].sanPham.maSP}</span>
            <span class="center-left col-5">${list[i].sanPham.tenSP}</span>
            <span class="center col-2 row-${list[i].sanPham.maSP} soLuong">${list[i].soLuong}</span>
            <span class="center col-2 row-${list[i].sanPham.maSP} donGia">${list[i].donGia}</span>
            <span class="center col-3 row-${list[i].sanPham.maSP} thanhTien">${list[i].thanhTien}</span>
        `;
    }
    return htmls;
}

function taiKhoanHTML(list) {
    let htmls = '';
    const length = list.length;

    for (let i = 0; i < length; i++) {
        htmls += `
            <div class="checkbox col-1">
                <input type="checkbox" class="taikhoan__checkbox" value="${list[i].maTK}"></input>
            </div>
            <span class="hidden row-${list[i].maTK} maQuyen">${list[i].quyen.maQuyen}</span>
            <span class="center-left col-1">${list[i].quyen.tenQuyen}</span>
            <span class="center-left col-2 row-${list[i].maTK} tenTaiKhoan">${list[i].tenTaiKhoan}</span>
            <span class="center-left line-break col-2 row-${list[i].maTK} matKhau">${list[i].matKhau}</span>
            <div class="center col-2">
                <img class="taikhoan-${list[i].maTK} row-${list[i].maTK} anhDaiDien" src="${list[i].anhDaiDien}" onerror="this.removeAttribute('onError');this.setAttribute('src','/Web2/admin/public/images/no-img.png')"></img>
            </div>
            <span class="center col-1 row-${list[i].maTK} trangThai">`;
        if (list[i].trangThai == 0) {
            htmls += `<input type="checkbox" class="check-trangThai row-${list[i].maHD}" onclick="capNhatTrangThai(this)" checked>`;
        } else {
            htmls += `<input type="checkbox" class="check-trangThai row-${list[i].maHD}" onclick="capNhatTrangThai(this)">`;
        }
        htmls += `
            </span>
            <span class="center col-1 row-${list[i].maTK} dangNhap">${list[i].dangNhap}</span>
            <span class="center-left col-1 row-${list[i].maTK} thoiGianTao">${list[i].thoiGianTao}</span>
            <div class="center col-1">
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
            <div class="checkbox col-1">
                <input type="checkbox" class="nhanvien__checkbox" value="${list[i].maNV}"></input>
            </div>
            <span class="hidden row-${list[i].maNV} maTK">${list[i].taikhoan.maTK}</span>
            <span class="center-left col-1">${list[i].taikhoan.tenTaiKhoan}</span>
            <span class="center-left col-1 row-${list[i].maNV} ho">${list[i].ho}</span>
            <span class="center-left col-1 row-${list[i].maNV} ten">${list[i].ten}</span>
            <span class="center col-2 row-${list[i].maNV} ngaySinh">${list[i].ngaySinh}</span>
            <span class="center-left col-3 row-${list[i].maNV} diaChi">${list[i].diaChi}</span>
            <span class="center col-1 row-${list[i].maNV} soDienThoai">${list[i].soDienThoai}</span>
            <span class="center col-1 row-${list[i].maNV} luong">${list[i].luong}</span>
            <div class="center col-1">
                <a href="#sua-nhanvien" class="nhanvien-${list[i].maNV} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
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
            <div class="checkbox col-1">
                <input type="checkbox" class="khachhang__checkbox" value="${list[i].maKH}"></input>
            </div>
            <span class="hidden row-${list[i].maKH} maTK">${list[i].taikhoan.maTK}</span>
            <span class="center-left col-1">${list[i].taikhoan.tenTaiKhoan}</span>
            <span class="center-left col-1 row-${list[i].maKH} ho">${list[i].ho}</span>
            <span class="center-left col-1 row-${list[i].maKH} ten">${list[i].ten}</span>
            <span class="center col-2 row-${list[i].maKH} ngaySinh">${list[i].ngaySinh}</span>
            <span class="center-left col-3 row-${list[i].maKH} diaChi">${list[i].diaChi}</span>
            <span class="center col-1 row-${list[i].maKH} soDienThoai">${list[i].soDienThoai}</span>
            <div class="center col-2">
                <a href="#sua-khachhang" class="khachhang-${list[i].maKH} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
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
            <div class="checkbox col-1">
                <input type="checkbox" class="nhacungcap__checkbox" value="${list[i].maNCC}"></input>
            </div>
            <span class="center-left col-3 row-${list[i].maNCC} tenNCC">${list[i].tenNCC}</span>
            <span class="center-left col-4 row-${list[i].maNCC} diaChi">${list[i].diaChi}</span>
            <span class="center col-2 row-${list[i].maNCC} soDienThoai">${list[i].soDienThoai}</span>
            <div class="center col-2">
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
            <div class="checkbox col-1">
                <input type="checkbox" class="nhasanxuat__checkbox" value="${list[i].maNSX}"></input>
            </div>
            <span class="center-left col-3 row-${list[i].maNSX} tenNSX">${list[i].tenNSX}</span>
            <span class="center-left col-4 row-${list[i].maNSX} diaChi">${list[i].diaChi}</span>
            <span class="center col-2 row-${list[i].maNSX} soDienThoai">${list[i].soDienThoai}</span>
            <div class="center col-2">
                <a href="#sua-nhasanxuat" class="nhasanxuat-${list[i].maNSX} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></a>
                <button class="nhasanxuat-${list[i].maNSX} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}

function renderPaginate(table, numOfPages) {
    let htmls = '';

    for (let i = 0; i < numOfPages; i++) {
        if (i == 0) {
            htmls += `<li onclick="paginate(this)" class="${table}-${i + 1} current-page">${
                i + 1
            }</li>`;
        } else {
            htmls += `<li onclick="paginate(this)" class="${table}-${i + 1}">${i + 1}</li>`;
        }
    }
    return htmls;
}

function getHTML(table, data) {
    switch (table) {
        case 'sanpham': {
            return sanPhamHTML(data);
        }
        case 'loai': {
            return loaiHTML(data);
        }
        case 'phieunhaphang': {
            return phieuNhapHangHTML(data);
        }
        case 'chitietphieunhaphang': {
            return chiTietPhieuNhapHangHTML(data);
        }
        case 'hoadon': {
            return hoaDonHTML(data);
        }
        case 'chitiethoadon': {
            return chiTietHoaDonHTML(data);
        }
        case 'taikhoan': {
            return taiKhoanHTML(data);
        }
        case 'nhanvien': {
            return nhanVienHTML(data);
        }
        case 'khachhang': {
            return khachHangHTML(data);
        }
        case 'nhacungcap': {
            return nhaCungCapHTML(data);
        }
        case 'nhasanxuat': {
            return nhaSanXuatHTML(data);
        }
    }
    return null;
}
