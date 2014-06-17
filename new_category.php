<?php
//Cette page permet d'ajouter une categorie
include('config.php');
if(isset($_SESSION['pseudo']) and $_SESSION['pseudo']==$admin)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style_forum.css" rel="stylesheet" title="style_forum" />
        <title>Nouvelle catégorie - Forum</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
	    </div>
        <div class="content">
<?php
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['id'].'" and user1read="no") or (user2="'.$_SESSION['id'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; Nouvelle catégorie
    </div>
	<div class="box_right">
    	<a href="accueil.php">Revenir sur le site</a> - <a href="list_pm.php">Vos messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
    <div class="clean"></div>
</div>
<?php
if(isset($_POST['name'], $_POST['description']) and $_POST['name']!='')
{
	$name = $_POST['name'];
	$description = $_POST['description'];
	if(get_magic_quotes_gpc())
	{
		$name = stripslashes($name);
		$description = stripslashes($description);
	}
	$name = mysql_real_escape_string($name);
	$description = mysql_real_escape_string($description);
	if(mysql_query('insert into categories (id, name, description, position) select ifnull(max(id), 0)+1, "'.$name.'", "'.$description.'", count(id)+1 from categories'))
	{
	?>
	<div class="message">La catégorie a bien été créée.<br />
	<a href="<?php echo $url_home; ?>">Retourner à l'index du Forum</a></div>
	<?php
	}
	else
	{
		echo 'Une erreur s\'est produite lors de la création de la catégorie.';
	}
}
else
{
?>
<form action="new_category.php" method="post">
	<label for="name">Nom</label><input type="text" name="name" id="name" /><br />
	<label for="description">Description</label>(html accepté)<br />
    <textarea name="description" id="description" cols="70" rows="6"></textarea><br />
    <input type="submit" value="Créer" />
</form>
<?php
}
?>
		</div>
		<div class="foot"><a href="http://www.tpik.fr/accueil.php">Site principal</a> - <A HREF="mailto:admin@tpik.fr">Envoyer un mail &agrave l'admin</A></div>
	</body>
</html>
<?php
}
else
{
	echo '<h2>Vous devez être connecté en tant qu\'administrateur pour accéder à cette page: <a href="login.php">Connexion</a> - <a href="signup.php">Inscription</a></h2>';
}
?>