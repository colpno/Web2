<?php
class BaseModel extends Database
{
    protected $conn;
    private $alert;

    protected function __construct()
    {
        $this->conn = $this->connect();
        $this->alert = new Other();
    }

    protected function countRowMethod($tableName, $primaryCol)
    {
        $sql = 'SELECT COUNT(' . $primaryCol . ') as soLuong FROM ' . $tableName;
        $query = $this->conn->query($sql);

        while ($row = mysqli_fetch_assoc($query)) {
            return $row;
        }
    }

    protected function getRowMethod($tableName, $col, $value)
    {
        if ($value != null) {
            $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $col . ' = ' . $value;
            $query = $this->conn->query($sql);

            while ($row = mysqli_fetch_assoc($query)) {
                return $row;
            }
        }
    }

    protected function getMaxMethod($tableName, $col)
    {
        $sql = 'SELECT ' . $col . ' FROM ' . $tableName . ' GROUP BY ' . $col . ' desc LIMIT 1';
        $query = $this->conn->query($sql);

        while ($row = mysqli_fetch_assoc($query)) {
            return $row;
        }
    }

    protected function getMinMethod($tableName, $col)
    {
        $sql = 'SELECT ' . $col . ' FROM ' . $tableName . ' GROUP BY ' . $col . ' asc LIMIT 1';
        $query = $this->conn->query($sql);

        while ($row = mysqli_fetch_assoc($query)) {
            return $row;
        }
    }

    protected function selectDisplayMethod($tableName, ...$col)
    {
        $cols = '';
        foreach ($col as $value) {
            $cols = $cols . $value . ',';
        }
        $cols = substr($cols, 0, -1);

        $sql = 'SELECT ' . $cols . ' FROM ' . $tableName;
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        return $data;
    }

    protected function getMethod($tableName, $data, $order = [])
    {
        $sql = '';
        if (!isset($data['current'])) {
            $data['current'] = 1;
        }
        if (empty($order)) {
            $sql = 'SELECT * FROM ' . $tableName . ' LIMIT ' . $data['limit'] . ' OFFSET ' . ($data['current'] - 1) * $data['limit'];
        } else {
            $sql = 'SELECT * FROM ' . $tableName . ' ORDER BY ' . $order['col'] . ' ' . $order['order'] . ' LIMIT ' . $data['limit'] . ' OFFSET ' . ($data['current'] - 1) * $data['limit'];
        }
        $numberOF = 'SELECT COUNT(*) FROM ' . $tableName;

        if (isset($data['id'])) {
            $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $data['col'] . ' = ' . $data['id'] . ' LIMIT ' . $data['limit'] . ' OFFSET ' . ($data['current'] - 1) * $data['limit'];
            $numberOF = 'SELECT * FROM ' . $tableName . ' WHERE ' . $data['col'] . ' = ' . $data['id'];
        }
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        $query = $this->conn->query($numberOF);
        $pages = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $pages = array_values($row)[0];
        }

        return [
            'data' => $data,
            'pages' => $pages
        ];
    }

    protected function getPrimaryCol($tableName)
    {
        $sql = 'SHOW KEYS FROM ' . $tableName . ' WHERE Key_name = "PRIMARY"';
        $query = $this->conn->query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        $key = array_column($data, 'Column_name');

        if (isset($key[0])) {
            return $key[0];
        }
        return null;
    }

    protected function postMethod($tableName, $data = [], $check = [], $maxID = null)
    {
        if (
            !empty($check) &&
            $this->checkExisting($tableName, $check['col'], $check['value'])
        ) {
            if ($tableName != 'chitietphieunhaphang') {
                die($check['value'] . ' đã tồn tại');
            } else {
                $this->congDonPNH($data);
                return;
            }
        }

        /* 
            Thêm file ảnh vào thư mục
         */
        $func = null;
        if (isset($data['anhDaiDien']) && $data['anhDaiDien'] != null && $maxID != null) {
            $func = $this->createImgFile($tableName, $maxID + 1, $data['anhDaiDien']);
            $data['anhDaiDien'] = $func['path'];
        }

        $dataStringValues = array_map(function ($value) {
            return "'$value'";
        }, array_values($data));
        $values = implode(",", array_values($dataStringValues));
        $columns = implode(",", array_keys($data));

        $resetAI = 'ALTER TABLE ' . $tableName . ' AUTO_INCREMENT = 1';
        if (!$this->conn->query($resetAI)) {
            return $this->conn->error;
        }

        $sql = "INSERT INTO $tableName($columns) VALUES ($values)";

        if ($this->conn->query($sql) or die($this->conn->error)) {
            if (isset($func['path']) && $func['path'] != "") {
                $func['instance']->upload($func['fileName']);
            }

            /* 
            Chi tiết phiếu nhập
            */
            if ($tableName == 'chitietphieunhaphang') {
                $this->sumChiTietPhieuNhap($data);
            }

            return;
        } else {
            return $this->conn->error;
        }
    }

    protected function postQuyenMethod($tableName, $data, $need, $check = [])
    {
        if (
            !empty($check) &&
            $this->checkExisting($tableName, $check['col'], $check['value'])
        ) {
            die($check['value'] . ' đã tồn tại');
        }

        // Reset AI
        $resetAI = 'ALTER TABLE ' . $tableName . ' AUTO_INCREMENT = 1';
        if (!$this->conn->query($resetAI)) {
            return $this->conn->error;
        }

        // Tạo chuỗi thêm
        $dataStringValues = array_map(function ($value) {
            return "'$value'";
        }, array_values($data));
        $values = implode(",", array_values($dataStringValues));
        $columns = implode(",", array_keys($data));

        // Thêm quyền / chức năng
        $sql = "INSERT INTO $tableName($columns) VALUES ($values)";
        $this->conn->query($sql);

        $colNeed = null;
        if (isset($data['tenQuyen'])) {
            $colNeed = 'maQuyen';
        }
        if (isset($data['tenCN'])) {
            $colNeed = 'maCN';
        }

        // Lấy maQuyen / maCN mới thêm
        $sql = "SELECT * FROM $tableName ORDER BY $colNeed desc LIMIT 1";
        $query = $this->conn->query($sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $colNeed = $row[$colNeed];
        }

        // Số chức năng / quyền
        $times = count($need['data']);

        // Thêm quyền chức năng
        $arr = [];
        if (isset($data['tenQuyen'])) {
            for ($i = 1; $i <= $times; $i++) {
                $arr[$i] = "($i,$colNeed,0)";
            }
        }
        if (isset($data['tenCN'])) {
            for ($i = 1; $i <= $times; $i++) {
                $arr[$i] = "($colNeed,$i,0)";
            }
        }
        $sql = "INSERT INTO quyenchucnang(maCN,maQuyen,hienThi) VALUES " . implode(',', $arr);
        $this->conn->query($sql);

        return;
    }

    protected function updateMethod($tableName, $data, $colID, $id)
    {
        $func = null;
        if (isset($data['anhDaiDien']) && !empty($data['anhDaiDien'])) {
            $func = $this->createImgFile($tableName, $id, $data['anhDaiDien']);
            $data['anhDaiDien'] = $func['path'];
        }

        $result = [];
        foreach ($data as $key => $value) {
            array_push($result, "$key = '$value'");
        }
        $result = implode(',', $result);

        $sql = 'UPDATE ' . $tableName . ' SET ' . $result . ' WHERE ' . $colID . ' = ' . $id;

        if ($this->conn->query($sql) or die($this->conn->error)) {
            if (isset($func['path']) && $func['path'] != "") {
                $func['instance']->upload($func['fileName']);
            }

            if ($tableName == 'chitietphieunhaphang') {
                $this->sumChiTietPhieuNhap($data);
            }
            return;
        } else {
            $this->alert->alert('Update failed');
        }
    }

    protected function capNhatTinhTrangMethod($tableName, $data)
    {
        $arrKeys = array_keys($data);
        $colSet = isset($data['tinhTrang']) ? array_search($data['tinhTrang'], $data) : array_search($data['trangThai'], $data);
        $colCondition = isset($data['maHD']) ? array_search($data['maHD'], $data) : array_search($data['maTK'], $data);
        $sql = "UPDATE $tableName SET $arrKeys[3] = " . $data[$colSet] . " WHERE $colCondition = " . $data[$colCondition];
        if ($this->conn->query($sql) or die($this->conn->error)) {
            return;
        } else {
            $this->alert->alert('Checked failure');
        }
    }

    /* 
        bang Quyen chuc nang
     */
    protected function updateQuCNMethod($tableName, $data)
    {
        $reset = 'UPDATE quyenchucnang SET hienthi = 0 WHERE hienThi = 1 AND maQuyen = ' . $data['maQuyen'];
        if (!$this->conn->query($reset)) {
            return $this->conn->error;
        }

        $sql = 'UPDATE quyenchucnang SET hienthi = 1 WHERE maQuyen = ' . $data['maQuyen'] . ' AND maCN IN (' . $data['maCN'] . ')';
        if ($this->conn->query($sql) or die($this->conn->error)) {
            return;
        } else {
            return $this->conn->error;
        }
    }

    protected function deleteMethod($tableName, $column, $data)
    {
        $id = '';
        if (isset($data['id']) && is_array($data['id'])) {
            $length = count($data['id']);
            for ($i = 0; $i < $length; $i++) {
                $id = $id . $data['id'][$i];
                if ($i != $length - 1) {
                    $id = $id . ',';
                }
            }
        } else
        if (isset($data['id']) && !is_array($data['id'])) {
            $id = $id . $data['id'];
        }
        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $column . ' IN (' . $id . ')';
        if ($this->conn->query($sql) or die($this->conn->error)) {
            if (isset($data['imgPath']) && $data['imgPath'] != null) {
                $status = 0;

                $filePath = substr($data['imgPath'], 0, strpos($data['imgPath'], "-")  + 1);
                $ext = substr($data['imgPath'], strrpos($data['imgPath'], "."));
                if (strpos($data['id'], ',')) {
                    $idArr = explode(',', $data['id']);
                    foreach ($idArr as $key => $value) {
                        if (unlink(__DIR__ . '/../../' . $filePath . $value .  $ext)) $status = 1;
                        else $status = 0;
                    }
                } else {
                    $filePath = substr($data['imgPath'], strpos($data['imgPath'], "public"));
                    if (unlink(__DIR__ . '/../../' . $filePath)) $status = 1;
                    else $status = 0;
                }
                if ($status == 0) {
                    return $this->alert->alert('No such file or directory');
                }
            }
            return;
        } else {
            return $this->conn->error;
        }
    }

    protected function deleteWithFKMethod($tableName, $FKTableName, $col, $data)
    {
        $id = '';
        if (isset($data['id']) && is_array($data['id'])) {
            $length = count($data['id']);
            for ($i = 0; $i < $length; $i++) {
                $id = $id . $data['id'][$i];
                if ($i != $length - 1) {
                    $id = $id . ',';
                }
            }
        } else
        if (isset($data['id']) && !is_array($data['id'])) {
            $id = $id . $data['id'];
        }

        $sql = 'DELETE FROM ' . $FKTableName . ' WHERE ' . $col . ' = ' . $id;
        $this->conn->query($sql) or die($this->conn->error);

        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $col . ' = ' . $id;
        $this->conn->query($sql) or die($this->conn->error);
        return;
    }

    protected function deleteChiTietMethod($tableName,  $data)
    {
        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $data['colChiTiet'] . ' IN (' . $data['valueChiTiet'] .
            ') AND ' . $data['col'] . ' = ' . $data['value'];
        $this->conn->query($sql) or die($this->conn->error);

        $data['maPhieu'] = $data['value'];
        $this->sumChiTietPhieuNhap($data);
        return;
    }

    protected function findMethod($tableName, $findValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'" .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        $sql = 'SELECT COUNT(' . $findValues['searchingCol'] . ') as pages FROM ' . $tableName .
            ' WHERE ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'";
        $query = $this->conn->query($sql);
        $pages = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $pages = array_values($row)[0];
        }

        return [
            'data' => $data,
            'pages' => $pages
        ];
    }

    protected function filterMethod($tableName, $filterValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= "' . $filterValues['from'] .
            '" AND ' . $filterValues['filterCol'] . ' <= "' . $filterValues['to'] .
            '" LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        $sql = 'SELECT COUNT(*) FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= "' . $filterValues['from'] .
            '" AND ' . $filterValues['filterCol'] . ' <= "' . $filterValues['to'] . '"';

        $query = $this->conn->query($sql);
        $pages = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $pages = array_values($row)[0];
        }

        return [
            'data' => $data,
            'pages' => $pages
        ];
    }

    protected function sortMethod($tableName, $sortValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        $sql = 'SELECT * FROM ' . $tableName .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'];
        $query = $this->conn->query($sql);
        $pages = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $pages = array_values($row)[0];
        }

        return [
            'data' => $data,
            'pages' => $pages
        ];
    }

    private function createImgFile($tableName, $id, $imgInfo)
    {
        $uploadInstance = null;
        $fileName = "";
        switch ($tableName) {
            case 'sanpham': {
                    $uploadInstance = new UploadImage("SanPham");
                    $fileName = "SP-" .  $id;
                    break;
                }
            case 'taikhoan': {
                    $uploadInstance = new UploadImage("TaiKhoan");
                    $fileName = "TK-" .  $id;
                    break;
                }
        }
        $loaiFile = strtolower(pathinfo($imgInfo['name'], PATHINFO_EXTENSION));
        return [
            'path' => '/Web2/admin/' . $uploadInstance->noiChuaFile . $fileName . '.' . $loaiFile,
            'fileName' => $fileName,
            'instance' => $uploadInstance,
        ];
    }
    public function thongkeMethod($tableName, $year, $yearCol, ...$cols)
    {
        $addComma = array_map(function ($col) {
            return $col . ',';
        }, $cols);
        $select = implode($addComma);
        $select = substr($select, 0, -1);

        $sql = '';
        if ($year != null) {
            $sql = 'SELECT YEAR(' . $yearCol . ') as nam,MONTH(' . $yearCol . ') as thang,' . $select . ' FROM ' . $tableName . ' WHERE YEAR(' . $yearCol . ') = ' . $year;
        } else {
            $sql = 'SELECT ' . $select . ' FROM ' . $tableName;
        }
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        return [
            'Data' => $data
        ];
    }

    /* 
        bảng Chi tiết
     */
    protected function getDetailMethod($tableName, $page, $data)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $data['col'] . ' = ' . $data['id'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        $query = $this->conn->query($sql);
        $result = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($result, $row);
        }

        $numberOF = 'SELECT COUNT(*) as pages FROM ' . $tableName .
            ' WHERE ' . $data['col'] . ' = ' . $data['id'];
        $query = $this->conn->query($numberOF);
        $pages = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $pages = array_values($row)[0];
        }

        return [
            'data' => $result,
            'pages' => $pages
        ];
    }

    protected function filterDetailMethod($tableName, $data, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $data['col'] . ' = ' . $data['id'] .
            ' AND ' . $data['filterCol'] . ' >= "' . $data['from'] .
            '" AND ' . $data['filterCol'] . ' <= "' . $data['to'] .
            '" LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        $query = $this->conn->query($sql);
        $result = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($result, $row);
        }

        $numberOF = 'SELECT COUNT(*) as pages FROM ' . $tableName .
            ' WHERE ' . $data['col'] . ' = ' . $data['id'] .
            ' AND ' . $data['filterCol'] . ' >= "' . $data['from'] .
            '" AND ' . $data['filterCol'] . ' <= "' . $data['to'] . '"';
        $query = $this->conn->query($numberOF);
        $pages = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $pages = array_values($row)[0];
        }

        return [
            'data' => $result,
            'pages' => $pages
        ];
    }

    private function checkExisting($tableName, $col, $value)
    {
        $sql = 'SELECT EXISTS(SELECT * FROM ' . $tableName . ' WHERE ' . $col . ' = "' . $value . '") as tonTai ';
        $query = $this->conn->query($sql);
        $isExisted = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $isExisted = $row['tonTai'];
        }
        return $isExisted;
    }

    private function congDonPNH($data)
    {
        $sql = 'SELECT soLuong,donGiaGoc,thanhTien FROM chitietphieunhaphang WHERE maPhieu = ' . $data['maPhieu'] . ' AND maSP = ' . $data['maSP'];
        $query = $this->conn->query($sql);
        $duLieu = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $duLieu = $row;
        }

        $sql = 'UPDATE chitietphieunhaphang SET soLuong = ' . ($data['soLuong'] + $duLieu['soLuong']) .
            ', donGiaGoc = ' . ($data['donGiaGoc'] + $duLieu['donGiaGoc']) .
            ', thanhTien = ' . ($data['thanhTien'] + $duLieu['thanhTien']) .
            ' WHERE maPhieu = ' . $data['maPhieu'] . ' AND maSP = ' . $data['maSP'];
        $this->conn->query($sql);
        $this->sumChiTietPhieuNhap($data);
    }
    private function sumChiTietPhieuNhap($data)
    {
        $sql = 'SELECT SUM(thanhTien) as thanhTien FROM chitietphieunhaphang' .
            ' WHERE maPhieu = ' . $data['maPhieu'];

        $query = $this->conn->query($sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $tongTien = $row['thanhTien'];
            if (!empty($tongTien)) {
                $sql = 'UPDATE phieunhaphang SET tongTien = ' . $tongTien . ' WHERE maPhieu = ' . $data['maPhieu'];
                $this->conn->query($sql);
            } else {
                $sql = 'UPDATE phieunhaphang SET tongTien = 0 WHERE maPhieu = ' . $data['maPhieu'];
                $this->conn->query($sql);
            }
        }
    }
}
