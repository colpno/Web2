<?php
session_start();
$dir = __DIR__;

require "$dir/../config/database/Database.php";
require "$dir/controllers/BaseController.php";
require "$dir/models/BaseModel.php";

require "$dir/../common/UploadImage.php";
require "$dir/../common/Other.php";

if (!isset($_POST['action'])) {
    if (isset($_COOKIE['user'])) {
        $userC = json_decode($_COOKIE['user'], true);
        if ($userC['quyen'] == 3) {
            echo "
            <script>
                window.location='http://localhost:8080/Web2';
            </script>
        ";
        }
    } else {
        echo "
            <script>
                window.location='http://localhost:8080/Web2';
            </script>
        ";
    }
    $uri = isset($_GET['uri']) ? $_GET['uri'] : "";
    $splitUri = explode("/", $uri);
    $controller = 'admin';
    $action = isset($splitUri[0]) ? $splitUri[0] : 'sanpham';
    $controllerObject = null;

    if (!isset($_COOKIE['past'])) {
        setcookie("past", $action, time() + 60 * 60);
    }
    require_once($dir . '/controllers/' . $controller . '.php');
    $controllerObject = new $controller;

    if (isset($_COOKIE['past']) && $_COOKIE['past'] != $action) {
        echo "
            <script>
                window.location=window.location.href;
            </script>
        ";
        setcookie("past", $action, time() + 60 * 60);
    }

    unset($_SESSION['get']);

    $_SESSION['quyen'] = $controllerObject->quyen();

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
        case 'thongke':
        case 'ThongKe': {
                $_SESSION['get'] = $controllerObject->thongke();
                break;
            }
        case 'quyen':
        case 'Quyen': {
                $_SESSION['get'] = $controllerObject->quyen();
                break;
            }
        default: {
                header('Location: http://localhost:8080/Web2');
                break;
            }
    }

    require_once($dir . '/views/admin.php');
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
                    case 'thongke':
                    case 'ThongKe': {
                            echo json_encode($controllerObject->thongke($_POST));
                            break;
                        }
                    case 'quyen':
                    case 'Quyen': {
                            echo json_encode($controllerObject->quyen($_POST));
                            break;
                        }
                }
                break;
            }
    }
}
