<?php

require_once("Include/bootstrap.php");

// S'il n'y a pas d'ID, alors c'est un ajout
if (empty($_REQUEST["id"])) {
	// Debut de la mise en page
	$page_title = "Nouveau voyage";
	outputHeader($page_title);
	echo "<h1>" . htmlspecialchars($page_title) . "</h1>" . PHP_EOL;
?>

<form action="view_trip.php" method="get">
<label for="trip_title">Titre</label>&nbsp;: <input id="trip_title" type="text" name="title" autofocus>
<input type="submit" value="Envoyer">
<input type="hidden" name="action" value="add_trip">
</form>

<?php	
} else {
	

	// Debut de la mise en page
	$page_title = "Voyage " . $view["trip"]->getTitle();
	outputHeader($page_title);
	echo "<h1>" . htmlspecialchars($page_title) . "</h1>" . PHP_EOL;

	if (count($view["trip_stops"]) > 0) {
		echo "<ul>" . PHP_EOL;
		foreach ($view["trip_stops"] as $row) {
			echo "<li class=\"addStop\">";
			outputDialogAddStop($view, false, $row->getID());
			echo "</li>" . PHP_EOL;
			echo "<li><strong>" . $row->getDestinationTitle() . "</strong>";
			echo " <img class=\"modalityIcon\" src=\"images/" . $row->getModalityIcon() . "\" alt=\"" . $row->getModalityTitle() . "\">";
			echo " <a href=\"view_trip.php?id=" . $view["trip"]->getID() . "&amp;action=delete_stop&amp;stop_id=" . $row->getID() . "\">Supprimer</a>";
			echo "</li>" . PHP_EOL;
		}
		echo "<li class=\"addStop\">";
		outputDialogAddStop($view, false);
		echo "</li>" . PHP_EOL;
		echo "</ul>" . PHP_EOL;
	} else {
		echo "<p class=\"addStop\">";
		outputDialogAddStop($view, true);
		echo "</p>" . PHP_EOL;
	}

}

outputFooter();


function outputDialogAddStop($view, $form_is_visible = true, $insert_before = "") {
	$stops_list = $view["trip"]->getAvailableOtherStops();
	if (count($stops_list) == 0) {
		return false;
	}
?>
<?php if (!$form_is_visible) { ?><a tabindex="-1" class="addStopToggle">Ajouter une étape ici</a><?php } ?>
<form action="view_trip.php" method="get"<?php if (!$form_is_visible) { ?> style="display: none;"<?php } ?>>
<input type="hidden" name="id" value="<?php echo $view["trip"]->getID(); ?>">
<input type="hidden" name="action" value="add_stop">
Aller à&nbsp;:
<select name="destination">
<?php
	foreach ($stops_list as $k => $v) {
		echo "<option value=\"" . $k . "\">" . $v . "</option>" . PHP_EOL;
	}
?>
</select>
avec&nbsp;:
<select name="modality">
<?php
	foreach (TripStop::getAllModalities() as $k => $v) {
		echo "<option value=\"" . $k . "\">" . $v . "</option>" . PHP_EOL;
	}
?>
</select>
<input type="submit" value="Ajouter">
<input type="hidden" name="add_stop_before" value="<?php echo $insert_before; ?>">
</form>
<?php
}

