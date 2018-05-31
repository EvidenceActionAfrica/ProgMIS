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

/*** error reporting on ***/
 error_reporting(E_ALL);

 /*** define the site path constant ***/
 $site_path = realpath(dirname(__FILE__));
 define ('__SITE_PATH', $site_path);

// load application config (error reporting etc.)
require 'application/config/config.php';

// load application class
require 'application/libs/application.php';
require 'application/libs/controller.php';
require 'application/libs/db.php';
require "application/libs/PHPExcel/Classes/PHPExcel.php";

// start the application
$app = new Application();
