<?php require_once 'app/index.php' ?> <?php
                                        session_start();
                                        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css">
    <script src="./bootstrap/js/jquery.min.js"></script>
    <script src="./bootstrap/js/popper.min.js"></script>
    <script src="./js/main.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./fontawesome/css/all.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <script src="/Web2/common/Other.js"></script>
    <script src="/Web2/common/InputTester.js"></script>
    <script src="/Web2/public/resource/jquery-3.6.0.min.js" type="text/javascript"></script>
    <script src="/Web2/public/resource/bootstrap-5.0.0-beta3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/Web2/public/resource/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Web2/public/resource/fontawesome-free-5.15.3-web/css/all.min.css" />
    <link rel="shortcut icon" href="#">

    <title>Cửa hàng bánh MUN</title>
</head>

<body>
    <?php
    if (isset($_SESSION['user'])) {

        if ($_SESSION['user']['quyen'] != 3) {
            header('Location: http://localhost:8080/Web2/admin/sanpham');
        }
    }
    require "./php/database/connection.php";
    require("./php/dungchung/header.php");
    if (isset($_GET["content"])) {
        switch ($_GET['content']) {
            case "trangchu":
                require("./php/container.php");
                break;
            case "sanpham":
                require("./php/product.php");
                break;
            case "giohang":
                require("./php/cart.php");
                break;
            case "chitietsanpham":
                require("./php/detail.php");
                break;
            case "danhsachdonhang":
                require("./php/danhsachdonhang.php");
                break;
            default:
                require("./php/container.php");
                break;
        }
    } else {
        require("./php/container.php");
    }
    require("./php/dungchung/footer.php");


    ?>

</body>

</html>