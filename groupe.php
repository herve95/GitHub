<?php
include ('contour.php');
include ('connect.php');

	//On verifie que lidentifiant de l'utilisateur est defini
	if(isset($_GET['nom_groupe']))
	{
		$nom_groupe = $_GET['nom_groupe'];
		//On verifie que lutilisateur existe
		$dn = mysql_query('select nom_groupe, style, email, departement, gerant_groupe, telephone from groupe where nom_groupe="'.$nom_groupe.'"');
		if(mysql_num_rows($dn)>0)
		{

			$dnn = mysql_fetch_array($dn);
			//On affiche les donnees de lutilisateur
?>
    <section id=page_groupe>
		<article id="presentation_groupe">
			<h1><?php echo $nom_groupe; ?></h1>
			<?php
				include('slider_groupe.php');
				$dn = mysql_query('select nom_groupe, style, email, departement, gerant_groupe, telephone from groupe where nom_groupe="'.$nom_groupe.'"');
				$dnn = mysql_fetch_array($dn);
			?>
			<div id="description_groupe">
				<h2>Informations</h2>
				<table style="width:500px;">
					<tr>
						<h4>
							Email: <?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?><br />
							Département: <?php echo htmlentities($dnn['departement'], ENT_QUOTES, 'UTF-8'); ?><br />
							Style: <?php echo htmlentities($dnn['style'], ENT_QUOTES, 'UTF-8'); ?><br />
							Telephone: <?php echo htmlentities($dnn['telephone'], ENT_QUOTES, 'UTF-8'); ?><br />
						</h4>
					</tr>
				</table>
			</div>
		</article>
					
		<article id="musique_groupe">
			<h2>Titres du groupe</h2>
		</article>
			<?php
				include ('playeur.php');
				$dn = mysql_query('select nom_groupe, style, email, departement, gerant_groupe, telephone from groupe where nom_groupe="'.$nom_groupe.'"');
				$dnn = mysql_fetch_array($dn);
				$gerant = $dnn['gerant_groupe'];
			?>
		
		
		<article id="membre_du_groupe">	
			<h2>Membres</h2>
			<?php
				$dn1 = mysql_query('select id_membre, pseudo from membre_groupe where groupe="'.$_GET['nom_groupe'].'"');
				while ($dnn1 = mysql_fetch_array($dn1)){
			?>
				<li><img src="upload/compte/<?php echo $dnn1['id_membre'];?>.jpg"  alt="Photo de membre" id="image_membre" /><?php echo $dnn1['pseudo']; ?></li>
			<?php	
				}
			?>		

			<?php
				if(isset($_SESSION['pseudo']))
				{
					if(($_SESSION['pseudo']) == $gerant){
			?>
			
				<center><a class="btn btn-warning" data-toggle="modal" data-target="#infos">Ajouter un membre</a></center>
				<script src="animation_formulaire.js"></script>
				<script src="jquery.js"></script>
				<script src="bootstrap/js/bootstrap.min.js"></script>
				<br>				
			<?php
					}
				}
			?>	
		</article>
					
		<article id="next_event">
			<h2>Prochains évènements:<h2>
			<?php
			 $today = date("Y-m-d");
			//On recupere les identifiants
			$req = mysql_query('select id, salle, date, description ,nom_event, nom_groupe,chemin_image,heure from evenement where  nom_groupe="'. $_GET['nom_groupe'].'" and date > "'.$today.'" GROUP BY  date ASC');
		while($dnn = mysql_fetch_array($req))
		{
			?>	
			<h4><?php echo htmlentities($dnn['date'], ENT_QUOTES, 'UTF-8');?> à <?php echo htmlentities($dnn['heure'], ENT_QUOTES, 'UTF-8');?></h4>
			<img src=<?php echo htmlentities($dnn['chemin_image'], ENT_QUOTES, 'UTF-8');?> alt="Festival" class="image_week" />
			<h4><?php echo htmlentities($dnn['description'], ENT_QUOTES, 'UTF-8');?><br>
			Salle :<?php echo htmlentities($dnn['salle'], ENT_QUOTES, 'UTF-8');?><br><h4>
			<form action="evenement.php?id=<?php echo $dnn['id']; ?>" method="post">
				<center><p><input class="btn btn-warning" type="submit" value="Accéder à l'évènement" /></p></center>
			</form>		
			<?php
		}
		if(isset($_SESSION['pseudo']))
		{
			if(($_SESSION['pseudo']) == $gerant){
		?>
				<form action="modif_groupe.php?nom_groupe=<?php echo $_GET['nom_groupe']; ?>" method="post">
				<center><p><input class="btn btn-warning" type="submit" value="Modifier le contenu" /></p></center>
				</form>
				
					<form action="suppression_groupe.php" method="post" >
					<input type="hidden" name="nom_groupe" id="nom_groupe" value="<?php echo $_GET['nom_groupe'];?>"/>
				<center><p><input class="btn btn-danger" type="submit" onclick="if(!confirm('Voulez-vous Supprimer le groupe')) return false;" value="Supprimer le groupe" /></p></center>
			</form>
					
		<?php
			}
		}
		?>
		<br>
		</article>
		
		
	</section>
			
	<div class="modal hide fade" id="infos">
		<div class="modal-header"> <a class="close" data-dismiss="modal">×</a></div>
			<div class="modal-body">
				<form id="myForm" action="ajout_membre.php" method="post">
					<label class="form_col" for="pseudo">Pseudo :</label>
					<input name="pseudo" type="text" />
						  
					<input name="groupe" type="hidden" value="<?php echo $_GET['nom_groupe']; ?>" />
					<br /><br />
						  
					<span class="form_col"></span>
					<input class="btn btn-warning" type="submit" value="Ajouter" /> <input  class="btn btn-warning" type="reset" value="Réinitialiser" />
				</form>
					
			</div>
		<div class="modal-footer"> <a class="btn btn-inverse" data-dismiss="modal">Fermer</a></div>
	</div>

<?php
	}
	else
	{
		echo 'Ce nom n\'existe pas.';
	}
}
else
{
	echo 'L\'identifiant de l\'utilisateur n\'est pas d&eacute;fini.';
}
?>