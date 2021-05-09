$(document).ready(function () {
    const kiemSoDienThoaiArr = ['soDienThoai'],
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

                let params = `?controller=admin&action=doitac`;

                $.ajax({
                    url: '/Web2/admin/app/index.php' + params,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (isJson(data) && data != null) {
                            const json = JSON.parse(data);
                            if (json.data != null) {
                                $(`.${table}--show`).html(getHTML(table, json.data));
                                $(`.${table}__row .paginate`).html(
                                    renderPaginate(table, json.pages),
                                );
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

                const params = `?controller=admin&action=doitac`;

                $.ajax({
                    url: '/Web2/admin/app/index.php' + params,
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (isJson(data) && data != null && data != null) {
                            const json = JSON.parse(data);
                            if (json.data != null) {
                                $(`.${table}--show`).html(getHTML(table, json.data));
                                $(`.${table}__add-content`).addClass('hidden');
                                alert('Updated');
                            }
                        } else {
                            alert(data);
                        }
                    },
                });
            }
        }
    });

    const toggleAddContents = ['nhacungcap', 'nhasanxuat'];
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
});

function ajaxPaginate(ele) {
    const eleID = ele.getAttribute('class'),
        page = eleID.substr(eleID.indexOf('-') + 1, 1),
        table = eleID.substring(0, eleID.indexOf('-')),
        href = window.location.href,
        fd = new FormData();

    fd.append('table', table);
    fd.append('action', 'get');

    let params = `?controller=admin&action=doitac&page=${page}&`;
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
            if (isJson(data) && data != null) {
                const json = JSON.parse(data);
                const parent = ele.parentNode;
                parent.querySelector('.current-page').classList.remove('current-page');
                parent.querySelector(`.${table}-${page}`).classList.add('current-page');
                let html = '';
                if (json.data != null) {
                    $(`.${table}--show`).html(getHTML(table, json.data));
                }
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
                text = that.text();
            if (text != id) {
                that.remove();
            }
        });

    switch (table) {
        case 'nhacungcap': {
            $(`.${table}__add-content`).append(
                `<input class="hidden" name="maNCC" type="text" value="${id}">`,
            );

            break;
        }
        case 'nhasanxuat': {
            $(`.${table}__add-content`).append(
                `<input class="hidden" value="${id}" name="maNSX" type="text">`,
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
            params = `?controller=admin&action=doitac`,
            id = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf('btn') - 1),
            fd = new FormData();

        fd.append('action', 'delete');
        fd.append('table', str);

        switch (str) {
            case 'nhacungcap': {
                fd.append('maNCC', id);
                break;
            }
            case 'nhasanxuat': {
                fd.append('maNSX', id);
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
                if (isJson(data) && data != null) {
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

        fd.append('action', 'delete');
        fd.append('table', str);

        checkboxes.forEach((element) => {
            if (element.checked == true) {
                id.push(element.value);
                image.push(
                    document.querySelector(`.nhacungcap-${element.value}`).getAttribute('src'),
                );
            }
        });
        if (id.length > 0) {
            const params = `?controller=admin&action=doitac`;
            switch (str) {
                case 'nhacungcap': {
                    fd.append('maNCC', id);
                    break;
                }
                case 'nhasanxuat': {
                    fd.append('maNSX', id);
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
                    if (isJson(data) && data != null) {
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
        } else {
            alert('Chọn ít nhất 1 phần tử');
        }
    }
}
