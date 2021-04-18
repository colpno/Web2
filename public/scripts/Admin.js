function find(search, table) {
    const url = window.location.href;
    const uri = url.substring(0, url.indexOf('?'));
    const params = url.indexOf('?') != -1 ? url.substring(url.indexOf('?')) : '';
    let htmls = '',
        action = 'find';

    $.ajax({
        url: uri + 'app/index.php' + params,
        type: 'post',
        data: {
            search,
            table,
            action: 'find',
        },
        success: function (data) {
            if (isJson(data)) {
                const parsed = JSON.parse(data);
                switch (table) {
                    case 'sanpham': {
                        const SPFound = parsed.data;
                        for (let i = 0; i < SPFound.length; i++) {
                            htmls += `
                                    <div class="center checkbox col-lg-1 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${SPFound[i].maSP}" ></input>
                                    </div>
                                    <div class="center col-lg-2 col-md-2 col-sm-12">
                                        <img src="${SPFound[i].anhDaiDien}" onerror="this.src="images/no-img.png""  />
                                    </div>
                                    <span class="center-left col-lg-3 col-md-4 col-sm-12">${SPFound[i].tenSP}</span>
                                    <span class="center-right col-lg-2 col-md-1 col-sm-12">${SPFound[i].donGia} ${SPFound[i].donViTinh}</span>
                                    <span class="center col-lg-2 col-md-2 col-sm-12">${SPFound[i].soLuong}</span>
                                    <div class="center col-lg-2 col-md-3 col-sm-12">
                                        <button class="btn " onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn " onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                        }
                        $('.product--show').html(htmls);
                        break;
                    }
                    case 'loai': {
                        const LSPFound = parsed.data;
                        for (let i = 0; i < LSPFound.length; i++) {
                            htmls += `
                                    <div class="center checkbox col-lg-2 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${LSPFound[i].maLoai}"></input>
                                    </div>
                                    <span class="center-left col-lg-6 col-md-4 col-sm-12">${LSPFound[i].tenLoai}</span>
                                    <div class="center cake__cmd col-lg-4 col-md-3 col-sm-12">
                                        <button class="btn cake__update" onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn cake__delete" onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                        }
                        $('.category--show').html(htmls);
                        break;
                    }
                    case 'khuyenmai': {
                        const KMFound = parsed.data;
                        for (let i = 0; i < KMFound.length; i++) {
                            htmls += `
                                    <div class="center checkbox col-lg-1 col-md-12 col-sm-12">
                                        <input type="checkbox" value="${KMFound[i].maKM}"></input>
                                    </div>
                                    <span class="center-left col-lg-5 col-md-4 col-sm-12">${KMFound[i].tenKM}</span>
                                    <span class="center col-lg-2 col-md-4 col-sm-12">${KMFound[i].ngayBatDau}</span>
                                    <span class="center col-lg-2 col-md-4 col-sm-12">${KMFound[i].ngayKetThuc}</span>
                                    <div class="center cake__cmd col-lg-2 col-md-3 col-sm-12">
                                        <button class="btn cake__update" onclick="updateCake(this)"><i class="far fa-edit"></i></button>
                                        <button class="btn cake__delete" onclick="deleteCake(this)"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                `;
                        }
                        $('.promotion--show').html(htmls);
                        break;
                    }
                }
            }
        },
        error: function (err) {
            alert(err);
        },
    });
}
