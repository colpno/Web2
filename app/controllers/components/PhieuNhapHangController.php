<?php
class PhieuNhapHangController extends BaseController
{
    private $phieuNhapHangModel;
    private $nhaCungCapModel;
    private $nhanVienModel;
    private $AllRowLength;
    private $uploadInstance;
    private $alert;

    public function __construct()
    {
        $this->phieuNhapHangModel = new PhieuNhapHangModel();

        $this->alert = new Other();
    }

    public function findMax($col)
    {
        $found = $this->phieuNhapHangModel->getMaxCol($col);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->phieuNhapHangModel->getMinCol($col);

        return $found;
    }

    public function countRow($col)
    {
        $number = $this->phieuNhapHangModel->countRow($col);

        return $number;
    }

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->phieuNhapHangModel->countRow())[0];
        }
        $phieuNhapHang = $this->phieuNhapHangModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages();

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($phieuNhapHang);

        return [
            'PNHArr' => $phieuNhapHang,
            'PNHPages' => $numOfPages
        ];
    }

    public function add($data)
    {
        if (
            $data['maNCC']
            && $data['maNV']
            && $data['ngayNhap']
            && $data['tongTien']
        ) {
            $maxID = array_values($this->phieuNhapHangModel->getMaxCol())[0];
            $fileName = "PNH-" .  ($maxID + 1);

            $values = $this->getValues($data);;
            $this->phieuNhapHangModel->post($values, $maxID + 1);
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
            && $data['tongTien']
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
            $this->phieuNhapHangModel->delete($data['maPhieu']);
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'PNHFound' => $found,
                'PNHFoundPages' => $numOfPages
            ];
        } else {
            $this->alert->alert("Thiếu thông tin cần thiết để tìm kiếm");
        }
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'PNHFound' => $found,
                'PNHFoundPages' => $numOfPages
            ];
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'PNHFound' => $found,
                'PNHFoundPages' => $numOfPages
            ];
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'PNHFound' => $found,
                'PNHFoundPages' => $numOfPages
            ];
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
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'PNHFiltered' => $filtered,
                'PNHFilteredPages' => $numOfPages
            ];
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
            $numOfPages = $this->getNumOfPages($sorted);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($sorted);

            return [
                'PNHSorted' => $sorted,
                'PNHSortedPages' => $numOfPages
            ];
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
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'PNHFiltered' => $filtered,
                'PNHFilteredPages' => $numOfPages
            ];
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
            'tongTien' => $data['tongTien'],
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

    private function getNumOfPages($list = [])
    {
        if (empty($list)) {
            return ceil($this->AllRowLength / $this->getPage()['limit']);
        } else {
            return ceil(count($list) / $this->getPage()['limit']);
        }
    }

    private function dieIfPageNotValid($numOfPages)
    {
        if ($this->getPage()['current'] > $numOfPages) {
            die('ERROR');
        }
    }

    private function changeProp(&$list)
    {
        require_once(__DIR__ . '/../models/NhaCungCapModel.php');
        require_once(__DIR__ . '/../models/NhanVienModel.php');

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
            'limit' => 15
        ];
    }
}
