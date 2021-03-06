<?php
class PhieuNhapHangController extends BaseController
{
    private $phieuNhapHangModel;
    private $nhaCungCapModel;
    private $nhanVienModel;
    private $AllRowLength;
    private $limit = 15;
    private $alert;

    public function __construct()
    {
        $this->phieuNhapHangModel = new PhieuNhapHangModel();
        $this->alert = new Other();
    }

    public function countRow($col)
    {
        $number = $this->phieuNhapHangModel->countRow($col);

        return $number;
    }

    public function get($page = [])
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->phieuNhapHangModel->countRow())[0];
        }
        $phieuNhapHang   = [];
        if (!empty($page)) {
            $phieuNhapHang  = $this->phieuNhapHangModel->get($page, 'desc');
        } else {
            $phieuNhapHang = $this->phieuNhapHangModel->get($this->getPage(), 'desc');
        }
        $numOfPages = $this->getNumOfPages($phieuNhapHang['pages']);

        $phieuNhapHang['pages'] = $numOfPages;


        $this->changeProp($phieuNhapHang['data']);

        return $phieuNhapHang;
    }

    public function add($data)
    {
        if (
            $data['maNCC']
            && $data['maNV']
            && $data['ngayNhap']
        ) {
            $data['ngayNhap'] = "'" . $data['ngayNhap'] . "'";
            $values = $this->getValues($data);
            $this->phieuNhapHangModel->post($values);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để thêm");
        }
    }

    public function update($data)
    {
        if (
            $data['maPhieu']
            && $data['maNCC']
            && $data['maNV']
            && $data['ngayNhap']
        ) {
            $id = $data['maPhieu'];
            $values = $this->getValues($data);
            $this->phieuNhapHangModel->update($values, $id);
            return $this->get();
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để sửa đổi");
        }
    }

    public function delete($data)
    {
        if (
            $data['maPhieu']
        ) {
            $remove = [
                'id' => $data['maPhieu'],
            ];
            $this->phieuNhapHangModel->delete($remove);
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
            $found = $this->phieuNhapHangModel->find($data['search'], $this->getPage());
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
        $found = $this->phieuNhapHangModel->getMaxCol($col);

        $this->changeProp($found['data']);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->phieuNhapHangModel->getMinCol($col);

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
            $filtered = $this->phieuNhapHangModel->filter($filterValues, $this->getPage());
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
            $sorted = $this->phieuNhapHangModel->sort($data, $this->getPage());
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
            'maNCC' => $data['maNCC'],
            'maNV' => $data['maNV'],
            'ngayNhap' => $data['ngayNhap'],
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
            die('ERROR');
        }
    }

    private function changeProp(&$list)
    {
        require_once(__DIR__ . '/../../models/NhaCungCapModel.php');
        require_once(__DIR__ . '/../../models/NhanVienModel.php');

        $this->nhaCungCapModel = new NhaCungCapModel();
        $this->nhanVienModel = new NhanVienModel();

        $length = count($list);
        for ($i = 0; $i < $length; $i++) {
            $list[$i]['nhanVien'] = $this->nhanVienModel->getRow('maNV', $list[$i]['maNV']);
            unset($list[$i]['maNV']);

            $list[$i]['nhaCungCap'] = $this->nhaCungCapModel->getRow('maNCC', $list[$i]['maNCC']);
            unset($list[$i]['maNCC']);
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
        return $this->phieuNhapHangModel->thongke($year, $yearCol, ...$cols);
    }
}
