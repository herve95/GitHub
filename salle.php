<?php
include ('contour.php');
include ('connect.php');
?>
<link rel="stylesheet" type="text/css" href="style_salle.css" />
	<script src="jquery.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script type="text/javascript">
            jQuery(function($){
               $('.month').hide();
               $('.month:first').show();
               $('.months a:first').addClass('active');
               var current = 1;
               $('.months a').click(function(){
                    var month = $(this).attr('id').replace('linkMonth','');
                    if(month != current){
                        $('#month'+current).slideUp();
                        $('#month'+month).slideDown();
                        $('.months a').removeClass('active'); 
                        $('.months a#linkMonth'+month).addClass('active'); 
                        current = month;
                    }
                    return false; 
               });
            });
        </script>
<?php
	//On verifie que lidentifiant de lutilisateur est defini
	$nom = $_GET['nom_salle'];
	if(isset($_GET['nom_salle']))
	{
		$nom_salle = $_GET['nom_salle'];
		//On verifie que lutilisateur existe
		$dn = mysql_query('select gerant_salle, email, departement, adresse, telephone from salle where nom_salle="'.$nom_salle.'"');
		if(mysql_num_rows($dn)>0)
		{
			$dnn = mysql_fetch_array($dn);
			//On affiche les donnees de lutilisateur
?>
			
    <section id="page_salle">
		<article id="presentation_salle">
			<h1><?php echo $nom_salle?></h1>
			<?php
				include('slider_salle.php');
				$dn = mysql_query('select gerant_salle, email, departement, adresse, ville, telephone from salle where nom_salle="'.$nom_salle.'"');	
				$dnn = mysql_fetch_array($dn);
				$gerant = $dnn['gerant_salle'];
				$adresse_complete = $dnn['adresse'] ." , ".$dnn['ville'] ;
			?>
			<div id="description_salle">
				<h2>Informations</h2>
				<table style="width:500px">
					<tr>
						<h4>
							Gérant salle : <?php echo htmlentities($dnn['gerant_salle'], ENT_QUOTES, 'UTF-8'); ?><br />
							Email: <?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?><br />
							Ville: <?php echo htmlentities($dnn['ville'], ENT_QUOTES, 'UTF-8'); ?><br />
							Département: <?php echo htmlentities($dnn['departement'], ENT_QUOTES, 'UTF-8'); ?><br />
							Adresse: <?php echo htmlentities($dnn['adresse'], ENT_QUOTES, 'UTF-8'); ?><br />
							Téléphone: <?php echo htmlentities($dnn['telephone'], ENT_QUOTES, 'UTF-8'); ?><br />
						</h4>
					</tr>
				</table>
			</div>
		</article>
		<article id="plan">
			<h1>Plan<h1>
			<div id="description_event">
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<script type="text/javascript" >
					
					function loadScript() {

						var script = document.createElement("script");
						script.src = "http://www.google.com/jsapi?key=AIzaSyALAxlAV8rBNw4EDH5saIQgfxR0JnFxYmI&callback=loadMaps";
						script.type = "text/javascript";
						document.getElementsByTagName("head")[0].appendChild(script);
					}

					function loadMaps() 
					{
						google.load("maps", "3", {
							"callback" : showMap,
							other_params: "sensor=false"
						});
					}

					function showMap()
					{
						document.getElementById("map").style.display = "block";

						var mapOptions = {
							zoom: 2,
							center : new google.maps.LatLng(0, 0),
							mapTypeId: google.maps.MapTypeId.HYBRID //On indique qu'il s'agit d'une "carte routière"
						};

						map = new google.maps.Map(document.getElementById("map"), mapOptions); 
					}

					function centerMap(map, coords, zoom)
					{
						map.panTo(coords);
						map.setZoom(zoom);
					}

					function searchAddress(map)
					{
						geocoder = new google.maps.Geocoder(); //Déclaration de la classe de géocodage de Google
						geoOptions = {
							'address': document.getElementById("address").value
						};
						geocoder.geocode( geoOptions, function(results, status) {
							/* Si l'adresse a pu être géolocalisée */
							if (status == google.maps.GeocoderStatus.OK) {
								var coords = results[0].geometry.location;
								addMarker(map, geoOptions.address, coords);
								centerMap(map, coords, 7);
							} else {
								alert("L'adresse n'a pu être géocodée avec succès.");
							}
						});
					}

					function searchMarkerCoords(marker, infowindow)
					{
						console.log(marker);
						geocoder = new google.maps.Geocoder(); //Déclaration de la classe de géocodage de Google
						geoOptions = {
							'latLng' : marker.position
						};
						geocoder.geocode( geoOptions, function(results, status) {
							/* Si les coordonnées ont pu être geolocalisées */
							if (status == google.maps.GeocoderStatus.OK) {
								var address = results[0].formatted_address;
								marker.setTitle("Marqueur déplacé");
								infowindow.setContent(address);
							} else {
								alert("Les nouvelles coordonnées n'ont pu être géocodées avec succès.");
							}
						});
					}

					function addMarker(map, body, location) {
						var marker = new google.maps.Marker({
							map : map, 
							position : location,
							animation: google.maps.Animation.DROP,
							draggable : true
						});
						marker.setTitle("Mon marqueur");
						var infowindow = new google.maps.InfoWindow( {
							content : body
						});
						new google.maps.event.addListener(marker, "click", function() {
							infowindow.open(map, marker);
						});
						new google.maps.event.addListener(marker, "rightclick", function() {
							removeMarker(marker);
						});
						new google.maps.event.addListener(marker, 'dragend', function(){
							searchMarkerCoords(marker, infowindow);
						});
					}

					function removeMarker(marker)
					{
						marker.setMap(null);
					}

					window.onload = loadScript();
						
				</script>
				<form onsubmit="return false">
					<input type="hidden" name="address" id="address" value="<?php echo $adresse_complete;?>"/>
					<input type="submit" class="btn btn-warning" value="Géolocalisez" onclick="searchAddress(map)"/>
				</form>
				<div id="map" style="width: 100%; height: 480px; display: none; max-width: 100%"></div>
			</div>
		</article>	
						
		<article id="planning">
			<h2>Planning</h2>
			<?php
				require('date.php');
				$date = new Date();
				$year = $_GET['annee'];
				$events = $date->getEvents($year);
				$dates = $date->getAll($year);
			?>
					
			<div class="periods">
				<div class="year">
					<a href="salle.php?nom_salle=<?php echo $nom_salle; ?>&annee=<?php echo $year-1;?>"><</a>	
					<?php echo $year; ?>
					<a href="salle.php?nom_salle=<?php echo $nom_salle; ?>&annee=<?php echo $year+1;?>">></a>
				</div>
				<div class="months">
					<ul>
						<?php foreach ($date->months as $id=>$m): ?>
							 <li><a href="#" id="linkMonth<?php echo $id+1; ?>"><?php echo utf8_encode(substr(utf8_decode($m),0,3)); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="clear">
				</div>
				<?php $dates = current($dates); ?>
				<?php foreach ($dates as $y=>$days): ?>
				<?php foreach ($dates as $m=>$days): ?>
				<div class="month relative" id="month<?php echo $m; ?>">
					<table>
						<thead>
							<tr>
								<?php foreach ($date->days as $d): ?>
									<th><?php echo substr($d,0,3); ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?php $end = end($days); foreach($days as $d=>$w): ?>
								<?php $time = strtotime("$year-$m-$d"); ?>
								<?php if($d == 1 && $w != 1): ?>
									<td colspan="<?php echo $w-1; ?>" class="padding"></td>
								<?php endif; ?>
									<td <?php if($time == strtotime(date('Y-m-d'))): ?> class="today" <?php endif; ?>>
										<div class="relative">
											<div class="day"><?php echo $d; ?>
											</div>
										</div>
										<ul class="events">
											<?php if(isset($events[$time])): foreach($events[$time] as $e): 
												$req = mysql_query('select id, nom_event from evenement where salle = "'.$nom.'" and date ="'.$e.'"');
												$req1 = mysql_fetch_array($req)?>
												<li><a href="evenement.php?id=<?php echo $req1['id']; ?>"><?php echo substr($req1['nom_event'],0,9);?></a></li></br>
											<?php endforeach; endif;  ?>
										</ul>
									</td>
									<?php if($w == 7): ?>
							</tr>
							<tr>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php if($end != 7): ?>
								<td colspan="<?php echo 7-$end; ?>" class="padding">
								</td>
								<?php endif; ?>
							</tr>
						</tbody>
					</table>
				</div>
				<?php endforeach; ?>
				<?php endforeach; ?>
			</div>
		</article>	
		
		<?php
			if(isset($_SESSION['pseudo']))
			{
				if(($_SESSION['pseudo']) == $gerant){
		?>	

			<center><a class="btn btn-warning" data-toggle="modal" data-target="#infos">Créer un evenement<a></center></br>	
		
			<form action="modif_salle.php?nom_salle=<?php echo $_GET['nom_salle']; ?>" method="post">
				<center><p><input class="btn btn-warning" type="submit" value="Modifier ma salle" /></p></center>
			</form>	</br>	</br>	
			
			<form action="suppression_salle.php" method="post" >
			<input type="hidden" name="nom_salle" id="nom_salle" value="<?php echo $_GET['nom_salle'];?>"/>
				<center><p><input class="btn btn-danger" type="submit" onclick="if(!confirm('Voulez-vous Supprimer la salle')) return false;" value="Supprimer la salle" /></p></center>
			</form>
			
			
		<?php
				}
			}
		?>				
	</section>
 						
  <div class="modal hide fade" id="infos">
  <div class="modal-header"> <a class="close" data-dismiss="modal">X</a></div>
  <div class="modal-body">
 <form id="myForm" action="inserer_evenement.php" method="post" enctype="multipart/form-data" />
 
      <label class="form_col" for="nom">Nom de l'événement :</label>
      <input name="nom" type="text" />
      <span class="tooltip">Un nom ne peut pas faire moins de 2 caractères</span>
      <br /><br />
	  
	  <label class="form_col" for="heure">Heure:</label>
      <input name="heure" type="time" />
      <br /><br />
	  
    <input name="salle" type="hidden" value="<?php echo $nom; ?>">
	  
      <label class="form_col" for="date">Date :</label>
      <input name="date" type="date" />
      <br /><br />
	  
	  <label class="form_col" for="nom_groupe">Nom du groupe:</label>
      <input name="nom_groupe" type="text" />
	   <span class="tooltip">Le nom du groupe doit être identique au nom du groupe sur le site</span>
      <br /><br />
	  
	  <label class="form_col" for="photo">Ajoutez la photo de l'événement: <label>
	  <input type="file" name="photo" id="photo"  />
	   <br /><br />
	  
	  <label class="form_col" for="description">Description:</label>
	  <TEXTAREA name="description" type="text" rows="6" ></TEXTAREA>
      <br /><br />
	 
       <span class="form_col"></span>
      <input class="btn btn-warning" type="submit" value="Valider" /> 
	  <input class="btn btn-inverse" type="reset" value="Réinitialiser le formulaire" />
	  
    </form>
  </div>
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
