<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:13
 */

namespace app\Controllers;

use components\SRC;

abstract class Controller
{
    protected function viewLoad($filename = 'index', $data = null)
    {
        SRC::template($filename, $data);
    }
}