
<?php
if(!isset($_SESSION['pseudo'])){
?>
<meta charset="utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="style.css" />

	<nav id="menu_right">
		<form action="connexion.php" method="post">
			<p>Pseudo<br><input type="text" name="pseudo" /></p>
			<p>Mot de passe<br><input type="password" name="password" /></p>
			<p><input class="btn btn-warning" type="submit" value="Valider" /></p>
		</form>
		<form method="link" action="mot_de_passe_oublie.php"> 
					<input class="btn btn-warning" type="submit" value="Mot de passe oublié">
		</form>
		<a class="btn btn-warning" data-toggle="modal" data-target="#infos">Inscription</a>
		<script src="animation_formulaire.js"></script>
		<script src="jquery.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    </nav>

			
	<div class="modal hide fade" id="infos">
		<div class="modal-header"> <a class="close" data-dismiss="modal">X</a></div>
		<div class="modal-body">
			<form id="myForm" action="inscription.php" method="post">
				<label class="form_col" for="nom">Nom :</label>
				<input name="nom" type="text" />
				<br /><br />
		  
				<label class="form_col" for="prenom">Prénom :</label>
				<input name="prenom" type="text" />
				<br /><br />
		  
				<label class="form_col" for="pseudo">Pseudo :</label>
				<input name="pseudo" type="text" />
				<br /><br />
		  
				<label class="form_col" for="pays">Pays :</label>
				<select name="pays" />
				<option value="France">Sélectionnez votre pays de résidence</option>
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
				<br />
				
				<label class="form_col" for="departement">Département :</label>
				<select name="departement" id="departement">
					<option value="Paris(75)">Sélectionnez votre département de résidence</option>
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
				<br />
		  
				<label class="form_col" for="ville">Ville :</label>
				<input name="ville" type="text" />
				<br /><br />
				  
				  
				<label class="form_col" for="adresse">Adresse :</label>
				<input name="adresse" type="text" />
				<br /><br />
				  
				<label class="form_col" for="date_de_naissance">Date de naissance :</label>
				<input name="date_de_naissance" type="date" />
				<br /><br />
				  
				<label class="form_col" for="mot_de_passe">Mot de passe :</label>
				<input name="password" type="password" />
				 
				<label class="form_col" for="passverif">Mot de passe (confirmation) :</label>
				<input name="passverif" type="password" />
				<br /><br />
					
				<label class="form_col" for="email">Email :</label>
				<input name="email" type="text" />
				<br /><br />
				
				<label class="form_col" for="CGU">Vous devez accepter les <a href="CGU.php">conditions d'utilisations</a></label>
				<input name="CGU" type="checkbox" value="ok" <label> J'ai lu les conditions générales du service</label>
				<br /><br />
				  
				<span class="form_col"></span>
				<input class="btn btn-warning" type="submit" value="M'inscrire" /> <input  class="btn btn-warning" type="reset" value="Réinitialiser le formulaire" />
			</form>
		</div>
	  
	  <div class="modal-footer"> <a class="btn btn-inverse" data-dismiss="modal">Fermer</a> </div>
	</div>
<?php
	}
?>