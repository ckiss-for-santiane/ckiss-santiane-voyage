
HELLO
-----

Suite à la panne de mon ordinateur "principal" j'ai dû bricoler un peu :)
Ce site a donc été élevé sur le serveur Apache de mon NAS, et codé avec l'Editeur de texte de Fedora 28 (on est bien loin de PhpStorm64), j'ai mis plus de temps que je ne voudrais l'admettre à tout configurer, mais bon, c'était fun quand même.

J'aurais bien essayé Laravel mais dans ces conditions ça me semblait un peu overkill, alors j'ai fait un micro framework à la place mais en maintenant le modèle MVC. (Peu importe le framework à la limite, mais c'est juste pour justifier ce choix)

Je n'ai pas fait une classe différente selon le mode de transport, car j'aime bien que mon modèle objet mappe bien la structure de la base de données si possible (mais du coup il n'y a pas d'héritage, pas de traits...) même si du coup des champs seront vides ("numéro de billet", etc.).

Les pages sont simplistes, et on pourrait bien sûr ajouter des fonctionnalités et autres trucs cool, comme de la cartographie, du React, du RDFa, du multilingue etc. mais j'avoue avoir déjà utilisé plus que les 2 heures imparties. Il manque aussi des autres fonctionnalités de base (comme la suppression d'un voyage), mais c'est trivial et ne représente bien sûr qu'une question de temps.

J'ai conscience que certaines exigences n'ont pas été implémentées (numéros des billets...) ; mais bon, ceci représente un "minimum viable product" qui pourra bien sûr être étoffé moyennant quelques heures supplémentaires.

Allez, on peut plonger dans ce site... (aux couleurs de Halloween)


MODE D'EMPLOI
-------------

 * Changer les données de connexion à MySQL dans : Include/infos_connexion.php
 * Lancer le site dans le navigateur, par exemple : http://localhost/santiane_voyage
 * Installer les données par défaut
et aussi
 * Les tests unitaires sont dans le dossier Include/UnitTest

