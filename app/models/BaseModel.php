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
        $sql = 'SELECT COUNT(' . $primaryCol . ') as tongSoLuong FROM ' . $tableName;
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

    protected function getMethod($tableName, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName . ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        return $this->returnBackValues($sql);
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

    protected function postMethod($tableName, $data = [])
    {
        $dataStringValues = array_map(function ($value) {
            return "'$value'";
        }, array_values($data));
        $values = implode(",", array_values($dataStringValues));
        $columns = implode(",", array_keys($data));

        $resetAI = 'ALTER TABLE ' . $tableName . ' AUTO_INCREMENT = 1';
        $this->conn->query($resetAI);

        $sql = "INSERT INTO $tableName($columns) VALUES ($values)";
        if ($this->conn->query($sql)) {
            $this->alert->alert('Add succeed');
        } else {
            $this->alert->alert('Add failed');
        }
    }

    protected function updateMethod($tableName, $data, $colID, $id)
    {
        $result = [];
        foreach ($data as $key => $value) {
            array_push($result, "$key = '$value'");
        }
        $result = implode(',', $result);

        $sql = 'UPDATE ' . $tableName . ' SET ' . $result . ' WHERE ' . $colID . ' = ' . $id;
        // if ($this->conn->query($sql)) {
        //     $this->alert->alert('Update succeed');
        // } else {
        //     $this->alert->alert('Update failed');
        // }
        echo $sql;
    }

    protected function updateQuCNMethod($data)
    {
        $reset = 'UPDATE quyenchucnang SET hienthi = 0 WHERE hienThi = 1 AND maQuyen = ' . $data['maQuyen'];
        $this->conn->query($reset);

        $sql = 'UPDATE quyenchucnang SET hienthi = 1 WHERE maQuyen = ' . $data['maQuyen'] . ' AND maCN = ' . $data['maCN'];
        $this->conn->query($sql);
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
        // echo $sql;

        if ($this->conn->query($sql)) {
            $status = 0;
            if (isset($data['imgPath']) && $data['imgPath'] != null) {
                $pos = strpos($data['imgPath'][0], "public");
                $filePath = substr($data['imgPath'][0], $pos, strpos($data['imgPath'][0], "-") - $pos + 1);
                $ext = substr($data['imgPath'][0], strrpos($data['imgPath'][0], "."));
                if (is_array($data['id'])) {
                    foreach ($data['id'] as $key => $value) {
                        // if (unlink(__DIR__ . '/../../' . $filePath . $value .  $ext)) $status = 1;
                        // else $status = 0;
                        // echo (__DIR__ . '/../../' . $filePath . $value .  $ext);
                    }
                } else {
                    $filePath = substr($data['imgPath'], strpos($data['imgPath'], "public"));
                    // if (unlink(__DIR__ . '/../../' . $filePath)) $status = 1;
                    // else $status = 0;
                    // echo __DIR__ . '/../../' . $filePath;
                }
            }
            if ($status == 1) {
                $this->alert->alert('Delete succeed');
            } else {
                $this->alert->alert('No such file or directory');
            }
        } else {
            print_r(json_encode(array('response' => (($this->conn->error)))));
        }
    }

    protected function findMethod($tableName, $findValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'" .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        return $this->returnBackValues($sql);
    }

    protected function findWithFilterMethod($tableName, $findValues, $filterValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' AND ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'" .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        return $this->returnBackValues($sql);
    }

    protected function findWithSortMethod($tableName, $findValues, $sortValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'" .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        return $this->returnBackValues($sql);
    }

    protected function findWithFilterAndSortMethod($tableName, $findValues, $filterValues, $sortValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' AND ' . $findValues['searchingCol'] . " LIKE '%" . $findValues['searchingText'] . "%'" .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        return $this->returnBackValues($sql);
    }

    protected function filterMethod($tableName, $filterValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        return $this->returnBackValues($sql);
    }

    protected function sortMethod($tableName, $sortValues, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        return $this->returnBackValues($sql);
    }

    protected function filterAndSortMethod($tableName, $sortValues = [], $filterValues = [], $page)
    {
        $sql = 'SELECT * FROM ' . $tableName .
            ' WHERE ' . $filterValues['filterCol'] . ' >= ' . $filterValues['from'] .
            ' AND ' . $filterValues['filterCol'] . ' <= ' . $filterValues['to'] .
            ' ORDER BY ' . $sortValues['sortCol'] . ' ' . $sortValues['order'] .
            ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];

        return $this->returnBackValues($sql);
    }

    private function returnBackValues($sql)
    {
        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        return $data;
    }
}
