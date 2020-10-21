<?php

// Infos de connexion a la DB
$mysql_host		= "localhost";
$mysql_database	        = "santiane_voyage";
$mysql_user		= "CHANGER_USER";
$mysql_password	        = "password";

if ($mysql_user == "CHANGER_USER") {
	// Message pour le prochain qui essaiera ce mini site ;)
	echo "<p><strong>Changer le login/mdp dans <tt>" . __FILE__ . "</tt>&nbsp;!</strong></p>" . PHP_EOL;
}

