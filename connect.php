<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'movies');

@$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

if( $mysqli->connect_error ) {
	trigger_error('<h1>Database connection failed :-(</h1>' . $mysqli->connect_error, E_USER_ERROR);
}
?>