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


$list_recipe = $bdd->prepare('SELECT * FROM recipe ORDER BY rcp_id DESC LIMIT 3');
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
		<?php require_once 'inc/navFront.php'; ?>
		
		<main class="page"> 

			<div class="container-full">
				<section id="section1">
					<img class="projector" src="<?php echo $info['inf_picture']; ?>" alt="Header restaurant">
				</section>
					
			</div>

			<div class="well container">								
				<div class="row col-xs-12">
					<section id="section2">
						<legend class="address"><strong>Faites votre choix</strong></legend>				
						<?php 
						foreach ($recipe as $key => $value) :
						?>
						<figure class="col-md-4 center-block">
							<img class="img-responsive imgrecipe" src="<?php echo $value['rcp_picture'] ?>" alt="Recette du chef">
							<a href="view_recipe.php?id=<?php echo $value['rcp_id']; ?>" class="front lire">voir la recette</a>
						</figure>
						<?php 
						endforeach;
						?>
						<div class="row col-xs-12 myrow">
							<div class="text-center">
								<a href="list_recipes.php" class="front btn btn-info">Découvrir toutes les recettes des chefs</a>
							</div>
						</div>
					</section>
				</div>
			</div>

		</main>
		<footer>
			<h3>Plan du Site</h3>
			
		</footer>

		<?php require_once 'inc/script.php'; ?>

	</body>
</html>