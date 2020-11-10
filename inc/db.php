<?php

$pdo = new PDO ('mysql:dbname=film;host=localhost','root','');
//Relie le dossier à la base de donnée - PDO manière la plus clean de se connecter 
//nom du dossier + l'hôte + identifiant MDP de la base de données 

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


