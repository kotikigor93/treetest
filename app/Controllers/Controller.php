<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:13
 */

namespace app\Controllers;

abstract class Controller
{
    protected function viewLoad($filename = 'index', $data = null)
    {
        if(file_exists(ROOT.'/view/content'.$filename.'.php')){
            require_once ROOT.'/view/content'.$filename.'.php';
            return;
        }
        require_once ROOT.'/view/contentIndex.php';
    }
}