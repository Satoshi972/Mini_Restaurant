<?php
require_once 'inc/connect.php';


	$select = $bdd->prepare('SELECT * FROM site_info ORDER BY  inf_id DESC LIMIT 1');
	if($select->execute()){
		$info = $select->fetch(PDO::FETCH_ASSOC);
	}
	else {
		var_dump($select->errorInfo());
		die;
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

			<?php require_once 'inc/navFront.php'; ?>

			<div id="content" class="well container">
				<div class="row">
					<div class="col-xs-12">
	
						<div class="col-xs-6">
							<div class="media">
								<div class="media-left">
									<img  src="./admin/<?=$info['inf_picture']; ?>" class="img-responsive img-thumbnail">
								</div>
							</div>
						</div>

						<div class="col-xs-6">
							<div class="media-body">
								<h4 class="media-heading list nameForm">Qui sommes nous !!!</h4>
								<h2 class="list"><?=$info['inf_name'];?></h2>
								<p class="list"><?=$info["inf_content"]; ?></p>
							</div>
						</div>

						<div class="row">

							<div class="col-xs-12">

								<div class="col-xs-6">
									<p class="list"><?='Adresse : ' .$info["inf_address"]; ?></p>
								</div>

								<div class="col-xs-6">
									<p class="list"><?='Tel :' .$info["inf_phone"]; ?></p>
								</div>

							</div>
						</div>
					</div>
				</div>                                      
			</div>
			<?php include_once 'inc/script.php'; ?>
		</main>
		<?php require_once 'inc/footer.php'; ?>

	</body>
</html>