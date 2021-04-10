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
        $sql = 'SELECT COUNT(' . $primaryCol . ') FROM ' . $tableName;
        $query = $this->conn->query($sql);

        while ($row = mysqli_fetch_assoc($query)) {
            return $row;
        }
    }

    protected function getRowMethod($tableName, $col, $value)
    {
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE ' . $col . ' = ' . $value;
        $query = $this->conn->query($sql);

        while ($row = mysqli_fetch_assoc($query)) {
            return $row;
        }
    }

    protected function getMaxIDCol($tableName, $primaryCol)
    {
        $sql = 'SELECT ' . $primaryCol . ' FROM ' . $tableName . ' GROUP BY ' . $primaryCol . ' desc LIMIT 1';
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

        return $key[0];
    }

    protected function postMethod($tableName, $data = [], $number)
    {
        $dataStringValues = array_map(function ($value) {
            return "'$value'";
        }, array_values($data));
        $values = implode(",", array_values($dataStringValues));
        $columns = implode(",", array_keys($data));

        $resetAI = 'ALTER TABLE ' . $tableName . ' AUTO_INCREMENT = ' . $number;
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
        if ($this->conn->query($sql)) {
            $this->alert->alert('Update succeed');
        } else {
            $this->alert->alert('Update failed');
        }
    }

    protected function deleteMethod($tableName, $column, $data)
    {
        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $column . ' IN (' . $data['id'] . ')';
        if ($this->conn->query($sql)) {
            $status = 0;
            if (strpos($data['id'], ',')) {
                $pos = strpos($data['imgPath'], "public");
                $filePath = substr($data['imgPath'], $pos, strpos($data['imgPath'], "-") - $pos + 1);
                $ext = substr($data['imgPath'], strrpos($data['imgPath'], "."));
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
            if ($status == 1) {
                $this->alert->alert('Delete succeed');
            } else {
                $this->alert->alert('No such file or directory');
            }
        } else {
            $this->alert->alert('Delete failed');
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
