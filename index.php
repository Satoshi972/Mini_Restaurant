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

		<header class="page-header index-header">
			<h2 class="name">
				<strong><a href="info_resto.php"><?php echo $info['inf_name']; ?></a></strong>
			</h2>

			<p class="address">
				<?php echo $info['inf_address']; ?>
			</p>
			<p class="address">
				<?php echo $info['inf_phone']; ?>
			</p>

			<p class="text-right address">
				<a href="contact.php">Nous contacter</a>
			</p>
		</header>

		<main> 
			<div class="container-full index-main">
				<div class="row col-xs-12">
					<section id="section1" class="text-center">
						<img class="img-responsive projector" src="<?php echo $info['inf_picture']; ?>" alt="Header restaurant">
					</section>
				</div>

				<section id="section2">
				<div class="container">
				<div class="row col-xs-12">				
					<div class="well container">
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
							<a href="recipe_list.php">
								<button>Découvrir toutes les recettes des chefs</button>
							</a>
						</div>
					</div>
					</div>
					</div>
					</div>
				</section>
					

				
			</div>
				</main>
				<footer class="foot">
					<div class="row">
						<div class="col-xs-12">
							<div class="col-md-6">
								<h3> Lorem Ipsum </h3>
								<ul>
									<li> <a href="#"> Lorem Ipsum </a> </li>
									<li> <a href="#"> Lorem Ipsum </a> </li>
									<li> <a href="#"> Lorem Ipsum </a> </li>
									<li> <a href="#"> Lorem Ipsum </a> </li>
								</ul>
							</div>


							<div class="col-md-6">
								<ul>
									<li>
										<div class="input-append newsletter-box text-center">
											<input type="text" class="full text-center" placeholder="Email ">
											<button class="btn  bg-gray" type="button"> Lorem ipsum <i class="fa fa-long-arrow-right"> </i> </button>
										</div>
									</li>
								</ul>
								<ul class="social">
									<li> <a href="#"> <i class=" fa fa-facebook">   </i> </a> </li>
									<li> <a href="#"> <i class="fa fa-twitter">   </i> </a> </li>
									<li> <a href="#"> <i class="fa fa-google-plus">   </i> </a> </li>
									<li> <a href="#"> <i class="fa fa-pinterest">   </i> </a> </li>
									<li> <a href="#"> <i class="fa fa-youtube">   </i> </a> </li>
								</ul>
								<ul class="nav nav-pills payments">
									<li><i class="fa fa-cc-visa"></i></li>
									<li><i class="fa fa-cc-mastercard"></i></li>
									<li><i class="fa fa-cc-amex"></i></li>
									<li><i class="fa fa-cc-paypal"></i></li>
								</ul> 
							</div>
						</div>
						<!--/.row--> 
					</div>
					<!--/.footer-bottom-->
					<div class="row">
						<div class="col-xs-12">
							<p class="pull-left"> Copyright © Footer 2014. All right reserved. </p>
						</div>
					</div>
					<!--/.container--> 
					<!--/.footer-->

				</footer>
			<?php require_once 'inc/script.php'; 
			?>
			</body>
		</html>