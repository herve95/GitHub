<?php
include ('contour.php');
include ('connect.php');
?>
<section id=recherche>
<h3><center>Voici la liste des évènements</h3>
<table class="table table-hover">
<thead>
    <tr>
		<th><h4>Nom évènement</h4></th>
		<th><h4>Salle</h4></th>	
		<th><h4>Date</h4></th>			
    </tr>
</thead>
<?php
//On recupere les identifiants
$req = mysql_query('select id, nom_event, salle, date FROM evenement');
while($dnn = mysql_fetch_array($req))
	{
?>	
	<tr class="recherche" onclick='document.location.href="evenement.php?id=<?php echo $dnn['id']; ?>"'>
    	<td class="left"><?php echo $dnn['nom_event']; ?></td>
		<td class="left"><?php echo $dnn['salle']; ?></td>
		<td class="left"><?php echo $dnn['date']; ?></td>
  </tr>
</section>
<?php
	}