
<head>
	<!-- Start WOWSlider.com HEAD section -->
	<link rel="stylesheet" type="text/css" href="engine1/style.css" />
	<script type="text/javascript" src="engine1/jquery.js"></script>
	<!-- End WOWSlider.com HEAD section -->
</head>
	<!-- Start WOWSlider.com BODY section -->
	

	<div id="wowslider-container1">
		<div class="ws_images">
			<ul>
				<?php
				//On recupere les identifiants, les pseudos et les emails des utilisateurs
				$nom_salle = $_GET['nom_salle'];
				
				$req = mysql_query('select chemin,nom_image from image where type_compte="'.$nom_salle.'" ');
			    while($dnn = mysql_fetch_array($req))
				{
				?>
				<li><img src=<?php echo htmlentities($dnn['chemin'], ENT_QUOTES, 'UTF-8'); ?> alt=<?php echo htmlentities($dnn['nom_image'], ENT_QUOTES, 'UTF-8'); ?> title=<?php echo htmlentities($dnn['nom_image'], ENT_QUOTES, 'UTF-8'); ?> /></li>	
				<?php
				}
				
				?>
			</ul>
		</div>

		<div class="ws_bullets"><div>

			<?php
			$req = mysql_query('select chemin,nom_image from image where type_compte="'.$nom_salle.'" ');
			 while($dnn = mysql_fetch_array($req))
			{

			?>
			<a href="#"> title=<?php echo htmlentities($dnn['nom_image'], ENT_QUOTES, 'UTF-8'); ?>  <img src="upload/salle/bullet/<?php echo htmlentities($dnn['nom_image'], ENT_QUOTES, 'UTF-8'); ?>" alt=<?php echo htmlentities($dnn['nom_image'], ENT_QUOTES, 'UTF-8'); ?>/></a>
			<?php
			}
			?>
		</div>
	</div>

<span class="wsl"> Pas de photo du groupe </span>
	<div class="ws_shadow"></div>
	</div>
	<script type="text/javascript" src="engine1/wowslider.js"></script>
	<script type="text/javascript" src="engine1/script.js"></script>
	<!-- End WOWSlider.com BODY section -->
