<?php
include ('contour.php');
include ('connect.php');
include ('formulaire.php');

?>     
	<script type="text/javascript" src="jquery.js"></script>
	<section>
                <article id="eventDay">
					<h1>TODAY</h1>
					<?php
					$recherche_id = mysql_query('select id from groupe');
					$nb_id=mysql_num_rows($recherche_id);
					$nb_id = $nb_id-1;
					$alea = mt_rand( 0, $nb_id);
					$recherche = mysql_query("select nom_groupe,style,gerant_groupe,email  from groupe LIMIT $alea,1");
					$tod = mysql_fetch_array($recherche);
					
					?>
					<h2>
						Vous aimez la musique <font color="red" ><?php echo htmlentities($tod['style'], ENT_QUOTES, 'UTF-8');?></font> découvrez le groupe <font color="red" ><?php echo htmlentities($tod['nom_groupe'], ENT_QUOTES, 'UTF-8');?></font><br>
					</h2>
					<?php	
					$image_today = mysql_query('select chemin from image where type_compte= "'.$tod['nom_groupe'].'" LIMIT 1');
					if ($img_tod = mysql_fetch_array($image_today)){
						?>
						<img src=<?php echo htmlentities($img_tod['chemin'], ENT_QUOTES, 'UTF-8');?>  alt="Concert du jour" id="image_day" />
						<?php
					}
					else{
						?>
						<img src="images/gratte.jpg" alt="Concert du jour" id="image_day" />
						<?php
					}
					?>
					<h4><br/>Visitez la page personnelle du groupe</br>
					<center><form method="post" action="groupe.php?nom_groupe=<?php echo $tod['nom_groupe']; ?>"> 
							</br><input class="btn btn-warning" type="submit" value="Voir le groupe">
						</form></center>
					</h4>
				</article>
				<div id="titreWeek">
					<h1>À VENIR</h1>
				</div>
				<article id="eventWeek">
					<h1>À VENIR</h1>
					<?php
					$today = date("Y-m-d"); 
					//On recupere les identifiants
					$req = mysql_query('select id, salle, date, description ,nom_event, nom_groupe,chemin_image,heure from evenement where date > "'.$today.'" GROUP BY  date  ASC LIMIT 3');
					while($dnn = mysql_fetch_array($req))
						{
						?>	
						<h3><?php echo htmlentities($dnn['date'], ENT_QUOTES, 'UTF-8');?> à <?php echo htmlentities($dnn['heure'], ENT_QUOTES, 'UTF-8');?></h2>
						<img src=<?php echo htmlentities($dnn['chemin_image'], ENT_QUOTES, 'UTF-8');?> alt="Festival" class="image_week" />
						<h3>Salle :<?php echo htmlentities($dnn['salle'], ENT_QUOTES, 'UTF-8');?><br>
						Groupe :<?php echo htmlentities($dnn['nom_groupe'], ENT_QUOTES, 'UTF-8');?></h3>
						<center><form method="post" action="evenement.php?id=<?php echo $dnn['id']; ?>"> 
							<input class="btn btn-warning" type="submit" value="Voir l'evenement">
						</form></center>
					    <?php
						}
					?>
					
				</article>
				<div id="titreNews">
					<h1>NEWS</h1>
				</div>
				<article id="news">
					<h1>NEWS</h1>
					<?php
					$today = date("Y-m-d"); 
					//On recupere les identifiants
					$req1 = mysql_query('select nom_groupe from groupe where creation_date = (SELECT max(creation_date) FROM groupe)');
					$dnn1 = mysql_fetch_array($req1);
					$req2 = mysql_query('select nom_salle from salle where creation_date = (SELECT max(creation_date) FROM salle)');
					$dnn2 = mysql_fetch_array($req2);
					$req3 = mysql_query('select nom_event,id from evenement where date = (SELECT max(date) FROM evenement)');
					$dnn3 = mysql_fetch_array($req3);
					?>
						<h2>Groupe</h2><br>
						<h3>Un nouveau groupe en plein essort : <?php echo $dnn1['nom_groupe'];?></h3>
						<center><form method="post" action="groupe.php?nom_groupe=<?php echo $dnn1['nom_groupe']; ?>"> 
							<input class="btn btn-warning" type="submit" value="Voir le groupe">
						</form></center>
						<h2>Salle</h2><br>
						<h3>Ouverture de la salle : <?php echo $dnn2['nom_salle'];?></h3>
						<center><form method="post" action="salle.php?nom_salle=<?php echo $dnn2['nom_salle']; ?>&annee=2014"> 
							<input class="btn btn-warning" type="submit" value="Voir la salle">
						</form></center>
						<h2>Evenement</h2><br>
						<h3>Evenement le plus récent : <?php echo $dnn3['nom_event'];?></h3>
						<center><form method="post" action="evenement.php?id=<?php echo $dnn3['id']; ?>"> 
							<input class="btn btn-warning" type="submit" value="Voir l'evenement">
						</form></center>
						<center><img src="images/fond_actu.png" alt="Anim" class="image_news" /></center>
				</article>

				<script type="text/javascript">
					
					$('#news').hover(function() {
						$("#eventWeek").fadeTo(50, 0);
						Translate(titreWeek, '0%');
						$("#titreWeek").fadeTo(0, 50);
					}, function() {
						$("#eventWeek").fadeTo("slow", 1);
						Translate(titreWeek, '40%');
						$("#titreWeek").fadeTo(50, 0);
					});
					
					$('#eventWeek').hover(function() {
						$("#news").fadeTo(50, 0);
						Translate(titreNews, '100%');
						$("#titreNews").fadeTo(0, 50);
					}, function() {
						$("#news").fadeTo("slow", 1);
						Translate(titreNews, '60%');
						$("#titreNews").fadeTo(50, 0);
					});
					
					function Rotate(div, angle) {
						$(div).css({
							'-moz-transform':'rotate('+angle+'deg)',
							'-webkit-transform':'rotate('+angle+'deg)',
						 });  
					}
					function Translate(div, pos) {
						$(div).css({
							'left':''+pos+'',
						 });  
					}
				</script>					
	</section>