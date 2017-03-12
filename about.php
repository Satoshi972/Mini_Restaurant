<?php
require_once 'inc/connect.php';

if(isset($_GET['id']) && !empty($_GET['id'])){
	$idRecipe = (int) $_GET['id'];

	$select = $bdd->prepare('SELECT * FROM site_info WHERE inf_id = :inf_id');
	$select->bindValue(':inf_id', $idRecipe, PDO::PARAM_INT);
	if($select->execute()){
		$restaurant = $select->fetch(PDO::FETCH_ASSOC);
	}
	else {
		var_dump($select->errorInfo());
		die;
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include_once 'inc/head.php'; ?>
		<meta charset="UTF-8">
		<title>A Propos</title>

	</head>
	<body>
		<main class="page">

			<?php include_once 'inc/menu.php'; ?>

			<div id="content" class="well container">
				<div class="row">
					<div class="col-xs-12">

						<?php if(isset($restaurant) && !empty($restaurant)) : ?>	

						<div class="col-xs-6">
							<div class="media">
								<div class="media-left">
									<img  src="<?=$restaurant['inf_picture']; ?>" class="media-object" style="width:500px;height:150px">
								</div>
							</div>
						</div>

						<div class="col-xs-6">
							<div class="media-body">
								<h4 class="media-heading list nameForm">Qui sommes nous !!!</h4>
								<h2 class="list"><?=$restaurant['inf_name'];?></h2>
								<p class="list"><?=$restaurant["inf_content"]; ?></p>
							</div>
						</div>

						<div class="row">

							<div class="col-xs-12">

								<div class="col-xs-6">
									<p class="list"><?='Adresse : ' .$restaurant["inf_address"]; ?></p>
								</div>

								<div class="col-xs-6">
									<p class="list"><?='Tel :' .$restaurant["inf_number"]; ?></p>
								</div>

							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>                                       
			</div>
			<?php include_once 'inc/script.php'; ?>
		</main>
	</body>
</html>