<?php
include ('contour.php');
		
//On verifie que le formulaire a ete envoye
if(isset($_POST['pseudo'],$_POST['nom'],$_POST['prenom'],$_POST['pays'],$_POST['ville'],$_POST['departement'],$_POST['adresse'],$_POST['date_de_naissance'],$_POST['password'], $_POST['passverif'], $_POST['email'], $_POST['CGU']))
{
	//On enleve lechappement si get_magic_quotes_gpc est active
	if(get_magic_quotes_gpc())
	{
		$_POST['nom'] = stripslashes($_POST['nom']);
		$_POST['prenom'] = stripslashes($_POST['prenom']);
		$_POST['pseudo'] = stripslashes($_POST['pseudo']);
		$_POST['pays'] = stripslashes($_POST['pays']);
		$_POST['ville'] = stripslashes($_POST['ville']);
		$_POST['departement'] = stripslashes($_POST['departement']);
		$_POST['adresse'] = stripslashes($_POST['adresse']);
		$_POST['date_de_naissance'] = stripslashes($_POST['date_de_naissance']);
		$_POST['password'] = stripslashes(md5($_POST['password']));
		$_POST['passverif'] = stripslashes(md5($_POST['passverif']));
		$_POST['email'] = stripslashes($_POST['email']);
		
	}
	//On verifie si le mot de passe et celui de la verification sont identiques
	if($_POST['password']==$_POST['passverif'])
	{
		//On verifie si le mot de passe a 6 caracteres ou plus
		if(strlen($_POST['password'])>=6)
		{
			//On verifie si lemail est valide
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
			{
				//On echape les variables pour pouvoir les mettre dans une requette SQL
				$pseudo = mysql_real_escape_string($_POST['pseudo']);
				$nom = mysql_real_escape_string($_POST['nom']);
				$prenom = mysql_real_escape_string($_POST['prenom']);
				$pays = mysql_real_escape_string($_POST['pays']);
				$departement = mysql_real_escape_string($_POST['departement']);
				$ville = mysql_real_escape_string($_POST['ville']);
				$adresse = mysql_real_escape_string($_POST['adresse']);
				$date_de_naissance = mysql_real_escape_string($_POST['date_de_naissance']);
				$password = mysql_real_escape_string(md5($_POST['password']));
				$email = mysql_real_escape_string($_POST['email']);
				//On verifie sil ny a pas deja un utilisateur inscrit avec le pseudo choisis
				$dn = mysql_num_rows(mysql_query('select id from compte where pseudo="'.$pseudo.'"'));
				if($dn==0)
				{
					//On recupere le nombre dutilisateurs pour donner un identifiant a lutilisateur actuel
					$dn2 = mysql_query('select id from compte where id = (SELECT max(id) FROM compte)');
					$dnn2 = mysql_fetch_array($dn2);
					$id = $dnn2['id']+1;
					
	
					//envoie de la photo dans la base de donnée
					$nom_image="$id.jpg";
					$chemin="upload/compte/$nom_image";
					
					$file = "upload/compte/default.jpg";
					$newfile = $chemin;

					if (!copy($file, $newfile)) {
						echo "La copie $file du fichier a échoué...\n";
					}
					
					//On enregistre les informations dans la base de donnee
					if(mysql_query('insert into compte(id, pseudo, nom, prenom, pays, departement, ville, adresse, date_de_naissance, password, email) values ('.$id.', "'.$pseudo.'", "'.$nom.'", "'.$prenom.'", "'.$pays.'", "'.$departement.'", "'.$ville.'", "'.$adresse.'", "'.$date_de_naissance.'","'.$password.'", "'.$email.'")'))
					{
						if (mysql_query('insert into image(chemin, nom_image, type_compte) values ( "'.$chemin.'", "'.$nom_image.'", "compte")'))
							{
								//Si ca a fonctionné, on n'affiche pas le formulaire
								$form = false;
							}
?>
<section><article id="eventDay">"Vous avez bien &eacute;t&eacute; inscrit. Vous pouvez dor&eacute;navant vous connecter. Un email a &eacutet&eacute envoy&eacute par mail.</article></section>
<meta http-equiv="refresh" content="1;url=accueil.php" />
<?php
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->Host = "mailout.one.com";
$mail->Port = 25;
$mail->Username = "admin@tpik.fr";
$mail->Password = "g4btpik";
											  
							 
$mail->From       = "admin@tpik.fr";
$mail->FromName   = "Admin Tpik";
$mail->Subject    = "Votre nouveau mot de passe";
$mail->AltBody    = "This is the body when user views in plain text format"; 
$mail->WordWrap   = 50; // set word wrap
$mail->Body='Bonjour,<br><br>Bienvenue sur notre site. Voici votre login : '.$pseudo.' et votre email en cas de perte de passe : '.$email.'<br><br>
			Cordialement';
							 
$mail->AddAddress($email);						 
					 
if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
					}
					
					}
					else
					{
						//Sinon on dit quil y a eu une erreur
						$form = true;
						$message = 'Une erreur est survenue lors de l\'inscription.';
					}
				}
				else
				{
					//Sinon, on dit que le pseudo est deja utilisé
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
			//Sinon, on dit que le mot de passe nest pas assez long
			$form = true;
			$message = 'Le mot de passe que vous avez entr&eacute; contien moins de 6 caract&egrave;res.';
		}
	}
	else
	{
		//Sinon, on dit que les mots de passes ne sont pas identiques
		$form = true;
		$message = 'Les mots de passe que vous avez entr&eacute; ne sont pas identiques.';
	}
}
else
{
	$form = true;
	$message = 'Vous n\'avez pas accepté les conditions';
	?><meta http-equiv="refresh" content="5;url=accueil.php" /><?php
}
if($form)
{
	//On affiche un message sil y a lieu
	if(isset($message))
	{
	?>
		<section><article id="eventDay"><?echo $message;?></article></section>
	<?php
	}
	//On affiche le formulaire

}
