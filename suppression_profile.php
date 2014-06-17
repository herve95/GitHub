<?php
include('contour.php');
?>
<?php
if(isset($_SESSION['pseudo']))
{



 if(mysql_query('DELETE FROM compte WHERE pseudo = "'.$_SESSION['pseudo'].'"')){
 
 if(mysql_query('DELETE FROM groupe WHERE gerant_groupe = "'.$_SESSION['pseudo'].'"')){
 
		if(mysql_query('DELETE FROM salle WHERE gerant_salle = "'.$_SESSION['pseudo'].'"')){
		
			?>
			<section>
			<br>
			<section><article id="eventDay"><?echo 'Tout a été supprimer' ?></article></section>
			<?php
			}
		}
unset($_SESSION['pseudo'], $_SESSION['id']);
setcookie('pseudo', '', time()-100);
setcookie('password', '', time()-100);
 }
 else{
		 if (mysql_query('DELETE FROM salle WHERE gerant_salle = "'.$_SESSION['pseudo'].'"')){
		 
				 ?>
				<section>
				<br>
				<section><article id="eventDay"><?echo 'Tout a été supprimer' ?></article></section>
				<?php
		 }
	}

 }
 