$(document).ready(function () {
    $('.add-content').submit(function (e) {
        e.preventDefault();
        if (confirm('Thông tin có chính xác?')) {
            let that = $(this),
                fd = new FormData(),
                checkboxes = [],
                radios = [],
                typeArr = ['file', 'checkbox', 'submit'];

            const clas = e.target.getAttribute('class');
            const tableEn = clas.substring(clas.lastIndexOf(' ') + 1, clas.lastIndexOf('__'));
            let table = '';
            switch (tableEn) {
                case 'product': {
                    table = 'sanpham';
                    break;
                }
                case 'category': {
                    table = 'loai';
                    break;
                }
                case 'promotion': {
                    table = 'khuyenmai';
                    break;
                }
                case 'detail-promotion': {
                    table = 'chitietkhuyenmai';
                    break;
                }
            }

            fd.append('action', 'add');
            fd.append('table', table);
            that.find('[name]').each(function (i, value) {
                let that = $(this),
                    name = that.attr('name'),
                    type = that.attr('type');

                if (type == 'file') {
                    let files = this.files[0];
                    fd.append(name, files);
                }

                if (type == 'checkbox' && this.checked == true) {
                    checkboxes.push(that.val());
                    fd.append('checked_checkboxes', checkboxes);
                }

                if (type == 'radio' && this.checked == true) {
                    radios.push(that.val());
                    fd.append('checked_radios', radios);
                }

                if (!typeArr.includes(type)) {
                    value = that.val();
                    fd.append(name, value);
                }
            });

            let url = window.location.href;
            let params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';

            $.ajax({
                url: 'app/index.php' + params,
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                },
            });
        }
    });

    $('.product--add').on('click', function (e) {
        $('.product__add-content').toggleClass('hidden');
    });
    $('.product--filter').on('click', function (e) {
        $('.product__filter-content').toggleClass('hidden');
    });
    $('.category--add').on('click', function (e) {
        $('.category__add-content').toggleClass('hidden');
    });
    $('.promotion--add').on('click', function (e) {
        $('.promotion__add-content').toggleClass('hidden');
    });
    $('.promotion--filter').on('click', function (e) {
        $('.promotion__filter-content').toggleClass('hidden');
    });
    $('.detail-promotion--add').on('click', function (e) {
        $('.detail-promotion__add-content').toggleClass('hidden');
    });
    $('.detail-promotion--filter').on('click', function (e) {
        $('.detail-promotion__filter-content').toggleClass('hidden');
    });
});

function ajaxOpenDetail(ele) {
    const clas = ele.getAttribute('class');
    const ID = clas.substring(clas.indexOf('-') + 1, clas.indexOf(' '));
    const general = clas.substring(0, clas.indexOf('-'));
    const detail = 'detail-' + general;
    $(`.${detail}--add`).addClass(`${general}-${ID}`);
    $(`.${detail}--filter`).addClass(`${general}-${ID}`);

    const url = window.location.href;
    const params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';
    $.ajax({
        url: 'app/index.php' + params,
        type: 'post',
        data: {
            table: 'chitietkhuyenmai',
            id: ID,
            col: 'maKM',
            action: 'get',
        },
        success: function (data) {
            if (isJson(data)) {
                const json = JSON.parse(data);
                const html = detailPromotionHTML(json.data);
                $('.detail-promotion--show').html(html);

                let page = `
                <div>
                    <ul class="text-center center paginate">
                        <li class="chitietkhuyenmai-first"></li>
                        <li class="chitietkhuyenmai-prev"></li>
            `;
                for (let i = 1; i <= json.pages; i++) {
                    if (i == 1)
                        page += `<li onclick="paginate(this)" class="chitietkhuyenmai-1 current-page">${i}</li>`;
                    else
                        page += `<li onclick="paginate(this)" class="chitietkhuyenmai-${i}">${i}</li>`;
                }
                page += `
                        <li class="chitietkhuyenmai-next"></li>
                        <li class="chitietkhuyenmai-last"></li>
                    </ul>
                </div>
            `;
                $('.detail-promotion__row .content-item__pagination').html(page);
            } else {
                $('.detail-promotion--show').html(`
                        <div style="display:flex;align-items: center;justify-content: center;height: 200px;">
                            <h1>Empty</h1>
                        </div>
                `);
                $('.detail-promotion__row .content-item__pagination').html('');
            }
        },
    });
}

function ajaxPaginate(ele) {
    const eleID = ele.getAttribute('class');
    const page = eleID.substr(eleID.indexOf('-') + 1, 1);
    const table = eleID.substring(0, eleID.indexOf('-'));
    let order = '';
    switch (table) {
        case 'sanpham': {
            order = 'desc';
            break;
        }
    }
    const url = window.location.href;
    const params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';
    $.ajax({
        url: 'app/index.php' + params,
        type: 'post',
        data: {
            table,
            current: page,
            order: order,
            action: 'get',
        },
        success: function (data) {
            if (isJson(data)) {
                const json = JSON.parse(data);
                const parent = ele.parentNode;
                parent.querySelector('.current-page').classList.remove('current-page');
                parent.querySelector(`.${table}-${page}`).classList.add('current-page');
                switch (table) {
                    case 'sanpham': {
                        const html = productHTML(json.data);
                        $('.product--show').html(html);
                        break;
                    }
                    case 'loai': {
                        const html = categoryHTML(json.data);
                        $('.category--show').html(html);
                        break;
                    }
                    case 'khuyenmai': {
                        const html = promotionHTML(json.data);
                        $('.promotion--show').html(html);
                        break;
                    }
                    case 'chitietkhuyenmai': {
                        const html = detailPromotionHTML(json.data);
                        $('.detail-promotion--show').html(html);
                        break;
                    }
                }
            }
        },
    });
}

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
                    table: 'sanpham',
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
                    table: 'loai',
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
                    table: 'khuyenmai',
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
                    maSP,
                    maKM,
                    hinhThucKhuyenMai,
                    phanTramKhuyenMai,
                    action: 'update',
                    table: 'chitietkhuyenmai',
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
                        table: 'sanpham',
                    },
                    success: function (data) {
                        if (isJson(data)) {
                            const json = JSON.parse(data);
                            if (!json.error) {
                                htmls = productHTML(json.data.SPArr);
                                console.log(htmls);
                            } else {
                                alert(json.error);
                            }
                        } else {
                            console.log(data);
                        }
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
                            table: 'loai',
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
                        table: 'khuyenmai',
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
                        table: 'chitietkhuyenmai',
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
                            table: 'sanpham',
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
                                table: 'loai',
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
                            table: 'khuyenmai',
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
                            table: 'chitietkhuyenmai',
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
                    <div class="center checkbox col-lg-1 col-md-12 col-sm-12">
                        <input type="checkbox" value="${list[i].maSP}" ></input>
                    </div>
                    <div class="center col-lg-2 col-md-2 col-sm-12">
                        <img src="${list[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                    </div>
                    <span class="center-left col-lg-3 col-md-4 col-sm-12">${list[i].tenSP}</span>
                    <span class="center-right col-lg-2 col-md-1 col-sm-12">${list[i].donGia} ${list[i].donViTinh}</span>
                    <span class="center col-lg-2 col-md-2 col-sm-12">${list[i].soLuong}</span>
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
            <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                <input type="checkbox" class="category__checkbox" value="${list[i].maLoai}"></input>
            </div>
            <span class="center-left col-lg-6 col-md-4 col-sm-12">${list[i].tenLoai}</span>
            <div class="center cake__cmd col-lg-4 col-md-3 col-sm-12">
                <button class="category-${list[i].maLoai} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                <button class="category-${list[i].maLoai} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
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
                <input type="checkbox" class="promotion__checkbox" value="${list[i].maKM}"></input>
            </div>
            <span class="center-left col-lg-5 col-md-4 col-sm-12">${list[i].tenKM}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12">${list[i].ngayBatDau}</span>
            <span class="center col-lg-2 col-md-4 col-sm-12">${list[i].ngayKetThuc}</span>
            <div class="center cake__cmd col-lg-2 col-md-3 col-sm-12">
                <button class="promotion-${list[i].maKM} btn " onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                <button class="promotion-${list[i].maKM} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
                <button class="promotion-${list[i].maKM} btn" onclick="openDetail(this)"><i class="fas fa-arrow-circle-right"></i></button>
            </div>
        `;
    }
    return htmls;
}

function detailPromotionHTML(list) {
    let htmls = '';
    for (let i = 0; i < list.length; i++) {
        htmls += `
            <div class="checkbox col-lg-2 col-md-12 col-sm-12">
                <input type="checkbox" class="detail-promotion__checkbox" value="${list[i].maSP}"></input>
            </div>
            <span class="center-left col-lg-6 col-md-4 col-sm-12">${list[i].hinhThucKhuyenMai}</span>
            <span class="center col-lg-1 col-md-4 col-sm-12">${list[i].phanTramKhuyenMai}</span>
            <div class="center cake__cmd col-lg-3 col-md-3 col-sm-12">
                <button class="detail-promotion-${list[i].maSP} btn" onclick="updateOne(this)"><i class="far fa-edit"></i></button>
                <button class="detail-promotion-${list[i].maSP} btn" onclick="deleteOne(this)"><i class="far fa-trash-alt"></i></button>
            </div>
        `;
    }
    return htmls;
}
