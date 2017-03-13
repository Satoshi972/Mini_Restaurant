<?php
session_start();

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

$maxSize = (1024 * 1000) * 2; // Taille maximum du fichier
$uploadDir = 'uploads/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$errors = [];
$post = [];

if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {

	$idRecipe = (int) $_GET['id'];
	
	$selectOne = $bdd->prepare('SELECT * FROM recipe WHERE rcp_id = :rcp_id');
	$selectOne->bindValue(':rcp_id', $idRecipe, PDO::PARAM_INT);

	if($selectOne->execute()){
		$modif_recipe = $selectOne->fetch(PDO::FETCH_ASSOC);
	}
	else {
		// Erreur de développement
		var_dump($selectOne->errorInfo());
		die; // alias de exit(); => die('Hello world');
	}
}
// Soumission du formulaire
if(!empty($_POST)){

	// équivalent au foreach de nettoyage
	$post = array_map('trim', array_map('strip_tags', $_POST)); 

	// si la valeur titre a moins de 5 ou plus de 50 caractères, alors "erreur"
	if(strlen($post['title']) < 5 || strlen($post['title']) > 50){
		$errors[] = 'Le titre doit contenir de 5 à 50 caractères';
	}
	// si la valeur recette a moins de 20 caractères, alors "erreur"
	if(strlen($post['content']) < 20){
		$errors[] = 'La recette doit contenir au moins 20 caractères';
	}
	// si le fichier image est défini et ne comporte pas d'erreur
	if(isset($_FILES['picture']) && $_FILES['picture']['error'] === 0){

		$finfo = new finfo();
		$mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);

		// vérifications de contrôle de l'image
		$extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

		if(in_array($mimeType, $mimeTypeAvailable)){
			// si le fichier n'excède pas le poids maxi autorisé
			if($_FILES['picture']['size'] <= $maxSize){

				if(!is_dir($uploadDir)){
					mkdir($uploadDir, 0755); //pour la compatibilité
				} 
				// on renomme le fichier
				$newPictureName = uniqid('image_').'.'.$extension;

				if(!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir.$newPictureName)){
					$errors[] = 'Erreur lors de l\'upload du fichier';
				} 
			}
			else {
				$errors[] = 'La taille du fichier excède 2 Mo';
			}
		}
		else {
			$errors[] = 'Le fichier n\'est pas une image valide';
		}
	}
	else {
		$errors[] = 'Aucune image sélectionnée';
	}


	if(count($errors) === 0) {

		$update = $bdd->prepare('UPDATE recipe SET rcp_title = :rcp_title, rcp_content = :rcp_content, rcp_picture = :rcp_picture WHERE rcp_id = :idRecipe');

		$update->bindValue(':idRecipe', $modif_recipe['rcp_id'], PDO::PARAM_INT);
		$update->bindValue(':rcp_title', $post['title']);
		$update->bindValue(':rcp_content', $post['content']);
		$update->bindValue(':rcp_picture', $uploadDir.$newPictureName);

		if($update->execute())
		{
			$success = 'Félicitations votre recette a été modifiée';

		} else {
			var_dump($update->errorInfo());
			die;
		}
	} else {
		$textErrors = implode('<br>', $errors);
	}

}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Modifier une recette</title>

		<?php include '../inc/head.php'; ?>

		<link rel="stylesheet" type="text/css" href="assets/css/styleAdmin.css">

		<link rel="stylesheet" href="../assets/css/style.css">		

	</head>
	<body>
		<?php include './inc/menu_admin.php'; ?>
		<main class="page">
			

			<div id="content" class="well container">
				<section class="row">
					<div class="contact col-xs-12">
						<h3>Modifier une recette</h3>
						<?php if(isset($modif_recipe) && !empty($modif_recipe)): ?>
						<!-- on affiche une message en cas d'erreur en rouge, sinon un message de succès en vert -->
						<?php if(isset($errorsText)): ?>
						<p class="alert alert-danger" role="alert"><?php echo $errorsText; ?></p>
						<?php endif; ?>

						<?php if(isset($success)): ?>
						<p class="alert alert-success" role="alert"><?php echo $success; ?></p>
						<?php endif; ?>

						<form method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label for="title">Nom de la recette</label>
								<input class="form-control" type="text" name="title" id="title" value="<?=$modif_recipe['rcp_title'];?>">
							</div>

							<div class="form-group">
								<label for="content">Recette</label>
								<div class="input-group">
									<textarea style="width : 756px" class="form-control" rows="15" name="content" id="content"><?=$modif_recipe['rcp_content'];?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="picture">Photo</label>
								<input class="form control" type="file" name="picture" id="picture" accept="image/*" value="<?=$modif_recipe['rcp_picture'];?>">
							</div>

							<div class="text-center">
								<input class="btn btn-primary" type="submit" value="Mettre a jour la recette">
							</div>
						</form>
						<?php else: ?>
						<p class="alert alert-danger" role="alert">Désolé, aucune recette correspondante !!!</p>
						<?php endif; ?>
					</div>
				</section>
			</div>
		</main>
		<?php include_once '../inc/script.php' ?>
	</body>
</html>