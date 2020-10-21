<?php

require_once("Include/bootstrap.php");

// Debut de la mise en page
outputHeader("Données par défaut");

echo "<p>" . $view["message"] . "</p>";
?>

<p><a href="./">Retour</a></p>

<?php
outputFooter();

