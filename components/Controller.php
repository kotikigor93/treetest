<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:13
 */

namespace components;

abstract class Controller
{
    /**
     * @param string $filename
     * @param array $data
     */
    protected function viewLoad(string $filename = 'index', array $data = [])
    {
        SRC::template($filename, $data);
    }

    /**
     * @param array $data
     * @return string
     */
    protected function ajax(array $data):string
    {
        return json_encode($data);
    }
}