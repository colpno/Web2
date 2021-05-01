<?php
session_start();
$dir = __DIR__;

require "$dir/../config/database/Database.php";
require "$dir/controllers/BaseController.php";
require "$dir/models/BaseModel.php";

require "$dir/../common/UploadImage.php";
require "$dir/../common/Other.php";


if (!isset($_POST['action'])) {
    $uri = isset($_GET['uri']) ? $_GET['uri'] : "";
    $splitUri = explode("/", $uri);
    $controller = $splitUri[0];
    $action = $splitUri[1];
    $controllerObject = null;

    if (!isset($_COOKIE['past'])) {
        setcookie("past", $action, time() + 3600);
    }



    require_once($dir . '/controllers/' . $controller . '.php');
    $controllerObject = new $controller;

    if (isset($_COOKIE['past']) && $_COOKIE['past'] != $action) {
        echo "
            <script>
                window.location=window.location.href;
            </script>
        ";
        setcookie("past", $action, time() + 3600);
    }

    switch ($controller) {
        case 'admin':
            require_once($dir . '/views/' . $controller . '.php');
    }

    if (!method_exists($controller, $action)) {
        die('Không có action');
    }

    session_unset();

    switch ($action) {
        case 'sanpham':
        case 'SanPham': {
                $_SESSION['get'] = $controllerObject->sanpham();
                break;
            }
        case 'nhapxuat':
        case 'NhapXuat': {
                $_SESSION['get'] = $controllerObject->nhapxuat();
                break;
            }
        case 'doitac':
        case 'DoiTac': {
                $_SESSION['get'] = $controllerObject->doitac();
                break;
            }
        case 'taikhoan':
        case 'TaiKhoan': {
                $_SESSION['get'] = $controllerObject->taikhoan();
                break;
            }
    }
}


if (isset($_POST['action'])) {
    if (isset($_FILES['anhDaiDien']['tmp_name'])) {
        $_POST['anhDaiDien'] = $_FILES['anhDaiDien'];
    }
    $controller = $_GET['controller'];
    require_once($dir . '/controllers/' . $controller . '.php');
    $controllerObject = new $controller;
    switch ($controller) {
        case 'admin': {
                switch ($_GET['action']) {
                    case 'sanpham':
                    case 'SanPham': {
                            echo json_encode($controllerObject->sanpham($_POST));
                            break;
                        }
                    case 'nhapxuat':
                    case 'NhapXuat': {
                            echo json_encode($controllerObject->nhapxuat($_POST));
                            break;
                        }
                    case 'doitac':
                    case 'DoiTac': {
                            echo json_encode($controllerObject->doitac($_POST));
                            break;
                        }
                    case 'taikhoan':
                    case 'TaiKhoan': {
                            echo json_encode($controllerObject->taikhoan($_POST));
                            break;
                        }
                }
                break;
            }
    }
}
