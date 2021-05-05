$(document).ready(function () {
    const chiChuVaKhoangTrangArr = ['tenSP', 'tenLoai'],
        chiSoArr = [
            { name: 'donGia', length: 10 },
            { name: 'soLuong', length: 10 },
        ],
        kiemNgayArr = ['ngayBatDau', 'ngayKetThuc'];

    $('.add-content').submit(function (e) {
        e.preventDefault();

        const that = $(this),
            clas = that.attr('class').replace(' ', '.'),
            table = clas.substring(clas.lastIndexOf('.') + 1, clas.lastIndexOf('__'));

        /* 
            Add
        */
        if ($(`.${clas} [type='submit']`).val() == 'Thêm' && confirm('Thông tin có chính xác?')) {
            $(`.chitiet${clas}__add-content`)
                .find('[class="hidden"]')
                .each(function () {
                    const that = $(this);
                    that.remove();
                });

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
                        type = that.attr('type'),
                        value = that.val();

                    if (type == 'file') {
                        const files = this.files[0];
                        fd.append(name, files);
                    } else if (type == 'checkbox' && this.checked == true) {
                        checkboxes.push(value);
                        fd.append('checked_checkboxes', checkboxes);
                    } else if (type == 'radio' && this.checked == true) {
                        radios.push(value);
                        fd.append('checked_radios', radios);
                    } else {
                        fd.append(name, value);
                    }
                });

                let params = `?controller=admin&action=sanpham`;

                $.ajax({
                    url: '/Web2/admin/app/index.php' + params,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (isJson(data)) {
                            const json = JSON.parse(data);
                            // $(`.${table}--show`).html(getHTML(table, json.data));
                            console.log(json);
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

            const params = `?controller=admin&action=sanpham`;

            $.ajax({
                url: '/Web2/admin/app/index.php' + params,
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
                        if (table == 'sanpham') {
                            location.reload();
                        }
                    } else {
                        console.log(data);
                    }
                },
            });
        }
    });

    /* 
        Filter
     */
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
            const filterCol = '',
                from = '',
                to = '';

            that.find('[name]').each(function () {
                const that = $(this),
                    name = that.attr('name'),
                    val = that.val();

                fd.append(name, val);

                if (name == 'filterCol') {
                    filterCol = val;
                }
                if (name == 'from') {
                    from = val;
                }
                if (name == 'to') {
                    to = val;
                }
            });

            const params = `?controller=admin&action=sanpham&filterCol=${filterCol}&from=${from}&to=${to}&page=1`;

            $.ajax({
                url: '/Web2/admin/app/index.php' + params,
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
    });

    const toggleAddContents = ['sanpham', 'loai'];
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

    const toggleFilterContents = ['sanpham'];
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
        parent = ele.parentNode,
        params = `?controller=admin&action=sanpham&page=${page}`;

    $.ajax({
        url: '/Web2/admin/app/index.php' + params,
        type: 'post',
        data: {
            table,
            action: 'get',
        },
        success: function (data) {
            if (isJson(data)) {
                const json = JSON.parse(data);
                parent.querySelector('.current-page').classList.remove('current-page');
                parent.querySelector(`.${table}-${page}`).classList.add('current-page');
                $(`.${table}--show`).html(getHTML(table, json.data));
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
        case 'sanpham': {
            $(`.${table}--show .row-${id}`).each(function () {
                const that = $(this),
                    val = that.text() != '' ? that.text() : that.val();

                if (that.hasClass('donGia')) {
                    money = val.substring(0, val.indexOf(' '));
                    $(`${href} [name='donGia']`).val(money);

                    unit = val.substring(val.indexOf(' ') + 1);
                    $(`${href} [name='donViTinh']`).val(unit);
                }
            });

            $(`.${table}__add-content`).append(
                `<input class="hidden" name="maSP" type="text" value="${id}">`,
            );

            break;
        }
        case 'loai': {
            $(`.${table}__add-content`).append(
                `<input class="hidden" value="${id}" name="maLoai" type="text">`,
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
            table = clas.substr(0, clas.lastIndexOf('-')),
            params = `?controller=admin&action=sanpham`,
            id = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf('btn') - 1),
            fd = new FormData();

        switch (table) {
            case 'sanpham': {
                const anhDaiDien = document.querySelector(`.sanpham-${id}`).getAttribute('src');
                fd.append('maSP', id);
                fd.append('anhDaiDien', anhDaiDien);
                break;
            }
            case 'loai': {
                fd.append('maLoai', id);
                break;
            }
        }
        fd.append('action', 'delete');
        fd.append('table', table);

        $.ajax({
            url: '/Web2/admin/app/index.php' + params,
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

function ajaxMultiDel(ele) {
    if (window.confirm('Chắc chắn muốn xóa?')) {
        const clas = ele.getAttribute('class'),
            table = clas.substr(0, clas.indexOf('--')),
            masterCheckbox = document.querySelector(`.${table}__master-checkbox`),
            checkboxes = document.querySelectorAll(`.${table}__checkbox`),
            fd = new FormData();

        let id = [],
            anhDaiDien = [];

        checkboxes.forEach((element) => {
            if (element.checked == true) {
                id.push(element.value);
                if (table == 'sanpham') {
                    anhDaiDien.push(
                        document.querySelector(`.sanpham-${element.value}`).getAttribute('src'),
                    );
                }
            }
        });

        switch (table) {
            case 'sanpham': {
                fd.append('maSP', id);
                fd.append('anhDaiDien', anhDaiDien);
                break;
            }
            case 'loai': {
                fd.append('maLoai', id);
                break;
            }
        }
        fd.append('action', 'delete');
        fd.append('table', table);

        if (id.length > 0) {
            const params = `?controller=admin&action=sanpham`;
            $.ajax({
                url: '/Web2/admin/app/index.php' + params,
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
        } else {
            alert('Chọn ít nhất 1 phần tử');
        }
    }
}

function getHTML(table, data) {
    switch (table) {
        case 'sanpham': {
            return sanPhamHTML(data);
        }
        case 'loai': {
            return loaiHTML(data);
        }
    }
    return null;
}
