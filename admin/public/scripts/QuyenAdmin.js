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

        that.find('[name]').each(function () {
            const that = $(this),
                name = that.attr('name'),
                value = that.val();

            if (chiChuVaKhoangTrangArr.includes(name)) {
                if (chiChuVaKhoangTrang(value, name, 255) === true) {
                    fd.append(name, value);
                }
            }
        });

        $.ajax({
            url: '/Web2/admin/app/index.php?controller=admin&action=quyen',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function (data) {
                if (isJson(data)) {
                    const json = JSON.parse(data);
                } else {
                    console.log(data);
                }
            },
        });
    });

    $('#sua-quyenchucnang').on('submit', function (e) {
        e.preventDefault();

        const that = $(this),
            clas = that.attr('id'),
            table = clas.substring(clas.lastIndexOf('-') + 1);

        for (let i = 1; i < 4; i++) {
            const checkbox = [],
                fd = new FormData();

            fd.append('table', table);
            fd.append('action', 'update');

            that.find(`[class="maQuyen-${i}"]`).each(function () {
                const that = $(this);

                fd.append('maQuyen', i);

                that.parent()
                    .parent()
                    .find('[name="maCN"]')
                    .each(function () {
                        const that = $(this),
                            value = that.val();

                        if (that[0].checked == true) {
                            checkbox.push(value);
                        }
                    });
            });
            fd.append('maCN', checkbox);

            $.ajax({
                url: '/Web2/admin/app/index.php?controller=admin&action=quyen',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (isJson(data)) {
                        const json = JSON.parse(data);
                        
                    } else {
                        console.log(data);
                    }
                },
            });    
        }
        alert("Sửa phân quyền thành công!");
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
    $(`.quyen-${ele.value}`).removeClass('hidden');

    const element = $(`[name="maQuyen"]`);
    for (let i = 0; i < element.length; i++) {
        if (element[i].checked == false) {
            $(`.quyen-${i + 1}`).addClass('hidden');
        }
    }
}
