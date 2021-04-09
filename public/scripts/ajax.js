function ajaxRequest(formID, action, type, placement) {
    $(`${formID}`).submit(function (e) {
        e.preventDefault();

        let that = $(this),
            formData = new FormData(),
            data = {};

        that.find('[name]').each(function (i, value) {
            let that = $(this),
                name = that.attr('name'),
                type = that.attr('type');

            if (type == 'file') {
                let files = $('#uploadImage')[0].files[0];
                formData.append(name, files);
            }

            console.log(value);
            if (type != 'submit' && type != 'file') {
                value = that.val();
                formData.append(name, value);
                data[name] = value;
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
                // $(`${placement}`).html(data);
                $('#preview').html(data);
            },
        });
    });
}
