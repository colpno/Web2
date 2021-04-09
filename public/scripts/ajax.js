function ajaxRequest(formID, action, type, placement) {
    $(`${formID}`).submit(function (e) {
        e.preventDefault();

        let that = $(this),
            formData = new FormData(),
            checkboxes = [],
            typeArr = ['file', 'checkbox', 'submit'];
        formData.append('action', action);

        that.find('[name]').each(function (i, value) {
            let that = $(this),
                name = that.attr('name'),
                type = that.attr('type');

            if (type == 'file') {
                let files = this.files[0];
                formData.append(name, files);
            }

            if (type == 'checkbox' && this.checked == true) {
                checkboxes.push(that.val());
                formData.append('checked_checkboxes', checkboxes);
            }

            if (!typeArr.includes(type)) {
                value = that.val();
                formData.append(name, value);
            }
        });

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
