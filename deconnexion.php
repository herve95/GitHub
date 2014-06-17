<?php
include ('contour.php');
?>
<?php


//Si lutilisateur est connecte, on le deconecte
if(isset($_SESSION['pseudo']))
{
	//On le deconecte en supprimant simplement les sessions nni et id
	unset($_SESSION['pseudo'], $_SESSION['id']);
	setcookie('pseudo', '', time()-100);
	setcookie('password', '', time()-100);
?>
<section id=page_profil>
<br>
<tr>
    	<td class="left">Vous avez bien &eacute;t&eacute; d&eacute;connect&eacute;.<br /></td>
</tr>
</section>
<meta http-equiv="refresh" content="1;url=accueil.php" />
<?php
}
else 'Bien tenté mais vous devez déjà vous connecter avant de vous déconnecter;.<br />';