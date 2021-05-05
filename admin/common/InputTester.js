function chiChu(str, label, lessThanOrEqual) {
    const pattern = new RegExp(
        /^[aAàÀảẢãÃáÁạẠăĂằẰẳẲẵẴắẮặẶâÂầẦẩẨẫẪấẤậẬbBcCdDđĐeEèÈẻẺẽẼéÉẹẸêÊềỀểỂễỄếẾệỆfFgGhHiIìÌỉỈĩĨíÍịỊjJkKlLmMnNoOòÒỏỎõÕóÓọỌôÔồỒổỔỗỖốỐộỘơƠờỜởỞỡỠớỚợỢpPqQrRsStTuUùÙủỦũŨúÚụỤưƯừỪửỬữỮứỨựỰvVwWxXyYỳỲỷỶỹỸýÝỵỴzZ]+$/g,
    );
    const notMatchMessage = 'chỉ gồm chữ';
    if (check(pattern, str, label, notMatchMessage, lessThanOrEqual)) {
        return false;
    }
    return true;
}

function chiChuVaKhoangTrang(str, label, lessThanOrEqual) {
    const pattern = new RegExp(
        /^[aAàÀảẢãÃáÁạẠăĂằẰẳẲẵẴắẮặẶâÂầẦẩẨẫẪấẤậẬbBcCdDđĐeEèÈẻẺẽẼéÉẹẸêÊềỀểỂễỄếẾệỆfFgGhHiIìÌỉỈĩĨíÍịỊjJkKlLmMnNoOòÒỏỎõÕóÓọỌôÔồỒổỔỗỖốỐộỘơƠờỜởỞỡỠớỚợỢpPqQrRsStTuUùÙủỦũŨúÚụỤưƯừỪửỬữỮứỨựỰvVwWxXyYỳỲỷỶỹỸýÝỵỴzZ\s]+$/g,
    );
    const notMatchMessage = 'chỉ bao gồm chữ và khoảng trắng';
    if (check(pattern, str, label, notMatchMessage, lessThanOrEqual) === false) {
        return false;
    }
    if (kiemKhoangTrang(str, label) === false) {
        return false;
    }
    return true;
}

function chiSo(str, label, lessThanOrEqual) {
    const pattern = new RegExp(/^\d+$/g);
    const notMatchMessage = 'chỉ bao gồm số';
    if (check(pattern, str, label, notMatchMessage, lessThanOrEqual) === false) {
        return false;
    }
    return true;
}

function chiSoVaKhoangTrang(str, label, lessThanOrEqual) {
    const pattern = new RegExp(/^\d+\s+|\d+$/g);
    const notMatchMessage = 'chỉ bao gồm chữ và khoảng trắng';
    if (check(pattern, str, label, notMatchMessage, lessThanOrEqual) === false) {
        return false;
    }
    if (kiemKhoangTrang(str, label) === false) {
        return false;
    }
    return true;
}

function chiSoVaChu(str, label, lessThanOrEqual) {
    const pattern = new RegExp(
        /^[aAàÀảẢãÃáÁạẠăĂằẰẳẲẵẴắẮặẶâÂầẦẩẨẫẪấẤậẬbBcCdDđĐeEèÈẻẺẽẼéÉẹẸêÊềỀểỂễỄếẾệỆfFgGhHiIìÌỉỈĩĨíÍịỊjJkKlLmMnNoOòÒỏỎõÕóÓọỌôÔồỒổỔỗỖốỐộỘơƠờỜởỞỡỠớỚợỢpPqQrRsStTuUùÙủỦũŨúÚụỤưƯừỪửỬữỮứỨựỰvVwWxXyYỳỲỷỶỹỸýÝỵỴzZ\d]+$/g,
    );
    const notMatchMessage = 'chỉ bao gồm số và chữ';
    if (check(pattern, str, label, notMatchMessage, lessThanOrEqual) === false) {
        return false;
    }
    return true;
}

function chiSoChuKhoangTrang(str, label, lessThanOrEqual) {
    const pattern = new RegExp(/^[\d\s]+|[\d]+$/g);
    const notMatchMessage = 'chỉ bao gồm chữ, số và khoảng trắng';
    if (check(pattern, str, label, notMatchMessage, lessThanOrEqual) === false) {
        return false;
    }
    if (kiemKhoangTrang(str, label) === false) {
        return false;
    }
    return true;
}

function soDienThoaiHopLe(str, label, lessThanOrEqual) {
    let pattern = new RegExp(/^[\d]{10}$/g);
    let notMatchMessage = 'gồm 10 số';
    if (check(pattern, str, label, notMatchMessage, lessThanOrEqual) === false) {
        return false;
    }
    pattern = new RegExp(/^0[\d]{9}$/g);
    notMatchMessage = 'số đầu tiên phải là số 0';
    if (check(pattern, str, label, notMatchMessage, lessThanOrEqual) === false) {
        return false;
    }
    return true;
}

function kiemNgay(str, label) {
    // const pattern = new RegExp(/^[\d]{2}\/[\d]{2}\/[\d]{4}$/g);
    const pattern = new RegExp(/^\d{4}-\d{2}-\d{2}$/g);
    if (chuoiNull(str, '')) {
        showDialog('Vui lòng nhập vào ' + label, 'Lỗi', 0);
        return false;
    }
    if (pattern.test(str) === false) {
        showDialog('Định dạng ngày phải là: yyyy-MM-dd', 'Lỗi', 0);
        return false;
    }

    const date = str.split('/'),
        day = parseInt(date[0], 10),
        month = parseInt(date[1], 10),
        year = parseInt(date[2], 10),
        localDate = new Date(),
        currentYear = localDate.getFullYear();
    let defaultDay = 0,
        count = 0;

    if (month < 1 || month > 12) {
        showDialog('Tháng phải trong khoảng 1 - 12', 'Lỗi', 0);
        count++;
    }

    if (year < 1950 || year > currentYear) {
        showDialog('Năm phải trong khoảng 1950 -> ' + currentYear, 'Lỗi', 0);
        count++;
    }

    switch (month) {
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            defaultDay = 31;
            break;
        case 4:
        case 6:
        case 9:
        case 11:
            defaultDay = 30;
            break;
        case 2: {
            if (year % 400 == 0 || (year % 4 == 0 && year % 100 != 0)) {
                defaultDay = 28;
            } else defaultDay = 29;
            break;
        }
    }
    if (defaultDay != 0 && (day < 1 || day > defaultDay)) {
        showDialog('Ngày phải trong khoảng 1 -> ' + defaultDay, 'Lỗi', 0);
        count++;
    }
    if (count == 0) {
        return true;
    }
    return false;
}

function laDiaChi(str, label, lessThanOrEqual) {
    const pattern = new RegExp(
        /^[aAàÀảẢãÃáÁạẠăĂằẰẳẲẵẴắẮặẶâÂầẦẩẨẫẪấẤậẬbBcCdDđĐeEèÈẻẺẽẼéÉẹẸêÊềỀểỂễỄếẾệỆfFgGhHiIìÌỉỈĩĨíÍịỊjJkKlLmMnNoOòÒỏỎõÕóÓọỌôÔồỒổỔỗỖốỐộỘơƠờỜởỞỡỠớỚợỢpPqQrRsStTuUùÙủỦũŨúÚụỤưƯừỪửỬữỮứỨựỰvVwWxXyYỳỲỷỶỹỸýÝỵỴzZ\d/,\.\s]+$/g,
    );
    if (check(pattern, str, label, 'Địa chỉ không hợp lệ', lessThanOrEqual) === false) {
        return false;
    }
    if (kiemKhoangTrang(str, label) === false) {
        return false;
    }
    return true;
}

function chuoiNull(str, label) {
    if (str === '' && label === '') {
        return true;
    }
    if (str === '' && !label === '') {
        showDialog('Vui lòng nhập vào ' + label, 'Lỗi', 0);
        return true;
    }
    return false;
}

function showDialog(notMatchMessage, title, notMatchMessageType) {
    alert(notMatchMessage);
}

function check(pattern, str, label, notMatchMessage, lessThanOrEqual) {
    if (chuoiNull(str, '')) {
        showDialog('Vui lòng nhập vào ' + label, 'Lỗi', 0);
        return false;
    }
    if (pattern.test(str) === false) {
        showDialog(label + ' ' + notMatchMessage, 'Lỗi', 0);
        return false;
    }
    if (lessThanOrEqual != 0 && str.length > lessThanOrEqual) {
        showDialog(label + ' phải nhỏ hơn hoặc bằng ' + lessThanOrEqual + ' ký tự', 'Lỗi', 0);
        return false;
    }
    return true;
}

function kiemKhoangTrang(str, label) {
    const pattern = new RegExp(/^\s|\s{2,99999}|\s$/g);
    if (pattern.test(str) === true) {
        showDialog(label + ' có khoảng trắng thừa', 'Lỗi', 0);
        return false;
    }
    return true;
}

function kiemKhongKhoangTrang(str, label) {
    const pattern = new RegExp(/\s+/g);
    if (pattern.test(str) === true) {
        showDialog('Xóa bỏ khoảng trắng ở ' + label, 'Lỗi', 0);
        return false;
    }
    return true;
}
