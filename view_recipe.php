<?php
require_once 'inc/connect.php';

$recipe = [];
// view_menu.php?id=6
if(isset($_GET['rcp_id']) && !empty($_GET['rcp_id'])){

	$idRecipe = (int) $_GET['rcp_id'];

	// Jointure SQL permettant de récupérer la recette & le prénom & nom de l'utilisateur l'ayant publié
	$selectOne = $bdd->prepare('SELECT r.*, usr_firstname, usr_lastname FROM restaurant AS r INNER JOIN users AS u ON r.usr_id = usr_id WHERE r.id = :rcp_id');
	$selectOne->bindValue(':rcp_id', $rcp_id, PDO::PARAM_INT);

	if($selectOne->execute()){
		$recette = $selectOne->fetch(PDO::FETCH_ASSOC);
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
</head>
<body>
<?php if(!empty($recipe)): ?>
	<h1>Détails de la recette</h1>

	<h2><?php echo $recipe['rcp_title'];?></h2>

	<p><?php echo nl2br($recipe['rcp_content']); ?></p>

	<img src="<?=$recipe['picture'];?>" alt="<?php echo $recette['title'];?>">


	<p>Publié par <?php echo $recipe['firstname'].' '.$recette['lastname'];?></p>
<?php else: ?>
	Aucune recette trouvée !
<?php endif; ?>

</body>
</html>