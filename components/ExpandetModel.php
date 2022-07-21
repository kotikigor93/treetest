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
     * @var int
     */
    private $id;

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
     * @var string
     */
    private $params = '';

    /**
     * @var string
     */
    private $value = '';

    /**
     * @var array
     */
    private $insertData = [];


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
     * @param array $insertData
     */
    public function setInsertData(array $insertData): void
    {
        $this->insertData = $insertData;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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

    /**
     * @return int
     */
    protected function insertTableRow():int
    {
        foreach ($this->insertData as $key => $val){
            $this->params .= $key.',';
            $this->value .= "'".$val."',";
        }
        $this->params = substr($this->params, 0, -1);
        $this->value = substr($this->value, 0, -1);
        $db = new DB();
        $db->query('INSERT INTO '.$this->mainTable.' ('.$this->params.') VALUES ('.$this->value.')');
        return $db->lastInsertId();
    }

    protected function delTableRowById():bool
    {
        $db = new DB();
        return (bool)$db->query('DELETE FROM ' . $this->mainTable . ' WHERE id =' . $this->id . ' OR parent =' . $this->id);
    }
}