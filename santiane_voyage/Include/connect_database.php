<?php

ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

require_once "infos_connexion.php";

$GLOBALS["mysql_link"] = mysqli_connect($mysql_host, $mysql_user, $mysql_password);
if ($GLOBALS["mysql_link"]) {
	mysqli_select_db($GLOBALS["mysql_link"], $mysql_database);
	mysqli_set_charset($GLOBALS["mysql_link"], "utf8");
} else {
	echo "<p class='error'>Connexion impossible a la base de donnees sur $mysql_host.</p>";
	outputFooter();
	die();
}

