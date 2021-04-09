<?php
class UploadImage
{
    private $noiChuaFile;
    public $duongDanDenFile;
    private $fileTam;
    private $trangThai;
    private $loaiFile;

    public function __construct($folder)
    {
        $this->noiChuaFile = __DIR__ . '/../public/images/' . $folder . '/';
        $this->trangThai = 1;
    }
    public function upload($fileName)
    {
        if ($_FILES['image']) {
            $img = $_FILES['image']['name'];
            $this->loaiFile = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            $this->fileTam = $_FILES['image']['tmp_name'];
            $this->duongDanDenFile = $this->noiChuaFile . $fileName . '.' . $this->loaiFile;

            if ($this->checkSuccess()) {
                if (move_uploaded_file($this->fileTam, $this->duongDanDenFile)) {
                    echo "Upload success !!!";
                } else echo "wrong";
            }
        } else {
            echo "Failed";
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
