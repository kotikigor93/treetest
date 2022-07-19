<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:32
 */

define('ROOT', dirname(__FILE__));
define('CURRENT_TIMESTAMP', time());
define('CURRENT_DATETIME', date('Y-m-d H:i:s', CURRENT_TIMESTAMP));
require_once ('components/Autoloader.php');

use components\Route;
$route = new Route();
$route->run();
