<?php
//Cette page permet d'afficher le profil d'un membre
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style_forum.css" rel="stylesheet" title="style_forum" />
        <title>Profil d'un utilisateur</title>
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
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; <a href="compte.php">Liste des utilisateurs</a> &gt; Profil d'un utilisateur
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Vos messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
    <div class="clean"></div>
</div>
<?php
}
else
{
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; <a href="compte.php">Liste des utilisateurs</a> &gt; Profil d'un utilisateur
    </div>
    <div class="clean"></div>
</div>
<?php
}
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
	$dn = mysql_query('select pseudo, nom, prenom, adresse, ville, pays, departement, email from compte where id="'.$id.'"');
	if(mysql_num_rows($dn)>0)
	{
		$dnn = mysql_fetch_array($dn);
?>
Voici le profil de "<?php echo htmlentities($dnn['pseudo']); ?>" :
<table style_forum="width:500px;">
	<tr>
    	<td><?php
?></td>
    	<td class="left"><h1><?php echo htmlentities($dnn['pseudo'], ENT_QUOTES, 'UTF-8'); ?></h1>
    	Nom: <?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?><br />
		Prénom: <?php echo htmlentities($dnn['prenom'], ENT_QUOTES, 'UTF-8'); ?><br />
		Adresse <?php echo htmlentities($dnn['nom'], ENT_QUOTES, 'UTF-8'); ?><br />
		Ville: <?php echo htmlentities($dnn['ville'], ENT_QUOTES, 'UTF-8'); ?><br />
		Pays: <?php echo htmlentities($dnn['pays'], ENT_QUOTES, 'UTF-8'); ?><br />
		Departement: <?php echo htmlentities($dnn['departement'], ENT_QUOTES, 'UTF-8'); ?><br />
    </tr>
</table>
<?php
if(isset($_SESSION['pseudo']) and $_SESSION['pseudo']!=$dnn['pseudo'])
{
?>
<br /><a href="new_pm.php?recip=<?php echo urlencode($dnn['pseudo']); ?>" class="big">Envoyer un MP à "<?php echo htmlentities($dnn['pseudo'], ENT_QUOTES, 'UTF-8'); ?>"</a>
<?php
}
	}
	else
	{
		echo 'Cet utilisateur n\'existe pas.';
	}
}
else
{
	echo 'L\'identifiant de l\'utilisateur n\'est pas d&eacute;fini.';
}
?>
		</div>
		<div class="foot"><a href="http://www.tpik.fr/accueil.php">Site principal</a> - <A HREF="mailto:admin@tpik.fr">Envoyer un mail &agrave l'admin</A></div>
	</body>
</html>