function ajaxRequest(formID, action, type, placement) {
    $(`${formID}`).submit(function (e) {
        e.preventDefault();

        let that = $(this),
            formData = new FormData(),
            checkboxes = [],
            radios = [],
            imgPath = [],
            input = [],
            typeArr = ['file', 'checkbox', 'submit'];
        formData.append('action', action);

        that.find('[name]').each(function (i, value) {
            let that = $(this),
                name = that.attr('name'),
                type = that.attr('type');

            if (type == 'file') {
                formData.append('anhDaiDien', this.files[0]);
            }

            if (this.tagName == 'IMG' && imgPath.length == 0) {
                imgPath.push(that.attr('src'));
            }

            if (type == 'checkbox' && this.checked == true) {
                checkboxes.push(that.val());
                formData.append(name, checkboxes);
            }

            if (type == 'radio' && this.checked == true) {
                radios.push(that.val());
                formData.append(name, radios);
            }

            if (!typeArr.includes(type)) {
                formData.append(name, that.val());
            }
        });
        formData.append('anhDaiDien', imgPath);

        let url = window.location.href;
        let params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';

        $.ajax({
            url: 'app/index.php' + params,
            type,
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $(`${placement}`).html(data);
            },
        });
    });
}
