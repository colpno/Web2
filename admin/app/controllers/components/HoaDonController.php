<?php
class HoaDonController extends BaseController
{
    private $hoaDonModel;
    private $khachHangModel;
    private $nhanVienModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->hoaDonModel = new HoaDonModel();

        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->hoaDonModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->hoaDonModel->countRow())[0];
        }
        $hoaDon  = [];
        if (!empty($page)) {
            if (isset($page['tinhTrang']) && $page['tinhTrang'] != null) {
                $page['id'] = $page['tinhTrang'];
                $page['col'] = 'tinhTrang';
                $page['limit'] = $this->getPage()['limit'];
                $page['current'] = $this->getPage()['current'];
            }
            $hoaDon   = $this->hoaDonModel->get($page, 'desc');
        } else {
            $hoaDon = $this->hoaDonModel->get($this->getPage(), 'desc');
        }
        $numOfPages = $this->getNumOfPages($hoaDon['pages']);

        $hoaDon['pages'] = $numOfPages;


        $this->changeProp($hoaDon['data']);

        return $hoaDon;
    }

    public function getAll()
    {
        $hoaDon  = [];
        $hoaDon = $this->hoaDonModel->getAll();
        return $hoaDon;
    }

    public function getMax($col)
    {
        return array_values($this->hoaDonModel->getMaxCol($col))[0];
    }

    public function add($data)
    {
        if (
            $data['maKH']
            && $data['maNV']
            && $data['ngayLapHoaDon']
            && $data['tongTien']
        ) {
            $values = $this->getValues($data);
            $this->hoaDonModel->post($values);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maHD']
            && $data['maKH']
            && $data['maNV']
            && $data['ngayLapHoaDon']
            && $data['tongTien']
        ) {
            $id = $data['maHD'];
            $values = $this->getValues($data);
            $this->hoaDonModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function capNhatTinhTrang($data)
    {
        if (
            $data['maHD']
            && $data['tinhTrang']
        ) {
            $this->hoaDonModel->capNhatTinhTrang($data);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maHD']
        ) {
            $remove = [
                'id' => $data['maHD'],
            ];
            $this->hoaDonModel->delete($remove);
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
            $found = $this->hoaDonModel->find($data['search'], $this->getPage());
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
        $found = $this->hoaDonModel->getMaxCol($col);

        $this->changeProp($found['data']);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->hoaDonModel->getMinCol($col);

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
            $filtered = $this->hoaDonModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;


            $this->changeProp($filtered['data']);

            return $filtered;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    public function sort($data)
    {
        if (
            $data['sortCol']
            && $data['order']
        ) {
            $sorted = $this->hoaDonModel->sort($data, $this->getPage());
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
            'maKH' => $data['maKH'],
            'maNV' => $data['maNV'],
            'ngayLapHoaDon' => $data['ngayLapHoaDon'],
            'tongTien' => $data['tongTien'],
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

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->getPage()['current'] > $numOfPages) {
            die('HoaDonController - 216: ERROR');
        }
    }

    private function changeProp(&$list)
    {
        require_once(__DIR__ . '/../../models/KhachHangModel.php');
        require_once(__DIR__ . '/../../models/NhanVienModel.php');

        $this->khachHangModel = new KhachHangModel();
        $this->nhanVienModel = new NhanVienModel();

        if ($list != null) {
            $length = count($list);
            for ($i = 0; $i < $length; $i++) {
                $list[$i]['nhanVien'] = $this->nhanVienModel->getRow('maNV', $list[$i]['maNV']);
                unset($list[$i]['maNV']);

                $list[$i]['khachHang'] = $this->khachHangModel->getRow('maKH', $list[$i]['maKH']);
                unset($list[$i]['maKH']);
            }
            return $list;
        }
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
        return $this->hoaDonModel->thongke($year, $yearCol, ...$cols);
    }
}
