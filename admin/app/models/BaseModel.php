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
        $sql = 'SELECT * FROM ' . $tableName . ' GROUP BY ' . $col . ' asc LIMIT 1';
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

    // protected function getAllMethod($tableName, $specialData = []) //specialData includes Col and Value
    // {
    //     if (empty($specialData)) {
    //         $sql = 'SELECT * FROM ' . $tableName;
    //     } else {
    //         $sql = 'SELECT * FROM ' . $tableName . 'WHERE ' . $specialData['col'] . ' = ' . $specialData['value'];
    //     }

    //     $query = $this->conn->query($sql);
    //     $data = [];
    //     while ($row = mysqli_fetch_assoc($query)) {
    //         array_push($data, $row);
    //     }

    //     return [
    //         'data' => $data,
    //     ];
    // }
    protected function getAllMethod($tableName)
    {
        $sql = 'SELECT * FROM ' . $tableName;
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        return [
            'Data' => $data,
        ];
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
        if ($tableName == 'chitietphieunhaphang') {
            if (
                !empty($check) &&
                $this->checkExistingChiTiet($tableName, $check['value'], $check['value2'])
            ) {
                $this->congDonPNH($data);
                $this->updateSoLuong($data);
                return;
            }
        } else
        if (
            !empty($check) &&
            $this->checkExisting($tableName, $check['col'], $check['value'])
        ) {
            die($check['value'] . ' ???? t???n t???i');
        }

        /* 
            Th??m file ???nh v??o th?? m???c
         */
        $func = null;
        if (isset($data['anhDaiDien']) && $data['anhDaiDien'] != 'undefined' && $maxID != null) {
            $func = $this->createImgFile($tableName, $maxID + 1, $data['anhDaiDien']);
            $data['anhDaiDien'] = $func['path'];
        }

        $dataStringValues = array_map(function ($value) {
            return $value;
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
            Chi ti???t phi???u nh???p
            */
            if ($tableName == 'chitietphieunhaphang') {
                $this->sumChiTietPhieuNhap($data);
                $this->updateSoLuong($data);
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
            die($check['value'] . ' ???? t???n t???i');
        }

        // Reset AI
        $resetAI = 'ALTER TABLE ' . $tableName . ' AUTO_INCREMENT = 1';
        if (!$this->conn->query($resetAI)) {
            return $this->conn->error;
        }

        // T???o chu???i th??m
        $dataStringValues = array_map(function ($value) {
            return "'$value'";
        }, array_values($data));
        $values = implode(",", array_values($dataStringValues));
        $columns = implode(",", array_keys($data));

        // Th??m quy???n / ch???c n??ng
        $sql = "INSERT INTO $tableName($columns) VALUES ($values)";
        $this->conn->query($sql);

        $colNeed = null;
        if (isset($data['tenQuyen'])) {
            $colNeed = 'maQuyen';
        }
        if (isset($data['tenCN'])) {
            $colNeed = 'maCN';
        }

        // L???y maQuyen / maCN m???i th??m
        $sql = "SELECT * FROM $tableName ORDER BY $colNeed desc LIMIT 1";
        $query = $this->conn->query($sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $colNeed = $row[$colNeed];
        }

        // S??? ch???c n??ng / quy???n
        $times = count($need['data']);

        // Th??m quy???n ch???c n??ng
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
        if (isset($data['anhDaiDien']) && $data['anhDaiDien'] != "undefined") {
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
            if (isset($data['anhDaiDien']) && $data['anhDaiDien'] != "undefined") {
                if (isset($func['path']) && $func['path'] != "") {
                    $func['instance']->upload($func['fileName']);
                }
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
        if ($tableName == 'hoadon') {
            $sql = "UPDATE $tableName SET $arrKeys[3] = " . $data[$colSet] . ', ';
            $length = count($arrKeys);
            for ($i = 4; $i < $length; $i++) {
                if ($data[$arrKeys[4]]) {
                    $moreCols = $arrKeys[$i] . " = " . $data[$arrKeys[$i]] . ", ";
                } else {
                    $moreCols = $arrKeys[$i] . " = '" . $data[$arrKeys[$i]] . "', ";
                }
                $sql = $sql . $moreCols;
            }
            $sql = rtrim($sql, ", ");
            $sql = $sql . " WHERE $colCondition = " . $data[$colCondition];
        }
        // echo $sql;
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
            if (strpos("no-img", $data['imgPath']) >= 0) {
            } else
            if (isset($data['imgPath'])) {
                $status = 0;

                $filePath = substr($data['imgPath'], 0, strpos($data['imgPath'], "-")  + 1);
                $ext = substr($data['imgPath'], strrpos($data['imgPath'], "."));
                if (strpos($data['id'], ',')) {
                    $idArr = explode(',', $data['id']);
                    foreach ($idArr as $key => $value) {
                        if (unlink($filePath . $value .  $ext)) $status = 1;
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
        if (strpos($data['id'], ',')) {
            $idArr = explode(',', $data['id']);
            for ($i = 0; $i < sizeof($idArr); $i++) {
                if (
                    $tableName == 'hoadon' || $tableName == 'chitiethoadon'

                ) {
                    $this->updateHoaDonSoluong($idArr[$i]);
                }
                $sql = 'DELETE FROM ' . $FKTableName . ' WHERE ' . $col . ' = ' . $idArr[$i];
                $this->conn->query($sql) or die($this->conn->error);

                $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $col . ' = ' . $idArr[$i];
                $this->conn->query($sql) or die($this->conn->error);
            }
        } else {
            if (
                $tableName == 'hoadon' || $tableName == 'chitiethoadon'

            ) {
                $this->updateHoaDonSoluong($id);
            }
            $sql = 'DELETE FROM ' . $FKTableName . ' WHERE ' . $col . ' = ' . $id;
            $this->conn->query($sql) or die($this->conn->error);

            $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $col . ' = ' . $id;
            $this->conn->query($sql) or die($this->conn->error);
        }

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

    protected function sortChiTietMethod($tableName, $sortValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $sortValues['col'] . ' = ' . $sortValues['value'] .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $sortValues['col'] . ' = ' . $sortValues['value'] .
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
        if (!empty($imgInfo)) {
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
                'path' =>  $uploadInstance->noiChuaFile . $fileName . '.' . $loaiFile,
                'fileName' => $fileName,
                'instance' => $uploadInstance,
            ];
        }
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
        b???ng Chi ti???t
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

    private function checkExistingChiTiet($tableName, $col, $value)
    {
        $sql = 'SELECT EXISTS(SELECT * FROM ' . $tableName . ' WHERE maPhieu = ' . $value . ' AND maSP =  ' . $col . ') as tonTai ';
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

    private function updateSoLuong($data)
    {
        $sql = 'SELECT soLuong as so FROM sanpham' .
            ' WHERE maSP = ' . $data['maSP'];

        $query = $this->conn->query($sql);
        $tong = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $tong = $row['so'];
        }
        $tong += $data['soLuong'];

        $sql = 'UPDATE sanpham  SET soLuong = ' . $tong . ' WHERE maSP = ' . $data['maSP'];
        $this->conn->query($sql) or die($this->conn->error);;
    }

    private function updateHoaDonSoluong($maHD)
    {
        $sql = 'SELECT maSP,soLuong FROM chitiethoadon' .
            ' WHERE maHD = ' . $maHD;

        $query = $this->conn->query($sql);
        while ($row = mysqli_fetch_assoc($query)) {
            $this->updateSoLuong($row);
        }
    }
}
