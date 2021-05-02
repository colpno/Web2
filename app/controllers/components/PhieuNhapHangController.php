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
            $page['limit'] = $this->getPage()['limit'];
            $phieuNhapHang  = $this->phieuNhapHangModel->get($page, 'desc');
        } else {
            $phieuNhapHang = $this->phieuNhapHangModel->get($this->getPage(), 'desc');
        }
        $numOfPages = $this->getNumOfPages($phieuNhapHang['pages']);

        $phieuNhapHang['pages'] = $numOfPages;

        $this->dieIfPageNotValid($numOfPages);
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
            $maxID = array_values($this->phieuNhapHangModel->getMaxCol())[0];



            $values = $this->getValues($data);
            $this->phieuNhapHangModel->post($values);
            return $this->get($data);
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
            return $this->get($data);
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
            $error = $this->phieuNhapHangModel->delete($remove);
            if (!empty($error)) {
                return $this->alert->alert($error);
            };
            return $this->get($data);
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

            $this->dieIfPageNotValid($numOfPages);
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

    public function findWithFilter($data)
    {
        if (
            $data['search']
            && $data['filterCol']
            && $data['from']
            && $data['to']
        ) {
            $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
            $found = $this->phieuNhapHangModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found['data']);

            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findWithSort($data)
    {
        if (
            $data['search']
            && $_GET['sortCol']
            && $_GET['order']
        ) {
            $sortValues = $this->getSortValues();
            $found = $this->phieuNhapHangModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found['data']);

            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
    }

    public function findWithFilterAndSort($data)
    {
        if (
            $data['search']
            && $data['filterCol']
            && $data['from']
            && $data['to']
        ) {
            $sortValues = $this->getSortValues();
            $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
            $found = $this->phieuNhapHangModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found['pages']);

            $found['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found['data']);

            return $found;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
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

            $this->dieIfPageNotValid($numOfPages);
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
            $sorted = $this->phieuNhapHangModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted['pages']);

            $sorted['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($sorted['data']);

            return $sorted;
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để lọc");
        }
    }

    public function filterAndSort($data)
    {
        if (
            $data['filterCol']
            && $data['from']
            && $data['to']
            && $_GET['sortCol']
            && $_GET['order']
        ) {
            $sortValues = $this->getSortValues();
            $filterValues = $this->getFilterValues($data['filterCol'], $data['from'], $data['to']);
            $filtered = $this->phieuNhapHangModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered['pages']);

            $filtered['pages'] = $numOfPages;

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered['data']);

            return $filtered;
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

    public function thongke()
    {
        return $this->phieuNhapHangModel->thongke();
    }
}
