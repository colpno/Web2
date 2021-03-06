<?php
class QuyenChucNangModel extends BaseModel
{
    private const TABLE_NAME = 'quyenchucnang';
    private $primaryCol;
    private $findValues;

    public function __construct()
    {
        parent::__construct();
        $this->primaryCol = $this->getPrimaryCol(self::TABLE_NAME);

        $this->findValues = [
            'searchingCol' => 'maQuyen'
        ];

        if ($this->primaryCol == null) {
            $this->primaryCol = $this->findValues['searchingCol'];
        }
    }

    public function countRow($col = null)
    {
        if ($col == null) {
            return $this->countRowMethod(self::TABLE_NAME, $this->primaryCol);
        } else {
            return $this->countRowMethod(self::TABLE_NAME, $col);
        }
    }

    public function getMinCol($col = null)
    {
        if ($col == null) {
            return $this->getMinMethod(self::TABLE_NAME, $this->primaryCol);
        } else {
            return $this->getMinMethod(self::TABLE_NAME, $col);
        }
    }

    public function getRow($col, $value)
    {
        return $this->getRowMethod(self::TABLE_NAME, $col, $value);
    }

    public function getMaxCol($col = null)
    {
        if ($col == null) {
            return $this->getMaxMethod(self::TABLE_NAME, $this->primaryCol);
        } else {
            return $this->getMaxMethod(self::TABLE_NAME, $col);
        }
    }

    public function get($page)
    {
        return $this->getMethod(self::TABLE_NAME, $page);
    }

    public function post($data = [], $number)
    {
        return $this->postMethod(self::TABLE_NAME, $data, $number);
    }

    public function update($data = [])
    {
        return $this->updateQuCNMethod(self::TABLE_NAME, $data);
    }

    public function delete($id = [])
    {
        return $this->deleteMethod(self::TABLE_NAME, $this->primaryCol, $id);
    }

    public function find($searchingText, $page)
    {
        $this->findValues['searchingText'] = $searchingText;
        return $this->findMethod(self::TABLE_NAME, $this->findValues, $page);
    }

    public function filter($filterValues, $page)
    {
        return $this->filterMethod(self::TABLE_NAME,  $filterValues, $page);
    }

    public function sort($sortValues, $page)
    {
        return $this->sortMethod(self::TABLE_NAME,  $sortValues, $page);
    }
}
