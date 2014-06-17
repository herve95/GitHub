<?php
include ('contour.php');
include ('connect.php');


	//On verifie que lidentifiant de lutilisateur est defini
	if(isset($_GET['id']))
	{
		$id_event = $_GET['id'];
		//On verifie que lutilisateur existe
		$dn = mysql_query('select salle, date, description ,nom_event, nom_groupe,chemin_image,heure from evenement where id="'.$id_event.'"');
		if(mysql_num_rows($dn)>0)
		{
			//peut etre vérifer si l'evenement existe 
			$dnn = mysql_fetch_array($dn);		
			$nom_event = $dnn['nom_event'];
			$nom_salle = $dnn['salle'];
			$nom_groupe = $dnn['nom_groupe'];
			//On affiche les donnees de lutilisateur
			?>
		
			<section id="page_event">
				<article id="presentation_event">	
				<h1>Evènement : <?php echo $nom_event?></h1>
				<img src=<?php echo htmlentities($dnn['chemin_image'], ENT_QUOTES, 'UTF-8'); ?>>
					<div id="description_event">	
						<h2>Informations de l'évènement </h2>
							<table style="width:500px">
								<tr>
									<h4>
										Description : <?php echo htmlentities($dnn['description'], ENT_QUOTES, 'UTF-8'); ?><br />
										Date: <?php echo htmlentities($dnn['date'], ENT_QUOTES, 'UTF-8'); ?><br />
										Horaire: <?php echo htmlentities($dnn['heure'], ENT_QUOTES, 'UTF-8'); ?><br />
									</h4>			
								</tr>
							</table>
					</div>
				</article>
				<article id="presentation_event">			
					<h1>Salle :<?php echo $nom_salle?></h1>
					<div id="description_event">
						<?php					
						$dn = mysql_query('select gerant_salle, email, departement, adresse, ville, telephone from salle where nom_salle="'.$nom_salle.'"');	
						if(mysql_num_rows($dn)>0){	
							$dnn = mysql_fetch_array($dn);
							?>	
							<h2>Informations de la salle </h2>
							<table style="width:500px">
								<tr>
									<h4>
										Gérant salle : <?php echo htmlentities($dnn['gerant_salle'], ENT_QUOTES, 'UTF-8'); ?><br />
										Email: <?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?><br />
										Adresse: <?php echo htmlentities($dnn['adresse'], ENT_QUOTES, 'UTF-8'); ?><br />
										Ville: <?php echo htmlentities($dnn['ville'], ENT_QUOTES, 'UTF-8'); ?><br />
										Département: <?php echo htmlentities($dnn['departement'], ENT_QUOTES, 'UTF-8'); ?><br />
										Téléphone: <?php echo htmlentities($dnn['telephone'], ENT_QUOTES, 'UTF-8'); ?><br />
									</h4>

									<form action="salle.php?nom_salle=<?php echo $nom_salle;?>&annee=<?php echo date('Y');?>" method="post">
										<center><p><input class="btn btn-warning" type="submit" value="voir la salle" /></p></center>
									</form>					
								</tr>
							</table>	
							
							<?php
							$adresse_complete = $dnn['adresse'] ." , ".$dnn['ville'] ;
						}		
						else {
						 echo "salle inconnu"; 
						}					
						?>
					</div>
				</article>
				<article id="presentation_groupe">
					
					<h1>Groupe : <?php echo $nom_groupe?></h1>
					<div id="description_event">
						<?php
						$dn = mysql_query('select style,email from groupe where nom_groupe="'.$nom_groupe.'"');	
						if(mysql_num_rows($dn)>0){	
							$req = mysql_fetch_array($dn);					
							?>	
							<h2>Informations du groupe </h2>
							<table style="width:500px">
								<tr>							
									<h4>
										Email: <?php echo htmlentities($req['email'], ENT_QUOTES, 'UTF-8'); ?><br />
										Style: <?php echo htmlentities($req['style'], ENT_QUOTES, 'UTF-8'); ?><br />
									</h4>
									
									<form action="groupe.php?nom_groupe=<?php echo $nom_groupe; ?>" method="post">
										<center><p><input class="btn btn-warning" type="submit" value="voir le groupe" /></p></center>
									</form>	
								</tr>
							</table>
							
						<?php
						}
						else {
							echo "groupe inconnu";
						}
						?>
					</div>
				</article>

				
				<article id="plan">
					<h1>Plan</h1>
					
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
            <input type="hidden" name="address" id="address" value="<?php echo $adresse_complete;?>"/></br>
            <center><input type="submit" class="btn btn-warning" value="Géolocalisez" onclick="searchAddress(map)"/></center>
        </form>
        <div id="map" style="width: 100%; height: 480px; display: none; max-width: 100%"></div></br>
<?php

		$dn3 = mysql_query('select gerant_evenement from evenement where id = "'.$id_event.'"');
				$dnn3 = mysql_fetch_array($dn3);
				$gerant = $dnn3['gerant_evenement'];
				
		if(isset($_SESSION['pseudo']))
			{
			if(($_SESSION['pseudo']) == $gerant){
?>
		<form action="suppression_evenement.php" method="post" >
					<input type="hidden" name="nom_event" id="nom_event" value="<?php echo $_GET['id'];?>"/>
				<center><p><input class="btn btn-warning" type="submit" onclick="if(!confirm('Voulez-vous Supprimer l'&eacutevenement')) return false;" value="Supprimer l\'evenement" /></p></center>

				</article>	
									
			</section>

		<?php
				}
			}
		}
		else{
			echo 'evenement inconnu.';
		}
	}
	else{
		echo 'Ce nom n\'existe pas.';
	}


?>
