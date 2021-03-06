<?php
session_start(); // Permet de démarrer la session

require_once 'inc/verif_session.php';

require_once '../inc/connect.php';


if(!isset($_SESSION['is_logged']) || empty($_SESSION['is_logged']))
{
	die(header("Location : loggin.php"));
}

$maxSize = (1024 * 1000) * 2; // Taille maximum du fichier
$uploadDir = 'uploads/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$errors = [];
$post = [];
$displayForm = true;

// si le post n'est pas vide, on récupère les données "nettoyées"
if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}
	// si la valeur titre a moins de 5 ou plus de 50 caractères, alors "erreur"
	// if(!preg_match('#^[a-z0-9._-]{5,140}$#', $post['title'])){
	// 	$errors[] = 'Le titre doit contenir de 5 à 50 caractères';
	// }
	if(strlen($post['title']) < 5){
		$errors[] = 'Le titre doit contenir de 5 à 50 caractères';
	}
	// si la valeur recette a moins de 20 caractères, alors "erreur"
	// if(!preg_match('#^[a-z0-9._-\s]{20,}$#', $post['content'])){
	// 	$errors[] = 'La recette doit contenir au moins 20 caractères';
	// }
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

	if(count($errors) === 0){
		// s'il n'y a pas d'erreur, on récupère les données de la table "recipe", titre, contenu et image et on leur affecte un nom
		$request = $bdd->prepare('INSERT INTO recipe (rcp_title, rcp_content, rcp_picture, rcp_usr_id) VALUES(:title, :content, :picture, :userId)');
		/* on affecte à chaque nom créé, la valeur récupérée dans les champs de la table de données et le chemin pour l'image... */
		$request->bindValue(':title', $post['title']);
		$request->bindValue(':content', $post['content']);
		$request->bindValue(':picture', $uploadDir.$newPictureName);
		$request->bindValue(':userId', $_SESSION['id']);


		if($request->execute()){
			$success = 'Bravo, la recette a bien été ajoutée';
			$displayForm = false;
		}
		else {
			var_dump($request->errorInfo());
			die;
		}
	}
	else {
		$errorsText = implode('<br>', $errors); 
	}
}



?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ajouter une recette</title>

		<?php include '../inc/head.php'; ?>

		<link rel="stylesheet" type="text/css" href="assets/css/styleAdmin.css">

	</head>
	<body>

		<?php include './inc/menu_admin.php'; ?>

		<main class="container">

			<div class="jumbotron">
				<h3>Ajouter une recette</h3>
				<!-- on affiche une message en cas d'erreur en rouge, sinon un message de succès en vert -->
				<?php if(isset($errorsText)): ?>
				<p style="color:red;"><?php echo $errorsText; ?></p>
				<?php endif; ?>

				<?php if(isset($success)): ?>
				<p style="color:green;"><?php echo $success; ?></p>
				<?php endif; ?>


				<?php if($displayForm === true): ?>
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="title">Nom de la recette</label>
						<input class="form-control" type="text" name="title" id="title">
					</div>

					<div class="form-group">
						<label for="content">Recette</label>
						<textarea class="form-control" rows="6" name="content" id="content"></textarea>
					</div>

					<div class="form-group">
						<label for="picture">Photo</label>
						<input class="form control" type="file" name="picture" id="picture" accept="image/*">
					</div>

					<div class="text-center">
						<input class="btn btn-primary" type="submit" value="Envoyer la recette">
					</div>
				</form>
				<?php endif; ?>
			</div>

			<?php include_once '../inc/script.php' ?>
			</body>
		</html>