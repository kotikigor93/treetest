<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:06
 */

namespace components;

class Autoloader
{
    public function loadClass($class)
    {
        $rootDir =ROOT. '/';
        $class = str_replace('\\', '/', $class);
        $path = $rootDir . $class . '.php';

        if (!class_exists($class))
        {
            if (file_exists($path))
            {
                require_once($path);
            }else{
                debug_print_backtrace();
                echo '<br/>';
                var_dump($path);
                die;
            }
        }else{
            debug_print_backtrace();
            echo '<br/>';
            var_dump($path);
            die;
        }
    }
}
spl_autoload_register([new Autoloader(), 'loadClass']);