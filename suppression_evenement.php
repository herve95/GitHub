<?php
include('contour.php');


if(isset($_SESSION['pseudo']))
{

 if(mysql_query('DELETE FROM evenement WHERE id = "'.$_POST['nom_event'].'"')){
 
$form = false;
							
?>
<section>
<br>
<div class="message">L\'evenement &agrave &eacute;t&eacute; supprim&eacute;e.<br />
<meta http-equiv="refresh" content="1;url=accueil.php" /></div>
</section>
<?php

	}
else {
	$form = true;
	$message = 'L\'evenement n\'&agrave pas &eacutet&eacute supprim&eacute';
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