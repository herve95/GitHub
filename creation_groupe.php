<?php
include ('contour.php');

$gerant_groupe = $_SESSION['pseudo'] ;
		
//On verifie que le formulaire a ete envoye
if(isset($_POST['nom_groupe'],$_POST['style'],$_POST['email_groupe'], $_POST['departement_groupe'],$_POST['telephone_groupe']))
{
	//On enleve lechappement si get_magic_quotes_gpc est active
	if(get_magic_quotes_gpc())
	{
		$_POST['nom_groupe'] = stripslashes($_POST['nom_groupe']);
		$_POST['style'] = stripslashes($_POST['style']);
		$_POST['email_groupe'] = stripslashes($_POST['email_groupe']);
		$_POST['departement_groupe'] = stripslashes($_POST['departement_groupe']);
		$_POST['telephone_groupe'] = stripslashes($_POST['telephone_groupe']);
	}

			//On verifie si lemail est valide
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email_groupe']))
			{
				//On echape les variables pour pouvoir les mettre dans une requette SQL
				$nom_groupe = mysql_real_escape_string($_POST['nom_groupe']);
				$style = mysql_real_escape_string($_POST['style']);
				$email_groupe = mysql_real_escape_string($_POST['email_groupe']);
				$departement_groupe = mysql_real_escape_string($_POST['departement_groupe']);
				if(preg_match("#(\+[0-9]{2}\([0-9]\))?[0-9]{10}#",$_POST['telephone_groupe'])){
				$telephone_groupe = mysql_real_escape_string($_POST['telephone_groupe']);
				
					//On enregistre les informations dans la base de donnee
					if(mysql_query('INSERT INTO groupe ( nom_groupe, style, email, gerant_groupe, departement, telephone, creation_date) VALUES ("'.$nom_groupe.'","'.$style.'", "'.$email_groupe.'","'.$gerant_groupe.'", "'.$departement_groupe.'", "'.$telephone_groupe.'", "'.date("Y-m-d").'")'))
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
$mail->Body='Bonjour,<br><br>Vous avez cr&eacuteer un goupe : '.$nom_groupe.'<br><br>
			Cordialement';
							 
$mail->AddAddress($email_groupe);

if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
					}	
?>
<section><article id="eventDay">"Vous avez bien cr&eacutee le groupe <? echo $nom_groupe ; ?>. 'Un email a &eacutet&eacute envoy&eacute par mail à <? echo $email_groupe ; ?>'</article></section>
<meta http-equiv="refresh" content="1;url=groupe.php?nom_groupe=<?php echo $nom_groupe; ?>" />
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