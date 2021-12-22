<?php
$spDB = new SanPhamDB();
$spArr = json_decode($spDB->listAll(), true);
$lspArr = json_decode($spDB->countLoai(), true);
$sosp1trang = 9;
?>

<div class="container-fluid bg-img-main-p " style="background-image:url('img/background2.jpg')"></div>
<div class="container-fluid mt-4">
    <div class="container">
        <div class="row">
            <input autocomplete="off" type="search" class="search__input " id="namesr" oninput="timten()" placeholder="Tìm kiếm tên sản phẩm...">
            <div class="search__button" onclick="timten()">
                <p class="col-md-0 mb-0">Search</p>
                <div class="d-md-none">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="container border-top my-4 py-4">
        <div class="row">
            <div class="col-md-3 col-md-0">
                <div class="category border-bottom my-4 pb-4">
                    <div class="category__heading" data-toggle="collapse" data-target="#product">
                        <h4 class="">Sản phẩm</h4>
                        <div class="category-icon">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                    <div id="product" class="collapse">
                        <div class="category-all py-2">
                            <div class="category-all__heading" id="allsp">Tổng sản phẩm</div>
                            <div class="category-all__number"><?php echo count($spArr) ?></div>
                        </div>
                        <?php
                        foreach ($lspArr as $key => $value) {
                            echo "<div onclick='timloai(" . $value['maLoai'] . ")' class='category-item'>
                                        <div class='category-item__heading'>" . $value['tenLoai'] . "</div>
                                        <div class='category-item__number'>" . $value['soLuong'] . "</div>
                                    </div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="price border-bottom my-4 pb-4">
                    <div class="price__heading py-2" data-toggle="collapse" data-target="#price">
                        <h4 class="">Giá tiền</h4>
                        <div class="category-icon">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                    <div id="price" class="price__content collapse">
                        <div class="price__input">
                            <input autocomplete="off" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="from" class="" placeholder="VNĐ">
                        </div>
                        <div class="price-to">-</div>
                        <div class="price__input">
                            <input autocomplete="off" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="to" class="" placeholder="VNĐ">
                        </div>
                        <button type="button" onclick="timgia()" class="price-button"> > </button>
                    </div>
                </div>
                <!--<div class="sale border-bottom my-4 pb-4">
                    <div class="sale__heading py-2" data-toggle="collapse" data-target="#sale">
                        <h4 class="">Khuyến mãi</h4>
                        <div class="category-icon"> 
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                    <div id="sale" class="sale-check collapse" >
                        <div class="sale-check__heading custom-control custom-checkbox">
                            <input autocomplete="off" type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                            <label class="custom-control-label" for="customCheck">Chọn</label>
                        </div>
                        <div class="sale-check__number">1</div>
                    </div>
                </div>-->
            </div>


            <div class="col-md-9 col-sm-12">
                <div class="row">
                    <div class="filter col-3 mb-4 d-md-none" onclick="openfilter()">
                        <div class="filter__name">Bộ lọc</div>
                        <div class="filter__icon">
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                    <div class="product-sort mb-4 col-9 col-md-12">
                        <select name="" id="filtergia" class=" form-control" onchange="locgia()">
                            <option value="0" class="" selected>Tìm kiếm theo...</option>
                            <option value="ASC" class="">Từ giá thấp đến giá cao</option>
                            <option value="DESC" class="">Từ giá cao đến giá thấp</option>
                        </select>
                    </div>
                </div>
                <div id="pageProduct" class="row">
                    <script>
                        page(1);
                    </script>

                </div>
                <div id="page-number">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="filter-tab" id="filter-tab">
    <div class="filter-tab__header border-bottom my-4 pb-4 px-4">
        <div class="filter-tab__name">Bộ lọc</div>
        <div class="filter-tab__button" onclick="closefilter()">Đóng</div>
    </div>
    <div class="category border-bottom my-4 pb-4 px-4">
        <div class="category__heading" data-toggle="collapse" data-target="#productf">
            <h4 class="">Sản phẩm</h4>
            <div class="category-icon">
                <i class="fas fa-angle-down"></i>
            </div>
        </div>
        <div id="productf" class="collapse">
            <div class="category-all py-2">
                <div class="category-all__heading" id="allspf" onclick="closefilter()">Tổng sản phẩm</div>
                <div class="category-all__number"><?php echo count($spArr) ?></div>
            </div>
            <?php
            foreach ($lspArr as $key => $value) {
                echo "<div onclick='timloai(" . $value['maLoai'] . "),closefilter()' class='category-item'>
                            <div class='category-item__heading'>" . $value['tenLoai'] . "</div>
                            <div class='category-item__number'>" . $value['soLuong'] . "</div>
                        </div>";
            }
            ?>
        </div>
    </div>
    <div class="price border-bottom my-4 pb-4 px-4">
        <div class="price__heading py-2" data-toggle="collapse" data-target="#pricef">
            <h4 class="">Giá tiền</h4>
            <div class="category-icon">
                <i class="fas fa-angle-down"></i>
            </div>
        </div>
        <div id="pricef" class="price__content collapse">
            <div class="price__input">
                <input autocomplete="off" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="fromf" class="" placeholder="VNĐ">
            </div>
            <div class="price-to">-</div>
            <div class="price__input">
                <input autocomplete="off" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="tof" class="" placeholder="VNĐ">
            </div>
            <button type="button" onclick="timgiaf(),closefilter()" class="price-button"> > </button>
        </div>
    </div>
    <!--<div class="sale border-bottom my-4 pb-4 px-4">
        <div class="sale__heading py-2" data-toggle="collapse" data-target="#sale">
            <h4 class="">Khuyến mãi</h4>
            <div class="category-icon"> 
                <i class="fas fa-angle-down"></i>
            </div>
        </div>
        <div id="sale" class="sale-check collapse" >
            <div class="sale-check__heading">
                <input autocomplete="off" type="checkbox" class="">
                <p class="sale-check__heading__text">Chọn</p>
            </div>
        <div class="sale-check__number">1</div>
        </div>
    </div>-->
</div>