$(document).ready(function () {
    const chiSoVaChuArr = ['tenTaiKhoan'],
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

                if (kiemDiaChiArr.includes(name)) {
                    if (laDiaChi(value, name, 255) === false) {
                        count++;
                    }
                }

                if (kiemSoDienThoaiArr.includes(name)) {
                    if (soDienThoaiHopLe(value, name, 10) === false) {
                        count++;
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
            });

            if (count === 0) {
                that.find('[name]').each(function () {
                    const that = $(this),
                        name = that.attr('name'),
                        type = that.attr('type');

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
                });

                let params = `?controller=admin&action=taikhoan`;

                $.ajax({
                    url: '/Web2/app/index.php' + params,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (isJson(data)) {
                            const json = JSON.parse(data);
                            $(`.${table}--show`).html(getHTML(table, json.data));
                        } else {
                            console.log(data);
                        }
                    },
                });
            }
        }

        /* 
            Update
         */
        if ($(`.${clas} [type='submit']`).val() == 'Sửa' && confirm('Thông tin có chính xác?')) {
            const fd = new FormData();
            let count = 0;

            fd.append('table', table);
            fd.append('action', 'update');

            that.find('[name]').each(function () {
                const that = $(this),
                    name = that.attr('name'),
                    value = that.val();

                if (kiemDiaChiArr.includes(name)) {
                    if (laDiaChi(value, name, 255) === false) {
                        count++;
                    }
                }

                if (kiemSoDienThoaiArr.includes(name)) {
                    if (soDienThoaiHopLe(value, name, 10) === false) {
                        count++;
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
                    url: '/Web2/app/index.php' + params,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (isJson(data)) {
                            const json = JSON.parse(data);
                            $(`.${table}--show`).html(getHTML(table, json.data));
                            $(`.${table}__add-content`).addClass('hidden');
                            alert('Updated');
                            if (table == 'taikhoan') {
                                location.reload();
                            }
                        } else {
                            console.log(data);
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
                url: '/Web2/app/index.php' + params,
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        let html = '';
                        switch (table) {
                            case 'taikhoan': {
                                html = taiKhoanHTML(json.data);
                                break;
                            }
                            case 'nhanvien': {
                                html = nhanVienHTML(json.data);
                                break;
                            }
                            case 'khachhang': {
                                html = khachHangHTML(json.data);
                                break;
                            }
                        }
                        $(`.${table}--show`).html(html);
                    } else {
                        console.log(data);
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
    const eleID = ele.getAttribute('class');
    const page = eleID.substr(eleID.indexOf('-') + 1, 1);
    const table = eleID.substring(0, eleID.indexOf('-'));
    const params = `?controller=admin&action=taikhoan&page=${page}`;
    $.ajax({
        url: '/Web2/app/index.php' + params,
        type: 'post',
        data: {
            table,
            action: 'get',
        },
        success: function (data) {
            if (isJson(data)) {
                const json = JSON.parse(data);
                const parent = ele.parentNode;
                parent.querySelector('.current-page').classList.remove('current-page');
                parent.querySelector(`.${table}-${page}`).classList.add('current-page');
                let html = '';
                switch (table) {
                    case 'taikhoan': {
                        html = taiKhoanHTML(json.data);
                        break;
                    }
                    case 'nhanvien': {
                        html = nhanVienHTML(json.data);
                        break;
                    }
                    case 'khachhang': {
                        html = khachHangHTML(json.data);
                        break;
                    }
                }
                $(`.${table}--show`).html(html);
            } else {
                console.log(data);
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
        const clas = ele.getAttribute('class');
        const str = clas.substr(0, clas.lastIndexOf('-'));
        const params = `?controller=admin&action=taikhoan`;
        let htmls = '';
        const id = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf('btn') - 1);

        switch (str) {
            case 'taikhoan': {
                const image = ele.parentNode.parentNode
                    .querySelector(`.taikhoan-${id}`)
                    .getAttribute('src');
                $.ajax({
                    url: '/Web2/app/index.php' + params,
                    type: 'post',
                    data: {
                        maTK: id,
                        anhDaiDien: image,
                        action: 'delete',
                        table: 'taikhoan',
                    },
                    success: function (data) {
                        if (isJson(data)) {
                            const json = JSON.parse(data);
                            if (!json.error) {
                                htmls = taiKhoanHTML(json.data.SPArr);
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
            case 'nhanvien':
                {
                    $.ajax({
                        url: '/Web2/app/index.php' + params,
                        type: 'post',
                        data: {
                            maNV: id,
                            action: 'delete',
                            table: 'nhanvien',
                        },
                        success: function (data) {
                            console.log(data);
                        },
                    });
                }
                break;
            case 'khachhang': {
                $.ajax({
                    url: '/Web2/app/index.php' + params,
                    type: 'post',
                    data: {
                        maKH: id,
                        action: 'delete',
                        table: 'khachhang',
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
                image.push(
                    document.querySelector(`.taikhoan-${element.value}`).getAttribute('src'),
                );
            }
        });
        if (id.length > 0) {
            const params = `?controller=admin&action=taikhoan`;
            let htmls = '';
            switch (str) {
                case 'taikhoan': {
                    $.ajax({
                        url: '/Web2/app/index.php' + params,
                        type: 'post',
                        data: {
                            maTK: id,
                            anhDaiDien: image,
                            action: 'delete',
                            table: 'taikhoan',
                        },
                        success: function (data) {
                            console.log(data);
                        },
                    });
                    break;
                }
                case 'nhanvien':
                    {
                        $.ajax({
                            url: '/Web2/app/index.php' + params,
                            type: 'post',
                            data: {
                                maNV: id,
                                action: 'delete',
                                table: 'nhanvien',
                            },
                            success: function (data) {
                                console.log(data);
                            },
                        });
                    }
                    break;
                case 'khachhang': {
                    $.ajax({
                        url: '/Web2/app/index.php' + params,
                        type: 'post',
                        data: {
                            maKH: id,
                            action: 'delete',
                            table: 'khachhang',
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

function getHTML(table, data) {
    switch (table) {
        case 'taikhoan': {
            return taiKhoanHTML(data);
        }
        case 'nhanvien': {
            return nhanVienHTML(data);
        }
        case 'khachhang': {
            return khachHangHTML(data);
        }
    }
    return null;
}
