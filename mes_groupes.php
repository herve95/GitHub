<?php
include ('contour.php');
include ('connect.php');
?>
<section id=recherche>
	<h3><center>Voici la liste des groupes :</h3>
	<table class="table table-hover">
	<thead>
		<tr>
			<th><h4>Groupe</h4></th>
			<th><h4>Style</h4></th>
			<th><h4>Département</h4></th>
		</tr>
	</thead>
<?php
	//On recupere les identifiants, les pseudos et les emails des utilisateurs
	$req = mysql_query('select nom_groupe,style,departement from groupe where gerant_groupe = "'.$_SESSION['pseudo'].'" ');
	while($dnn = mysql_fetch_array($req))
	{
?>	
	<tr class="recherche" onclick='document.location.href="groupe.php?nom_groupe=<?php echo $dnn['nom_groupe']; ?>"'>
    	<td class="left"><?php echo htmlentities($dnn['nom_groupe'], ENT_QUOTES, 'UTF-8'); ?></td>
		<td class="left"><?php echo htmlentities($dnn['style'], ENT_QUOTES, 'UTF-8'); ?></td>
		<td class="left"><?php echo htmlentities($dnn['departement'], ENT_QUOTES, 'UTF-8'); ?></td>
	</tr>
</section>
<?php
	}