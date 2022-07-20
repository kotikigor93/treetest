<?php
/**
 * Created by Kotyk Ihor
 * Date : 20.07.2022
 * Time : 16:17
 */

namespace app\Models;

use \components\ExpandetModel;


class TreeApplication extends ExpandetModel
{
    /**
     * @return array
     */
    public function getTreeList():array
    {
        $this->setMainTable('tree');
        $this->setOrderBy('parent');
        $this->setSort('ASC');
        return $this->init()->getData();
    }
}