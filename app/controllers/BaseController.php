<?php
class BaseController
{
    private const VIEW_PATH = __DIR__ . '/../views/';
    private const MODEL_PATH = __DIR__ . '/../models/';

    protected function view($fileName, array $data = [], $print = true)
    {
        $fileName = self::VIEW_PATH . $fileName . '.php';

        $output = NULL;
        if (file_exists($fileName)) {
            extract($data);
            ob_start();
            include $fileName;
            $output = ob_get_clean();
        }
        if ($print) {
            print $output;
        }
        return $output;
    }
}
