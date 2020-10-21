<?php

require_once("Include/bootstrap.php");

// Debut de la mise en page
$page_title = "Liste des voyages";
outputHeader($page_title);
echo "<h1>" . htmlspecialchars($page_title) . "</h1>" . PHP_EOL;

if (count($view["tripsList"]) == 0) {
	// Aucune donnée en base
	echo "<p><strong>Aucun voyage&nbsp;!</strong><p>" . PHP_EOL;
	echo "<ul>" . PHP_EOL;
	echo "<li><a href=\"load_default_data.php\">Charger les données de démonstration</a></li>" . PHP_EOL;
	echo "<li><a href=\"view_trip.php?action=add_trip\">Ajouter un voyage</a></li>" . PHP_EOL;
	echo "</ul>" . PHP_EOL;
} else {
	// Affichage des données en base
	echo "<ul>" . PHP_EOL;
	foreach ($view["tripsList"] as $row) {
		echo "<li><a href=\"view_trip.php?id=" . $row->getID() . "\">";
		echo "<strong>" . $row->getTitle() . "</strong>";
		echo "</a></li>" . PHP_EOL;
	}
	echo "<li class=\"addTrip\"><a href=\"view_trip.php?action=add_trip\">Ajouter un voyage</a></li>" . PHP_EOL;
	echo "</ul>" . PHP_EOL;
}

outputFooter();

