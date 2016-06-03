<?php

echo '<pre>';
print_r($_GET);
print_r($_SERVER['REQUEST_URI']);
define('SYSTEMPATH', 'system'.DIRECTORY_SEPARATOR);
define('APPPATH', 'application'.DIRECTORY_SEPARATOR);

require_once SYSTEMPATH.'core/initialize.php';
