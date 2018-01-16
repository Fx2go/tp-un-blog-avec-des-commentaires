<!DOCTYPE HTML>
<html>
	<head>
		<title>Supprimer le billet</title>
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

<?php
if (isset ($_GET['id']) )
	{
		$id_billet=strip_tags($_GET['id']);
	}
else
{//On retourne sur la page principale
	header('Location: ../../index.php');
}

include ('../connection_BDD.php');

	$req = $bdd->prepare("DELETE FROM billets WHERE id= :id_billet");
	 
	$req->bindParam(':id_billet', $id_billet);
	$req->execute();
	// une fois le billet supprimé, on retourne sur la page d'accueil
	header('Location: ../../index.php');
	?>

		</body>
</html>
