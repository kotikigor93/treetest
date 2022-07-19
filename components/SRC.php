<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 19:42
 */

namespace components;


class SRC
{
    public static function template($filename = 'error', $data = null)
    {
        if(file_exists(ROOT.'/view/content'.$filename.'.php')){
            require_once ROOT.'/view/content'.$filename.'.php';
        }
        require_once ROOT.'/view/contentIndex.php';
    }
}