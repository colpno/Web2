$(document).ready(function () {
    let chiSoVaChuArr = ['tenTaiKhoan'],
        chiChuVaKhoangTrangArr = ['ho', 'ten'],
        chiSoArr = [{ name: 'luong', length: 10 }],
        kiemKhoangTrangArr = ['matKhau'],
        kiemNgayArr = ['thoiGianTao', 'ngaySinh'],
        kiemSoDienThoaiArr = ['soDienThoai'],
        kiemDiaChiArr = ['diaChi'];

    $('.add-content').submit(function (e) {
        e.preventDefault();

        const that = $(this),
            clas = that.attr('class').replace(' ', '.'),
            table = clas.substring(clas.lastIndexOf('.') + 1, clas.lastIndexOf('__'));

        /* 
            Add
        */
        if ($(`.${clas} [type='submit']`).val() == 'Thêm' && confirm('Thông tin có chính xác?')) {
            const that = $(this),
                fd = new FormData(),
                checkboxes = [],
                radios = [];
            let count = 0;

            fd.append('action', 'add');
            fd.append('table', table);

            that.find('[name]').each(function () {
                const that = $(this),
                    name = that.attr('name'),
                    value = that.val();

                if (kiemDiaChiArr.includes(name) && value != '') {
                    if (laDiaChi(value, name, 255) === false) {
                        count++;
                    }
                }

                if (kiemSoDienThoaiArr.includes(name) && value != '') {
                    if (soDienThoaiHopLe(value, name, 10) === false) {
                        count++;
                    }
                }

                if (kiemKhoangTrangArr.includes(name) && value != '') {
                    if (kiemKhongKhoangTrang(value, name) === false) {
                        count++;
                    }
                }

                if (chiSoVaChuArr.includes(name) && value != '') {
                    if (chiSoVaChu(value, name, 255) === false) {
                        count++;
                    }
                }

                if (chiChuVaKhoangTrangArr.includes(name) && value != '') {
                    if (chiChuVaKhoangTrang(value, name, 255) === false) {
                        count++;
                    }
                }

                chiSoArr.some((obj) => {
                    if (obj.name === name && value != '') {
                        if (chiSo(value, name, obj.length) === false) {
                            count++;
                        }
                        return;
                    }
                });

                if (kiemNgayArr.includes(name) && value != '') {
                    if (kiemNgay(value, name) === false) {
                        count++;
                    }
                }
            });

            if (count === 0) {
                that.find('[name]').each(function () {
                    const that = $(this),
                        name = that.attr('name'),
                        type = that.attr('type');

                    if (that.val() != '') {
                        if (type == 'file') {
                            const files = this.files[0];
                            fd.append(name, files);
                        } else if (type == 'checkbox' && this.checked == true) {
                            checkboxes.push(that.val());
                            fd.append('checked_checkboxes', checkboxes);
                        } else if (type == 'radio' && this.checked == true) {
                            radios.push(that.val());
                            fd.append('checked_radios', radios);
                        } else {
                            fd.append(name, that.val());
                        }
                    }
                });

                let params = `?controller=admin&action=taikhoan`;

                $.ajax({
                    url: '/Web2/admin/app/index.php' + params,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (isJson(data)) {
                            const json = JSON.parse(data);
                            if (json.data != null) {
                                $(`.${table}--show`).html(getHTML(table, json.data));
                                $(`.${table}__row .paginate`).html(
                                    renderPaginate(table, json.pages),
                                );
                                location.reload();
                            }
                        } else {
                            alert(data);
                        }
                    },
                });
            }
        }

        /* 
            Update
         */
        if ($(`.${clas} [type='submit']`).val() == 'Sửa' && confirm('Thông tin có chính xác?')) {
            let chiSoVaChuArr = ['tenTaiKhoan'],
                kiemKhoangTrangArr = ['matKhau'];

            const fd = new FormData();
            let count = 0;

            fd.append('table', table);
            fd.append('action', 'update');

            that.find('[name]').each(function () {
                const that = $(this),
                    name = that.attr('name'),
                    value = that.val();

                if (table == 'nhanvien' || table == 'khachhang') {
                    if (kiemDiaChiArr.includes(name)) {
                        if (laDiaChi(value, name, 255) === false) {
                            count++;
                        }
                    }

                    if (kiemSoDienThoaiArr.includes(name)) {
                        if (soDienThoaiHopLe(value, name, 10) === false) {
                            count++;
                        }

                        if (chiChuVaKhoangTrangArr.includes(name)) {
                            if (chiChuVaKhoangTrang(value, name, 255) === false) {
                                count++;
                            }
                        }

                        chiSoArr.some((obj) => {
                            if (obj.name === name) {
                                if (chiSo(value, name, obj.length) === false) {
                                    count++;
                                }
                                return;
                            }
                        });

                        if (kiemNgayArr.includes(name)) {
                            if (kiemNgay(value, name) === false) {
                                count++;
                            }
                        }
                    }
                }

                if (kiemKhoangTrangArr.includes(name)) {
                    if (kiemKhongKhoangTrang(value, name) === false) {
                        count++;
                    }
                }

                if (chiSoVaChuArr.includes(name)) {
                    if (chiSoVaChu(value, name, 255) === false) {
                        count++;
                    }
                }
            });

            if (count == 0) {
                that.find('[name]').each(function () {
                    const that = $(this),
                        name = that.attr('name'),
                        type = that.attr('type'),
                        value = that.val();

                    if (type == 'file') {
                        const files = this.files[0];
                        fd.append(name, files);
                    } else {
                        fd.append(name, value);
                    }
                });

                const params = `?controller=admin&action=taikhoan`;

                $.ajax({
                    url: '/Web2/admin/app/index.php' + params,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (isJson(data)) {
                            const json = JSON.parse(data);
                            if (json.data != null) {
                                $(`.${table}--show`).html(getHTML(table, json.data));
                                $(`.${table}__add-content`).addClass('hidden');
                                alert('Updated');
                                if (table == 'taikhoan') {
                                    location.reload();
                                }
                            }
                        } else {
                            alert(data);
                        }
                    },
                });
            }
        }
    });

    $('.filter-content').on('submit', function (e) {
        e.preventDefault();

        const that = $(this),
            fd = new FormData(),
            clas = e.target.getAttribute('class'),
            table = clas.substring(clas.lastIndexOf(' ') + 1, clas.lastIndexOf('__'));
        let count = 0;

        fd.append('action', 'filter');
        fd.append('table', table);

        const fill = [];
        that.find('[name]').each(function () {
            const that = $(this),
                value = that.val();

            fill.push(value);
        });

        /* 
            Tester
         */
        chiSoArr.some((obj) => {
            if (obj.name === fill[0]) {
                for (let i = 1; i < fill.length; i++) {
                    if (chiSo(fill[i], fill[0], obj.length) === false) {
                        count++;
                    }
                }
                return;
            }
        });

        if (kiemNgayArr.includes(fill[0])) {
            for (let i = 1; i < fill.length; i++) {
                if (kiemNgay(fill[i], fill[0]) === false) {
                    count++;
                }
            }
        }

        /* 
            No failed testing
         */
        if (count == 0) {
            that.find('[name]').each(function () {
                const that = $(this),
                    name = that.attr('name'),
                    val = that.val();

                fd.append(name, val);
            });

            const params = '?controller=admin&action=taikhoan';

            $.ajax({
                url: '/Web2/admin/app/index.php' + params,
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        let html = '';
                        if (json.data != null) {
                            $(`.${table}--show`).html(getHTML(table, json.data));
                            $(`.${table}__row .paginate`).html(renderPaginate(table, json.pages));
                        }
                    } else {
                        alert(data);
                    }
                },
            });
        }
    });

    $('#trangThaiTaiKhoan').on('change', function () {
        const that = $(this),
            value = that.val();

        if (value != '') {
            $.ajax({
                url: '/Web2/admin/app/index.php?controller=admin&action=taikhoan',
                type: 'post',
                data: {
                    trangThai: value,
                    table: 'taikhoan',
                    action: 'get',
                },
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        if (json.data != null) {
                            $('.taikhoan--show').html(getHTML('taikhoan', json.data));
                            $(`.taikhoan__row .paginate`).html(
                                renderPaginate('hoadon', json.pages),
                            );
                        }
                    } else {
                        alert(data);
                    }
                },
            });
        } else {
            $.ajax({
                url: '/Web2/admin/app/index.php?controller=admin&action=taikhoan',
                type: 'post',
                data: {
                    table: 'taikhoan',
                    action: 'get',
                },
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        if (json.data != null) {
                            $('.taikhoan--show').html(getHTML('taikhoan', json.data));
                            $(`.taikhoan__row .paginate`).html(
                                renderPaginate('hoadon', json.pages),
                            );
                        }
                    } else {
                        alert(data);
                    }
                },
            });
        }
    });

    const toggleAddContents = ['taikhoan', 'nhanvien', 'khachhang'];
    toggleAddContents.forEach((element) => {
        $(`.${element}--add`).on('click', function () {
            $(`.${element}__add-content [type="submit"]`).val('Thêm');

            $(`.${element}__add-content`)
                .find('[name]')
                .each(function () {
                    $(this).val('');
                });

            $(`.${element}__add-content`).toggleClass('hidden');
        });
    });

    const toggleFilterContents = ['taikhoan', 'nhanvien', 'khachhang'];
    toggleFilterContents.forEach((element) => {
        $(`.${element}--filter`).on('click', function () {
            $(`.${element}__filter-content`).toggleClass('hidden');
        });
    });
});

function ajaxPaginate(ele) {
    const eleID = ele.getAttribute('class'),
        page = eleID.substr(eleID.indexOf('-') + 1, 1),
        table = eleID.substring(0, eleID.indexOf('-')),
        href = window.location.href,
        fd = new FormData();

    fd.append('table', table);
    fd.append('action', 'get');

    let params = `?controller=admin&action=taikhoan&page=${page}&`;
    params += href.indexOf('?') ? href.substring(href.indexOf('?') + 1, href.indexOf('&page')) : '';

    if (params.includes('filterCol')) {
        const url_string = window.location.href,
            url = new URL(url_string);
        fd.append('filterCol', url.searchParams.get('filterCol'));
        fd.append('from', url.searchParams.get('from'));
        fd.append('to', url.searchParams.get('to'));
        fd.append('action', 'filter');
    }

    $.ajax({
        url: '/Web2/admin/app/index.php' + params,
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function (data) {
            if (isJson(data)) {
                const json = JSON.parse(data);
                const parent = ele.parentNode;
                parent.querySelector('.current-page').classList.remove('current-page');
                parent.querySelector(`.${table}-${page}`).classList.add('current-page');
                if (json.data != null) {
                    $(`.${table}--show`).html(getHTML(table, json.data));
                    $(`.${table}__row .paginate`).html(renderPaginate(table, json.pages));
                }
            } else {
                alert(data);
            }
        },
    });
}

function ajaxCapNhatTrangThai(ele) {
    const that = $(ele),
        clas = that.attr('class'),
        maTK = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf(' ')),
        trangThai = ele.checked == true ? 0 : 1;

    $.ajax({
        url: '/Web2/admin/app/index.php?controller=admin&action=taikhoan',
        type: 'post',
        data: {
            table: 'taikhoan',
            action: 'capNhatTrangThai',
            maTK,
            trangThai,
        },
        success: function (data) {
            if (isJson(data)) {
            } else {
                alert(data);
            }
        },
    });
}

function ajaxUpdateOne(ele) {
    const that = $(ele),
        clas = that.attr('class'),
        id = clas.substring(clas.indexOf('-') + 1, clas.indexOf(' ')),
        table = clas.substr(0, clas.lastIndexOf('-')),
        href = that.attr('href');

    $('.taikhoan__add select[name="maQuyen"]').removeAttr('onchange');

    /* 
        Ghi lại các giá trị vào field
     */
    $(`.${table}--show .row-${id}`).each(function () {
        const that = $(this),
            clas = that.attr('class'),
            prop = clas.substring(clas.lastIndexOf(' ') + 1);

        const val = that.text();
        $(`${href} [name='${prop}']`).val(val);
    });

    /* 
        xóa tất cả trước khi append
     */
    $(`.${table}__add-content`)
        .find('[class="hidden"]')
        .each(function () {
            const that = $(this),
                text = that.text();
            if (text != id) {
                that.remove();
            }
        });

    switch (table) {
        case 'taikhoan': {
            const maQuyen = $(`.${table}--show .hidden.maQuyen.row-${id}`).text();

            $(`.${table}__add-content`).append(
                `<input class="hidden" name="maTK" type="text" value="${id}">`,
                `<input class="hidden" name="maQuyen" type="text" value="${maQuyen}">`,
            );

            break;
        }
        case 'nhanvien': {
            const maTK = $(`.${table}--show .hidden.maTK.row-${id}`).text();

            $(`.${table}__add-content`).append(
                `<input class="hidden" value="${id}" name="maNV" type="text">`,
                `<input class="hidden" value="${maTK}" name="maTK" type="text">`,
            );

            break;
        }
        case 'khachhang': {
            const maTK = $(`.${table}--show .hidden.maTK.row-${id}`).text();

            $(`.${table}__add-content`).append(
                `<input class="hidden" value="${id}" name="maKH" type="text">`,
                `<input class="hidden" value="${maTK}" name="maTK" type="text">`,
            );

            break;
        }
    }

    if ($(href).hasClass('hidden')) {
        $(href).removeClass('hidden');
    }

    $(`.${table}__add-content [type='submit']`).val('Sửa');
}

function ajaxDeleteOne(ele) {
    if (window.confirm('Chắc chắn muốn xóa?')) {
        const clas = ele.getAttribute('class'),
            str = clas.substr(0, clas.lastIndexOf('-')),
            params = `?controller=admin&action=taikhoan`,
            id = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf('btn') - 1),
            fd = new FormData();

        fd.append('table', str);
        fd.append('action', 'delete');

        switch (str) {
            case 'taikhoan': {
                const image = ele.parentNode.parentNode
                    .querySelector(`.row-${id}.anhDaiDien`)
                    .getAttribute('src');
                fd.append('anhDaiDien', image);
                fd.append('maTK', id);
                break;
            }
            case 'nhanvien': {
                fd.append('maNV', id);
                break;
            }
            case 'khachhang': {
                fd.append('maKH', id);
                break;
            }
        }

        $.ajax({
            url: '/Web2/admin/app/index.php' + params,
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                if (isJson(data)) {
                    const json = JSON.parse(data);
                    if (json.data != null) {
                        $(`.${str}--show`).html(getHTML(str, json.data));
                        $(`.${str}__row .paginate`).html(renderPaginate(str, json.pages));
                    }
                } else {
                    alert(data);
                }
            },
        });
    }
}

function ajaxMultiDel(ele) {
    if (window.confirm('Chắc chắn muốn xóa?')) {
        const clas = ele.getAttribute('class'),
            str = clas.substr(0, clas.indexOf('--')),
            masterCheckbox = document.querySelector(`.${str}__master-checkbox`),
            checkboxes = document.querySelectorAll(`.${str}__checkbox`),
            fd = new FormData();

        let table = '',
            id = [],
            image = [];

        checkboxes.forEach((element) => {
            if (element.checked == true) {
                id.push(element.value);
                image.push(
                    document.querySelector(`.taikhoan-${element.value}`).getAttribute('src'),
                );
            }
        });

        fd.append('table', str);
        fd.append('action', 'delete');

        if (id.length > 0) {
            const params = `?controller=admin&action=taikhoan`;
            switch (str) {
                case 'taikhoan': {
                    fd.append('maTK', id);
                    fd.append('anhDaiDien', image);
                    break;
                }
                case 'nhanvien': {
                    fd.append('maNV', id);
                    break;
                }
                case 'khachhang': {
                    fd.append('maKH', id);
                    break;
                }
            }

            $.ajax({
                url: '/Web2/admin/app/index.php' + params,
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        if (json.data != null) {
                            $(`.${str}--show`).html(getHTML(str, json.data));
                            $(`.${str}__row .paginate`).html(renderPaginate(str, json.pages));
                        }
                    } else {
                        // alert(data);
                        alert(data);
                    }
                },
            });
        } else {
            alert('Chọn ít nhất 1 phần tử');
        }
    }
}
function ajaxChangeQuyen(ele) {
    switch (ele.value) {
        case '2': {
            $('.nhanvien-taikhoan__add-content').removeClass('hidden');
            $('.khachhang-taikhoan__add-content').addClass('hidden');

            const ar = $('.khachhang-taikhoan__add-content [name]');
            for (let i = 0; i < ar.length; i++) {
                const element = ar[i];
                element.value = '';
            }
            break;
        }
        case '3': {
            $('.nhanvien-taikhoan__add-content').addClass('hidden');
            $('.khachhang-taikhoan__add-content').removeClass('hidden');

            const ar = $('.nhanvien-taikhoan__add-content [name]');
            for (let i = 0; i < ar.length; i++) {
                const element = ar[i];
                element.value = '';
            }
            break;
        }
        default: {
            $('.nhanvien-taikhoan__add-content').addClass('hidden');
            $('.khachhang-taikhoan__add-content').addClass('hidden');
            break;
        }
    }
}
