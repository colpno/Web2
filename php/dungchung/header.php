<?php
require "./php/database/QuyenDB.php";
require "./php/database/SanPhamDB.php";

$q = new QuyenDB();
$sp = new SanPhamDB();
//<a href="index.php?content=thongtincanhan"><div id="infouser" class="avatar-menu__item">Thông tin cá nhân</div></a> 134
?>

<div class="header">
  <nav class="navbar navbar-expand-md navbar-light">
    <div class="container">
      <a href="index.php?content=trangchu" class="navbar-brand"><img src="img/logo.png" width=200px></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="menu collapse navbar-collapse" id="navbarResponsive">
        <ul class=" navbar-nav menu-content">
          <li class="navbar-item menu-item mb-2">
            <a href="index.php?content=trangchu" class="menu-link ">Trang chủ</a>
          </li>
          <li class="navbar-item menu-item mb-2">
            <a href="index.php?content=sanpham" class="menu-link">Sản phẩm</a>
          </li>
        </ul>
      </div>
      <div class="menu-right collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav menu-content">
          <li class="navbar-item menu-item mb-2 text-center">
            <?php
            if (isset($_SESSION['user'])) {
              echo '<div class="avatar-user">
                          <div class="avatar-img" ><img src="' .  $_SESSION["user"]["anh"] . '"></div>
                          <div class="avatar-name">' . $_SESSION["user"]["ho"] . ' ' . $_SESSION["user"]["ten"] . '</div>
                          <div class="avatar-menu">
                           
                            <a href="index.php?content=danhsachdonhang"><div id="cartuser" class="avatar-menu__item">Xem đơn hàng</div></a>
                            <div id="logout" class="avatar-menu__item">Đăng xuất</div>
                          </div>
                        </div>';
              if (isset($_GET['action'])) {
                if ($_GET['action'] == "xoa" && isset($_GET['masp'])) {
                  if (isset($_SESSION['giohang'])) {
                    $cartArr = $_SESSION['giohang'];
                    $spArr = json_decode($sp->searchMaSP($_GET['masp']), true);
                    $soluongsp = $spArr[0]['soLuong'];
                    foreach ($cartArr as $key => $value) {
                      if ($value['maSP'] == $_GET['masp']) {
                        $soluongsp += $value['soLuong'];
                        $sp->updateSoLuong($_GET['masp'], $soluongsp);
                        unset($_SESSION['giohang'][$key]);
                        break;
                      }
                    }
                  }
                }
              }
            } else {
              echo '<div class="menu-link" onclick="opentab(\'form-tab\')">
                        <i class="fas fa-user-circle"></i>
                      </div>';
            }

            ?>


          </li>
          <li class="navbar-item menu-item mb-2">
            <a href="index.php?content=giohang" class="menu-link">
              <i class="fas fa-shopping-cart"></i>
              <div class="cart-list__number"><?php if (isset($_SESSION['giohang']))
                                                echo count($_SESSION['giohang']);
                                              else echo '0'; ?></div>
            </a>

          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<div id="form-tab" class="login">
  <div class="overlay" onclick="closetab('form-tab')"></div>
  <div class="form-login">
    <div class="form-login__header">
      <div id="btn-form"></div>
      <button type="button" class="form-login__header__item" onclick="login()">Đăng nhập</button>
      <button type="button" class="form-login__header__item" onclick="register()">Đăng ký</button>
    </div>
    <div id="login" class="form-login__content">
      <input type="text" id="login-text" autocomplete="off" class="form-login__input form-control" name="userlogin" placeholder="Tên tài khoản">
      <input type="password" autocomplete="off" class="form-login__input form-control" name="passlogin" placeholder="Mật khẩu">
      <button type="button" id="button-login" class="form-button">Đăng nhập</button>
      <div id="form-login-tk"></div>
      <div id="form-login-matkhau"></div>
      <div id="form-login-success"></div>
    </div>
    <div id="register" class="form-login__content">
      <input type="text" id="register-text" autocomplete="off" class="form-login__input form-control" name="userregister" placeholder="Tên tài khoản">
      <div id="form-error"></div>
      <input type="password" autocomplete="off" class="form-login__input form-control" name="passregister" placeholder="Mật khẩu">
      <div class="form-login__input form-hoten">
        <input type="text" autocomplete="off" class="form-control form-ho" name="horegister" placeholder="Họ">
        <input type="text" autocomplete="off" class="form-control form-ten" name="tenregister" placeholder="Tên">
      </div>
      <!--<input type="text" class="form-login__input form-control" name="addressregister" placeholder="Địa chỉ">-->
      <input type="text" autocomplete="off" class="form-login__input form-control" name="phoneregister" placeholder="Số điện thoại">
      <button type="button" id="button-register" class="form-button">Đăng ký</button>
      <div id="form-register-tk"></div>
      <div id="form-register-matkhau"></div>
      <div id="form-register-hoten"></div>
      <div id="form-register-sodienthoai"></div>
      <div id="form-register-success"></div>
    </div>
    <span class="close-icon" onclick="closetab('form-tab')">&times</span>
  </div>
</div>

</div>