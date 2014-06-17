<?php
include('contour.php');
?>
<?php
if(isset($_SESSION['pseudo']))
{

 if(mysql_query('DELETE FROM groupe WHERE nom_groupe = "'.$_POST['nom_groupe'].'"')){
 
$form = false;
							
?>
<section>
<br>
<div class="message">Le groupe &agrave &eacute;t&eacute; supprim&eacute;e.<br />
<meta http-equiv="refresh" content="1;url=accueil.php" /></div>
</section>
<?php

	}
else {
	$form = true;
	$message = 'Le groupe n\'&agrave pas &eacutet&eacute supprim&eacute';
		}
 if($form)
	{
		//On affiche un message sil y a lieu
		if(isset($message))
		{
			?><section><article id="eventDay"><?echo $message ?></article></section><?php
		}
 
	}
 }