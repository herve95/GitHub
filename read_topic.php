<?php
//Cette page permet d'afficher le contenu d'un sujet
include('config.php');
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
	$dn1 = mysql_fetch_array(mysql_query('select count(t.id) as nb1, t.title, t.parent, count(t2.id) as nb2, c.name from topics as t, topics as t2, categories as c where t.id="'.$id.'" and t.id2=1 and t2.id="'.$id.'" and c.id=t.parent group by t.id'));
if($dn1['nb1']>0)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style_forum.css" rel="stylesheet" title="style_forum" />
        <title><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?> - Forum</title>
    </head>
    <body>
    	<div class="header">
        	<a href="<?php echo $url_home; ?>"><img src="<?php echo $design; ?>/images/logo.png" alt="Forum" /></a>
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
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; <a href="list_topics.php?parent=<?php echo $dn1['parent']; ?>"><?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; <a href="read_topic.php?id=<?php echo $id; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Lecture des messages
    </div>
	<div class="box_right">
    	<a href="accueil.php">Revenir sur le site</a> - <a href="list_pm.php">Vos messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a>
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
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; <a href="list_topics.php?parent=<?php echo $dn1['parent']; ?>"><?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; <a href="read_topic.php?id=<?php echo $id; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Lecture des messages
    </div>
    <div class="clean"></div>
</div>
<?php
}
?>
<h1><?php echo $dn1['title']; ?></h1>
<?php
$dn2 = mysql_query('select t.id2, t.authorid, t.message, t.timestamp, u.pseudo as author from topics as t, compte as u where t.id="'.$id.'" and u.id=t.authorid order by t.timestamp asc');
?>
<table class="messages_table">
	<tr>
    	<th class="author">Auteur</th>
    	<th>Message</th>
	</tr>
<?php
while($dnn2 = mysql_fetch_array($dn2))
{
?>
	<tr>
    	<td class="author center"><?php

?><br /><a href="profile.php?id=<?php echo $dnn2['authorid']; ?>"><?php echo $dnn2['author']; ?></a></td>
    	<td class="left"><?php if(isset($_SESSION['pseudo']) and ($_SESSION['pseudo']==$dnn2['author'] or $_SESSION['pseudo']==$admin)){ ?><div class="edit"><a href="edit_message.php?id=<?php echo $id; ?>&id2=<?php echo $dnn2['id2']; ?>"><img src="<?php echo $design; ?>/images/edit.png" alt="Modifier" /></a></div><?php } ?><div class="date">Date d'envoi: <?php echo date('d/m/Y H:i:s' ,$dnn2['timestamp']); ?></div>
        <div class="clean"></div>
    	<?php echo $dnn2['message']; ?></td>
    </tr>
<?php
}
?>
</table>
<?php
if(isset($_SESSION['pseudo']))
{
?>
	<a href="new_reply.php?id=<?php echo $id; ?>" class="button">Répondre</a>
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
	echo '<h2>La catégorie que vous désirez visiter n\'existe pas.</h2>';
}
}
else
{
	echo '<h2>L\'identifiant de la catégorie que vous désirez visiter n\'est pas défini.</h2>';
}
?>