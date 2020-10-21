<?php

function defaultAction() {
	$view = array();

	mysqli_multi_query($GLOBALS["mysql_link"], file_get_contents("Include/default_data_dump.sql")); 
	$view["message"] = "Import effectué.";

	return $view;
}

