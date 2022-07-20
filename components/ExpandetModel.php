<?php
/**
 * Created by Kotyk Ihor
 * Date : 20.07.2022
 * Time : 15:57
 */

namespace components;

use PDO;

abstract class ExpandetModel
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $mainTable = 'tree';

    /**
     * @var string
     */
    private $orderBy = 'id';

    /**
     * @var string
     */
    private $sort = 'DESC';


    /**
     * @return $this
     */
    public function init():self
    {
        $this->data = $this->getCurrentTableRow();
        return $this;
    }

    /**
     * @param string $mainTable
     */
    public function setMainTable(string $mainTable): void
    {
        $this->mainTable = $mainTable;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @param string $sort
     */
    public function setSort(string $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return array
     */
    public function getData():array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    protected function getCurrentTableRow(): array
    {
        $db = new DB();
        $result = $db->query('SELECT * FROM '.$this->mainTable.' ORDER BY '.$this->orderBy.' '.$this->sort);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $result->fetchAll();
    }
}