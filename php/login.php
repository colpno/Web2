<?php
    session_start();

    if (isset($_GET['dn'])) {
        echo "hello";
    }
    
    if (isset($_SESSION['maQuyen'])) {
        print_r($_SESSION['maQuyen']);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize-min.css" />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <script src="../js/main.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="login-user">
        <form action="xuly.php" method="post" id="register" class="register" onsubmit="return validate()">
            <div class="register-form">
                <div class="register-form__item">
                    <div class="register-form__item__heading">Đăng ký</div>
                    <div class="register-form__item__purpose">Nói cho chúng tôi về bạn</div>
                </div>
                <div class="register-form__item">
                    <div class="register-form__item__name">
                        <input type="text" id="register__id" name="register__id" placeholder="Mã sinh viên"/>
                        <div id="id-error-message"></div>
                    </div>
                    <div class="register-form__item__phone">
                        <input type="text" id="register__name" name="register__name" placeholder="Họ tên"/>
                        <div id="name-error-message"></div>
                    </div>
                </div>
                <div class="register-form__item">
                    <div class="register-form__item__password">
                        <input type="text" id="register__phone" name="register__phone" placeholder="Số điện thoại"/>
                        <div id="phone-error-message"></div>
                    </div>
                    <div class="register-form__item__password">
                        <input type="text" id="register__mail" name="register__mail" placeholder="Mail"/>
                        <div id="mail-error-message"></div>
                    </div>
                </div>
                <div class="register-form__item">
                    <div class="register-form__item__button">
                        <input type="submit" id="bt-res" value="Đăng ký" class="btn">
                    </div>
                </div>
            </div>
        </form>
        <form action="index.php" method="post" id="login" class="login">
            <div class="login-form">
                <div class="login-form__item">
                    <div class="login-form__item__heading">Đăng nhập</div>
                    <div class="login-form__item__purpose">Rất vui được gặp lại bạn</div>
                </div>
                <div class="login-form__item">
                    <div class="login-form__item__name">
                        <input type="text" id="login__name" placeholder="Tên đăng nhập"/>
                    </div>
                    <div class="login-form__item__password">
                        <input type="password" id="login__passwd" placeholder="Mật khẩu"/>
                    </div>
                </div>
                <div class="login-form__item">
                    <div class="login-form__item__forget">
                        <a href="#" class="login__forget">Quên mật khẩu</a>
                    </div>
                </div>
                <div class="login-form__item">
                    <div class="login-form__item__button">
                        <input type="submit" id="bt-login" value="Đăng nhập" class="btn">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
