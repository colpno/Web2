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
                    url: '/Web2/app/index.php' + params,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (isJson(data)) {
                            const json = JSON.parse(data);
                            $(`.${table}--show`).html(getHTML(table, json.data));

                            if (table == 'chitietphieunhaphang') {
                                $.ajax({
                                    url: '/Web2/app/index.php' + params,
                                    type: 'post',
                                    data: {
                                        table: 'phieunhaphang',
                                        action: 'get',
                                    },
                                    success: function (data) {
                                        if (isJson(data)) {
                                            const json = JSON.parse(data);
                                            $(`.phieunhaphang--show`).html(
                                                getHTML('phieunhaphang', json.data),
                                            );
                                        } else {
                                            console.log(data);
                                        }
                                    },
                                });
                            }
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

                            if (table == 'chitietphieunhaphang') {
                                $.ajax({
                                    url: '/Web2/app/index.php' + params,
                                    type: 'post',
                                    data: {
                                        table: 'phieunhaphang',
                                        action: 'get',
                                    },
                                    success: function (data) {
                                        if (isJson(data)) {
                                            const json = JSON.parse(data);
                                            $(`.phieunhaphang--show`).html(
                                                getHTML('phieunhaphang', json.data),
                                            );
                                        } else {
                                            console.log(data);
                                        }
                                    },
                                });
                            }
                            alert('Updated');
                        } else {
                            console.log(data);
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

        if (count === 0) {
            that.find('[name]').each(function () {
                const that = $(this),
                    name = that.attr('name'),
                    val = that.val();

                fd.append(name, val);
            });

            const params = '?controller=admin&action=nhapxuat';

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
                    } else {
                        console.log(data);
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
        url: '/Web2/app/index.php' + params,
        type: 'post',
        data: {
            table: `chitiet${general}`,
            id: ID,
            col,
            action: 'get',
        },
        success: function (data) {
            if (isJson(data)) {
                const json = JSON.parse(data);
                let html = '';
                switch (general) {
                    case 'phieunhaphang': {
                        html = chiTietPhieuNhapHangHTML(json.data);
                        break;
                    }
                    case 'hoadon': {
                        html = chiTietHoaDonHTML(json.data);
                        break;
                    }
                }
                $(`.chitiet${general}--show`).html(html);

                let page = `
                    <div>
                        <ul class="text-center center paginate">
                            <li class="chitiet${general}-first"></li>
                            <li class="chitiet${general}-prev"></li>
                `;
                for (let i = 1; i <= json.pages; i++) {
                    if (i == 1)
                        page += `<li onclick="paginate(this)" class="chitiet${general}-1 current-page">${i}</li>`;
                    else
                        page += `<li onclick="paginate(this)" class="chitiet${general}-${i}">${i}</li>`;
                }
                page += `
                            <li class="chitiet${general}-next"></li>
                            <li class="chitiet${general}-last"></li>
                        </ul>
                    </div>
                `;
                $(`.chitiet${general}__row .content-item__pagination`).html(page);
            } else {
                console.log(data);
                $(`.chitiet${general}--show`).html(`
                        <div style="display:flex;align-items: center;justify-content: center;height: 200px;">
                            <h1>Empty</h1>
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
            $(`.chitietphieunhaphang__${element}-content [name='maPhieu']`).text(ID);
        }
    });
}

function ajaxPaginate(ele) {
    const eleID = ele.getAttribute('class');
    const page = eleID.substr(eleID.indexOf('-') + 1, 1);
    const table = eleID.substring(0, eleID.indexOf('-'));
    const params = `?controller=admin&action=nhapxuat&page=${page}`;
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
            url: '/Web2/app/index.php' + params,
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                if (isJson(data)) {
                    const json = JSON.parse(data);
                    $(`.${str}--show`).html(getHTML(str, json.data));

                    if (str == 'chitietphieunhaphang') {
                        $.ajax({
                            url: '/Web2/app/index.php' + params,
                            type: 'post',
                            data: {
                                table: 'phieunhaphang',
                                action: 'get',
                            },
                            success: function (data) {
                                if (isJson(data)) {
                                    const json = JSON.parse(data);
                                    $(`.phieunhaphang--show`).html(
                                        getHTML('phieunhaphang', json.data),
                                    );
                                } else {
                                    console.log(data);
                                }
                            },
                        });
                    }
                } else {
                    $('body').append(data);
                    console.log(data);
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
                        const maPhieu = $(`.${str}__add-content [name='maPhieu']`).val();
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
                url: '/Web2/app/index.php' + params,
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        $(`.${str}--show`).html(getHTML(json.data));

                        if (str == 'chitietphieunhaphang') {
                            $.ajax({
                                url: '/Web2/app/index.php' + params,
                                type: 'post',
                                data: {
                                    table: 'phieunhaphang',
                                    action: 'get',
                                },
                                success: function (data) {
                                    if (isJson(data)) {
                                        const json = JSON.parse(data);
                                        $(`.phieunhaphang--show`).html(
                                            getHTML('phieunhaphang', json.data),
                                        );
                                    } else {
                                        console.log(data);
                                    }
                                },
                            });
                        }
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
