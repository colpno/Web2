<?php
class BaseController
{
    private const VIEW_PATH = __DIR__ . '/../views/';
    private const MODEL_PATH = __DIR__ . '/../models/';

    protected function view($view, array $data = [], $json = false)
    {
        // foreach ($data as $key => $value) {
        //     $$key = $value;
        // }
        $filePath = self::VIEW_PATH . $view . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }

    protected function model($model)
    {
        $completeFileName = $model . 'Model';
        $filePath = self::MODEL_PATH . $completeFileName . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return new $completeFileName;
        }
    }
}
