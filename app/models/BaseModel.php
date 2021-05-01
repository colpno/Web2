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

    protected function postMethod($tableName, $data = [], $maxID = null)
    {
        /* 
            Chi tiết phiếu nhập
        */
        if ($tableName == 'chitietphieunhaphang') {
            $sql = 'SELECT tongTien FROM phieunhaphang' .
                ' WHERE maPhieu = ' . $data['maPhieu'];

            $query = $this->conn->query($sql);
            $needed = null;
            while ($row = mysqli_fetch_assoc($query)) {
                $needed = $row;
            }

            $total = $needed['tongTien'] + $data['thanhTien'];
            $sql = 'UPDATE phieunhaphang SET tongTien = ' . $total . ' WHERE maPhieu = ' . $data['maPhieu'];
            $this->conn->query($sql);

            $sql = 'UPDATE chitietphieunhaphang SET thanhTien = ' . $data['thanhTien'] . ' WHERE maPhieu = ' . $data['maPhieu'] . ' AND maSP = ' . $data['maSP'];
            $this->conn->query($sql);
        }

        $func = null;
        if (isset($data['anhDaiDien']) && $data['anhDaiDien'] != null && $maxID != null) {
            $func = $this->createImgFile($tableName, $maxID, $data['anhDaiDien']);
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

        if ($this->conn->query($sql)) {
            if (isset($func['path']) && $func['path'] != "") {
                $func['instance']->upload($func['fileName']);
            }

            return;
        } else {
            return $this->conn->error;
        }
    }

    protected function updateMethod($tableName, $data, $colID, $id)
    {
        $func = null;
        if (isset($data['anhDaiDien']) && $data['anhDaiDien'] != null) {
            $func = $this->createImgFile($tableName, $id, $data['anhDaiDien']);
            $data['anhDaiDien'] = $func['path'];
        }

        $result = [];
        foreach ($data as $key => $value) {
            array_push($result, "$key = '$value'");
        }
        $result = implode(',', $result);

        $sql = 'UPDATE ' . $tableName . ' SET ' . $result . ' WHERE ' . $colID . ' = ' . $id;

        if ($this->conn->query($sql)) {
            if (isset($func['path']) && $func['path'] != "") {
                $func['instance']->upload($func['fileName']);
            }

            if ($tableName == 'chitietphieunhaphang') {
                $sql = 'SELECT SUM(thanhTien) as thanhTien FROM chitietphieunhaphang' .
                    ' WHERE maPhieu = ' . $data['maPhieu'];

                $query = $this->conn->query($sql);
                while ($row = mysqli_fetch_assoc($query)) {
                    $tongTien = $row;
                    if (!empty($tongTien)) {
                        $sql = 'UPDATE phieunhaphang SET tongTien = ' . $tongTien['thanhTien'] . ' WHERE maPhieu = ' . $data['maPhieu'];
                        $this->conn->query($sql);
                    } else {
                        $sql = 'UPDATE phieunhaphang SET tongTien = 0 WHERE maPhieu = ' . $data['maPhieu'];
                        $this->conn->query($sql);
                    }
                }
            }
            return;
        } else {
            $this->alert->alert('Update failed');
        }
    }

    protected function updateQuCNMethod($data)
    {
        $reset = 'UPDATE quyenchucnang SET hienthi = 0 WHERE hienThi = 1 AND maQuyen = ' . $data['maQuyen'];
        if (!$this->conn->query($reset)) {
            return $this->conn->error;
        }

        $sql = 'UPDATE quyenchucnang SET hienthi = 1 WHERE maQuyen = ' . $data['maQuyen'] . ' AND maCN = ' . $data['maCN'];
        if ($this->conn->query($sql)) {
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
        } else {
            $length = count($data);
            for ($i = 0; $i < $length; $i++) {
                $id = $id . $data[$i];
                if ($i != $length - 1) {
                    $id = $id . ',';
                }
            }
        }
        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $column . ' IN (' . $id . ')';

        if ($this->conn->query($sql)) {
            if (isset($data['imgPath']) && $data['imgPath'] != null) {
                $status = 0;

                $pos = strpos($data['imgPath'][0], "public");
                $filePath = substr($data['imgPath'][0], $pos, strpos($data['imgPath'][0], "-") - $pos + 1);
                $ext = substr($data['imgPath'][0], strrpos($data['imgPath'][0], "."));
                if (is_array($data['id'])) {
                    foreach ($data['id'] as $key => $value) {
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

            /* 
                Chi tiết phiếu nhập
             */
            if ($tableName == 'chitietphieunhaphang') {
                $sql = 'SELECT SUM(thanhTien) as thanhTien FROM chitietphieunhaphang' .
                    ' WHERE maPhieu = ' . $data['maPhieu'];

                $query = $this->conn->query($sql);
                while ($row = mysqli_fetch_assoc($query)) {
                    $tongTien = $row;
                    if (!empty($tongTien)) {
                        $sql = 'UPDATE phieunhaphang SET tongTien = ' . $tongTien['thanhTien'] . ' WHERE maPhieu = ' . $data['maPhieu'];
                        $this->conn->query($sql);
                    } else {
                        $sql = 'UPDATE phieunhaphang SET tongTien = 0 WHERE maPhieu = ' . $data['maPhieu'];
                        $this->conn->query($sql);
                    }
                }
            }
            return;
        } else {
            return $this->conn->error;
        }
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

    protected function findWithFilterMethod($tableName, $findValues, $filterValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' AND ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'" .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        $sql = 'SELECT COUNT(*) FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' AND ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'";
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

    protected function findWithSortMethod($tableName, $findValues, $sortValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'" .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }


        $sql = 'SELECT * FROM ' . $tableName .
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

    protected function findWithFilterAndSortMethod($tableName, $findValues, $filterValues, $sortValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' AND ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'" .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' AND ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'";
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

        $sql = 'SELECT * FROM ' . $tableName .
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

    protected function filterAndSortMethod($tableName, $sortValues = [], $filterValues = [], $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'];
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
    private function createImgFile($tableName, $id, $path)
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
        return [
            'path' => !empty($path) ? $path . $fileName . '.png' : "",
            'fileName' => $fileName,
            'instance' => $uploadInstance,
        ];
    }
}
