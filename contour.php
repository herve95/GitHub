<?php
include('config.php');
ini_set("max_execution_time", 60);
include("class.phpmailer.php");                                                 // Appel de mon class.phpmailer
include("class.smtp.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
<!--[if lte IE 8]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <link rel="stylesheet" href="style_ie8.css" />
<![endif]--> 

        <meta charset="utf-8" />
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="style.css" />
        <title>Tpik</title>

		<link rel="SHORTCUT ICON" href="favicon.ico" /> 

		<link rel="shortcut icon" href="favicon.ico" type="images/x-icon" />
		<link rel="icon" type="images/png" href="images/favicon.ico" />

    </head>

    <body>
            <header>
                <div id="entete">
                    <img src="images/titre.png" alt="Logo Tpik" id="logo" />

				</div>
            </header>
			
			<nav id="menu_left">					
				<ul id="menu-navigation">
					<li><a href="accueil.php">Accueil</a></li>
					<li><a href="">Rechercher</a>
					<ul>
						<li><a href="recherche_groupe.php">Rechercher Groupes</a></li>
						<li><a href="recherche_salle.php">Rechercher Salles</a></li>
						<li><a href="recherche_evenement.php">Rechercher Evènements</a></li>
					</ul>
					</li>
						<li><a href="">Aide</a>
						<ul>
							<li><a href="presentation.php">Presentation de Tpik</a></li>
							<li><a href="aide_groupe.php">Creer un groupe</a></li>
							<li><a href="aide_salle.php">Creer une salle</a></li>
							<li><a href="CGU.php">Conditions d'utilisations</a></li>
							<li><a href="aide_fonction.php">Fonctionnalités avancées</a></li>
						</ul>
					</li>
					<li><a target="blank" href="forum.php">Forum</a></li>
				</ul>
			</nav>
            
			
            <footer>
				Dernière mise à jour faites le 17/06/2014.
            </footer>
    </body>
</html>