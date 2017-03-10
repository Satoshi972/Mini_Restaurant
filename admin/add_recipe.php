<?php
session_start(); // Permet de démarrer la session
require_once '../inc/connect.php';

/* if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false){
 	header('Location: login.php');
 	die; 
}*/

$maxSize = (1024 * 1000) * 2; // Taille maximum du fichier
$uploadDir = 'uploads/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$errors = [];
$post = [];
$displayForm = true;

if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(strlen($post['title']) < 5 || strlen($post['title']) > 50){
		$errors[] = 'Le titre doit contenir de 5 à 50 caractères';
	}

	if(strlen($post['content']) < 20){
		$errors[] = 'La description doit contenir au moins 20 caractères';
	}

	if(isset($_FILES['picture']) && $_FILES['picture']['error'] === 0){

		$finfo = new finfo();
		$mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);

		$extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

		if(in_array($mimeType, $mimeTypeAvailable)){

			if($_FILES['image']['size'] <= $maxSize){

				if(!is_dir($uploadDir)){
					mkdir($uploadDir, 0755);
				}

				$newPictureName = uniqid('image').'.'.$extension;

				if(!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$newPictureName)){
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

		$request = $bdd->prepare('INSERT INTO recipe (rcp_title, rcp_content, rcp_picture) VALUES(:title, :content, :picture)');

		$request->bindValue(':title', $post['title']);
		$request->bindValue(':content', $post['content']);
        $request->bindValue(':picture', $uploadDir.$newPictureName);
    
    if($request->execute()){
        $success = 'Youpi, la recette a bien été ajoutée';
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

</head>
<body>

	<h1>Ajouter une recette</h1>

	<?php if(isset($errorsText)): ?>
		<p style="color:red;"><?php echo $errorsText; ?></p>
	<?php endif; ?>

	<?php if(isset($success)): ?>
		<p style="color:green;"><?php echo $success; ?></p>
	<?php endif; ?>


	<?php if($displayForm === true): ?>
	<form method="post" enctype="multipart/form-data">
		<label for="title">Titre de la recette</label>
		<input type="text" name="title" id="title">

		<br>
		<label for="content">Description</label>
		<textarea name="content" id="content"></textarea>

		<br>
		<label for="picture">Photo</label>
		<input type="file" name="picture" id="picture" accept="image/*">

		<br>
		<input type="submit" value="Envoyer la recette">
	</form>
	<?php endif; ?>


</body>
</html>