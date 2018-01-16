<div class="titre">
	<a href="<?php echo $lien_article;?>">
		<h3><?php echo htmlspecialchars($data['titre']);?></h3>
	</a>
	<span>
		<?php echo 'Discours de <strong>'.htmlspecialchars($data['nom_auteur']).'</strong>, publié ici le '.htmlspecialchars($data['date_formatee']);?>
	</span>
<?php
if (isset ($_GET['id']) )
	{
		include('admin-menu.php');
	}
?>
</div>
