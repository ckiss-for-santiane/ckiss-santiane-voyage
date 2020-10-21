<?php

// Recuperation du nom de la page appelee
$page_name = preg_replace("/(^.*\/)|(\.php\$)/", "", $_SERVER["PHP_SELF"]);

// Connexion a la DB
require_once "connect_database.php";

// Chargement des modeles
requireDir("Models");

// Appel du controlleur
$view = getController($page_name);


/**
 * Redirection "double" qui marche meme si les headers sont passes
 */
function redirectTo($url) {
	header("Location: " . $url);
	die("<p><a href=\"" . $url . "\" autofocus>Redirection&hellip;</a></p></body></html>");
}

/**
 * Recupere automatiquement le bon controleur
 */
function getController($page_name) {
	$vars = array();

	$controller_name = preg_replace("/ /", "", ucWords(preg_replace("/_/", " ", $page_name))) . "Controller.php";
	if (file_exists("Controllers/" . $controller_name)) {
		require_once "Controllers/" . $controller_name;
		if (isset($_REQUEST["action"])) {
			// "add_stop" --> "addStopAction()"
			$action_name = lcfirst(preg_replace("/ /", "", ucWords(preg_replace("/_/", " ", $_REQUEST["action"])))) . "Action";
			call_user_func($action_name);
		} else {
			$vars = defaultAction();
		}
	} else {
		die("<h1>Controlleur $controller_name introuvable</h1>");
	}

	return $vars;
}

/**
 * Fait un 'require_once()' pour tous les fichiers PHP du dossier (non recursif)
 */
function requireDir($path) {
	if (false !== $dir_handle = opendir($path)) {
		while ($file = readdir($dir_handle)) {
			if (preg_match('/.php$/', $file)) {
				require_once $path . "/" . $file;
			}
		}
	}
}

/**
 * Mise en page du header HTML
 */
function outputHeader($page_title = "(Pas de titre)") {
?><!DOCTYPE html>
<html lang="fr">
<head>
	<title><?php echo $page_title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
body { background: #000; color: #eee; font-family: sans-serif; }
a:link, a:visited, a[tabindex] { color: orange; text-decoration: underline; cursor: pointer; }
.debug { background: navy; }
.addStop, .addTrip { list-style-type: none; }
.modalityIcon { height: 30px; vertical-align: middle; }
	</style>
	<script>
function enableAddStopToggles() {
	var mesElts = document.getElementsByClassName('addStopToggle');
	for (let a = 0; a < mesElts.length; a++) {
		mesElts.item(a).addEventListener('click', addStopToggle);
	}
}

function addStopToggle(evt) {
	evt.target.style.display = 'none';
	evt.target.closest('li').getElementsByTagName('form').item(0).style.display = 'block';
	window.setTimeout(function (elt) {
		elt.focus();
	}, 100, evt.target.closest('li').getElementsByTagName('select').item(0));
}

document.addEventListener('DOMContentLoaded', enableAddStopToggles);
	</script>
</head>
<body>
<header><h2><a href="./">Santiane Voyage</a></h2></header>
<?php
}

/**
 * Mise en page du footer HTML
 */
function outputFooter() {
?>
<hr>
</body>
</html>
<?php
}

