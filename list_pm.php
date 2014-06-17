<?php
//Cette page permet d'afficher la liste des messages personnels d'un membre
include('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style_forum.css" rel="stylesheet" title="style_forum" />
        <title>Messages Personnels</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Espace Membre" /></a>
	    </div>
        <div class="content">
<?php
if(isset($_SESSION['pseudo']))
{
$req1 = mysql_query('select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, compte.id as userid, compte.pseudo from pm as m1, pm as m2,compte where ((m1.user1="'.$_SESSION['id'].'" and m1.user1read="no" and compte.id=m1.user2) or (m1.user2="'.$_SESSION['id'].'" and m1.user2read="no" and compte.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
$req2 = mysql_query('select m1.id, m1.title, m1.timestamp, count(m2.id) as reps, compte.id as userid, compte.pseudo from pm as m1, pm as m2,compte where ((m1.user1="'.$_SESSION['id'].'" and m1.user1read="yes" and compte.id=m1.user2) or (m1.user2="'.$_SESSION['id'].'" and m1.user2read="yes" and compte.id=m1.user1)) and m1.id2="1" and m2.id=m1.id group by m1.id order by m1.id desc');
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['id'].'" and user1read="no") or (user2="'.$_SESSION['id'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; Liste de vos Messages Personnels
    </div>
	<div class="box_right">
    	<a href="accueil.php">Revenir sur le site</a> - <a href="list_pm.php">Vos messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
    <div class="clean"></div>
</div>
Voici la liste de vos messages:<br />
<a href="new_pm.php" class="button">Nouveau message priv&eacute;</a><br />
<h3>Messages non-lus(<?php echo intval(mysql_num_rows($req1)); ?>):</h3>
<table class="list_pm">
	<tr>
    	<th class="title_cell">Titre</th>
        <th>Nb. R&eacute;ponses</th>
        <th>Participant</th>
        <th>Date d'envoi</th>
    </tr>
<?php
while($dn1 = mysql_fetch_array($req1))
{
?>
	<tr>
    	<td class="left"><a href="read_pm.php?id=<?php echo $dn1['id']; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn1['reps']-1; ?></td>
    	<td><a href="profile.php?id=<?php echo $dn1['userid']; ?>"><?php echo htmlentities($dn1['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo date('d/m/Y H:i:s' ,$dn1['timestamp']); ?></td>
    </tr>
<?php
}
if(intval(mysql_num_rows($req1))==0)
{
?>
	<tr>
    	<td colspan="4" class="center">Vous n'avez aucun message non-lu.</td>
    </tr>
<?php
}
?>
</table>
<br />
<h3>Messages lus(<?php echo intval(mysql_num_rows($req2)); ?>):</h3>
<table class="list_pm">
	<tr>
    	<th class="title_cell">Titre</th>
        <th>Nb. R&eacute;ponses</th>
        <th>Participant</th>
        <th>Date d'envoi</th>
    </tr>
<?php
while($dn2 = mysql_fetch_array($req2))
{
?>
	<tr>
    	<td class="left"><a href="read_pm.php?id=<?php echo $dn2['id']; ?>"><?php echo htmlentities($dn2['title'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn2['reps']-1; ?></td>
    	<td><a href="profile.php?id=<?php echo $dn2['id']; ?>"><?php echo htmlentities($dn2['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo date('d/m/Y H:i:s' ,$dn2['timestamp']); ?></td>
    </tr>
<?php
}
if(intval(mysql_num_rows($req2))==0)
{
?>
	<tr>
    	<td colspan="4" class="center">Vous n'avez aucun message lu.</td>
    </tr>
<?php
}
?>
</table>
<?php
}
else
{
?>
Vous devez &ecirc;tre connect&eacute; pour acc&eacute;der &agrave; cette page.

<?php
}
?>
		</div>
		<div class="foot"><a href="http://www.tpik.fr/accueil.php">Site principal</a> - <A HREF="mailto:admin@tpik.fr">Envoyer un mail &agrave l'admin</A></div>
	</body>
</html>