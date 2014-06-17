<?php 
include ('contour.php');
include ('connect.php');
include ('redimensionner.php');
//On verifie si l'utilisateur est connecte

	//On verifie si le formulaire a été envoyé
	if(isset($_POST['salle'],$_POST['adresse'], $_POST['email'], $_POST['ville'], $_POST['departement']))
{
		$nom_salle = $_GET['nom_salle'];
		//On enleve l'echappement si get_magic_quotes_gpc est active
		if(get_magic_quotes_gpc())
		{
		$_POST['salle'] = stripslashes($_POST['salle']);
		$_POST['adresse'] = stripslashes($_POST['adresse']);
		$_POST['ville'] = stripslashes($_POST['ville']);
		$_POST['departement'] = stripslashes($_POST['departement']);
		$_POST['email'] = stripslashes($_POST['email']);
		$_POST['photo'] = $_POST['photo'];
		}
	
				//On verifie si lemail est valide
				if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
				{
					//On échape les variables pour pouvoir les mettre dans une requête SQL
				$salle = mysql_real_escape_string($_POST['salle']);
				$adresse = mysql_real_escape_string($_POST['adresse']);
				$ville = mysql_real_escape_string($_POST['ville']);
				$departement = mysql_real_escape_string($_POST['departement']);
				$email = mysql_real_escape_string($_POST['email']);
				
					$id=mysql_real_escape_string($_SESSION['id']);
					//envoie de la photo dans la base de donnée
					$alea=time();
					$nom_image="$nom_salle$alea.jpg";
					$nom_image=str_replace(' ','-',$nom_image);
					$dossier="upload/salle";
					$chemin="$dossier/$nom_image";
					modif_taille_img('photo',360,640,$dossier,$nom_image);
					$dossier="upload/salle/bullet";
					modif_taille_img('photo',48,85,$dossier,$nom_image);
					//On verifie s'il n'y a pas deja un utilisateur inscrit avec le salle choisis
					$dn = mysql_fetch_array(mysql_query('select count(*) as nb from salle where nom_salle="'.$salle.'"'));
					$dn1 = mysql_fetch_array(mysql_query('select id from salle where nom_salle="'.$_POST['id_salle'].'"'));
	
					//On verifie si le salle a ete modifie pour un autre et que celui-ci n'est pas deja utilise
					if($dn['nb']==1)
					{
						//On modifie les informations de l'utilisateur avec les nouvelles
						if(mysql_query('UPDATE salle SET nom_salle="'.$salle.'", adresse="'.$adresse.'", ville="'.$ville.'", departement="'.$departement.'", email ="'.$email.'" WHERE id="'.$dn1['id'].'"'))
						{
							if (mysql_query('insert into image(chemin, nom_image, type_compte) values ( "'.$chemin.'", "'.$nom_image.'", "'.$salle.'")'))
							{
							
							}

?>
<section>
<br>
<div class="message">Vos informations ont bien &eacute;t&eacute; modifif&eacute;e.<br />

</section>
<?php
						}
						else
						{
							//Sinon on dit quil y a eu une erreur
							$form = true;
							$message = 'Une erreur est survenue lors des modifications.';
						}
					}
					else
					{
						//Sinon, on dit que le salle voulu est deja pris
						$form = true;
						$message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
					}
				}
				else
				{
					//Sinon, on dit que lemail nest pas valide
					$form = true;
					$message = 'L\'email que vous avez entr&eacute; n\'est pas valide.';
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
			echo '<strong>'.$message.'</strong>';
		}
		//Si le formulaire a deja ete envoye on recupere les donnes que lutilisateur avait deja insere
		if(isset($_POST['salle'], $_POST['ville'],$_POST['adresse'],$_POST['departement'], $_POST['email']))
{
			$salle = htmlentities($_POST['salle']);
			$ville = htmlentities($_POST['ville'],  ENT_NOQUOTES, 'iso-8859-1');
			$adresse = htmlentities($_POST['adresse'],  ENT_NOQUOTES, 'iso-8859-1');
			$departement = htmlentities($_POST['departement'],  ENT_NOQUOTES, 'iso-8859-1');
			$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
		}
		else
		{
			
			//Sinon, on affiche les donnes a partir de la base de donnee
			$dnn = mysql_fetch_array(mysql_query('select nom_salle, adresse, departement, ville, email from salle WHERE gerant_salle="'.mysql_real_escape_string($_SESSION['pseudo']).'" AND nom_salle="'.$_GET['nom_salle'].'"'));
			$salle = htmlentities($dnn['nom_salle'], ENT_QUOTES, 'UTF-8');
			$ville = htmlentities($dnn['ville'], ENT_QUOTES, 'UTF-8');
			$departement = htmlentities($dnn['departement'],  ENT_NOQUOTES, 'UTF-8');
			$adresse = htmlentities($dnn['adresse'],  ENT_NOQUOTES, 'UTF-8');
			$email = htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8');
		}
		//On affiche le formulaire
?>
<section>
<div class="content">
    <form action="modif_salle.php?nom_salle=<?php echo $_GET['nom_salle']; ?>" method="post"  enctype="multipart/form-data">
        <br>Vous pouvez modifier vos informations:<br /><br>
		<div class="center">
		<center> 
		<table>
            <tr><td><label for="salle">Salle : </label></td><td><input type="text" name="salle" id="salle" value="<?php echo $salle; ?>" /></td></tr>
			<input type="hidden" name="id_salle" id="id_salle" value="<?php echo $_GET['nom_salle']; ?>" />
			<tr><td><label for="ville">Ville : </label></td><td><input type="text" name="ville" id="ville" value="<?php echo $ville; ?>" /></td></tr>
			<tr><td><label for="departement">Depatement : </label></td><td><input type="text" name="departement" id="departement" value="<?php echo $departement; ?>" /></td></tr>
			<tr><td><label for="adresse">Adresse : </label></td><td><input type="text" name="adresse" id="adresse" value="<?php echo $adresse; ?>" /></td></tr>
            <tr><td><label for="email">Email : </label></td><td><input type="text" name="email" id="email" value="<?php echo $email; ?>" /></td></tr>
			<tr><td><label for="photo">Ajouter une photo : <label></td><td> <input type="file" name="photo" id="photo"  /></td></tr>
			</table>
		</center> 
			<center><input class="btn btn-warning" type="submit" value="Envoyer" /></center>
        </div>
    </form>
</div>
</section>
<?php
	}
