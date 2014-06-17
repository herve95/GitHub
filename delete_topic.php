<?php
//Cette page permet de supprimer un sujet
include('config.php');
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
if(isset($_SESSION['pseudo']))
{
	$dn1 = mysql_fetch_array(mysql_query('select count(t.id) as nb1, t.title, t.parent, c.name from topics as t, categories as c where t.id="'.$id.'" and t.id2=1 and c.id=t.parent group by t.id'));
if($dn1['nb1']>0)
{
if($_SESSION['pseudo']==$admin)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style_forum.css" rel="stylesheet" title="style_forum" />
        <title>Supprimer un sujet - <?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?> - Forum</title>
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
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; <a href="list_topics.php?parent=<?php echo $dn1['parent']; ?>"><?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; <a href="read_topic.php?id=<?php echo $id; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Supprimer le sujet
    </div>
	<div class="box_right">
    	<a href="accueil.php">Revenir sur le site</a> - <a href="list_pm.php">Vos messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
    <div class="clean"></div>
</div>
<?php
if(isset($_POST['confirm']))
{
	if(mysql_query('delete from topics where id="'.$id.'"'))
	{
	?>
	<div class="message">Le sujet a bien été supprimé.<br />
	<a href="list_topics.php?parent=<?php echo $dn1['parent']; ?>">Retourner au sujet</a></div>
	<?php
	}
	else
	{
		echo 'Une erreur s\'est produite lors de la suppression du sujet.';
	}
}
else
{
?>
<form action="delete_topic.php?id=<?php echo $id; ?>" method="post">
	Êtes-vous sûr de vouloir supprimer ce sujet?
    <input type="hidden" name="confirm" value="true" />
    <input type="submit" value="Oui" /> <input type="button" value="Non" onclick="javascript:history.go(-1);" />
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
	echo '<h2>Vous n\'avez pas le droit de supprimer ce sujet.</h2>';
}
}
else
{
	echo '<h2>Le sujet que vous désirez supprimer n\'existe pas.</h2>';
}
}
else
{
	echo '<h2>Vous devez être connecté en tant qu\'administrateur pour accéder à cette page: <a href="login.php">Connexion</a> - <a href="signup.php">Inscription</a></h2>';
}
}
else
{
	echo '<h2>Un identifiant du sujet que vous désirez supprimer n\'est pas défini.</h2>';
}
?>