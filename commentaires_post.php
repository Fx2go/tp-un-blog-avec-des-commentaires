<?php

//On récupère les variables du pseudo et message envoyées par POST
//et on élimine d'éventuelles balises html
$pseudo=htmlspecialchars($_POST['pseudo']);
$pseudo=stripslashes($pseudo);
$commentaire=htmlspecialchars($_POST['commentaire']);
$commentaire=stripslashes($commentaire);
$id_billet=htmlspecialchars($_POST['id_billet']);

// On stock le pseudo dans un cookie
setcookie('pseudo', $pseudo, time() + 365*24*3600);



//On stock les variables en base de données
	//On se connecte à la base de données
	include ('connection_BDD.php');
	// On execute la requete pour stocker les variables


	 $req = $bdd->prepare('INSERT INTO commentaires(nom_auteur,commentaire,date_commentaire,id_billet) VALUES(:nom_auteur,:commentaire,NOW(),:id_billet)');

	 $req->execute(array('nom_auteur'=>$pseudo, 'commentaire'=>$commentaire,'id_billet'=> $id_billet));



//On retourne sur la page précédente

	header('Location:billet.php?id='.$id_billet);

?>