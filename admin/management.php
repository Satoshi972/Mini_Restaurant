<?php 
session_start(); // Permet de démarrer la session

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

$sql = $bdd->prepare('SELECT * FROM site_info');
if($sql->execute())
{
	$req = $sql->fetch(PDO::FETCH_ASSOC);
	var_dump($req);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Changer l'apparence du site</title>
	<?php require_once '../inc/head.php' ?>
</head>
<body>
	<?php require_once 'inc/menu_admin.php' ?>
	<main class="container">
		
		<div class="jumbotron">
			<form method="post" class="form-horizontal" enctype="multipart/form-data">

				<div class="form-group">
					<label for="name">Nom du restaurant</label>
					<input type="text" name="name" id="name" class="form-control" required>
				</div>


				<div class="form-group">
					<label for="picture">Image d'entête</label>
					<input type="file" name="picture" id="picture" required accept="img/*">
				</div>

				<div class="form-group">
					<label for="address">Adresse</label>
					<input type="text" name="address" id="address" class="form-control" required>			
				</div>

				<div class="form-group">
					<label for="phone">Numéro du restaurant</label>
					<input type="text" name="phone" id="phone" class="form-control" required>
				</div>
				
				<div class="form-group">
					<label for="content">Description</label>
					<textarea name="content" id="content" class="form-control" cols="30" rows="10"></textarea>
				</div>


				<div class="text-center">
					<input type="submit" class="btn btn-primary">
				</div>

			</form>
		</div>

	</main>
	<?php require_once '../inc/script.php' ?>
</body>
</html>