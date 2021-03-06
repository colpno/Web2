<?php
class ChucNangModel extends BaseModel
{
    private const TABLE_NAME = 'chucnang';
    private $primaryCol;
    private $findValues;

    public function __construct()
    {
        parent::__construct();
        $this->primaryCol = $this->getPrimaryCol(self::TABLE_NAME);

        $this->findValues = [
            'searchingCol' => 'tenCN'
        ];
    }

    public function countRow($col = null)
    {
        if ($col == null) {
            return $this->countRowMethod(self::TABLE_NAME, $this->primaryCol);
        } else {
            return $this->countRowMethod(self::TABLE_NAME, $col);
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

    public function getMinCol($col = null)
    {
        if ($col == null) {
            return $this->getMinMethod(self::TABLE_NAME, $this->primaryCol);
        } else {
            return $this->getMinMethod(self::TABLE_NAME, $col);
        }
    }

    public function get($page)
    {
        return $this->getMethod(self::TABLE_NAME, $page);
    }

    public function post($data = [], $need)
    {
        $check = [
            'col' => 'tenCN',
            'value' => $data['tenCN'],
        ];
        return $this->postQuyenMethod(self::TABLE_NAME, $data, $need, $check);
    }

    public function update($data = [], $id)
    {
        return $this->updateMethod(self::TABLE_NAME, $data, $this->primaryCol, $id);
    }

    public function delete($id = [])
    {
        return $this->deleteWithFKMethod(self::TABLE_NAME, 'quyenchucnang', $this->primaryCol, $id);
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
