<?php
class BaseModel extends Database
{
    protected $conn;

    protected function __construct()
    {
        $this->conn = $this->connect();
    }

    protected function countMethod($tableName, $col)
    {
        $sql = 'SELECT COUNT(' . $col . ') FROM ' . $tableName;
        return $this->conn->query($sql);
    }

    protected function postMethod($tableName, $data = [])
    {
        $dataStringValues = array_map(function ($value) {
            return "'$value'";
        }, array_values($data));
        $values = implode(",", array_values($dataStringValues));
        $columns = implode(",", array_keys($data));

        $sql = "INSERT INTO $tableName($columns) VALUES ($values)";
        $this->conn->query($sql);
    }

    protected function getMethod($tableName, $page)
    {
        $sql = 'SELECT * FROM ' . $tableName . ' LIMIT ' . $page['limit'] . ' OFFSET ' . ($page['current'] - 1) * $page['limit'];
        $query = $this->conn->query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        return $data;
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

    protected function updateMethod($tableName, $data, $colID, $id)
    {
        $result = [];
        foreach ($data as $key => $value) {
            array_push($result, "$key = '$value'");
        }
        $result = implode(',', $result);

        $sql = 'UPDATE ' . $tableName . ' SET ' . $result . ' WHERE ' . $colID . ' = ' . $id;
        $this->conn->query($sql);
        echo $sql;
    }

    protected function deleteMethod($tableName, $column, $data)
    {
        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $column . ' IN (' . $data['id'] . ')';
        $alert = new Other();
        if ($this->conn->query($sql)) {
            $filePath = substr($data['imgPath'], strpos($data['imgPath'], "public"));

            if (strpos($data['id'], ',')) {
                $idArr = explode(',', $data['id']);
                foreach ($data['id'] as $key => $value) {
                    unlink(__DIR__ . '/../../' . $filePath);
                }
            } else {
                unlink(__DIR__ . '/../../' . $filePath);
            }
            $alert->alert('Delete success');
        } else {
            $alert->alert('Query failed');
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

        $query = $this->conn->query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }
        return $this->returnBackValues($sql);
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
        return $this->returnBackValues($sql);
    }

    protected function sortAndFilterMethod($tableName, $sortValues = [], $filterValues = [], $page)
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
