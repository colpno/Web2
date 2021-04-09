<?php
class BaseController
{
    private const VIEW_PATH = __DIR__ . '/../views/';
    private const MODEL_PATH = __DIR__ . '/../models/';

    protected function view($fileName, array $data = [])
    {
        $fileName = self::VIEW_PATH . $fileName . '.php';

        foreach ($data as $key => $value) {
            $$key = $value;
        }

        require_once $fileName;
    }
}
