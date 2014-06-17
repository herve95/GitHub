<?php
//Cette page permet aux utilisateurs de modifier leur profil
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style_forum.css" rel="stylesheet" title="style_forum" />
        <title>Modifier ses informations personnelles</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
		<div class="content">
<?php
if(isset($_SESSION['pseudo']))
{
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['id'].'" and user1read="no") or (user2="'.$_SESSION['id'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Index du Forum</a>
    </div>
	<div class="box_right">
    	<a href="accueil.php">Revenir sur le site</a> - <a href="list_pm.php">Vos messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
    <div class="clean"></div>
</div>
	</div>
		<div class="foot"><a href="http://www.tpik.fr/accueil.php">Site principal</a> - <A HREF="mailto:admin@tpik.fr">Envoyer un mail &agrave l'admin</A></div>
	</body>
<?php
}
?>
</html>