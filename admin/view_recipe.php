<?php
session_start();
require_once '../inc/connect.php';
require_once 'inc/verif_session.php';


$added_recipe = [];
// view_menu.php?id=6
if(isset($_GET['id']) && !empty($_GET['id'])){

	$idRecipe = (int) $_GET['id'];

	// Jointure SQL permettant de récupérer la recette & le prénom & nom de l'utilisateur l'ayant publié
	$selectOne = $bdd->prepare('SELECT usr_firstname, usr_lastname, rcp_title, rcp_content, rcp_picture FROM users INNER JOIN recipe ON users.usr_id = recipe.rcp_usr_id WHERE rcp_id = :id');
	$selectOne->bindValue(':id', $idRecipe, PDO::PARAM_INT);

	if($selectOne->execute()){
		$added_recipe = $selectOne->fetch(PDO::FETCH_ASSOC);
	}
	else {
		// Erreur de développement
		var_dump($selectOne->errorInfo());
		die; // alias de exit(); => die('Hello world');
	}
}
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Détails de la recette</title>
		<?php include_once '../inc/head.php'; ?>
	</head>
	<body>
		<main class="page">
			<?php include_once 'inc/menu_admin.php'; ?>
			<div id="content" class="container well">

				<legend class="nameForm"><h2>Détails de la recette</h2></legend>
				<?php if(!empty($added_recipe)): ?>
				<h2 class="list"><?php echo $added_recipe['rcp_title'];?></h2>

				<p class="list"><?php echo nl2br($added_recipe['rcp_content']); ?></p>
				<!-- on affiche l'image récupérée dans notre tableau added_recipe avec les données récupérées dans la table, à défaut on affiche le nom de la rectte récupérée dans la table -->
				<img src="<?=$added_recipe['rcp_picture'];?>" alt="<?php echo $added_recipe['rcp_title'];?>">


				<p class="list">Publié par <?php echo $added_recipe['usr_firstname'].' '.$added_recipe['usr_lastname'];?></p>
				<?php else: ?>
				Aucune recette trouvée !
				<?php endif; ?>
			</div>
			<?php include_once '../inc/script.php'; ?>
			</body>
		</html>