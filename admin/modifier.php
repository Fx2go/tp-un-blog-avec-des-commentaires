<?php


// on tente de récupèrer les variables du formulaire de cette même page
$id_billet=stripslashes(htmlspecialchars($_POST['id_billet']));
$auteur=stripslashes(htmlspecialchars($_POST['auteur']));
$titre_billet=stripslashes(htmlspecialchars($_POST['titre_billet']));
$contenu_billet=stripslashes(htmlspecialchars($_POST['contenu_billet']));

		//Si le formulaire complet vient d'être envoyé

		if(!empty($_POST[auteur])&&!empty($_POST[titre_billet])&&!empty($_POST[contenu_billet])) {

			//connection BDD
	include ('../connection_BDD.php');
			//requete pour modifier le Billet
	 $req = $bdd->prepare('UPDATE billets SET titre=:titre,contenu=:contenu,nom_auteur=:nom_auteur WHERE id=:id_billet');

	$req->execute(array('id_billet'=>$id_billet,'titre'=>$titre_billet,'contenu'=>$contenu_billet,'nom_auteur'=>$auteur));

	//une fois la modification effectuée en BD, on redirige l'utilisateur vers la page du billet modifié
	 	

	header('Location:../../billet.php?billet='.$id_billet);

		}

		// mais si on vient d'arriver sur cette page (qu'on a pas encore soumis le formulaire)
		elseif (isset ($_GET['id']) )
			{
				$id_billet=strip_tags($_GET['id']);
	include ('../connection_BDD.php');			
			//on récupère les valeurs du titre,auteur et contenu du billet à modifier
	 $req2 = $bdd->prepare('SELECT titre,contenu,nom_auteur FROM billets WHERE id=:id_billet');
	$req2->bindParam(':id_billet', $id_billet);
	$req2->execute();


	$data = $req2->fetch();
	// Si le résultat de la requête est vide (ex: l'ID du billet a été modifié dans l'url envoyée)
	if(empty($data))
		// ...alors on affiche à nouveau la page d'accueil
		{
			?>

				<p>	Nous sommes d&eacute;sol&eacute;s pour vous mais le billet n&deg; <?php echo $id_billet; ?> 
					n&#039;existe pas sur ce blog <br/>
				</p>	
			<?php
					}
		// ... sinon on affiche le formulaire de modification
	else {
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Modifier un billet</title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <link href="https://fonts.googleapis.com/css?family=Geo|Dosis" rel="stylesheet" type="text/css" >
        <script src="https://use.fontawesome.com/3a7f9ca103.js"></script>

        <link rel="stylesheet" href="../../style.css" />

	</head>
	<body>
	

	<?php
		//on insere le titre de l'admin
		include('header_admin.php');
	?>
	<h2 class="edition">Modifier le billet</h2>
	<?php
		//on récupère les données à modifier


	?>
		<!-- formulaire pour modifier le billet-->
	<div id="formulaire_modif_billet">
			<form method="post" action="modifier.php">
				<p>	
				<!--Champ "Auteur"-->
					Auteur<br/>
					<input type="text" name="auteur" value=" <?php 
						echo htmlspecialchars($data['nom_auteur']);
					?>"  ><br/>
					
					Titre<br/>
				<!--Champ "Titre"-->
					<input type="text" name="titre_billet" value="<?php 
						echo htmlspecialchars($data['titre']);
					?>" ><br/>

				<!--Champ "Contenu"-->
					Contenu du billet<br/>
					<textarea rows=20 cols=50 name="contenu_billet" ><?php 
						echo htmlspecialchars($data['contenu']);
					?></textarea><br/>
					<input type="text" name="id_billet" value="<?php echo $id_billet ?>">
				<!--Bouton "Poster"-->
					<input type="submit" name="submit" value="Poster"/>
				</p>
			</form>



	</div>

	<?php

		}
	}
		else
			{//sinon,si on ne sait pas quel billet modifier ou que les infos à modifier sont imcomplètes ,on retourne sur la page principale
				header('Location: index.php');
			}

	?>

		</body>
</html>
