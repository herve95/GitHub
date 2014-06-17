<?php
include ('contour.php');


function chaine_aleatoire($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789')
{
    $nb_lettres = strlen($chaine) - 1;
    $generation = '';
    for($i=0; $i < $nb_car; $i++)
    {
        $pos = mt_rand(0, $nb_lettres);
        $car = $chaine[$pos];
        $generation .= $car;
    }
    return $generation;
}

if(!empty($_POST['email']))
$email = $_POST['email'];
else
exit("mail vide.");

if(!empty($_POST['pseudo']))
$pseudo = $_POST['pseudo'];
else
exit("pseudo vide.");
 
$pass = chaine_aleatoire(8);
$passcrypt = md5($pass);
$sql1 = "UPDATE compte SET password = '$passcrypt' WHERE pseudo = '$pseudo' AND email = '$email'" ;
$req1 = mysql_query($sql1) or die ('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
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
$mail->Body='Bonjour,<br><br>Voici votre nouveau mot de passe : '.$pass.'.<br><br>
			Cordialement';
							 
$mail->AddAddress($email);
?>
		<section><article id="eventDay"><?echo 'Votre nouveau pass à &eatcutet&eacute envoy&eacute par mail'?></article></section>
<?php								 

if(!$mail->Send()) {
	echo "Mailer Error: " . $mail->ErrorInfo;
					}
	
?>

		</section>
