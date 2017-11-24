<?php
if (isset ($_GET['billet']) )
	{
		$id_billet=strip_tags($_GET['billet']);
	}
else
{//On retourne sur la page principale
	header('Location: index.php');
}

include ('connection_BDD.php');


	 $req = $bdd->prepare("SELECT titre,contenu, DATE_FORMAT(date_creation, 'Le %d/%m/%Y à %Hh %imin') AS date_formatee FROM billets WHERE id= :id_billet");
	 
	$req->bindParam(':id_billet', $id_billet);
	$req->execute();


	$data = $req->fetch();
	// Si le résultat de la requête est vide (ex: l'ID du billet a été modifié dans l'url envoyée)
	if(empty($data))
		// ...alors on affiche à nouveau la page d'accueil
		{
?>

	<p>	Nous sommes d&eacute;sol&eacute;s pour vous mais le billet n&deg; <?php echo $id_billet; ?> 
		n&#039;existe pas sur ce blog <br/>.... pour le moment
	</p>	
<?php
		}
		// ... sinon on affiche la page correspondante
	else {
			
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo htmlspecialchars($data['titre']) ?></title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <link href="https://fonts.googleapis.com/css?family=Geo|Dosis" rel="stylesheet" type="text/css" >
        <link rel="stylesheet" href="style.css" />
        <script src="https://use.fontawesome.com/3a7f9ca103.js"></script>
	</head>
	<body>
	<?php include('header.php');?>


<div .news>
			
	<?php include('titre_billet.php');?>

	<p .news>
		<?php echo htmlspecialchars($data['contenu']);?>
		
	</p>
</div>
<?php

	//On ferme le traitement de la requête
	$req->closeCursor();
?>

<div.commentaires>
	<h4><i class="fa fa-comments" aria-hidden="true"></i> Commentaires</h4>

<?php
		$req = $bdd->prepare("SELECT id,id_billet,nom_auteur,commentaire, DATE_FORMAT(date_commentaire, '%d/%m/%Y à %Hh %imin') AS date_formatee FROM commentaires WHERE id_billet= :id_billet ORDER BY id DESC ");
	// $req->execute(array('id_billet'=>$id_billet));
	 
	$req->bindParam(':id_billet', $id_billet);
	$req->execute();

	while ($data = $req->fetch())
	{ 
			echo'<p>';
			echo'<strong>'.htmlspecialchars($data['nom_auteur']).'</strong>, le '.htmlspecialchars($data['date_formatee']);
			echo' :" '.htmlspecialchars($data['commentaire']);
			echo' "</p>';
	}
?>


</div>

		

<?php

	//On ferme le traitement de la requête
	$req->closeCursor();

	// on affiche un formulaire de saisie de commentaires
?>
	<!--Formulaire -->

	<div id="form_comm">
		<form method="post" action="commentaires_post.php">
			<p>	
			<!--Champ "Pseudo"-->
				<strong><i class="fa fa-user-circle-o" aria-hidden="true"></i></strong> :
				<input type="text" name="pseudo" value="<?php if(isset($_COOKIE['pseudo'])){echo $_COOKIE['pseudo'];} ?>" placeholder="Pseudo" ></input>
			<!--Champ "Commentaire"-->
				<i class="fa fa-commenting-o" aria-hidden="true"></i>
				<input type="text" name="commentaire" placeholder="Commentaire"></input>
				<input type="hidden" name="id_billet" value="<?php echo $id_billet ?>"></input>

				<input type="submit" value="Poster">
			</p>
		</form>
	</div>

<?php
}// fin du ELSE

?>
	</body>
</html>