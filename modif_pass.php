<?php 
include ('contour.php');
include ('connect.php');
//On verifie si l'utilisateur est connecte
if(isset($_SESSION['pseudo']))
{
	//On verifie si le formulaire a été envoyé
	if(isset($_POST['password'], $_POST['passverif']))
{
	$_POST['password'] = stripslashes($_POST['password']);
	$_POST['passverif'] = stripslashes($_POST['passverif']);
		
			//On verifie si le mot de passe et celui de la verification sont identiques
		if($_POST['password']==$_POST['passverif'])
	{
			//On verifie si le mot de passe a 6 caracteres ou plus
			if(strlen($_POST['password'])>=6)
		{
		$password = mysql_real_escape_string(md5($_POST['password']));
		
		//On modifie les informations de l'utilisateur avec les nouvelles
						if(mysql_query('UPDATE compte SET password="'.$password.'" WHERE pseudo="'.mysql_real_escape_string($_SESSION['pseudo']).'"'))
						{
						
						?>
<section>
<br>
<div class="message">Le mot de passe a &eacute;t&eacute; modifif&eacute;e.<br />
<meta http-equiv="refresh" content="1;url=accueil.php" /></div>
</section>
<?php

	}
						else
						{
							//Sinon on dit quil y a eu une erreur
							$form = true;
							$message = 'Une erreur est survenue lors des modifications.';
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
			$message = 'Les mot de passe que vous avez entr&eacute; ne sont pas identiques.';
		}
	}
	else
	{
		$form = true;
	}
	
	if(isset($form))
	{
		//On affiche un message sil y a lieu
		if(isset($message))
		{
			echo '<strong>'.$message.'</strong>';
		}
	
?>
<section>
<div class="content">
    <form action="modif_pass.php" method="post"  enctype="multipart/form-data">
        <br>Vous pouvez modifier vos informations:<br /><br>
		<div class="center">
		<center> 
		<table>		
           <tr><td><label for="password">Mot de passe<span class="small">(6 caract&egrave;res min.) : </span></label></td><td><input type="password" name="password" id="password" /></td></tr>
            <tr><td><label for="passverif">Mot de passe<span class="small">(v&eacute;rification) : </span></label></td><td><input type="password" name="passverif" id="passverif" /></td></tr>
			</table>
		</center> 
			<center><input type="submit" value="Envoyer" /></center>
        </div>
    </form>
</div>
</section>
<?php
}
}