<?php
include ('contour.php');
		
//On verifie que le formulaire a ete envoye
if(isset($_POST['nom_salle'],$_POST['adresse_salle'], $_POST['ville'], $_POST['email_salle'], $_POST['departement_salle'], $_POST['telephone_salle']))
{
	//On enleve lechappement si get_magic_quotes_gpc est active
	if(get_magic_quotes_gpc())
	{
		$_POST['nom_salle'] = stripslashes($_POST['nom_salle']);
		$_POST['ville'] = stripslashes($_POST['ville']);
		$_POST['adresse_salle'] = stripslashes($_POST['adresse_salle']);
		$_POST['email_salle'] = stripslashes($_POST['email_salle']);
		$_POST['departement_salle'] = stripslashes($_POST['departement_salle']);
		$_POST['telephone_salle'] = stripslashes($_POST['telephone_salle']);
		
	}
	
			//On verifie si lemail est valide
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email_salle']))
			{
				//On echape les variables pour pouvoir les mettre dans une requette SQL
				$gerant_salle = $_SESSION['pseudo'];
				$nom_salle = mysql_real_escape_string($_POST['nom_salle']);
				$ville = mysql_real_escape_string($_POST['ville']);
				$adresse_salle = mysql_real_escape_string($_POST['adresse_salle']);
				$email_salle = mysql_real_escape_string($_POST['email_salle']);
				$departement_salle = mysql_real_escape_string($_POST['departement_salle']);
				if(preg_match("#(\+[0-9]{2}\([0-9]\))?[0-9]{10}#",$_POST['telephone_salle'])){
				$telephone_salle = mysql_real_escape_string($_POST['telephone_salle']);
				
					//On enregistre les informations dans la base de donnee
					if(mysql_query('INSERT INTO salle ( gerant_salle, nom_salle, ville,  adresse, email, departement, telephone, creation_date) VALUES ("'.$gerant_salle.'","'.$nom_salle.'", "'.$ville.'","'.$adresse_salle.'", "'.$email_salle.'", "'.$departement_salle.'", "'.$telephone_salle.'", "'.date("Y-m-d").'")'))
					{
						//Si ca a fonctionne, on naffiche pas le formulaire
						$form = false;
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->Host = "mailout.one.com";
$mail->Port = 25;
$mail->Username = "admin@tpik.fr";
$mail->Password = "g4btpik";
											  
							 
$mail->From       = "admin@tpik.fr";
$mail->FromName   = "Admin Tpik";
$mail->Subject    = "Votre nouveau groupe";
$mail->AltBody    = "This is the body when user views in plain text format"; 
$mail->WordWrap   = 50; // set word wrap
$mail->Body='Bonjour,<br><br>Vous avez cr&eacuteer une salle : '.$email_salle.'<br><br>
			Cordialement';
			
$mail->AddAddress($email_salle);

if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
					}
?>
<section><article id="eventDay">"Vous avez bien cr&eacute;t&eacutee; la salle <? echo $nom_salle; ?>. Un email a &eacutet&eacute envoy&eacute par mail <? echo $email_salle; ?></article></section>
<meta http-equiv="refresh" content="1;url=salle.php?nom_salle=<?php echo $nom_salle; ?>&annee=2014" />
<?php
					}
					else
					{
						//Sinon on dit quil y a eu une erreur
						$form = true;
						$message = 'Une erreur est survenue lors de la creation.';
					}
				
				}
				else 
				{
					//Sinon on dit quil y a eu une erreur
						$form = true;
						$message = 'Le telephone n\'est pas bon';
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
	?>
		<section><article id="eventDay"><?echo $message?></article></section>
	<?php
	}
	//On affiche le formulaire

}