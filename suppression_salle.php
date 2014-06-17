<?php
include('contour.php');
?>
<?php
if(isset($_SESSION['pseudo']))
{

 if(mysql_query('DELETE FROM salle WHERE nom_salle = "'.$_POST['nom_salle'].'"')){
 
$form = false;
							
?>
<section>
<br>
<div class="message">La salle &agrave &eacute;t&eacute; supprim&eacute;e.<br />
<meta http-equiv="refresh" content="1;url=accueil.php" /></div>
</section>
<?php

	}
else {
	$form = true;
	$message = 'La salle n\'&agrave pas &eacutet&eacute supprim&eacute';
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