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
		<div class=" container-full">
			<div class="row">
				<div class="col-xs-12">
					<header class="page-header index-header">

						<div class="col-xs-6">
							<h2 class="name">
								<strong><a href="info_resto.php"><?php echo $info['inf_name']; ?></a></strong>
							</h2>
							<p class="address">
								<?php echo $info['inf_address']; ?>
							</p>
							<p class="address">
								<?php echo $info['inf_phone']; ?>
							</p>
						</div>

						<div class="col-xs-6">
							<div class="text-right address">
								<a href="contact.php">Nous contacter</a>
							</div>
						</div>

					</header>
				</div>
			</div>
		</div>

		<main> 
			<div class="container-full index-main">
				<div class="row">
					<div class="col-xs-12">
						<section id="section1" class="text-center">
							<img class="img-responsive projector" src="<?php echo $info['inf_picture']; ?>" alt="Header restaurant">
						</section>
					</div>
				</div>
			</div>

			<div class="well container">								
				<div class="row col-xs-12">
					<section id="section2">
						<legend class="address"><strong>Faites votre choix</strong></legend>				
						<?php 
						foreach ($recipe as $key => $value) :
						?>
						<figure class="col-md-4">
							<img class="img-responsive imgrecipe" src="<?php echo $value['rcp_picture'] ?>" alt="Recette du chef">
							<a href="view_recipe.php?id=<?php echo $value['rcp_id']; ?>">lire la recette</a>
						</figure>
						<?php 
						endforeach;
						?>
						<div class="row col-xs-12">
							<div class="text-center">
								<a href="list_recipes.php">
									<button>Découvrir toutes les recettes des chefs</button>
								</a>
							</div>
						</div>
					</section>
				</div>
			</div>

		</main>

		<?php require_once 'inc/script.php'; ?>

	</body>
</html>