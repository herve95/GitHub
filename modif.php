<?php 
include ('contour.php');
include ('connect.php');
include ('upload.php');
include ('redimensionner.php');


//On verifie si l'utilisateur est connecte
if(isset($_SESSION['pseudo']))
{
	//On verifie si le formulaire a été envoyé
	if(isset($_POST['pseudo'],$_POST['nom'],$_POST['prenom'],$_POST['ville'],$_POST['pays'], $_POST['departement'],$_POST['adresse'],$_POST['date_de_naissance'], $_POST['email']))
{
		//On enleve l'echappement si get_magic_quotes_gpc est active
		if(get_magic_quotes_gpc())
		{
		$_POST['pseudo'] = stripslashes($_POST['pseudo']);
		$_POST['nom'] = stripslashes($_POST['nom']);
		$_POST['prenom'] = stripslashes($_POST['prenom']);
		$_POST['pays'] = stripslashes($_POST['pays']);
		$_POST['ville'] = stripslashes($_POST['ville']);
		$_POST['departement'] = stripslashes($_POST['departement']);
		$_POST['adresse'] = stripslashes($_POST['adresse']);
		$_POST['date_de_naissance'] = stripslashes($_POST['date_de_naissance']);
		$_POST['email'] = stripslashes($_POST['email']);
		$_POST['photo'] = $_POST['photo'];
		}
		
				//On verifie si lemail est valide
				if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
				{
					//On échape les variables pour pouvoir les mettre dans une requête SQL
				$pseudo = mysql_real_escape_string($_POST['pseudo']);
				$nom = mysql_real_escape_string($_POST['nom']);
				$prenom = mysql_real_escape_string($_POST['prenom']);
				$pays = mysql_real_escape_string($_POST['pays']);
				$departement = mysql_real_escape_string($_POST['departement']);
				$ville = mysql_real_escape_string($_POST['ville']);
				$adresse = mysql_real_escape_string($_POST['adresse']);
				$date_de_naissance = mysql_real_escape_string($_POST['date_de_naissance']);
				$email = mysql_real_escape_string($_POST['email']);
					
					//On verifie s'il n'y a pas deja un utilisateur inscrit avec le pseudo choisis
					
					$dn = mysql_fetch_array(mysql_query('select count(*) as nb from compte where pseudo="'.$pseudo.'"'));
					$dn1 = mysql_fetch_array(mysql_query('select id from compte where pseudo="'.$pseudo.'"'));
					
					$id=mysql_real_escape_string($_SESSION['id']);
					//envoie de la photo dans la base de donnée
					$nom_image="$id.jpg";
					$chemin="upload/compte/$nom_image";
					$upload1 = upload('photo',$chemin,15360000, array('png','gif','jpg','jpeg') );
				    if ($upload1) echo"Upload de l'icone réussi!<br />";
		
					//On verifie si le pseudo a ete modifie pour un autre et que celui-ci n'est pas deja utilise
					if($dn['nb']==0 or $dn1['id'] == $_SESSION['id'])
					{
						//On modifie les informations de l'utilisateur avec les nouvelles
						if(mysql_query('UPDATE compte SET pseudo="'.$pseudo.'", prenom="'.$prenom.'", pays="'.$pays.'", ville="'.$ville.'", departement="'.$departement.'", adresse="'.$adresse.'", date_de_naissance="'.$date_de_naissance.'", email="'.$email.'" WHERE id="'.mysql_real_escape_string($_SESSION['id']).'"'))
						{
							mysql_query('UPDATE image SET chemin="'.$chemin.'", nom_image="'.$nom_image.'", type_compte="compte" WHERE id="'.mysql_real_escape_string($_SESSION['id']).'"');
						
								//Si ca a fonctionné, on n'affiche pas le formulaire
								$form = false;
							
?>
<section>
<br>
<div class="message">Vos informations ont bien &eacute;t&eacute; modifif&eacute;e.<br />
<meta http-equiv="refresh" content="1;url=accueil.php" /></div>
</section>
<?php
						}
						else
						{
							//Sinon on dit quil y a eu une erreur
							$form = true;
							$message = 'Une erreur est survenue lors des modifications.';
						}
					}
					else
					{
						//Sinon, on dit que le pseudo voulu est deja pris
						$form = true;
						$message = 'Un autre utilisateur utilise d&eacute;j&agrave; le nom d\'utilisateur que vous d&eacute;sirez utiliser.';
					}
				}
				else
				{
					//Sinon, on dit que lemail nest pas valide
					$form = true;
					$message = 'L\'email que vous avez entr&eacute; n\'est pas valide.';
				}
			
	}
	else
	{
		$form = true;
	}
	if($form)
	{
		//On affiche un message sil y a lieu
		if(isset($message))
		{
			?><section><article id="eventDay"><?echo $message ?></article></section><?php
		}
		//Si le formulaire a deja ete envoye on recupere les donnes que lutilisateur avait deja insere
		if(isset($_POST['pseudo'],$_POST['nom'],$_POST['prenom'],$_POST['ville'],$_POST['pays'], $_POST['departement'],$_POST['adresse'],$_POST['date_de_naissance'], $_POST['email']))
{
			$pseudo = htmlentities($_POST['pseudo']);
			$prenom = htmlentities($_POST['prenom'],  ENT_NOQUOTES, 'UTF-8');
			$nom = htmlentities($_POST['nom'],  ENT_NOQUOTES, 'UTF-8');
			$pays = htmlentities($_POST['pays'],  ENT_NOQUOTES, 'UTF-8');
			$ville = htmlentities($_POST['ville'],  ENT_NOQUOTES, 'UTF-8');
			$departement = htmlentities($_POST['departement'],  ENT_NOQUOTES, 'UTF-8');
			$adresse = htmlentities($_POST['adresse'],  ENT_NOQUOTES, 'UTF-8');
			$date_de_naissance = htmlentities($_POST['date_de_naissance'],  ENT_NOQUOTES, 'UTF-8');
			$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
		}
		else
		{
			
			//Sinon, on affiche les donnes a partir de la base de donnee
			$dnn = mysql_fetch_array(mysql_query('select pseudo, nom, prenom, pays, ville, departement, adresse, date_de_naissance, email from compte WHERE id="'.mysql_real_escape_string($_SESSION['id']).'"'));
			$pseudo = htmlentities($dnn['pseudo'], ENT_QUOTES, 'UTF-8');
			$prenom = htmlentities($dnn['prenom'],  ENT_NOQUOTES, 'UTF-8');
			$nom = htmlentities($dnn['nom'],  ENT_NOQUOTES, 'UTF-8');
			$pays = htmlentities($dnn['pays'],  ENT_NOQUOTES, 'UTF-8');
			$adresse = htmlentities($dnn['adresse'],  ENT_NOQUOTES, 'UTF-8');
			$ville = htmlentities($dnn['ville'],  ENT_NOQUOTES, 'UTF-8');
			$departement = htmlentities($dnn['departement'],  ENT_NOQUOTES, 'UTF-8');
			$date_de_naissance = htmlentities($dnn['date_de_naissance'],  ENT_NOQUOTES, 'UTF-8');
			$email = htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8');
		}
		//On affiche le formulaire
?>
<section>
<div class="content">
    <form action="modif.php" method="post" enctype="multipart/form-data">
        <br>Vous pouvez modifier vos informations:<br /><br>
		<div class="center">
		<center> 
		<table>
            <tr><td><label for="pseudo">Pseudo : </label></td><td><input type="text" name="pseudo" id="pseudo" value="<?php echo $pseudo; ?>" /></td></tr>
			<tr><td><label for="nom">Nom : </label></td><td><input type="text" name="nom" id="nom" value="<?php echo $nom; ?>" /></td></tr>
			<tr><td><label for="prenom">Pr&eacutenom : </label></td><td><input type="text" name="prenom" id="prenom" value="<?php echo $prenom; ?>" /></td></tr>
			<tr><td><label for="pays">Pays :</label></td><td>
				<select name="pays" />
				<option value="<?php echo $pays; ?>">Sélectionnez votre pays de résidence</option>
				<option value="Albanie">Albanie</option>
				<option value="Allemagne">Allemagne</option>
				<option value="Andorre">Andorre</option>
				<option value="Autriche">Autriche</option>
				<option value="Belgique">Belgique</option>
				<option value="Bielorussie">Biélorussie</option>
				<option value="Bosnie-Herzegovine">Bosnie-Herzégovine</option>
				<option value="Bulgarie">Bulgarie</option>
				<option value="Chypre">Chypre</option>
				<option value="Croatie">Croatie</option>
				<option value="Danemark">Danemark</option>
				<option value="Espagne">Espagne</option>
				<option value="Estonie">Estonie</option>
				<option value="Finlande">Finlande</option>
				<option value="France">France</option>
				<option value="Grece">Grèce</option>
				<option value="Hongrie">Hongrie</option>
				<option value="Irlande">Irlande</option>
				<option value="Islande">Islande</option>
				<option value="Italie">Italie</option>
				<option value="Lettonie">Lettonie</option>
				<option value="Liechtenstein">Liechtenstein</option>
				<option value="Lituanie">Lituanie</option>
				<option value="Luxembourg">Luxembourg</option>
				<option value="Macedoine">Macédoine</option>
				<option value="Malte">Malte</option>
				<option value="Moldavie">Moldavie</option>
				<option value="Monaco">Monaco</option>
				<option value="Montenegro">Monténégro</option>
				<option value="Norvege">Norvège</option>
				<option value="Pays-bas">Pays-Bas</option>
				<option value="Pologne">Pologne</option>
				<option value="Portugal">Portugal</option>
				<option value="Republique Tcheque">République Tchèque</option>
				<option value="Roumanie">Roumanie</option>
				<option value="Royaume-uni">Royaume-Uni</option>
				<option value="Russie">Russie</option>
				<option value="Serbie">Serbie</option>
				<option value="Slovaquie">Slovaquie</option>
				<option value="Slovenie">Slovénie</option>
				<option value="Suede">Suède</option>
				<option value="Suisse">Suisse</option>
				<option value="Ukraine">Ukraine</option>
				</select>
				</td></tr>
				
				<tr><td><label for="departement">Département :</label></td><td>
				<select name="departement" id="departement">
					<option value="<?php echo $departement; ?>">Sélectionnez votre département de résidence</option>
					<option value="Ain(1)">Ain(1)</option>
					<option value="Aisne(2)">Aisne(2)</option>
					<option value="Allier(3)">Allier(3)</option>
					<option value="Alpes de Hautes-Provence(4)">Alpes de Hautes-Provence(4)</option>
					<option value="Hautes-Alpes(5)">Hautes-Alpes(5)</option>
					<option value="Alpes-Maritimes(6)">Alpes-Maritimes(6)</option>
					<option value="Ardèche(7)">Ardèche(7)</option>
					<option value="Ardennes(8)">Ardennes(8)</option>
					<option value="Ariège(9)">Ariège(9)</option>
					<option value="Aube(10)">Aube(10)</option>
					<option value="Aude(11)">Aude(11)</option>
					<option value="Aveyron(12)">Aveyron(12)</option>
					<option value="Bouches-du-Rhône(13)">Bouches-du-Rhône(13)</option>
					<option value="Calvados(14)">Calvados(14)</option>
					<option value="Cantal(15)">Cantal(15)</option>
					<option value="Charente(16)">Charente(16)</option>
					<option value="Charente-Maritime(17)">Charente-Maritime(17)</option>
					<option value="Cher(18)">Cher(18)</option>
					<option value="Corrèze(19)">Corrèze(19)</option>
					<option value="Corse-du-Sud(2A)">Corse-du-Sud(2A)</option>
					<option value="Haute-Corse(2B)">Haute-Corse(2B)</option>
					<option value="Côte-d'Or(21)">Côte-d'Or(21)</option>
					<option value="Côtes d'Armor(22)">Côtes d'Armor(22)</option>
					<option value="Creuse(23)">Creuse(23)</option>
					<option value="Dordogne(24)">Dordogne(24)</option>
					<option value="Doubs(25)">Doubs(25)</option>
					<option value="Drôme(26)">Drôme(26)</option>
					<option value="Eure(27)">Eure(27)</option>
					<option value="Eure-et-Loir(28)">Eure-et-Loir(28)</option>
					<option value="Finistère(29)">Finistère(29)</option>
					<option value="Gard(30)">Gard(30)</option>
					<option value="Haute-Garonne(31)">Haute-Garonne(31)</option>
					<option value="Gers(32)">Gers(32)</option>
					<option value="Gironde(33)">Gironde(33)</option>
					<option value="Hérault(34)">Hérault(34)</option>
					<option value="Ille-et-Vilaine(35)">Ille-et-Vilaine(35)</option>
					<option value="Indre(36)">Indre(36)</option>
					<option value="Indre-et-Loire(37)">Indre-et-Loire(37)</option>
					<option value="Isère(38)">Isère(38)</option>
					<option value="Jura(39)">Jura(39)</option>
					<option value="Landes(40)">Landes(40)</option>
					<option value="Loir-et-Cher(41)">Loir-et-Cher(41)</option>
					<option value="Loire(42)">Loire(42)</option>
					<option value="Haute-Loire(43)">Haute-Loire(43)</option>
					<option value="Loire-Atlantique(44)">Loire-Atlantique(44)</option>
					<option value="Loiret(45)</">Loiret(45)</option>
					<option value="Lot(46)">Lot(46)</option>
					<option value="Lot-et-Garonne(47)">Lot-et-Garonne(47)</option>
					<option value="Lozère(48)">Lozère(48)</option>
					<option value="Maine-et-Loire(49)">Maine-et-Loire(49)</option>
					<option value="Manche(50)">Manche(50)</option>
					<option value="Marne(51)">Marne(51)</option>
					<option value="Haute-Marne(52)">Haute-Marne(52)</option>
					<option value="Mayenne(53)">Mayenne(53)</option>
					<option value="Meurthe-et-Moselle(54)">Meurthe-et-Moselle(54)</option>
					<option value="Meuse(55)">Meuse(55)</option>
					<option value="Morbihan(56)">Morbihan(56)</option>
					<option value="Moselle(57)">Moselle(57)</option>
					<option value="Nièvre(58)">Nièvre(58)</option>
					<option value="Nord(59)">Nord(59)</option>
					<option value="Oise(60)">Oise(60)</option>
					<option value="Orne(61)">Orne(61)</option>
					<option value="Pas-de-Calais(62)">Pas-de-Calais(62)</option>
					<option value="Puy-de-Dôme(63)">Puy-de-Dôme(63)</option>
					<option value="Pyrénées-Atlantiques(64)">Pyrénées-Atlantiques(64)</option>
					<option value="Hautes-Pyrénées(65)">Hautes-Pyrénées(65)</option>
					<option value="Pyrénées-Orientales(66)">Pyrénées-Orientales(66)</option>
					<option value="Bas-Rhin(67)">Bas-Rhin(67)</option>
					<option value="Haut-Rhin(68)">Haut-Rhin(68)</option>
					<option value="Rhône(69)">Rhône(69)</option>
					<option value="Haute-Saône(70)">Haute-Saône(70)</option>
					<option value="Saône-et-Loire(71)">Saône-et-Loire(71)</option>
					<option value="Sarthe(72)">Sarthe(72)</option>
					<option value="Savoie(73)">Savoie(73)</option>
					<option value="Haute-Savoie(74)">Haute-Savoie(74)</option>
					<option value="Paris(75)">Paris(75)</option>
					<option value="Seine-Maritime(76)">Seine-Maritime(76)</option>
					<option value="Seine-et-Marne(77)">Seine-et-Marne(77)</option>
					<option value="Yvelines(78)">Yvelines(78)</option>
					<option value="Deux-Sèvres(79)">Deux-Sèvres(79)</option>
					<option value="Somme(80)">Somme(80)</option>
					<option value="Tarn(81)">Tarn(81)</option>
					<option value="Tarn-et-Garonne(82)">Tarn-et-Garonne(82)</option>
					<option value="Var(83)">Var(83)</option>
					<option value="Vaucluse(84)">Vaucluse(84)</option>
					<option value="Vendée(85)">Vendée(85)</option>
					<option value="Vienne(86)">Vienne(86)</option>
					<option value="Haute-Vienne(87)">Haute-Vienne(87)</option>
					<option value="Vosges(88)">Vosges(88)</option>
					<option value="Yonne(89)">Yonne(89)</option>
					<option value="Territoire-de-Belfort(90)">Territoire-de-Belfort(90)</option>
					<option value="Essonne(91)">Essonne(91)</option>
					<option value="Hauts-de-Seine(92)">Hauts-de-Seine(92)</option>
					<option value="Seine-Saint-Denis(93)">Seine-Saint-Denis(93)</option>
					<option value="Val-de-Marne(94)">Val-de-Marne(94)</option>
					<option value="Val-d'Oise(95)">Val-d'Oise(95)</option>
				</select>
				</td></tr>
			
			<tr><td><label for="ville">Ville : </label></td><td><input type="text" name="ville" id="ville" value="<?php echo $ville; ?>" /></td></tr>
			<tr><td><label for="adresse">Adresse : </label></td><td><input type="text" name="adresse" id="adresse" value="<?php echo $adresse; ?>" /></td></tr>
			<tr><td><label for="date_de_naissance">Date de naissance : </label></td><td><input type="date" name="date_de_naissance" id="date_de_naissance" value="<?php echo $date_de_naissance; ?>" /></td></tr>
            <tr><td><label for="email">Email : </label></td><td><input type="text" name="email" id="email" value="<?php echo $email; ?>" /></td></tr>
			<tr><td><label for="photo">Ajouter une photo (JPG, PNG): <label></td><td> <input type="file" name="photo" id="photo"  /></td></tr>
			</table>
		</center>
			<center><input class="btn btn-warning" type="submit" value="Envoyer" /></center>
        </div>
    </form>
<center><form method="link" action="modif_pass.php">
<input class="btn btn-warning" type="submit" value="Modifier mon password">
</form></center>
		<script language="javascript">
			function confirme( nom )
							  {
								var confirmation = confirm( "Voulez-vous vraiment supprimer ce profil ? \n Si vous continuez, vous perdrez toutes vos données y compris les salles et les groupes associés à votre compte." ) ;
							if( confirmation )
							{
							  document.location.href = "suppression_profile.php" ;
							}
							  }
							  
		</script>
								<?php				
						
						echo("<a href=\"#\" class=\"btn btn-danger\" onClick=\"confirme()\" >Supprimer mon compte</a><br>\n") ;
						?>
</div>
</section>

<?php							
						}


	}

else
{
?>
<section>
<div class="message">Pour acc&eacute;der &agrave; cette page, vous devez &ecirc;tre connect&eacute;.<br />
<meta http-equiv="refresh" content="1;url=connexion.php" /></div>
</section>
<?php
}
?>