<?php
include ('contour.php');
?>

<section>
<form action="envoie_pass.php" method="post">
        <center>
		<table>
            <tr><td><label for="pseudo">Rentrez votre pseudo : </label></td><td><input type="text" name="pseudo" id="pseudo" /></td></tr>
			 <tr><td><label for="email">Rentrez votre email : </label></td><td><input type="text" name="email" id="email" /></td></tr>
		</table>
		<center>
            <br><input type="submit" value="Envoyer" /></br><br>
    </form>
</section>
