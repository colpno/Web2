<?php
class UploadImage
{
    public $noiChuaFile;
    private $duongDanDenFile;
    private $fileTam;
    private $trangThai;
    private $loaiFile;

    public function __construct($folder)
    {
        $this->noiChuaFile = '/../public/images/' . $folder . '/';
        $this->trangThai = 1;
    }
    public function upload($fileName)
    {
        $alert = new Other();
        if ($_FILES) {
            $img = $_FILES['anhDaiDien']['name'];

            $this->loaiFile = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            $this->noiChuaFile = $this->noiChuaFile . $fileName . '.' . $this->loaiFile;
            $this->duongDanDenFile = __DIR__ . $this->noiChuaFile;
            $this->fileTam = $_FILES['anhDaiDien']['tmp_name'];

            if ($this->checkSuccess()) {
                if (move_uploaded_file($this->fileTam, $this->duongDanDenFile)) {
                } else {
                    $alert->alert('Error while upload file');
                }
            }
        } else {
            $alert->alert('$_FILES empty');
        }
    }

    private function checkExisted()
    {
        if (file_exists($this->duongDanDenFile)) {
            $this->trangThai = 0;
        }
    }

    private function checkExtension()
    {
        if ($this->loaiFile != 'jpg' && $this->loaiFile != 'png') {
            $this->trangThai = 0;
        }
    }

    private function checkSuccess()
    {
        $this->checkFakeImage();
        $this->checkExisted();
        $this->checkExtension();
        if ($this->trangThai == 0) {
            return false;
        }
        return true;
    }

    private function checkFakeImage()
    {
        if (isset($_POST['submit'])) {
            $check = getimagesize($this->fileTam);
            if ($check == false) {
                $this->trangThai = 0;
            } else {
                $this->trangThai = 1;
            }
        }
    }
}
