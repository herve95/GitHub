<?php
include ('contour.php');
include ('connect.php');
?>
<section id=recherche>
	<h3><center>Voici la liste des salles</h3>
	<table class="table table-hover">
		<thead>
			<tr><h4>
			   <th><h4>Salle</h4></th>
			   <th><h4>Département</h4></th>
			   <th><h4>Adresse</h4></th>
			</tr>
		</thead>
	
<?php

//On recupere les identifiants, les pseudos et les emails des utilisateurs
$req = mysql_query('select nom_salle, departement, adresse FROM salle');
while($dnn = mysql_fetch_array($req))
	{
?>
	<tr class="recherche" onclick='document.location.href="salle.php?nom_salle=<?php echo $dnn['nom_salle']; ?>&annee=<?php echo date('Y');?>"'>
    	<td class="left"><?php echo htmlentities($dnn['nom_salle'], ENT_QUOTES, 'UTF-8'); ?></a></td>
		<td class="left"><?php echo htmlentities($dnn['adresse'], ENT_QUOTES, 'UTF-8'); ?></a></td>
		<td class="left"><?php echo htmlentities($dnn['departement'], ENT_QUOTES, 'UTF-8'); ?></a></td>
   </tr>
</section>
<?php
	}