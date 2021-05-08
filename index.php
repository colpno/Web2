<?php
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
            default: require("./php/container.php");
                    break;
        }
    } else {
        require("./php/container.php");
    }
    require("./php/dungchung/footer.php");


    ?>

</body>

</html>