<?php
$dir = __DIR__;
$uriGetParam = isset($_GET['uri']) ? '/' . $_GET['uri'] : '/';
$splitUri = explode('/', $uriGetParam);
$upperCaseUri = preg_replace_callback("/^(.)|\_./", function ($match) {
    return strtoupper($match[0]);
}, $splitUri[1]);
$param = str_replace('_', '', $upperCaseUri);
$controllerName = $splitUri[1] == '' ? 'SanPhamController' :  "${param}Controller";
$modelName = $splitUri[1] == '' ? 'SanPhamModel' :  "${param}Model";
$actionName = strtolower($_REQUEST['f'] ?? 'index');

require "$dir/../config/database/Database.php";
require "$dir/controllers/BaseController.php";
require "$dir/controllers/$controllerName.php";
require "$dir/models/BaseModel.php";
require "$dir/models/$modelName.php";

require "$dir/../common/UploadImage.php";
require "$dir/../common/Other.php";

$controllerObject = new $controllerName;
if (!isset($_POST['action'])) {
    $controllerObject->index();
}
if (isset($_POST['action'])) {
    $data = $_POST;
    if (array_key_exists('anhDaiDien', $_FILES)) {
        $data['anhDaiDien'] = $_FILES['anhDaiDien'];
    }

    switch ($_POST['action']) {
        case "add": {
                $controllerObject->add($data);
                break;
            }
        case "update": {
                $controllerObject->update($data);
                break;
            }
        case "delete": {
                $controllerObject->delete($data);
                break;
            }
        case "find": {
                $controllerObject->find($data);
                break;
            }
        case "findWithSort": {
                $controllerObject->findWithSort($data);
                break;
            }
        case "findWithFilter": {
                $controllerObject->findWithFilter($data);
                break;
            }
        case "findWithFilterAndSort": {
                $controllerObject->findWithFilterAndSort($data);
                break;
            }
        case "filter": {
                $controllerObject->filter($data);
                break;
            }
        case "filterAndSort": {
                $sortCol = $_GET['sortCol'];
                $order = $_GET['order'];
                $controllerObject->sortAndFilter($data);
                break;
            }
    }
}

if (isset($_GET['order'], $_GET['sortCol'])) {
    $controllerObject->sort();
}
