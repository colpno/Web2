<?php
class TaiKhoanController extends BaseController
{
    private $taiKhoanModel;
    private $quyenModel;
    private $AllRowLength;
    private $uploadInstance;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->taiKhoanModel = new TaiKhoanModel();
        $this->uploadInstance = new UploadImage("TaiKhoan");

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->taiKhoanModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->taiKhoanModel->countRow())[0];
        }
        $taiKhoan  = [];
        if (!empty($page)) {
            $taiKhoan   = $this->taiKhoanModel->get($page);
        } else {
            $taiKhoan = $this->taiKhoanModel->get($this->getPage());
        }
        $numOfPages = $this->getNumOfPages($taiKhoan['pages']);

        $taiKhoan['pages'] = $numOfPages;


        $this->changeProp($taiKhoan['data']);

        return $taiKhoan;
    }

    public function add($data)
    {
        if (
            $data['maQuyen']
            && $data['tenTaiKhoan']
            && $data['matKhau']
            && $data['anhDaiDien']
        ) {
            if (array_key_exists('ho', $data)) {
                if (array_key_exists('luong', $data)) {
                    require_once(__DIR__ . '/NhanVienController.php');
                    $nhanVien = new NhanVienController();
                    $data['maTK'] = $this->taiKhoanModel->countRow('maTK')['soLuong'] + 1;
                    $nhanVien->add($data);
                }
                if (!array_key_exists('luong', $data)) {
                    require_once(__DIR__ . '/KhachHangController.php');
                    $khachHang = new KhachHangController();
                    $data['maTK'] = $this->taiKhoanModel->countRow('maTK')['soLuong'] + 1;
                    $khachHang->add($data);
                }
            }
            $data['matKhau'] = password_hash($data['matKhau'], PASSWORD_DEFAULT);
            $values = $this->getValues($data);
            $maxID = array_values($this->taiKhoanModel->getMaxCol())[0];
            $this->taiKhoanModel->post($values, $maxID);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maTK']
            && $data['maQuyen']
            && $data['tenTaiKhoan']
            && $data['matKhau']
            && $data['anhDaiDien']
        ) {
            $id = $data['maTK'];
            $values = $this->getValues($data);
            $this->taiKhoanModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function capNhatTrangThai($data)
    {
        if (
            $data['maTK']
            && $data['trangThai'] != null
        ) {
            $this->taiKhoanModel->capNhatTrangThai($data);
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }


    public function delete($data)
    {
        if (
            $data['maTK']
            && $data['anhDaiDien']
        ) {
            $remove = [
                'id' => $data['maTK'],
                'imgPath' => $data['anhDaiDien']
            ];
            $this->taiKhoanModel->delete($remove);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để xóa");
        }
    }

    public function find($data)
    {
        if (
            $data['search']
        ) {
            $found = $this->taiKhoanModel->find($data['search'], $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;


            $this->changeProp($found['data']);

            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findMax($col)
    {
        $found = $this->taiKhoanModel->getMaxCol($col);

        $this->changeProp($found['data']);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->taiKhoanModel->getMinCol($col);

        $this->changeProp($found['data']);

        return $found;
    }

    public function filter($data)
    {
        if (
            $data['filterCol']
            && $data['from']
            && $data['to']
        ) {
            $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
            $filtered = $this->taiKhoanModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;


            $this->changeProp($filtered['data']);

            return $filtered;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    public function sort()
    {
        if (
            $_GET['sortCol']
            && $_GET['order']
        ) {
            $sortValues = $this->getSortValues();
            $sorted = $this->taiKhoanModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted['pages']);

            $sorted['pages'] = $numOfPages;


            $this->changeProp($sorted['data']);

            return $sorted;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    private function getValues($data)
    {
        return [
            'maQuyen' => $data['maQuyen'],
            'tenTaiKhoan' => $data['tenTaiKhoan'],
            'matKhau' => $data['matKhau'],
            'trangThai' => 0,
            'anhDaiDien' => $data['anhDaiDien'],
            'dangNhap' => 0,
        ];
    }

    private function getSortValues()
    {
        return [
            'sortCol' => $_GET['sortCol'],
            'order' => $_GET['order']
        ];
    }

    private function getFilterValues($col, $from, $to)
    {
        return [
            'filterCol' => $col,
            'from' => $from,
            'to' => $to
        ];
    }

    private function getNumOfPages($number)
    {
        return ceil((int) $number / $this->getPage()['limit']);
    }

    public function selectDisplay()
    {
        return $this->taiKhoanModel->selectDisplay();
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

        $this->quyenModel = new QuyenModel();

        $length = count($list);
        for ($i = 0; $i < $length; $i++) {
            $list[$i]['quyen'] = $this->quyenModel->getRow('maQuyen', $list[$i]['maQuyen']);
            unset($list[$i]['maQuyen']);
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

    public function thongke($year = null, $yearCol = null, ...$cols)
    {
        return $this->taiKhoanModel->thongke($year, $yearCol, ...$cols);
    }
}
