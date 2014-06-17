<?php 
include ('contour.php');
include ('connect.php');
include ('redimensionner.php');
include ('upload.php');

//On verifie si l'utilisateur est connecte

	//On verifie si le formulaire a été envoyé
	if(isset($_POST['groupe'],$_POST['style'], $_POST['email'], $_POST['departement']))
{
		$nom_groupe = $_GET['nom_groupe'];
		//On enleve l'echappement si get_magic_quotes_gpc est active
		if(get_magic_quotes_gpc())
		{
		$_POST['groupe'] = stripslashes($_POST['groupe']);
		$_POST['style'] = stripslashes($_POST['style']);
		$_POST['departement'] = stripslashes($_POST['departement']);
		$_POST['email'] = stripslashes($_POST['email']);
		}
	
				//On verifie si lemail est valide
				if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
				{
					//On échape les variables pour pouvoir les mettre dans une requête SQL
				$groupe = mysql_real_escape_string($_POST['groupe']);
				$style = mysql_real_escape_string($_POST['style']);
				$departement = mysql_real_escape_string($_POST['departement']);
				$email = mysql_real_escape_string($_POST['email']);
				$photo = $_FILES['photo'];
				$musique = $_FILES['musique'];

					//On verifie s'il n'y a pas deja un utilisateur inscrit avec le salle choisis
					$dn = mysql_fetch_array(mysql_query('select count(*) as nb from groupe where nom_groupe="'.$groupe.'"'));
					$dn1 = mysql_fetch_array(mysql_query('select id from groupe where nom_groupe="'.$_POST['id_groupe'].'"'));
	
					//On verifie si le salle a ete modifie pour un autre et que celui-ci n'est pas deja utilise
					if($dn['nb']==1)
					{
						//On modifie les informations de l'utilisateur avec les nouvelles
						if(mysql_query('UPDATE groupe SET nom_groupe="'.$groupe.'", style="'.$style.'", departement="'.$departement.'", email ="'.$email.'" WHERE id="'.$dn1['id'].'"'))
						{
						if($_FILES['photo']['name']!=''){
							echo $photo;
							$alea=time();
							$nom_image="$nom_groupe$alea.jpg";
							$nom_image=str_replace(' ','-',$nom_image);
							$dossier="upload/groupe";
							$chemin="$dossier/$nom_image";
							modif_taille_img('photo',360,640,$dossier,$nom_image);
							$dossier="upload/groupe/bullet";
							modif_taille_img('photo',48,85,$dossier,$nom_image);
							mysql_query('insert into image(chemin, nom_image, type_compte) values ( "'.$chemin.'", "'.$nom_image.'", "'.$groupe.'")');
						}
						if($_FILES['musique']['name']!=''){
							echo $musique;
							$titre=$_FILES['musique']['name'];						
							$nom_musique="$nom_groupe$titre";
							$chemin_musique="upload/musique/$nom_musique";
							$chemin_musique=str_replace(' ','-',$chemin_musique);
							$chemin_musique2=substr($chemin_musique, 0, -4);
							$upload1 = upload('musique',$chemin_musique,153600000000, array('MP3','mp3') );
							mysql_query('insert into musique(chemin_musique, titre, nom_groupe) values ( "'.$chemin_musique2.'", "'.$nom_musique.'", "'.$groupe.'")');
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
	if(isset($form))
	{
		//On affiche un message sil y a lieu
		if(isset($message))
		{
			echo '<strong>'.$message.'</strong>';
		}
		//Si le formulaire a deja ete envoye on recupere les donnes que lutilisateur avait deja insere
	if(isset($_POST['groupe'],$_POST['style'],$_POST['departement'], $_POST['email']))
{
			$groupe = htmlentities($_POST['groupe']);
			$style = htmlentities($_POST['style'],  ENT_NOQUOTES, 'UTF-8');
			$departement = htmlentities($_POST['departement'],  ENT_NOQUOTES, 'UTF-8');
			$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
		}
		else
		{
			
			//Sinon, on affiche les donnes a partir de la base de donnee
			$dnn = mysql_fetch_array(mysql_query('select nom_groupe, departement, style, email from groupe WHERE gerant_groupe="'.mysql_real_escape_string($_SESSION['pseudo']).'" AND nom_groupe="'.$_GET['nom_groupe'].'"'));
			$groupe = htmlentities($dnn['nom_groupe'], ENT_QUOTES, 'UTF-8');
			$departement = htmlentities($dnn['departement'],  ENT_NOQUOTES, 'UTF-8');
			$style = htmlentities($dnn['style'],  ENT_NOQUOTES, 'UTF-8');
			$email = htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8');
		}
		//On affiche le formulaire
?>
<section>
<div class="content">
    <form action="modif_groupe.php?nom_groupe=<?php echo $_GET['nom_groupe']; ?>" method="post"  enctype="multipart/form-data">
        <br>Vous pouvez modifier vos informations:<br /><br>
		<div class="center">
		<center> 
		<table>
            <tr><td><label for="groupe">Groupe : </label></td><td><input type="text" name="groupe" id="groupe" value="<?php echo $groupe; ?>" /></td></tr>
			<input type="hidden" name="id_groupe" id="id_groupe" value="<?php echo $_GET['nom_groupe']; ?>" />
			<tr><td><label for="departement">Depatement : </label></td><td><input type="text" name="departement" id="departement" value="<?php echo $departement; ?>" /></td></tr>
			<tr><td><label for="style">style : </label></td><td>
				<select name="style" id="Style" >
								<option value="none"><?php echo $style; ?></option>
								<option value="rock">Rock</option>
								<option value="reggae">Reggae</option>
								<option value="jazz">Jazz</option>
								<option value="pop">Pop</option>
								<option value="hip-hop">Hip-Hop</option>
								<option value="rap">Rap</option>
							</select></td></tr>
            <tr><td><label for="email">Email : </label></td><td><input type="text" name="email" id="email" value="<?php echo $email; ?>" /></td></tr>
			<tr><td><label for="photo">Ajouter une photo : <label></td><td> <input type="file" name="photo" id="photo"  /></td></tr>
			<tr><td><label for="musique">Ajouter une musique: <label></td><td> <input type="file" name="musique" id="musique"  /></td></tr>
		
			</table>
		</center> 
			<center><input class="btn btn-warning" type="submit" value="Envoyer" /></center>
        </div>
    </form>
</div>
</section>
<?php
	}
	?>
