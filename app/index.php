<?php
$dir = __DIR__;

require "$dir/../config/database/Database.php";
require "$dir/controllers/BaseController.php";
require "$dir/models/BaseModel.php";

require "$dir/../common/UploadImage.php";
require "$dir/../common/Other.php";

$uriGetParam = isset($_GET['uri']) ?  $_GET['uri'] : '/';
$splitUri = explode('/', $uriGetParam);
$splitUri = array_values($splitUri);

$controller = 'Admin';
$action = 'SanPham';
$params = [];
$controllerObject = null;

$controllerName = $splitUri[0];
if (file_exists('app/controllers/' . $controllerName . '.php')) {
    $controller = $controllerName;
}
unset($splitUri[0]);
require_once($dir . '/controllers/' . $controller . '.php');

$controllerObject = new $controller;

if (!isset($_POST['action'])) {
    session_start();

    require_once($dir . '/views/' . $controller . '.php');
    $actionName = $splitUri[1];
    if (isset($actionName) && method_exists($controller, $actionName)) {
        $action = $actionName;
    }
    unset($splitUri[1]);
    $_SESSION['get'] = $controllerObject->$action();

    $params = $splitUri ? array_values($splitUri) : [];
}

if (isset($_POST['action'])) {
    switch ($controller) {
        case 'Admin': {
                ($controllerObject->SanPham($_POST));
            }
            // case "add": {
            //         $controllerObject->add($data);
            //         break;
            //     }
            // case "update": {
            //         $controllerObject->update($data);
            //         break;
            //     }
            // case "delete": {
            //         $controllerObject->delete($data);
            //         break;
            //     }
            // case "find": {
            //         $controllerObject->find($data);
            //         break;
            //     }
            // case "findWithSort": {
            //         $controllerObject->findWithSort($data);
            //         break;
            //     }
            // case "findWithFilter": {
            //         $controllerObject->findWithFilter($data);
            //         break;
            //     }
            // case "findWithFilterAndSort": {
            //         $controllerObject->findWithFilterAndSort($data);
            //         break;
            //     }
            // case "filter": {
            //         $controllerObject->filter($data);
            //         break;
            //     }
            // case "filterAndSort": {
            //         $sortCol = $_GET['sortCol'];
            //         $order = $_GET['order'];
            //         $controllerObject->sortAndFilter($data);
            //         break;
            //     }
            // case "sort": {
            //         $controllerObject->sort();
            //     }
    }
}
