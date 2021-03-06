<?php

/**
 * A simple PHP MVC skeleton
 *
 * @package php-mvc
 * @author Panique
 * @link http://www.php-mvc.net
 * @link https://github.com/panique/php-mvc/
 * @license http://opensource.org/licenses/MIT MIT License
 */


// load application config (error reporting etc.)
require 'application/config/config.php';

// load application class
require 'application/libs/application.php';
require 'application/libs/controller.php';
require 'application/libs/db.php';
require "application/libs/PHPExcel/Classes/PHPExcel.php";

if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('UTC');
}

// start the application
$app = new Application();
