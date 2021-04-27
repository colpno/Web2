<?php
class Route
{
    private $_uri = array();
    private $_method = array();

    public function add($uri, $method = null)
    {
        $this->_uri[] = '/' . trim($uri, '/');

        if ($method != null) {
            $this->_method[] = $method;
        }
    }

    public function submit()
    {
        $dir = __DIR__;

        require "$dir/../config/database/Database.php";
        require "$dir/../app/controllers/BaseController.php";
        require "$dir/../app/models/BaseModel.php";
        require "$dir/../common/UploadImage.php";
        require "$dir/../common/Other.php";

        $uriGetParam = isset($_GET['uri']) ? '/' . $_GET['uri'] : '/';

        foreach ($this->_uri as $key => $value) {
            if (preg_match("#^$value$#", $uriGetParam)) {
                if (is_string($this->_method[$key])) {
                    $useMethod = $this->_method[$key];
                }
            }
        }
    }
}
