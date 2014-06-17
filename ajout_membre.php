<?php
include ('contour.php');
		
//On verifie que le formulaire a ete envoye
if(isset($_POST['pseudo'], $_POST['groupe']))
{
	//On enleve lechappement si get_magic_quotes_gpc est active
	if(get_magic_quotes_gpc())
	{
		$_POST['pseudo'] = stripslashes($_POST['pseudo']);
		$_POST['groupe'] = stripslashes($_POST['groupe']);
		
		
	}
	
				//On echape les variables pour pouvoir les mettre dans une requette SQL
				$pseudo = mysql_real_escape_string($_POST['pseudo']);
				$groupe = mysql_real_escape_string($_POST['groupe']);
				
				//On verifie sil ny a pas deja un utilisateur inscrit avec le pseudo choisis
				$dnn = mysql_query('select id from compte where pseudo="'.$pseudo.'"');
				$dnn1 = mysql_fetch_array($dnn);
				$id = $dnn1['id'];
				$dn = mysql_num_rows(mysql_query('select id from compte where pseudo="'.$pseudo.'"'));
				if($dn==1)
				{
					
					
					//On enregistre les informations dans la base de donnee
					if(mysql_query('insert into membre_groupe(id_membre, pseudo, groupe) values ("'.$id.'","'.$pseudo.'", "'.$groupe.'")'))
					{
						
								//Si ca a fonctionné, on n'affiche pas le formulaire
								$form = false;
							
?>
<section><article id="eventDay">"Ce membre a bien &eacutet&eacute ajout&eacute.</article></section>
<meta http-equiv="refresh" content="1;url=groupe.php?nom_groupe=<?php echo $groupe; ?>" />
<?php
					}
					else
					{
						//Sinon on dit quil y a eu une erreur
						$form = true;
						$message = 'Une erreur est survenue lors de l\'inscription.';
					}
			
		}
		else
		{
			$form = true;
			$message = 'Ce pseudo n\'existe pas.';
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
	?>
		<section><article id="eventDay"><?echo $message ?></article></section>
	<?php
	}
	//On affiche le formulaire

}
