<?php 
require_once 'inc/connect.php';

$site_info = $bdd->prepare('SELECT * FROM site_info ORDER BY inf_id DESC LIMIT 3');
if($site_info->execute())
{
	$info = $site_info->fetch(PDO::FETCH_ASSOC);
}
else
{
	die(var_dump($site_info->errorInfo()));
}


$list_recipe = $bdd->prepare('SELECT * FROM recipe, users WHERE rcp_usr_id = usr_id ORDER BY rcp_id DESC LIMIT 3');
if($list_recipe->execute())
{
	$recipe = $list_recipe->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($recipe);
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
				<strong><a href="info_resto.php"><?php echo $info['inf_name']; ?></a></strong>
			</p>

			<p>
				<?php echo $info['inf_address']; ?>
			</p>

			<p>
				<?php echo $info['inf_phone']; ?>
			</p>

			<p class="text-right">
				<a href="contact.php">Nous contacter</a>
			</p>

		</header>
		
		<section class="text-center">
			<img class="img-responsive" src="<?php $info['inf_picture']; ?>" alt="Header restaurant">
		</section>
		
		<section class="col-xs-12">
		<?php 
			foreach ($recipe as $key => $value) :
		?>
			<figure class="col-md-4">
				<img class="img-responsive" src="<?php $value['rcp_picture'] ?>" alt="Recette du chef">
				<a href="view_recipe.php?id=<?php echo $value['rcp_id']; ?>">lire la recette</a>
			</figure>

		<?php 
			endforeach;
		?>
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