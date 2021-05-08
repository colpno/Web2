$(document).ready(function () {
    const chiSoArr = [
            { name: 'tongTien', length: 10 },
            { name: 'donGiaGoc', length: 10 },
            { name: 'donGia', length: 10 },
            { name: 'thanhTien', length: 10 },
            { name: 'soLuong', length: 5 },
        ],
        kiemNgayArr = ['ngayNhap', 'ngayLapHoaDon'];

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
                if (table == 'chitietphieunhaphang') {
                    const soLuong = $(`.${table}__add-content [name='soLuong']`).val();
                    const donGiaGoc = $(`.${table}__add-content [name='donGiaGoc']`).val();
                    fd.append('thanhTien', soLuong * donGiaGoc);
                }

                that.find('[name]').each(function () {
                    const that = $(this),
                        name = that.attr('name'),
                        value = that.val() ? that.val() : that.text(),
                        type = that.attr('type');

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

                let params = `?controller=admin&action=nhapxuat`;

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

                                if (table == 'chitietphieunhaphang') {
                                    $.ajax({
                                        url: '/Web2/admin/app/index.php' + params,
                                        type: 'post',
                                        data: {
                                            table: 'phieunhaphang',
                                            action: 'get',
                                        },
                                        success: function (data) {
                                            if (isJson(data)) {
                                                const json = JSON.parse(data);
                                                if (json.data != null) {
                                                    $(`.phieunhaphang--show`).html(
                                                        getHTML('phieunhaphang', json.data),
                                                    );
                                                    $(`.phieunhaphang__row .paginate`).html(
                                                        renderPaginate('phieunhaphang', json.pages),
                                                    );
                                                }
                                            } else {
                                                alert(data);
                                            }
                                        },
                                    });
                                }
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
            const fd = new FormData();
            let count = 0;

            fd.append('table', table);
            fd.append('action', 'update');

            that.find('[name]').each(function () {
                const that = $(this),
                    name = that.attr('name'),
                    value = that.val();

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
                    } else {
                        fd.append(name, value);
                    }
                });

                const params = `?controller=admin&action=nhapxuat`;

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

                                if (table == 'chitietphieunhaphang') {
                                    $.ajax({
                                        url: '/Web2/admin/app/index.php' + params,
                                        type: 'post',
                                        data: {
                                            table: 'phieunhaphang',
                                            action: 'update',
                                        },
                                        success: function (data) {
                                            if (isJson(data)) {
                                                const json = JSON.parse(data);
                                                if (json.data != null) {
                                                    $(`.phieunhaphang--show`).html(
                                                        getHTML('phieunhaphang', json.data),
                                                    );
                                                }
                                            } else {
                                                alert(data);
                                            }
                                        },
                                    });
                                }
                                alert('Updated');
                            }
                        } else {
                            alert(data);
                        }
                    },
                });

                if (table == 'hoadon' || table == 'chitiethoadon') {
                    $(`.content-item__header .${table}--add`).addClass('hidden');
                }
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

        const filterCol = that.find('[name="filterCol"]').val();
        that.find('[name="from"],[name="to"]').each(function () {
            const that = $(this),
                name = that.attr('name'),
                value = that.val();

            switch (filterCol) {
                case 'ngayNhap':
                case 'ngayLapHoaDon': {
                    if (kiemNgay(value, name) === false) {
                        count++;
                    }
                    break;
                }
                default: {
                    if (chiSo(value, name, 10) === false) {
                        count++;
                    }
                    break;
                }
            }
        });

        if (count === 0) {
            that.find('[name]').each(function () {
                const that = $(this),
                    name = that.attr('name'),
                    val = that.val() != '' ? that.val() : that.text();

                fd.append(name, val);
            });

            const params = '?controller=admin&action=nhapxuat';

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
                        switch (table) {
                            case 'phieunhaphang': {
                                html = phieuNhapHangHTML(json.data);
                                break;
                            }
                            case 'chitietphieunhaphang': {
                                html = chiTietPhieuNhapHangHTML(json.data);
                                break;
                            }
                            case 'hoadon': {
                                html = hoaDonHTML(json.data);
                                break;
                            }
                            case 'chitiethoadon': {
                                html = chiTietHoaDonHTML(json.data);
                                break;
                            }
                        }
                        $(`.${table}--show`).html(html);
                        $(`.${table}__row .paginate`).html(renderPaginate(table, json.pages));
                    } else {
                        alert(data);
                    }
                },
            });
        }
    });

    $('#tinhTrangDon').on('change', function () {
        const that = $(this),
            value = that.val();

        if (value != '') {
            $.ajax({
                url: '/Web2/admin/app/index.php?controller=admin&action=nhapxuat',
                type: 'post',
                data: {
                    tinhTrang: value,
                    table: 'hoadon',
                    action: 'get',
                },
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        if (json.data != null) {
                            $('.hoadon--show').html(getHTML('hoadon', json.data));
                        }
                    } else {
                        alert(data);
                    }
                },
            });
        } else {
            $.ajax({
                url: '/Web2/admin/app/index.php?controller=admin&action=nhapxuat',
                type: 'post',
                data: {
                    table: 'hoadon',
                    action: 'get',
                },
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        if (json.data != null) {
                            $('.hoadon--show').html(getHTML('hoadon', json.data));
                        }
                    } else {
                        alert(data);
                    }
                },
            });
        }
    });

    const toggleAddContents = ['phieunhaphang', 'chitietphieunhaphang', 'hoadon', 'chitiethoadon'];
    toggleAddContents.forEach((element) => {
        $(`.${element}--add:not(.hidden)`).on('click', function () {
            if (element == toggleAddContents[2] || element == toggleAddContents[3]) {
                $(`.${element}__add-content [type="submit"]`).val('Sửa');
            } else {
                $(`.${element}__add-content [type="submit"]`).val('Thêm');
            }

            $(`.${element}__add-content`)
                .find('[name]')
                .each(function () {
                    $(this).val('');
                });

            $(`.${element}__add-content`).toggleClass('hidden');
        });
    });

    const toggleFilterContents = [
        'phieunhaphang',
        'chitietphieunhaphang',
        'hoadon',
        'chitiethoadon',
    ];
    toggleFilterContents.forEach((element) => {
        $(`.${element}--filter`).on('click', function () {
            $(`.${element}__filter-content`).toggleClass('hidden');
        });
    });
});

function ajaxOpenDetail(ele) {
    const clas = ele.getAttribute('class');
    const ID = clas.substring(clas.indexOf('-') + 1, clas.indexOf(' '));
    const general = clas.substring(0, clas.indexOf('-'));
    let col = '';
    switch (general) {
        case 'phieunhaphang': {
            col = 'maPhieu';
            break;
        }
        case 'hoadon': {
            col = 'maHD';
            break;
        }
    }

    const url = window.location.href,
        uri = url.substring(url.indexOf('admin/')),
        params = `?controller=admin&action=nhapxuat`;

    $.ajax({
        url: '/Web2/admin/app/index.php' + params,
        type: 'post',
        data: {
            table: `chitiet${general}`,
            id: ID,
            col,
            action: 'get',
        },
        success: function (data) {
            if (isJson(data) && JSON.parse(data).data.length > 0) {
                const json = JSON.parse(data);
                if (json.data != null) {
                    $(`.chitiet${general}--show`).html(getHTML(`chitiet${general}`, json.data));
                    $(`.chitiet${general}__row .paginate`).html(
                        renderPaginate(`chitiet${general}`, json.pages),
                    );
                }
            } else {
                $(`.chitiet${general}--show`).html(`
                        <div style="display:flex;align-items: center;justify-content: center;height: 200px;">
                            <h1>Trống</h1>
                        </div>
                `);
                $(`.chitiet${general}__row .content-item__pagination`).html('');
            }
        },
    });

    ['add', 'filter'].forEach((element) => {
        $(`.chitiet${general}__${element}-content`)
            .find('[class="hidden"]')
            .each(function () {
                const that = $(this),
                    text = that.val();
                if (text != ID) {
                    that.remove();
                }
            });
        if (general == 'phieunhaphang') {
            $(`.chitietphieunhaphang__${element}-content`).append(
                `<input type="text" class="hidden" name="maPhieu">`,
            );
            $(`.chitietphieunhaphang__${element}-content [name='maPhieu']`).text(ID);
        } else {
            $(`.chitiethoadon__${element}-content`).append(
                `<input type="text" class="hidden" name="maHD">`,
            );
            $(`.chitiethoadon__${element}-content [name='maHD']`).text(ID);
        }
    });
}

function ajaxPaginate(ele) {
    const eleID = ele.getAttribute('class'),
        page = eleID.substr(eleID.indexOf('-') + 1, 1),
        table = eleID.substring(0, eleID.indexOf('-')),
        href = window.location.href,
        fd = new FormData();

    fd.append('table', table);
    fd.append('action', 'get');

    let params = `?controller=admin&action=nhapxuat&page=${page}&`;
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
                switch (table) {
                    case 'phieunhaphang': {
                        const html = phieuNhapHangHTML(json.data);
                        $('.phieunhaphang--show').html(html);
                        break;
                    }
                    case 'chitietphieunhaphang': {
                        const html = chiTietPhieuNhapHangHTML(json.data);
                        $('.chitietphieunhaphang--show').html(html);
                        break;
                    }
                    case 'hoadon': {
                        const html = hoaDonHTML(json.data);
                        $('.hoadon--show').html(html);
                        break;
                    }
                    case 'chitiethoadon': {
                        const html = chiTietHoaDonHTML(json.data);
                        $('.chitiethoadon--show').html(html);
                        break;
                    }
                }
            } else {
                alert(data);
            }
        },
    });
}

function ajaxCapNhatHoaDon(ele) {
    const that = $(ele),
        clas = that.attr('class'),
        maHD = clas.substring(clas.lastIndexOf('-') + 1),
        tinhTrang = ele.checked == true ? 1 : 0;

    $.ajax({
        url: '/Web2/admin/app/index.php?controller=admin&action=nhapxuat',
        type: 'post',
        data: {
            table: 'hoadon',
            action: 'capNhatTinhTrang',
            maHD,
            tinhTrang,
        },
        success: function (data) {
            if (isJson(data)) {
                const json = JSON.parse(data);
                console.log(json);
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
                text = that.val();
            if (text != id) {
                that.remove();
            }
        });

    switch (table) {
        case 'phieunhaphang': {
            const maNCC = $(`.${table}--show .hidden.maNCC.row-${id}`).text(),
                maNV = $(`.${table}--show .hidden.maNV.row-${id}`).text();

            $(`.${table}__add-content`).append(
                `<input class="hidden" name="maPhieu" type="text" value="${id}">`,
                `<input class="hidden" name="maNCC" type="text" value="${maNCC}">`,
                `<input class="hidden" name="maNV" type="text" value="${maNV}">`,
            );

            break;
        }
        case 'chitietphieunhaphang': {
            const maPhieu = $(`.${table}--show .hidden.maPhieu.row-${id}`).text();

            $(`.${table}__add-content`).append(
                `<input class="hidden" value="${id}" name="maSP" type="text">`,
                `<input class="hidden" value="${maPhieu}" name="maPhieu" type="text">`,
            );

            break;
        }
        case 'hoadon': {
            const maNV = $(`.${table}--show .hidden.maNV.row-${id}`).text(),
                maKH = $(`.${table}--show .hidden.maKH.row-${id}`).text();

            $(`.${table}__add-content`).append(
                `<input class="hidden" value="${id}" name="maHD" type="text">`,
                `<input class="hidden" value="${maNV}" name="maNV" type="text">`,
                `<input class="hidden" value="${maKH}" name="maKH" type="text">`,
            );

            break;
        }
        case 'chitiethoadon': {
            const maHD = $(`.${table}--show .hidden.maHD.row-${id}`).text();

            $(`.${table}__add-content`).append(
                `<input class="hidden" value="${id}" name="maSP" type="text">`,
                `<input class="hidden" value="${maHD}" name="maHD" type="text">`,
            );

            break;
        }
    }

    if ($(href).hasClass('hidden')) {
        $(href).removeClass('hidden');
    }
    if ($(`.content-item__header .${table}--add`).hasClass('hidden')) {
        $(`.content-item__header .${table}--add`).removeClass('hidden');
    }

    $(`.${table}__add-content [type='submit']`).val('Sửa');
}

function ajaxDeleteOne(ele) {
    if (window.confirm('Chắc chắn muốn xóa?')) {
        const clas = ele.getAttribute('class');
        const str = clas.substr(0, clas.lastIndexOf('-'));
        const params = '?controller=admin&action=nhapxuat';
        let htmls = '';
        const id = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf('btn') - 1),
            fd = new FormData();

        fd.append('action', 'delete');
        fd.append('table', str);

        switch (str) {
            case 'phieunhaphang': {
                fd.append('maPhieu', id);
                break;
            }
            case 'chitietphieunhaphang':
                {
                    const maPhieu = document.querySelectorAll(
                        '.chitietphieunhaphang__add-content .hidden',
                    )[0].textContent;
                    fd.append('maPhieu', maPhieu);
                    fd.append('maSP', id);
                }
                break;
            case 'hoadon': {
                fd.append('maHD', id);
                break;
            }
            case 'chitiethoadon': {
                const maHD = $(`.${str}__add-content [name='maHD']`).val();
                fd.append('maHD', maHD);
                fd.append('maSP', id);
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

                        if (str == 'chitietphieunhaphang') {
                            $.ajax({
                                url: '/Web2/admin/app/index.php' + params,
                                type: 'post',
                                data: {
                                    table: 'phieunhaphang',
                                    action: 'get',
                                },
                                success: function (data) {
                                    if (isJson(data)) {
                                        const json = JSON.parse(data);
                                        if (json.data != null) {
                                            $(`.phieunhaphang--show`).html(
                                                getHTML('phieunhaphang', json.data),
                                            );
                                            $(`.phieunhaphang__row .paginate`).html(
                                                renderPaginate('phieunhaphang', json.pages),
                                            );
                                        }
                                    } else {
                                        alert(data);
                                    }
                                },
                            });
                        }
                    }
                } else {
                    $('body').append(data);
                    alert(data);
                }
            },
        });
    }
}

function ajaxMultiDel(ele) {
    const clas = ele.getAttribute('class');
    const str = clas.substr(0, clas.indexOf('--'));
    const masterCheckbox = document.querySelector(`.${str}__master-checkbox`);
    const checkboxes = document.querySelectorAll(`.${str}__checkbox`);
    const fd = new FormData();
    let table = '',
        id = [];

    if (window.confirm('Chắc chắn muốn xóa?')) {
        fd.append('table', str);
        fd.append('action', 'delete');

        checkboxes.forEach((element) => {
            if (element.checked == true) {
                id.push(element.value);
            }
        });
        if (id.length > 0) {
            const params = '?controller=admin&action=nhapxuat';
            let htmls = '';
            switch (str) {
                case 'phieunhaphang': {
                    fd.append('maPhieu', id);
                    break;
                }
                case 'chitietphieunhaphang':
                    {
                        const maPhieu = $(`.row-${id[0]}.maPhieu`).text();
                        fd.append('maPhieu', maPhieu);
                        fd.append('maSP', id);
                    }
                    break;
                case 'hoadon': {
                    fd.append('maHD', id);
                    break;
                }
                case 'chitiethoadon': {
                    const maHD = $(`.${str}__add-content [name='maHD']`).val();
                    fd.append('maHD', maHD);
                    fd.append('maSP', id);
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

                            if (str == 'chitietphieunhaphang') {
                                $.ajax({
                                    url: '/Web2/admin/app/index.php' + params,
                                    type: 'post',
                                    data: {
                                        table: 'phieunhaphang',
                                        action: 'get',
                                    },
                                    success: function (data) {
                                        if (isJson(data)) {
                                            const json = JSON.parse(data);
                                            if (json.data != null) {
                                                $(`.phieunhaphang--show`).html(
                                                    getHTML('phieunhaphang', json.data),
                                                );
                                                $(`.phieunhaphang__row .paginate`).html(
                                                    renderPaginate('phieunhaphang', json.pages),
                                                );
                                            }
                                        } else {
                                            alert(data);
                                        }
                                    },
                                });
                            }
                        }
                    } else {
                        alert(data);
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
    }
    return null;
}
