<?php
include ('contour.php');
include ('connect.php');
include ('upload.php');


//On verifie si l'utilisateur est connecte
if(isset($_SESSION['pseudo']))
{
//On verifie que le formulaire a ete envoye
if(isset($_POST['nom'],$_POST['heure'],$_POST['salle'],$_POST['date'], $_POST['description'], $_POST['nom_groupe'],$_FILES['photo']))
{
	//On enleve lechappement si get_magic_quotes_gpc est active
	if(get_magic_quotes_gpc())
	{
		$_POST['nom'] = stripslashes($_POST['nom']);
		$_POST['heure'] = stripslashes($_POST['heure']);
		$_POST['salle'] = stripslashes($_POST['salle']);
		$_POST['date'] = stripslashes($_POST['date']);
		$_POST['nom_groupe'] = stripslashes($_POST['nom_groupe']);
		$_POST['description'] = stripslashes($_POST['description']);
		$_POST['photo'] = $_POST['photo'];
		
	}
	
			{
				//On echape les variables pour pouvoir les mettre dans une requette SQL
				$nom_event = mysql_real_escape_string($_POST['nom']);
				$nom_groupe = mysql_real_escape_string($_POST['nom_groupe']);
				$heure = mysql_real_escape_string($_POST['heure']);
				$salle = mysql_real_escape_string($_POST['salle']);
				$date = mysql_real_escape_string($_POST['date']);
				$description = mysql_real_escape_string($_POST['description']);
				
					$nom_image="$nom_event.jpg";
					$nom_image=str_replace(' ','-',$nom_image);
					$chemin="upload/evenement/$nom_image";
					$upload1 = upload('photo',$chemin,15360000, array('png','gif','jpg','jpeg') );
				    if ($upload1) echo"Upload de l'icone réussi!<br />";
							
				
					//On enregistre les informations dans la base de donnee
					if(mysql_query('insert into evenement(nom_event, heure, salle, date, description, gerant_evenement,nom_groupe,chemin_image) values ( "'.$nom_event.'", "'.$heure.'", "'.$salle.'", "'.$date.'", "'.$description.'", "'.$_SESSION['pseudo'].'","'.$nom_groupe.'","'.$chemin.'")'))
					{
						
						
						//Si ca a fonctionne, on naffiche pas le formulaire
						$form = false;
						
					?>
					<section><article id="eventDay">"Votre &eacute;v&eacute;nement est enregistr&eacute;.</article></section>
					<?php
					}
					else
					{
						//Sinon on dit qu'il y a eu une erreur
						$form = true;
						$message = 'Une erreur est survenue lors de l\'inscription.';
					}		
			}
}
			
else
{
$form = true;
}
if($form)
{
	//On affiche un message sil y a lieu
	if(isset($message))
	{
	?>
		<section><article id="eventDay"><?echo $message ?></article></section>
	<?php
	}
	//On affiche le formulaire
	
}

}
else
{
?>
<section>
<div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre connect&eacute;.<br />
<meta http-equiv="refresh" content="1;url=connexion.php" /></div>
</section>
<?php
}
?>