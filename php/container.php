<div class="container-fluid bg-img-main " style="background-image:url('img/background1.jpg')">

</div>
<div class="bg-light py-4">
    <div class="container text-center pb-4 my-4">
        <h4 class="">Sản phẩm bán chạy</h4>
        <hr class="">
        <div class="row mb-4">
            <?php 
                $spDB=new SanPhamDB();
                $spArr=json_decode($spDB->listAll(),true);
                for ($i=0;$i<4;$i++) {
                    echo "<div class='col-lg-3 col-md-6 col-sm-12 my-3'>
                            <div class='card text-center shadow-lg'>
                                <div style='background-image:url(".".".substr($spArr[$i]['anhDaiDien'],5).")' class='product-item__img'></div>
                                <legend>".$spArr[$i]['tenSP']."</legend>
                                <p>".$spArr[$i]['donGia']." VNĐ</p>";
                    if ($spArr[$i]['soLuong']>0) {
                        echo "<p>Còn hàng</p>";
                    }
                    else {
                        echo "<p class='no-product'>Hết hàng</p>";
                    }
                    echo "    </div>
                        </div>";
                }
            ?>
        </div>
        <a href="index.php?content=sanpham" ><button type="button" class="btn btn-outline-primary">Xem tất cả sản phẩm </button></a>
    </div>    

    <div class="container-fluid promotion" style="background-image:url('img/img.jpg')">
        <!--<div class="promotion-content">
            <div class="promotion-header text-center">
                Mua sắm ngay để nhận được ưu đãi 10%!
                <button type="button" class="btn btn-outline-primary">Mua hàng</button>
            </div>
        </div>-->

    </div>

    <div class="container mb-4 mt-5">
        <div class="assess">
            <div class="row"> 
                <div class="col-lg-4 col-sm-12 mb-4">
                    <div class="assess-content border p-4 text-center rounded-top">
                        <div class="assess-icon icon-box text-center">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h4 class="mt-4">Sản phẩm</h4>
                        <p class="lead">Sản phẩm chất lượng, an toàn thực phẩm</p>
                        
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 mb-4">
                    <div class="assess-content border p-4 text-center rounded-top">
                        <div class="assess-icon icon-truck">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4 class="mt-4">Shipping</h4>
                        <p class="lead">Giao hàng nhanh, đảm bảo chất lượng hàng hóa</p>
                        
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 mb-4">
                    <div class="assess-content border p-4 text-center rounded-top">
                        <div class="assess-icon icon-heart">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="mt-4">Dịch vụ</h4>
                        <p class="lead">Tận tình, chu đáo, hài lòng khách hàng</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>