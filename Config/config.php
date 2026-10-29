<?php

/*define("BASE_URL", "http://localhost/CH4/public/");
define("APP_URL", "http://localhost/CH4/");*/
$host = $_SERVER['HTTP_HOST']; 

define("BASE_URL", "http://" . $host . "/CH4/public/");
define("APP_URL", "http://" . $host . "/CH4/");
define("APP_NAME", "CH4");
define('DB_SERVIDOR', 'localhost');
define('DB_USER', 'root');
define('DB_CLAVE', '');
define('DB_NOMBRE', 'Venturi_CH4');

