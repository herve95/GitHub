<?php
include ('contour.php');

	$opseudo = '';
	//On verifie si le formulaire a ete envoye
	if(isset($_POST['pseudo'], $_POST['password']))
	{
		//On echappe les variables pour pouvoir les mettre dans des requetes SQL
		if(get_magic_quotes_gpc())
		{
			$opseudo = stripslashes($_POST['pseudo']);
			$pseudo = mysql_real_escape_string(stripslashes($_POST['pseudo']));
			$password = stripslashes(md5($_POST['password']));
		}
		else
		{
			$pseudo = mysql_real_escape_string($_POST['pseudo']);
			$password = stripslashes(md5($_POST['password']));
		}
		//On recupere le mot de passe de lutilisateur
		$req = mysql_query('select password,id from compte where pseudo="'.$pseudo.'"');
		$dn = mysql_fetch_array($req);
		//On le compare a celui quil a entre et on verifie si le membre existe
		if($dn['password']==$password and mysql_num_rows($req)>0)
		{
			//Si le mot de passe est bon, on ne vas pas afficher le formulaire
			$form = false;
			//On enregistre son pseudo dans la session nni et son identifiant dans la session id
			$_SESSION['pseudo'] = $_POST['pseudo'];
			$_SESSION['id'] = $dn['id'];
			
			$one_year = time()+(60*60*24*365);
			setcookie('pseudo', $_POST['pseudo'], $one_year);
			setcookie('password', sha1($password), $one_year);
			
			if(isset($_SESSION['pseudo'])){$dnn = mysql_fetch_array(mysql_query('select pseudo, nom, prenom from compte where pseudo="'.$_SESSION['pseudo'].'"'));
			$prenom = htmlentities($dnn['prenom'],  ENT_NOQUOTES, 'UTF-8');
			$nom = htmlentities($dnn['nom'],  ENT_NOQUOTES, 'UTF-8');
			$nom_complet = $nom ." ".$prenom ;
			}
?>
<section id=page_profil>
<br><tr>
    	<td class="left">Bienvenue <?php echo $nom_complet;?>. Vous allez &ecirctre redirig&eacute<br /></td>
</tr>
</section>
<meta http-equiv="refresh" content="1;url=profil.php" />
 
<?php
		}
		else
		{
			//Sinon, on indique que la combinaison nest pas bonne
			$form = true;
			$message = 'La combinaison que vous avez entr&eacute; n\'est pas bonne.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
		//On affiche un message s'il y a lieu
	if(isset($message))
	{
		echo '<section id=page_profil><div id="description_salle">'.$message.'</div></section>';
	}
	//On affiche le formulaire

}

