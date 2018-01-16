<?php
$auteur=stripslashes(htmlspecialchars($_POST['auteur']));
$titre_billet=stripslashes(htmlspecialchars($_POST['titre_billet']));
$contenu_billet=stripslashes(htmlspecialchars($_POST['contenu_billet']));
		//Si le formulaire complet a été envoyer 
		if(!empty($_POST[auteur])&&!empty($_POST[titre_billet])&&!empty($_POST[contenu_billet])) {
			//connection BDD
	include ('../connection_BDD.php');
			//requete pour ajouter Billet
	 $req = $bdd->prepare('INSERT INTO billets(titre,contenu,date_creation,nom_auteur) VALUES(:titre,:contenu,NOW(),:nom_auteur)');
	$req->execute(array('titre'=>$titre_billet,'contenu'=>$contenu_billet,'nom_auteur'=>$auteur));
	//on redirige l'url vers le nouvel article
	 	//on identifie l'ID du nouveau billet
	 $req1=$bdd->prepare('SELECT id FROM billets WHERE titre=:titre AND contenu=:contenu AND date_creation=:date_creation AND   nom_auteur=:nom_auteur');
	 $req1->execute(array('titre'=>$titre_billet,'contenu'=>$contenu_billet,'date_creation'=>$date_billet,'nom_auteur'=>$auteur));
	 while ($data=$req->fetch())
	 	{
	 		$id_billet=$data['id'];
		}
	header('Location:../billet.php?id='.$id_billet);
	//header('Location:../index.php');
		}
		elseif (isset($_POST['envoyer'])) {
			echo'Formulaire incomplet!!<br>';
		 } 
		// Si non on fait rien ... on attends....
	
?>




<!DOCTYPE HTML>
<html>
	<head>
		<title>Ajouter un billet</title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <link href="https://fonts.googleapis.com/css?family=Geo|Dosis" rel="stylesheet" type="text/css" >
        <script src="https://use.fontawesome.com/3a7f9ca103.js"></script>

        <link rel="stylesheet" href="../style.css" />

	</head>
	<body>
	

	<?php
		//on insere le titre de l'admin
		include('header_admin.php');
	?>

	<h2 class="edition">Ajouter un billet</h2>

<!-- formulaire pour saisir le billet-->
	<div id="formulaire_ajout_billet">
			<form method="post" action="ajouter.php">
				<p>	
				<!--Champ "Auteur"-->
					Auteur<br/>
					<input type="text" name="auteur" value="<?php 
					if(isset($_COOKIE['pseudo']))
						{echo $_COOKIE['pseudo'];} 
					elseif(isset($auteur))
					{echo $auteur;}
					?>" placeholder="Nom de l'auteur" ><br/>
					
					Titre<br/>
				<!--Champ "Titre"-->
					<input type="text" name="titre_billet" value="<?php echo $titre_billet;?>" placeholder="Titre de votre billet"><br/>

				<!--Champ "Contenu"-->
					Contenu du billet<br/>
					<textarea rows=20 cols=50 name="contenu_billet"  placeholder="Texte de votre billet"><?php echo $contenu_billet;?></textarea><br/>

				<!--Bouton "Poster"-->
					<input type="submit" name="submit" value="Poster"/>
				</p>
			</form>



	</div>



		</body>
</html>
