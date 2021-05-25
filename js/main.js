var regex_address =
    /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\d\/\,]+$/;
var regex_id = /^[a-zA-Z\d]+$/i;
var regex_name =
    /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+$/;
var regex_phone = /^[0]\d{9}$/;
var regex_mail = /^([a-zA-Z\d\.]{6,30})\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var regex_cmnd = /^\d{9}$|^\d{12}$/;
var regex_pass =
    /^([a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\d\s\W]{4,8})+$/;
var regex_search =
    /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂẾưăạảấầẩẫậắằẳẵặẹẻẽềềểếỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s\d]+$/;

function validate() {
    var bool = true;
    var x = document.getElementById('register__id').value;
    var y = document.getElementById('register__name').value;
    var z = document.getElementById('register__phone').value;
    var t = document.getElementById('register__mail').value;

    if (!regex_id.test(x)) {
        document.getElementById('id-error-message').innerHTML =
            'Mã SV phải theo dạng: SVxxxx với x là số';
        document.getElementById('id-error-message').style.display = 'block';
        bool = false;
    } else {
        document.getElementById('id-error-message').style.display = 'none';
    }
    if (!regex_name.test(y)) {
        document.getElementById('name-error-message').innerHTML = 'Không nhập số và ký tự đặc biệt';
        document.getElementById('name-error-message').style.display = 'block';
        bool = false;
    } else {
        document.getElementById('name-error-message').style.display = 'none';
    }
    if (!regex_phone.test(z)) {
        document.getElementById('phone-error-message').innerHTML = 'Chỉ nhập số và đủ 10 số';
        document.getElementById('phone-error-message').style.display = 'block';
        bool = false;
    } else {
        document.getElementById('phone-error-message').style.display = 'none';
    }
    if (!regex_mail.test(t)) {
        document.getElementById('mail-error-message').innerHTML =
            'Mail có dạng: X@MaMien với X chỉ nhập 6-30 ký tự được phép nhập chữ,số,(.)';
        document.getElementById('mail-error-message').style.display = 'block';
        bool = false;
    } else {
        document.getElementById('mail-error-message').style.display = 'none';
    }
    return bool;
}

function closetab(name) {
    document.getElementById(name).style.display = 'none';
    $('input[name=userregister]').html('');
    $('input[name=passregister]').html('');
    $('input[name=horegister]').html('');
    $('input[name=tenregister]').html('');
    $('input[name=phoneregister]').html('');
    $('input[name=userlogin]').html('');
    $('input[name=passlogin]').html('');
    $('#form-register-tk').html('');
    $('#form-register-matkhau').html('');
    $('#form-register-hoten').html('');
    $('#form-register-sodienthoai').html('');
    $('#form-register-success').html('');
    $('#form-login-tk').html('');
    $('#form-login-matkhau').html('');
    $('#form-login-success').html('');
}

function opentab(name) {
    document.getElementById(name).style.display = 'flex';
}

function register() {
    document.getElementById('btn-form').style.left = '126px';
    document.getElementById('login').style.left = '-380px';
    document.getElementById('register').style.left = '30px';
}
function login() {
    document.getElementById('btn-form').style.left = '0px';
    document.getElementById('login').style.left = '30px';
    document.getElementById('register').style.left = '380px';
}

function openfilter() {
    document.getElementById('filter-tab').style.top = '0%';
}
function closefilter() {
    document.getElementById('filter-tab').style.top = '100%';
}

function prevNumber() {
    var sl = Number(document.getElementsByClassName('cart-list-input__text')[0].value);
    if (sl > 1) {
        sl -= 1;
    }
    document.getElementsByClassName('cart-list-input__text')[0].value = sl;
}
function inputnumber(x) {
    var sl = Number(document.getElementsByClassName('cart-list-input__text')[0].value);
    if (sl > x) {
        sl = x;
        alert('Số lượng còn ' + x);
    }
    if (sl < 1) {
        sl = 1;
    }
    document.getElementsByClassName('cart-list-input__text')[0].value = sl;
}
function nextNumber(x) {
    var sl = Number(document.getElementsByClassName('cart-list-input__text')[0].value);
    if (sl < x) {
        sl += 1;
    }
    document.getElementsByClassName('cart-list-input__text')[0].value = sl;
}

function prevNumberCart(vt, x, masp) {
    var namesl = 'slNumberCart' + vt;
    var sl = Number(document.getElementById(namesl).value);
    if (sl > 1) {
        var namedg = 'dongiasp' + vt;
        var nametsp = 'tiensp' + vt;
        var dongiasp = Number(document.getElementById(namedg).innerHTML);
        var tiensp = Number(document.getElementById(nametsp).innerHTML);
        var tongtiensp = Number(document.getElementById('tongtiensp').innerHTML);
        var thanhtiensp = Number(document.getElementById('thanhtiensp').innerHTML);
        document.getElementById(namesl).value = sl - 1;
        document.getElementById(nametsp).innerHTML = tiensp - dongiasp;
        document.getElementById('tongtiensp').innerHTML = tongtiensp - dongiasp;
        document.getElementById('thanhtiensp').innerHTML = thanhtiensp - dongiasp;
        $.post('./php/soluongsp.php', { prevsp: masp }, function (data) {
            document
                .getElementsByClassName('cart-list-input__prev')
                [vt].setAttribute(
                    'onclick',
                    'prevNumberCart(' + vt + ',' + (x + 1) + ',' + masp + ')',
                );

            document
                .getElementById(namesl)
                .setAttribute(
                    'onchange',
                    'inputnumbercart(' + vt + ',' + (x + 1) + ',' + masp + ')',
                );

            document
                .getElementsByClassName('cart-list-input__next')
                [vt].setAttribute(
                    'onclick',
                    'nextNumberCart(' + vt + ',' + (x + 1) + ',' + masp + ')',
                );
        });
    }
}
function inputnumbercart(vt, x, masp) {
    var namesl = 'slNumberCart' + vt;
    var namedg = 'dongiasp' + vt;
    var nametsp = 'tiensp' + vt;
    var dongiasp = Number(document.getElementById(namedg).innerHTML);
    var tiensp = Number(document.getElementById(nametsp).innerHTML);
    var slbd = tiensp / dongiasp;
    var sl = Number(document.getElementById(namesl).value);
    var tongsl = x + slbd;

    if (sl > tongsl) {
        sl = tongsl;
        alert('Số lượng sản phẩm còn lại bạn có thể mua là ' + tongsl);
    }
    if (sl < 1) {
        sl = 1;
    }
    var tongtiensp = Number(document.getElementById('tongtiensp').innerHTML);
    var thanhtiensp = Number(document.getElementById('thanhtiensp').innerHTML);
    document.getElementById(namesl).value = sl;
    document.getElementById('tongtiensp').innerHTML = tongtiensp - tiensp + sl * dongiasp;
    document.getElementById('thanhtiensp').innerHTML = thanhtiensp - tiensp + sl * dongiasp;
    document.getElementById(nametsp).innerHTML = sl * dongiasp;
    $.post('./php/soluongsp.php', { inputsp: masp, slbd: slbd, sl: sl }, function (data) {
        document
            .getElementsByClassName('cart-list-input__prev')
            [vt].setAttribute(
                'onclick',
                'prevNumberCart(' + vt + ',' + (x + slbd - sl) + ',' + masp + ')',
            );

        document
            .getElementById(namesl)
            .setAttribute(
                'onchange',
                'inputnumbercart(' + vt + ',' + (x + slbd - sl) + ',' + masp + ')',
            );

        document
            .getElementsByClassName('cart-list-input__next')
            [vt].setAttribute(
                'onclick',
                'nextNumberCart(' + vt + ',' + (x + slbd - sl) + ',' + masp + ')',
            );
    });
}
function nextNumberCart(vt, x, masp) {
    var namesl = 'slNumberCart' + vt;
    var sl = Number(document.getElementById(namesl).value);
    if (x > 0) {
        var namedg = 'dongiasp' + vt;
        var nametsp = 'tiensp' + vt;
        var dongiasp = Number(document.getElementById(namedg).innerHTML);
        var tiensp = Number(document.getElementById(nametsp).innerHTML);
        var tongtiensp = Number(document.getElementById('tongtiensp').innerHTML);
        var thanhtiensp = Number(document.getElementById('thanhtiensp').innerHTML);
        document.getElementById(namesl).value = sl + 1;
        document.getElementById(nametsp).innerHTML = tiensp + dongiasp;
        document.getElementById('tongtiensp').innerHTML = tongtiensp + dongiasp;
        document.getElementById('thanhtiensp').innerHTML = thanhtiensp + dongiasp;
        $.post('./php/soluongsp.php', { nextsp: masp }, function (data) {
            document
                .getElementsByClassName('cart-list-input__prev')
                [vt].setAttribute(
                    'onclick',
                    'prevNumberCart(' + vt + ',' + (x - 1) + ',' + masp + ')',
                );

            document
                .getElementById(namesl)
                .setAttribute(
                    'onchange',
                    'inputnumbercart(' + vt + ',' + (x - 1) + ',' + masp + ')',
                );

            document
                .getElementsByClassName('cart-list-input__next')
                [vt].setAttribute(
                    'onclick',
                    'nextNumberCart(' + vt + ',' + (x - 1) + ',' + masp + ')',
                );
        });
    } else {
        alert('Số lượng sản phẩm này còn lại đã hết!');
    }
}

function deletecart(masp) {
    window.location =
        'http://localhost:8080/web2/index.php?content=giohang&action=xoa&masp=' + masp;
}

$(document).ready(function () {
    $('#register-text').on('change', function () {
        var name = $(this).val();
        if (name != '') {
            $.post('./php/dungchung/dangky.php', { tenTK: name }, function (data) {
                $('#form-error').html(data);
            });
        }
    });
    $('#button-register').click(function () {
        var tk = $('input[name=userregister]').val();
        var matkhau = $('input[name=passregister]').val();
        var ho = $('input[name=horegister]').val();
        var ten = $('input[name=tenregister]').val();
        //var diachi=$("input[name=addressregister]").val();
        var sodienthoai = $('input[name=phoneregister]').val();
        var check = 0;

        if (tk == '') {
            check = 1;
            $('#form-register-tk').html('-Tài khoản không được để trống!');
        } else {
            if ($('#form-error').html() != '') {
                check = 1;
            }
            if (!regex_id.test(tk)) {
                $('#form-register-tk').html('-Tài khoản không được có dấu, ký tự đặc biệt!');
            }
        }

        if (matkhau == '') {
            check = 1;
            $('#form-register-matkhau').html('-Mật khẩu không được để trống!');
        } else {
            if (!regex_pass.test(matkhau)) {
                check = 1;
                $('#form-register-matkhau').html('-Mật khẩu có ít nhất 4 ký tự!');
            }
        }

        if (ho == '') {
            check = 1;
            $('#form-register-hoten').html('-Họ tên không được để trống!');
        } else {
            if (!regex_name.test(ho)) {
                check = 1;
                $('#form-register-hoten').html('-Họ tên chỉ nhập chữ!');
            }
        }

        if (ten == '') {
            check = 1;
            $('#form-register-hoten').html('-Họ tên không được để trống!');
        } else {
            if (!regex_name.test(ten)) {
                check = 1;
                $('#form-register-hoten').html('-Họ tên chỉ nhập chữ!');
            }
        }

        if (sodienthoai == '') {
            check = 1;
            $('#form-register-sodienthoai').html('-Số điện thoại không được để trống!');
        } else {
            if (!regex_phone.test(sodienthoai)) {
                check = 1;
                $('#form-register-sodienthoai').html(
                    '-Số điện thoại chỉ nhập số, bắt đầu bằng 0, đủ 10!',
                );
            }
        }

        if (check == 0) {
            $.post(
                './php/dungchung/dangky.php',
                {
                    tk: tk,
                    matkhau: matkhau,
                    ho: ho,
                    ten: ten,
                    /*diachi:diachi,*/ sodienthoai: sodienthoai,
                },
                function (data) {
                    $('#form-register-success').html(data);
                    $('input[name=userregister]').val('');
                    $('input[name=passregister]').val('');
                    $('input[name=horegister]').val('');
                    $('input[name=tenregister]').val('');
                    $('input[name=phoneregister]').val('');
                    //$("input[name=addressregister]").val("");
                },
            );
        }
    });
    $('#button-login').click(function () {
        var tk = $('input[name=userlogin]').val();
        var matkhau = $('input[name=passlogin]').val();
        var check = 0;
        if (tk == '') {
            check = 1;
            $('#form-login-tk').html('-Tài khoản không được để trống!');
        }

        if (matkhau == '') {
            check = 1;
            $('#form-login-matkhau').html('-Mật khẩu không được để trống!');
        }

        if (check == 0) {
            $.post(
                './php/dungchung/dangnhap.php',
                { tentk: tk, matkhau: matkhau },
                function (data) {
                    switch (data) {
                        case '0':
                            $('#form-login-success').html('Tài khoản hoặc mật khẩu bị sai!');
                            break;
                        case '1':
                            $('#form-tab').css('display', 'none');
                            location.reload();
                            break;
                        case '2':
                            window.location = 'http://localhost:8080/web2/admin/sanpham';
                            break;
                        default:
                            $('#form-login-success').html('Tài khoản của bạn đã bị khóa');
                            break;
                    }
                },
            );
        }
    });
    $('#logout').click(function () {
        $.post('./php/dungchung/dangnhap.php', { exit: '0' }, function (data) {
            location.reload();
        });
    });
    $('#pay').click(function () {
        var tong = $('.cart-list-subtotal__number__price').text();
        var check = 0;
        var diachi = $('#cart-info-address').val();
        var sodienthoai = $('#cart-info-phone').val();
        if (!regex_address.test(diachi)) {
            check = 1;
            $('#cart-info-address-error').html("Vui lòng chỉ nhập số, chữ, và dấu '/' ',' ");
        }
        if (!regex_phone.test(sodienthoai)) {
            check = 1;
            $('#cart-info-phone-error').html('Vui lòng chỉ nhập số, bắt đầu bằng 0, đủ 10 số');
        }
        if (check == 0) {
            $.post(
                './php/donhang.php',
                { tong: tong, diachi: diachi, sodienthoai: sodienthoai },
                function (data) {
                    alert('Cảm ơn đã mua hàng!');
                    location.reload();
                },
            );
        }
    });

    $('#allsp').click(function () {
        var url = 'http://localhost:8080/web2/index.php?content=sanpham';
        history.pushState({}, null, url);
        page('1');
    });
    $('#allspf').click(function () {
        var url = 'http://localhost:8080/web2/index.php?content=sanpham';
        history.pushState({}, null, url);
        page('1');
    });
    $('#cart-info-address').on('input', function () {
        $('#cart-info-address-error').html('');
    });
    $('#cart-info-phone').on('input', function () {
        $('#cart-info-phone-error').html('');
    });
    $('input[name=userlogin]').on('input', function () {
        $('#form-login-tk').html('');
        $('#form-login-success').html('');
    });
    $('input[name=passlogin]').on('input', function () {
        $('#form-login-matkhau').html('');
        $('#form-login-success').html('');
    });
    $('input[name=userregister]').on('input', function () {
        $('#form-register-tk').html('');
    });
    $('input[name=passregister]').on('input', function () {
        $('#form-register-matkhau').html('');
    });
    $('input[name=horegister]').on('input', function () {
        $('#form-register-hoten').html('');
    });
    $('input[name=tenregister]').on('input', function () {
        $('#form-register-hoten').html('');
    });
    $('input[name=phoneregister]').on('input', function () {
        $('#form-register-sodienthoai').html('');
    });

    $('.category-item').click(function () {
        $('.category-item.category-active').removeClass('category-active');
        $(this).addClass('category-active');
    });
    $('.category-all').click(function () {
        $('.category-item.category-active').removeClass('category-active');
    });
});

function scrollpage() {
    window.scroll(0, 700);
}

function timten() {
    var params = location.search;
    var vlget = new URLSearchParams(params);
    var url = 'http://localhost:8080/web2/index.php?content=sanpham';
    var search = document.getElementById('namesr').value;

    if (vlget.get('loai')) {
        url += '&loai=' + vlget.get('loai');
    }
    if (search != '') {
        if (!regex_search.test(search)) {
            search = '*';
        }
        url += '&search=' + search;
    }
    if (vlget.get('from')) {
        url += '&from=' + vlget.get('from');
    }
    if (vlget.get('to')) {
        url += '&to=' + vlget.get('to');
    }
    if (vlget.get('sort')) {
        url += '&sort=' + vlget.get('sort');
    }
    history.pushState({}, null, url);
    page('1');
}

function timloai(loai) {
    var params = location.search;
    var vlget = new URLSearchParams(params);
    var url = 'http://localhost:8080/web2/index.php?content=sanpham';

    url += '&loai=' + loai;
    if (vlget.get('search')) {
        url += '&search=' + vlget.get('search');
    }
    if (vlget.get('from')) {
        url += '&from=' + vlget.get('from');
    }
    if (vlget.get('to')) {
        url += '&to=' + vlget.get('to');
    }
    if (vlget.get('sort')) {
        url += '&sort=' + vlget.get('sort');
    }
    history.pushState({}, null, url);
    page('1');
}

function timgia() {
    var params = location.search;
    var vlget = new URLSearchParams(params);
    var url = 'http://localhost:8080/web2/index.php?content=sanpham';
    var from = document.getElementById('from').value;
    var to = document.getElementById('to').value;

    if (vlget.get('loai')) {
        url += '&loai=' + vlget.get('loai');
    }
    if (vlget.get('search')) {
        url += '&search=' + vlget.get('search');
    }
    if (from != '') {
        url += '&from=' + from;
    }
    if (to != '') {
        url += '&to=' + to;
    }
    if (vlget.get('sort')) {
        url += '&sort=' + vlget.get('sort');
    }
    history.pushState({}, null, url);
    page('1');
}
function timgiaf() {
    var params = location.search;
    var vlget = new URLSearchParams(params);
    var url = 'http://localhost:8080/web2/index.php?content=sanpham';
    var from = document.getElementById('fromf').value;
    var to = document.getElementById('tof').value;

    if (vlget.get('loai')) {
        url += '&loai=' + vlget.get('loai');
    }
    if (vlget.get('search')) {
        url += '&search=' + vlget.get('search');
    }
    if (from != '') {
        url += '&from=' + from;
    }
    if (to != '') {
        url += '&to=' + to;
    }
    if (vlget.get('sort')) {
        url += '&sort=' + vlget.get('sort');
    }
    history.pushState({}, null, url);
    page('1');
}
function locgia() {
    var params = location.search;
    var vlget = new URLSearchParams(params);
    var url = 'http://localhost:8080/web2/index.php?content=sanpham';
    var sort = document.getElementById('filtergia').value;

    if (vlget.get('loai')) {
        url += '&loai=' + vlget.get('loai');
    }
    if (vlget.get('search')) {
        url += '&search=' + vlget.get('search');
    }
    if (vlget.get('from')) {
        url += '&from=' + vlget.get('from');
    }
    if (vlget.get('to')) {
        url += '&to=' + vlget.get('to');
    }
    if (sort != 0) {
        url += '&sort=' + sort;
    }
    history.pushState({}, null, url);
    page('1');
}
function page(trang) {
    var params = location.search;
    var vlget = new URLSearchParams(params);
    var loai = '',
        search = '',
        from = '',
        to = '',
        sort = '';
    if (vlget.get('loai')) {
        loai = vlget.get('loai');
    }
    if (vlget.get('search')) {
        search = vlget.get('search');
    }
    if (vlget.get('from')) {
        from = vlget.get('from');
    }
    if (vlget.get('to')) {
        to = vlget.get('to');
    }
    if (vlget.get('sort')) {
        sort = vlget.get('sort');
    }
    $.post(
        './php/phantrangsp.php',
        { trang: trang, loai: loai, search: search, from: from, to: to, sort: sort },
        function (data) {
            $('#pageProduct').html(data);
        },
    );
}
