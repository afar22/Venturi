<?php

/*define("BASE_URL", "http://localhost/Venturi/public/");
define("APP_URL", "http://localhost/Venturi/");*/
$host = $_SERVER['HTTP_HOST']; 

define("BASE_URL", "http://" . $host . "/Venturi/public/");
define("APP_URL", "http://" . $host . "/Venturi/");
define("APP_NAME", "CH4");
define('DB_SERVIDOR', 'localhost');
define('DB_USER', 'root');
define('DB_CLAVE', '');
define('DB_NOMBRE', 'Venturi_CH4');

