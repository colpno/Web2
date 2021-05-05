<?php
class QuyenChucNangController extends BaseController
{
    private $quyenChucNangModel;
    private $chucNangModel;
    private $quyenModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->quyenChucNangModel = new QuyenChucNangModel();

        $this->alert = new Other();
    }

    public function findMax($col)
    {
        $found = $this->quyenChucNangModel->getMaxCol($col);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->quyenChucNangModel->getMinCol($col);

        return $found;
    }

    public function countRow($col)
    {
        $number = $this->quyenChucNangModel->countRow($col);

        return $number;
    }

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->quyenChucNangModel->countRow())[0];
        }
        $quyenChucNang = $this->quyenChucNangModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages($quyenChucNang['pages']);


        $this->changeProp($quyenChucNang['data']);

        return $quyenChucNang;
    }

    public function update($data)
    {
        if (
            $data['maQuyen']
            && $data['maCN']
        ) {
            $this->quyenChucNangModel->update($data);
            return $this->get();
        }
    }

    private function getNumOfPages($number)
    {
        return ceil((int) $number / $this->getPage()['limit']);
    }

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->getPage()['current'] > $numOfPages) {
            die('ERROR');
        }
    }

    private function changeProp(&$list)
    {
        require_once(__DIR__ . '/../../models/QuyenModel.php');
        require_once(__DIR__ . '/../../models/ChucNangModel.php');

        $this->chucNangModel = new ChucNangModel();
        $this->quyenModel = new QuyenModel();

        $length = count($list);
        for ($i = 0; $i < $length; $i++) {
            $list[$i]['quyen'] = $this->quyenModel->getRow('maQuyen', $list[$i]['maQuyen']);
            unset($list[$i]['maQuyen']);

            $list[$i]['chucNang'] = $this->chucNangModel->getRow('maCN', $list[$i]['maCN']);
            unset($list[$i]['maCN']);
        }
        return $list;
    }

    private function getPage()
    {
        return [
            'current' => isset($_GET['page']) ? $_GET['page'] : 1,
            'limit' => $this->limit
        ];
    }
}
