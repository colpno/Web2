<?php
class HoaDonController extends BaseController
{
    private $hoaDonModel;
    private $khachHangModel;
    private $nhanVienModel;
    private $AllRowLength;
    private $uploadInstance;
    private $alert;

    public function __construct()
    {
        $this->hoaDonModel = new HoaDonModel();

        $this->alert = new Other();
    }

    public function findMax($col)
    {
        $found = $this->hoaDonModel->getMaxCol($col);

        return  $found;
    }

    public function findMin($col)
    {
        $found = $this->hoaDonModel->getMinCol($col);

        return $found;
    }

    public function countRow($col)
    {
        $number = $this->hoaDonModel->countRow($col);

        return $number;
    }

    public function get()
    {
        if (!$this->AllRowLength) {
            $this->AllRowLength = array_values($this->hoaDonModel->countRow())[0];
        }
        $hoaDon = $this->hoaDonModel->get($this->getPage());
        $numOfPages = $this->getNumOfPages();

        $this->dieIfPageNotValid($numOfPages);
        $this->changeProp($hoaDon);

        return [
            'HDArr' => $hoaDon,
            'HDPages' => $numOfPages
        ];
    }

    public function add($data)
    {
        if (
            $data['maKH']
            && $data['maNV']
            && $data['ngayLapHoaDon']
            && $data['tongTien']
        ) {
            $maxID = array_values($this->hoaDonModel->getMaxCol())[0];
            $fileName = "HD-" .  ($maxID + 1);

            $values = $this->getValues($data);;
            $this->hoaDonModel->post($values, $maxID + 1);
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

    public function delete($data)
    {
        if (
            $data['maHD']
        ) {
            $this->hoaDonModel->delete($data['maHD']);
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
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'HDFound' => $found,
                'HDFoundPages' => $numOfPages
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
            $found = $this->hoaDonModel->findWithFilter($data['search'], $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'HDFound' => $found,
                'HDFoundPages' => $numOfPages
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
            $found = $this->hoaDonModel->findWithSort($data['search'], $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'HDFound' => $found,
                'HDFoundPages' => $numOfPages
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
            $found = $this->hoaDonModel->findWithFilterAndSort($data['search'], $filterValues, $sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($found);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($found);

            return [
                'HDFound' => $found,
                'HDFoundPages' => $numOfPages
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
            $filtered = $this->hoaDonModel->filter($filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'HDFiltered' => $filtered,
                'HDFilteredPages' => $numOfPages
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
            $sorted = $this->hoaDonModel->sort($sortValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($sorted);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($sorted);

            return [
                'HDSorted' => $sorted,
                'HDSortedPages' => $numOfPages
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
            $filtered = $this->hoaDonModel->filterAndSort($sortValues, $filterValues, $this->getPage());
            $numOfPages = $this->getNumOfPages($filtered);

            $this->dieIfPageNotValid($numOfPages);
            $this->changeProp($filtered);

            return [
                'HDFiltered' => $filtered,
                'HDFilteredPages' => $numOfPages
            ];
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
        require_once(__DIR__ . '/../models/KhachHangModel.php');
        require_once(__DIR__ . '/../models/NhanVienModel.php');

        $this->khachHangModel = new KhachHangModel();
        $this->nhanVienModel = new NhanVienModel();

        $length = count($list);
        for ($i = 0; $i < $length; $i++) {
            $list[$i]['nhanVien'] = $this->nhanVienModel->getRow('maNV', $list[$i]['maNV']);
            unset($list[$i]['maNV']);

            $list[$i]['khachHang'] = $this->khachHangModel->getRow('maKH', $list[$i]['maKH']);
            unset($list[$i]['maKH']);
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
