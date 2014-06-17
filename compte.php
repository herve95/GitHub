<?php
//Cette page permet de modifer un message
include('config.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
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
$req = mysql_query('select pseudo,id from compte');
while($dnn = mysql_fetch_array($req)){
?>
<tr>
    	<td ><a href="profile.php?id=<?php echo $dnn['id']; ?>"><?php echo htmlentities($dnn['pseudo'], ENT_QUOTES, 'UTF-8'); ?></a></td>
</tr>
<?php
}
}
