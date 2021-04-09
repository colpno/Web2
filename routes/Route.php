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
        $uriGetParam = isset($_GET['uri']) ? '/' . $_GET['uri'] : '/';
        $arrCount = count($this->_uri);

        foreach ($this->_uri as $key => $value) {
            if (preg_match("#^$value$#", $uriGetParam)) {
                $useMethod = $this->_method[$key];

                require_once('./app/index.php');

                // new $useMethod;
                break;
            }
            if ($arrCount === $key + 1) {
                die("ERROR");
            }
        }
    }
}
