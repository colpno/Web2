<?php
class ChiTietKhuyenMaiModel extends BaseModel
{
    private const TABLE_NAME = 'chitietkhuyenmai';
    private $primaryCol;
    private $findValues;

    public function __construct()
    {
        parent::__construct();
        $this->primaryCol = $this->getPrimaryCol(self::TABLE_NAME);

        $this->findValues = [
            'searchingCol' => 'maSP'
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

    public function get($page, $id)
    {
        return $this->getDetailMethod(self::TABLE_NAME, $page, $id);
    }

    public function post($data = [])
    {
        return $this->postMethod(self::TABLE_NAME, $data);
    }

    public function update($data = [], $id)
    {
        return $this->updateMethod(self::TABLE_NAME, $data, $this->primaryCol, $id);
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

    public function findWithFilter($searchingText, $filterValues, $page)
    {
        $this->findValues['searchingText'] = $searchingText;
        return $this->findWithFilterMethod(self::TABLE_NAME, $this->findValues, $filterValues, $page);
    }

    public function findWithSort($searchingText, $sortValues, $page)
    {
        $this->findValues['searchingText'] = $searchingText;
        return $this->findWithSortMethod(self::TABLE_NAME, $this->findValues, $sortValues, $page);
    }

    public function findWithFilterAndSort($searchingText, $filterValues, $sortValues, $page)
    {
        $this->findValues['searchingText'] = $searchingText;
        return $this->findWithFilterAndSortMethod(self::TABLE_NAME, $this->findValues, $filterValues, $sortValues, $page);
    }

    public function filter($filterValues, $page)
    {
        return $this->filterDetailMethod(self::TABLE_NAME,  $filterValues, $page);
    }

    public function sort($sortValues, $page)
    {
        return $this->sortMethod(self::TABLE_NAME,  $sortValues, $page);
    }

    public function filterAndSort($sortValues, $filterValues, $page)
    {
        return $this->filterAndSortMethod(self::TABLE_NAME, $sortValues, $filterValues, $page);
    }
}
