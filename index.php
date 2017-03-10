<?php 
require_once 'inc/connect.php';

$site_info = $bdd->prepare('SELECT * FROM site_info');
if($site_info->execute())
{
	$info = $site_info->fetchAll(PDO::FETCH_ASSOC);
}
else
{
	die(var_dump($site_info->errorInfo()));
}

$list_recipe = $bdd->prepare('SELECT * FROM recipe, users WHERE rcp_usr_id = usr_id');
if($list_recipe->execute())
{
	$recipe = $list_recipe->fetchAll(PDO::FETCH_ASSOC);
}
else
{
	die(var_dump($list_recipe->errorInfo()));
}


?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Accueil</title>
	<?php require_once 'inc/head.php'; ?>
</head>
<body>
	<main class="container-full index-main">
		<header class="page-header index-header">

			<p>
				<strong><a href="info_resto.php"><?php echo $info['inf_name'] ?></a></strong>
			</p>

			<p>
				<?php echo $info['inf_address'] ?>
			</p>

			<p>
				<?php echo $info['inf_number'] ?>
			</p>

			<p class="text-right">
				<a href="contact.php">Nous contacter</a>
			</p>

		</header>

		<section class="text-center">
			<img class="img-responsive" src="<?php $info['inf_picture'] ?>" alt="Header restaurant">
		</section>

		<section class="col-xs-12">
			<legend class="text-center">Les recettes du chefs</legend>
			<figure class="col-md-4">
				<img class="img-responsive" src="<?php $recipe ?>" alt="Recette du chef 1">
				<a href="recipe_details.php?id=<?php $recipe['rcp_id'] ?>">lire la recette</a>
			</figure>

			<figure class="col-md-4">
				<img class="img-responsive" src="<?php $recipe ?>" alt="Recette du chef 2">
				<a href="recipe_details.php?id=<?php $recipe['rcp_id'] ?>">lire la recette</a>
			</figure>

			<figure class="col-md-4">
				<img class="img-responsive" src="<?php $recipe ?>" alt="Recette du chef 3">
				<a href="recipe_details.php?id=<?php $recipe['rcp_id'] ?>">lire la recette</a>
			</figure>

			<div class="text-center">
				<a href="recipe_list.php">
					<button>Découvrir toutes les recettes des chefs</button>
				</a>
			</div>

		</section>
		
	</main>
	<?php require_once 'inc/script.php' ?>
</body>
</html>