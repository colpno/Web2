function ajaxChangeReport(ele) {
    switch (ele.value) {
        case 'tongthu': {
            $('.tongthu').removeClass('hidden');
            $('.doanhthu').addClass('hidden');
            $('.taikhoan-report').addClass('hidden');
            break;
        }
        case 'doanhthu': {
            $('.tongthu').addClass('hidden');
            $('.doanhthu').removeClass('hidden');
            $('.taikhoan-report').addClass('hidden');
            break;
        }
        case 'taikhoan-report': {
            $('.tongthu').addClass('hidden');
            $('.doanhthu').addClass('hidden');
            $('.taikhoan-report').removeClass('hidden');
            break;
        }
    }
}

function ajaxChangeYear(ele) {
    $.ajax({
        url: '/Web2/admin/app/index.php?controller=admin&action=thongke',
        type: 'POST',
        data: {
            year: ele.value,
            table: 'thongke',
            action: 'thongke',
        },
        success: function (data) {
            if (isJson(data) && data != null) {
                const json = JSON.parse(data),
                    idString = ele.getAttribute('id'),
                    table = idString.substring(0, idString.indexOf('-'));

                let html = '';
                switch (table) {
                    case 'tongthu': {
                        html += renderTongThu(json);
                        break;
                    }
                    case 'doanhthu': {
                        html += renderDoanhThu(json);
                        break;
                    }
                    case 'taikhoan-report': {
                        html += renderTaiKhoan(json);
                        break;
                    }
                }
                if (html == '') {
                    html = '';
                    for (let i = 0; i < 12; i++) {
                        html += `
                    <div>
                        <div
                            class="chart-layout__item thang-${i + 1}"
                            style="--percent: 0%">
                            <p>0</p>
                        </div>
                        <span>${i}</span>
                    </div>
                       `;
                    }
                    $(`.${table}-report .chart-layout`).html(html);
                    $(`.summary-${table}-report`).text(numberWithCommas(0));
                } else {
                    if (table == 'taikhoan') {
                        $(`.${table}-report .chart-layout`).html(html);
                    } else {
                        $(`.${table} .chart-layout`).html(html);
                    }
                }
            } else {
                alert(data);
            }
        },
    });
}

function renderDoanhThu(list) {
    const doanhThu = [];

    for (let i = 1; i <= 12; i++) {
        doanhThu.push({
            thang: i,
            tongTien: 0,
        });
    }

    list.HoaDon.Data.forEach((element) => {
        doanhThu[parseInt(element.thang) - 1].tongTien += parseInt(element.tongTien);
    });

    let max = 0,
        thangMax = 0;
    doanhThu.forEach((element) => {
        if (element.tongTien > max) {
            max = element.tongTien;
            thangMax = element.thang;
        }
    });

    let html = '';
    doanhThu.forEach((element) => {
        let tongTien = parseInt(element.tongTien),
            thang = parseInt(element.thang),
            percent = 0;
        if (thang != thangMax) {
            if (tongTien < 0 || max < 0) {
                tongTien = 0;
                max = 0;
            }
            if (tongTien > 0 && max > 0) {
                percent = Math.round(((tongTien * 1.0) / max) * 100);
            }
            const formated = numberWithCommas(tongTien);
            html += `
                <div>
                    <div class='chart-layout__item thang-${thang}' style='--percent: ${percent}%'><p>${formated}</p></div>
                    <span>${thang}</span>
                </div>`;
        }
        if (thang == thangMax) {
            const formated = numberWithCommas(max);
            html += `
                <div>
                    <div class='chart-layout__item thang-${thang}' style='--percent: 100%'><p>${formated}</p></div>
                    <span>${thang}</span>
                </div>`;
        }
    });

    let tong = 0;
    doanhThu.forEach((element) => {
        tong += parseInt(element.tongTien);
    });
    $('.summary-doanhthu').text(numberWithCommas(tong));

    return html;
}

function renderTongThu(list) {
    const doanhThu = [],
        tienNhap = [],
        tongThu = [];
    for (let i = 1; i <= 12; i++) {
        doanhThu.push({
            thang: i,
            tongTien: 0,
        });
        tienNhap.push({
            thang: i,
            tongTien: 0,
        });
        tongThu.push({
            thang: i,
            tongTien: 0,
        });
    }

    list.HoaDon.Data.forEach((element) => {
        doanhThu[parseInt(element.thang) - 1].tongTien += parseInt(element.tongTien);
    });

    list.PhieuNhapHang.Data.forEach((element) => {
        tienNhap[parseInt(element.thang) - 1].tongTien += parseInt(element.tongTien);
    });

    let tongLuong = 0;
    list.NhanVien.Data.forEach((element) => {
        tongLuong += parseInt(element.luong);
    });

    for (let i = 0; i < 12; i++) {
        tongThu[i].tongTien = doanhThu[i].tongTien - tienNhap[i].tongTien - tongLuong;
    }

    let max = tongThu[0].tongTien,
        thangMax = tongThu[0].thang;
    tongThu.forEach((element) => {
        if (element.tongTien > max) {
            max = element.tongTien;
            thangMax = element.thang;
        }
    });

    let html = '';
    tongThu.forEach((element) => {
        let percent = 0,
            thang = element.thang,
            tongTien = element.tongTien;
        if (thang != thangMax) {
            if (tongTien < 0 || max < 0) {
                tongTien = 0;
                max = 0;
            }
            const formated = numberWithCommas(tongTien);
            if (tongTien > 0 && max > 0) {
                percent = Math.round(((tongTien * 1.0) / max) * 100);
            }
            html += `
                <div>
                    <div class='chart-layout__item thang-${thang}' style='--percent: ${percent}%'><p>${formated}</p></div>
                    <span>${thang}</span>
                </div>`;
        }
        if (thang == thangMax) {
            let formated = 0;
            if (max > 0) {
                formated = numberWithCommas(max);
                percent = 100;
            }
            html += `
                <div>
                    <div class='chart-layout__item thang-${thangMax}' style='--percent: ${percent}%'><p>${formated}</p></div>
                    <span>${thangMax}</span>
                </div>`;
        }
    });

    let tong = 0;
    tongThu.forEach((element) => {
        tong += parseInt(element.tongTien);
    });
    $('.summary-tongthu').text(numberWithCommas(tong));

    return html;
}

function renderTaiKhoan(list) {
    const taiKhoanTaoHangThang = [];

    for (i = 1; i <= 12; i++) {
        taiKhoanTaoHangThang[i] = {
            thang: i,
            soLuong: 0,
        };
    }

    list.TaiKhoan.Data.forEach((element) => {
        if (element.maQuyen == 3) {
            taiKhoanTaoHangThang[element.thang - 1].soLuong++;
        }
    });

    let max = 0,
        thangMax = 0;
    taiKhoanTaoHangThang.forEach((element) => {
        if (element.soLuong > max) {
            max = element.soLuong;
            thangMax = element.thang;
        }
    });

    let html = '';
    taiKhoanTaoHangThang.forEach((element) => {
        let percent = 0,
            thang = element.thang,
            soLuong = element.soLuong;
        if (thang != thangMax) {
            if (soLuong > 0 && max > 0) {
                percent = Math.round(((soLuong * 1.0) / max) * 100);
            }
            html += `
                <div>
                    <div class='chart-layout__item thang-${thang}' style='--percent: ${percent}%'><p>${soLuong}</p></div>
                    <span>${thang}</span>
                </div>`;
        }
        if (thang == thangMax) {
            if (max > 0) {
                percent = 100;
            }
            html += `
                <div>
                    <div class='chart-layout__item thang-${thangMax}' style='--percent: ${percent}%'><p>${max}</p></div>
                    <span>${thangMax}</span>
                </div>`;
        }
    });

    let tong = 0;
    taiKhoanTaoHangThang.forEach((element) => {
        tong += parseInt(element.soLuong);
    });
    $('.summary-taikhoan-report').text(numberWithCommas(tong));

    return html;
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}
