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

function ajaxUpdateOne(ele) {
    const clas = ele.getAttribute('class');
    const str = clas.substr(0, clas.lastIndexOf('-'));
    const id = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf('btn') - 1);

    const url = window.location.href;
    const params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';
    let htmls = '';

    switch (str) {
        case 'product': {
            const anhDaiDien = '/ok',
                maLoai = '2',
                maNSX = '5',
                tenSP = 'ten',
                donGia = '20000',
                donViTinh = 'vnd',
                soLuong = '1000';
            $.ajax({
                url: '/Web2/app/index.php' + params,
                type: 'post',
                data: {
                    maSP: id,
                    anhDaiDien,
                    maLoai,
                    maNSX,
                    tenSP,
                    donGia,
                    donViTinh,
                    soLuong,
                    action: 'update',
                    table: 'product',
                },
                success: function (data) {
                    console.log(data);
                },
            });
            break;
        }
        case 'category': {
            const maLoai = '2',
                tenLoai = 'ten';
            $.ajax({
                url: '/Web2/app/index.php' + params,
                type: 'post',
                data: {
                    maLoai: id,
                    tenLoai,
                    action: 'update',
                    table: 'category',
                },
                success: function (data) {
                    console.log(data);
                },
            });
            break;
        }
        case 'promotion': {
            const maKM = id,
                tenKM = 'tenKM',
                ngayBatDau = 'ngayBD',
                ngayKetThuc = 'ngayKT';
            $.ajax({
                url: '/Web2/app/index.php' + params,
                type: 'post',
                data: {
                    maKM: id,
                    tenKM,
                    ngayBatDau,
                    ngayKetThuc,
                    action: 'update',
                    table: 'promotion',
                },
                success: function (data) {
                    console.log(data);
                },
            });
            break;
        }
        case 'detail-promotion': {
            const maKM = id,
                maSP = '3',
                hinhThucKhuyenMai = 'hinhthuc',
                phanTramKhuyenMai = 'phantram';
            $.ajax({
                url: '/Web2/app/index.php' + params,
                type: 'post',
                data: {
                    maSP: id,
                    maKM: 3,
                    hinhThucKhuyenMai,
                    phanTramKhuyenMai,
                    action: 'update',
                    table: 'detail-promotion',
                },
                success: function (data) {
                    console.log(data);
                },
            });
            break;
        }
    }
}

function ajaxDeleteOne(ele) {
    if (window.confirm('Chắc chắn muốn xóa?')) {
        const clas = ele.getAttribute('class');
        const str = clas.substr(0, clas.lastIndexOf('-'));
        const url = window.location.href;
        const params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';
        let htmls = '';
        const id = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf('btn') - 1);
        const image = document.querySelector(`.product-${id}`).getAttribute('src');

        switch (str) {
            case 'product': {
                $.ajax({
                    url: '/Web2/app/index.php' + params,
                    type: 'post',
                    data: {
                        maSP: id,
                        anhDaiDien: image,
                        action: 'delete',
                        table: 'product',
                    },
                    success: function (data) {
                        console.log(data);
                        // const json = JSON.parse(data);
                        // console.log(JSON.parse(data));
                        // if (json.response.status == 'error') {
                        //     console.log(json);
                        // }
                    },
                });
                break;
            }
            case 'category':
                {
                    $.ajax({
                        url: '/Web2/app/index.php' + params,
                        type: 'post',
                        data: {
                            maLoai: id,
                            action: 'delete',
                            table: 'category',
                        },
                        success: function (data) {
                            console.log(data);
                        },
                    });
                }
                break;
            case 'promotion': {
                $.ajax({
                    url: '/Web2/app/index.php' + params,
                    type: 'post',
                    data: {
                        maKM: id,
                        action: 'delete',
                        table: 'promotion',
                    },
                    success: function (data) {
                        console.log(data);
                    },
                });
                break;
            }
            case 'detail-promotion': {
                $.ajax({
                    url: '/Web2/app/index.php' + params,
                    type: 'post',
                    data: {
                        maSP: id,
                        action: 'delete',
                        table: 'detail-promotion',
                    },
                    success: function (data) {
                        console.log(data);
                    },
                });
                break;
            }
        }
    }
}

function ajaxMultiDel(ele) {
    const clas = ele.getAttribute('class');
    const str = clas.substr(0, clas.indexOf('--'));
    const masterCheckbox = document.querySelector(`.${str}__master-checkbox`);
    const checkboxes = document.querySelectorAll(`.${str}__checkbox`);
    let table = '',
        id = [],
        image = [];

    if (window.confirm('Chắc chắn muốn xóa?')) {
        checkboxes.forEach((element) => {
            if (element.checked == true) {
                id.push(element.value);
                image.push(document.querySelector(`.product-${element.value}`).getAttribute('src'));
            }
        });
        if (id.length > 0) {
            const url = window.location.href;
            const params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';
            let htmls = '';
            switch (str) {
                case 'product': {
                    $.ajax({
                        url: '/Web2/app/index.php' + params,
                        type: 'post',
                        data: {
                            maSP: id,
                            anhDaiDien: image,
                            action: 'delete',
                            table: 'product',
                        },
                        success: function (data) {
                            console.log(data);
                        },
                    });
                    break;
                }
                case 'category':
                    {
                        $.ajax({
                            url: '/Web2/app/index.php' + params,
                            type: 'post',
                            data: {
                                maLoai: id,
                                action: 'delete',
                                table: 'category',
                            },
                            success: function (data) {
                                console.log(data);
                            },
                        });
                    }
                    break;
                case 'promotion': {
                    $.ajax({
                        url: '/Web2/app/index.php' + params,
                        type: 'post',
                        data: {
                            maKM: id,
                            action: 'delete',
                            table: 'promotion',
                        },
                        success: function (data) {
                            console.log(data);
                        },
                    });
                    break;
                }
                case 'detail-promotion': {
                    $.ajax({
                        url: '/Web2/app/index.php' + params,
                        type: 'post',
                        data: {
                            maSP: id,
                            action: 'delete',
                            table: 'detail-promotion',
                        },
                        success: function (data) {
                            console.log(data);
                        },
                    });
                    break;
                }
            }
        } else {
            alert('Chọn ít nhất 1 phần tử');
        }
    }
}

function productHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
                    <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                        <input type="checkbox" value="${list[i].maSP}" ></input>
                    </div>
                    <div class="center col-lg-2 col-md-2 col-sm-12">
                        <img src="${list[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                    </div>
                    <span class="center-left col-lg-3 col-md-4 col-sm-12">${list[i].tenSP}</span>
                    <span class="center col-lg-2 col-md-1 col-sm-12">${list[i].donGia} ${list[i].donViTinh}</span>
                    <span class="center col-lg-2 col-md-2 col-sm-12">${list[i].loaiSanPham.tenloai}</span>
                    <div class="center col-lg-2 col-md-3 col-sm-12">
                        <button class="btn " onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                        <button class="btn " onclick="delOneete(this)"><i class="far fa-trash-alt"></i></button>
                    </div>
                `;
    }
    return htmls;
}

function categoryHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
                    <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                        <input type="checkbox" value="${list[i].maSP}" ></input>
                    </div>
                    <div class="center col-lg-2 col-md-2 col-sm-12">
                        <img src="${list[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                    </div>
                    <span class="center-left col-lg-3 col-md-4 col-sm-12">${list[i].tenSP}</span>
                    <span class="center col-lg-2 col-md-1 col-sm-12">${list[i].donGia} ${list[i].donViTinh}</span>
                    <span class="center col-lg-2 col-md-2 col-sm-12">${list[i].loaiSanPham.tenloai}</span>
                    <div class="center col-lg-2 col-md-3 col-sm-12">
                        <button class="btn " onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                        <button class="btn " onclick="delOneete(this)"><i class="far fa-trash-alt"></i></button>
                    </div>
                `;
    }
    return htmls;
}

function promotionHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
                    <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                        <input type="checkbox" value="${list[i].maSP}" ></input>
                    </div>
                    <div class="center col-lg-2 col-md-2 col-sm-12">
                        <img src="${list[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                    </div>
                    <span class="center-left col-lg-3 col-md-4 col-sm-12">${list[i].tenSP}</span>
                    <span class="center col-lg-2 col-md-1 col-sm-12">${list[i].donGia} ${list[i].donViTinh}</span>
                    <span class="center col-lg-2 col-md-2 col-sm-12">${list[i].loaiSanPham.tenloai}</span>
                    <div class="center col-lg-2 col-md-3 col-sm-12">
                        <button class="btn " onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                        <button class="btn " onclick="delOneete(this)"><i class="far fa-trash-alt"></i></button>
                    </div>
                `;
    }
    return htmls;
}

function detailPromotionHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
                    <div class="checkbox col-lg-1 col-md-12 col-sm-12">
                        <input type="checkbox" value="${list[i].maSP}" ></input>
                    </div>
                    <div class="center col-lg-2 col-md-2 col-sm-12">
                        <img src="${list[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                    </div>
                    <span class="center-left col-lg-3 col-md-4 col-sm-12">${list[i].tenSP}</span>
                    <span class="center col-lg-2 col-md-1 col-sm-12">${list[i].donGia} ${list[i].donViTinh}</span>
                    <span class="center col-lg-2 col-md-2 col-sm-12">${list[i].loaiSanPham.tenloai}</span>
                    <div class="center col-lg-2 col-md-3 col-sm-12">
                        <button class="btn " onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                        <button class="btn " onclick="delOneete(this)"><i class="far fa-trash-alt"></i></button>
                    </div>
                `;
    }
    return htmls;
}
