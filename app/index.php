<?php
session_start();
$dir = __DIR__;

require "$dir/../config/database/Database.php";
require "$dir/controllers/BaseController.php";
require "$dir/models/BaseModel.php";

require "$dir/../common/UploadImage.php";
require "$dir/../common/Other.php";

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'admin';
$action = isset($_GET['action']) ? $_GET['action'] : 'sanpham';
$controllerObject = null;

require_once($dir . '/controllers/' . $controller . '.php');
$controllerObject = new $controller;

if (!isset($_POST['action'])) {
    switch ($controller) {
        case 'admin':
            require_once($dir . '/views/' . $controller . '.php');
    }


    if (!method_exists($controller, $action)) {
        die('Không có action');
    }

    $_SESSION['get'] = $controllerObject->$action();

    if (isset($_GET['page'], $_GET['table'])) {
        $_SESSION['get'] = $controllerObject->SanPham([
            $_GET['page'],
            $_GET['table']
        ]);
    }
}


if (isset($_POST['action'])) {
    if (isset($_FILES['anhDaiDien']['tmp_name'])) {
        $_POST['anhDaiDien'] = $_FILES['anhDaiDien'];
    }
    switch ($controller) {
        case 'admin': {
                echo json_encode($controllerObject->SanPham($_POST));
            }
    }
}
