<?php
//Cette page permet de répondre à un sujet
include('config.php');
if(isset($_GET['id']))
{
	$id = intval($_GET['id']);
if(isset($_SESSION['pseudo']))
{
	$dn1 = mysql_fetch_array(mysql_query('select count(t.id) as nb1, t.title, t.parent, c.name from topics as t, categories as c where t.id="'.$id.'" and t.id2=1 and c.id=t.parent group by t.id'));
if($dn1['nb1']>0)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style_forum.css" rel="stylesheet" title="style_forum" />
        <title>Ajout d'une réponse - <?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?> - Forum</title>
		<script type="text/javascript" src="functions.js"></script>
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
    	<a href="<?php echo $url_home; ?>">Index du Forum</a> &gt; <a href="list_topics.php?parent=<?php echo $dn1['parent']; ?>"><?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; <a href="read_topic.php?id=<?php echo $id; ?>"><?php echo htmlentities($dn1['title'], ENT_QUOTES, 'UTF-8'); ?></a> &gt; Ajout d'une réponse
    </div>
	<div class="box_right">
    	<a href="accueil.php">Revenir sur le site</a> - <a href="list_pm.php">Vos messages(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['id']; ?>"><?php echo htmlentities($_SESSION['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a>
    </div>
    <div class="clean"></div>
</div>
<?php
if(isset($_POST['message']) and $_POST['message']!='')
{
	include('bbcode_function.php');
	$message = $_POST['message'];
	if(get_magic_quotes_gpc())
	{
		$message = stripslashes($message);
	}
	$message = mysql_real_escape_string(bbcode_to_html($message));
	if(mysql_query('insert into topics (parent, id, id2, title, message, authorid, timestamp, timestamp2) select "'.$dn1['parent'].'", "'.$id.'", max(id2)+1, "", "'.$message.'", "'.$_SESSION['id'].'", "'.time().'", "'.time().'" from topics where id="'.$id.'"') and mysql_query('update topics set timestamp2="'.time().'" where id="'.$id.'" and id2=1'))
	{
	?>
	<div class="message">Le message a bien &eacute;t&eacute; envoy&eacute;.<br />
	<a href="read_topic.php?id=<?php echo $id; ?>">Retourner au sujet</a></div>
	<?php
	}
	else
	{
		echo 'Une erreur s\'est produite lors de l\'envoi du message.';
	}
}
else
{
?>
<form action="new_reply.php?id=<?php echo $id; ?>" method="post">
    <label for="message">Message</label><br />
    <div class="message_buttons">
        <input type="button" value="Gras" onclick="javascript:insert('[b]', '[/b]', 'message');" /><!--
        --><input type="button" value="Italique" onclick="javascript:insert('[i]', '[/i]', 'message');" /><!--
        --><input type="button" value="Souligne" onclick="javascript:insert('[u]', '[/u]', 'message');" /><!--
        --><input type="button" value="Image" onclick="javascript:insert('[img]', '[/img]', 'message');" /><!--
        --><input type="button" value="Lien" onclick="javascript:insert('[url]', '[/url]', 'message');" /><!--
        --><input type="button" value="Gauche" onclick="javascript:insert('[left]', '[/left]', 'message');" /><!--
        --><input type="button" value="Centre" onclick="javascript:insert('[center]', '[/center]', 'message');" /><!--
        --><input type="button" value="Droite" onclick="javascript:insert('[right]', '[/right]', 'message');" />
    </div>
    <textarea name="message" id="message" cols="70" rows="6"></textarea><br />
    <input type="submit" value="Envoyer" />
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
	echo '<h2>Le sujet auquel vous désirez répondre n\'existe pas.</h2>';
}
}

}
else
{
	echo '<h2>L\'identifiant du sujet auquel vous désirez répondre n\'est pas défini.</h2>';
}
?>