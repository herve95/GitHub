<?php
//On demarre les sessions
session_start();

// Connexion à la base de données
		$link = mysql_connect("tpik.fr.mysql", "tpik_fr", "ZbF5QmeY")
		// $link = mysql_connect("localhost", "root", "")
		or die("Impossible de se connecter : " . mysql_error());
		
		// Rendre la base de données bdd, la base courante
		$db_selected = mysql_select_db('tpik_fr', $link);
		if (!$db_selected){
			die ('Impossible de sélectionner la base de données : ' . mysql_error());
		}
?>