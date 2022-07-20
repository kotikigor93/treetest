<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 19:42
 */

namespace components;


class SRC
{
    /**
     * @param string $filename
     * @param array $data
     */
    public static function template(string $filename = 'error', array $data = [])
    {
        if(file_exists(ROOT.'/view/content'.$filename.'.php')){
            require_once ROOT.'/view/content'.$filename.'.php';
        }
        require_once ROOT.'/view/contentIndex.php';
    }
}