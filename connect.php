
<?php
if(isset($_SESSION['pseudo'])){
	$id = $_SESSION['id'];
?>

    <body>          
		<nav id="menu_right">
			<div id="connect">
				<img src="upload/compte/<?php echo $id;?>.jpg" alt="pseudo" class="photo_profil_accueil"><br>
				
<?php
	$dnn = mysql_fetch_array(mysql_query('select pseudo, nom, prenom from compte where pseudo="'.$_SESSION['pseudo'].'"'));
	$pseudo = htmlentities($dnn['pseudo'],  ENT_NOQUOTES, 'UTF-8');
	$prenom = htmlentities($dnn['prenom'],  ENT_NOQUOTES, 'UTF-8');
	$nom = htmlentities($dnn['nom'],  ENT_NOQUOTES, 'UTF-8');

?>
				<div id="ident">
					<h4><?php echo $pseudo;?></br>
					<?php echo $nom;?>
					<?php echo $prenom;?></br></h4>
				</div>
				
				<div id="bouton">
					<form method="link" action="profil.php"> 
					<input class="btn btn-warning" type="submit" value="Mon profil">
					</form>
					<form action="modif.php" method="post">
					<p><input class="btn btn-warning" type="submit" value="Modifier mon profil" /></p>
					</form>
				
					<form method="link" action="mes_groupes.php"> 
					<input class="btn btn-warning" type="submit" value="Mes groupes">
					</form>
				
					<form method="link" action="mes_salles.php"> 
					<input class="btn btn-warning" type="submit" value="Mes salles">
					</form>

					<form action="deconnexion.php" method="post">
					<p><input class="btn btn-inverse" type="submit" value="Deconnexion" /></p>
					</form>
					
				</div>				
        </nav>
    </body>
<?php
	}
?>

