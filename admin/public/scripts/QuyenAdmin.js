$(document).ready(function () {
    const chiChuVaKhoangTrangArr = ['tenQuyen', 'tenCN'];

    $('.add-content').on('submit', function (e) {
        e.preventDefault();

        const that = $(this),
            clas = that.attr('class'),
            table = clas.substring(clas.lastIndexOf(' ') + 1, clas.lastIndexOf('__')),
            fd = new FormData();

        fd.append('table', table);
        fd.append('action', 'add');

        let isValid = false;

        that.find('[name]').each(function () {
            const that = $(this),
                name = that.attr('name'),
                value = that.val();

            if (chiChuVaKhoangTrangArr.includes(name)) {
                if (chiChuVaKhoangTrang(value, name, 255) === true) {
                    fd.append(name, value);
                    isValid = true;
                }
            }
        });

        if (isValid == true) {
            $.ajax({
                url: '/Web2/admin/app/index.php?controller=admin&action=quyen',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (isJson(data) && data != null) {
                        location.reload();
                    } else {
                        alert(data);
                    }
                },
            });
        }
    });

    $('#sua-phanquyenchucnang').on('submit', function (e) {
        e.preventDefault();

        const that = $(this),
            clas = that.attr('id'),
            table = clas.substring(clas.lastIndexOf('-') + 1),
            length = $('.section').length;

        for (let i = 1; i <= length; i++) {
            const checkbox = [],
                fd = new FormData();

            fd.append('table', 'quyenchucnang');
            fd.append('action', 'update');

            that.find(`[class="maQuyen-${i}"]`).each(function () {
                fd.append('maQuyen', i);

                $(`.phanquyen-${i}`)
                    .find('[name="maCN"]')
                    .each(function () {
                        const that = $(this),
                            value = that.val();

                        if (that[0].checked == true) {
                            checkbox.push(value);
                        }
                    });
                fd.append('maCN', checkbox);
            });

            $.ajax({
                url: '/Web2/admin/app/index.php?controller=admin&action=quyen',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (isJson(data) && data != null) {
                    } else {
                        alert(data);
                    }
                },
            });
        }
        alert('Sửa phân quyền thành công!');
    });

    const toggleAddContents = ['quyen', 'chucnang'];
    toggleAddContents.forEach((element) => {
        $(`.${element}--add`).on('click', function () {
            $(`.${element}__add-content`)
                .find('[name]')
                .each(function () {
                    $(this).val('');
                });

            $(`.${element}__add-content`).toggleClass('hidden');
        });
    });
});

function ajaxChonQuyen(ele) {
    const element = $(`.chonChucNang`);
    for (let i = 0; i < element.length; i++) {
        element[i].classList.add('hidden');
    }

    $(`.phanquyen-${ele.value}`).removeClass('hidden');
}

function ajaxDeleteOne(ele) {
    if (confirm('Chắc chắn muốn xóa?')) {
        const that = $(ele),
            clas = that.attr('class'),
            table = clas.substring(0, clas.indexOf('-')),
            id = clas.substring(clas.lastIndexOf('-') + 1, clas.lastIndexOf('btn') - 1),
            fd = new FormData();

        fd.append('action', 'delete');
        fd.append('table', table);
        switch (table) {
            case 'quyen': {
                fd.append('maQuyen', id);
                break;
            }
            case 'chucnang': {
                fd.append('maCN', id);
                break;
            }
        }

        $.ajax({
            url: '/Web2/admin/app/index.php?controller=admin&action=quyen',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                if (isJson(data) && data != null) {
                    location.reload();
                } else {
                    alert(data);
                }
            },
        });
    }
}
