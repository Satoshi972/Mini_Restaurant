<?php 
session_start(); // Permet de démarrer la session

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

$post = [];
$errors = [];

$maxSize = (1024 * 1000) * 2; // Taille maximum du fichier
$uploadDir = 'uploads/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$sql = $bdd->prepare('SELECT * FROM site_info ORDER BY inf_id DESC LIMIT 1');
if($sql->execute())
{
	$req = $sql->fetch(PDO::FETCH_ASSOC);
}

if(!empty($_POST))
{
	$post=array_map('trim', array_map('strip_tags', $_POST));

	if(!preg_match('#^[a-z0-9._-]{3,}$#', $post['name']))
	{
		$errros[] = 'Le nom du restaurant doit faire au moins 3 caracères';
	}

	if(!preg_match('#^[a-z0-9._-]{3,}$#', $post['address']))
	{
		$errros[] = 'Le nom du restaurant doit faire au moins 3 caracères';
	}

	if(!preg_match('#^0([0-9]{2})([-. ]?[0-9]{2}){4}$#', $post['phone']))
	{
		$errros[] = 'Le nom du restaurant doit faire au moins 3 caracères';
	}

	if(!preg_match('#^[a-z0-9._-]{20,}$#', $post['content']))
	{
		$errros[] = 'La description du restaurant doit faire au moins 20 caracères';
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
				$newPictureName = uniqid('img_').'.'.$extension;

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

	if(count($errors)>0)
	{
		$errorsText = implode('<br>', $errors);
	}
	else
	{
		$update = $bdd->prepare("UPDATE site_info SET inf_name = :name, inf_address = :address, inf_content = :content, inf_phone = :phone, inf_picture = :picture WHERE inf_id = :id");
		$update->bindValue(':name', $post['name']);
		$update->bindValue(':address', $post['address']);
		$update->bindValue(':content', $post['content']);
		$update->bindValue(':phone', $post['phone']);
		$update->bindValue(':id', $req['inf_id']);
		$update->bindValue(':picture',  $uploadDir.$newPictureName);

		if($update->execute())
		{
			//refresh();
			//$success = 'Modification efféctée';
		}
		else
		{
			die(var_dump($update->errorInfo()));
		}
	}
}

	

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Changer l'apparence du site</title>
	<?php require_once '../inc/head.php' ?>
	<link rel="stylesheet" type="text/css" href="./assets/css/styleAdmin.css">
</head>
<body>
	<?php require_once 'inc/menu_admin.php' ?>
	<main class="container">
		
		<div class="jumbotron">
			<?php if(isset($errorsText)) 

				echo '<p class="text-danger">'.$errorsText.'</p>';

			?>
			<form method="post" class="form-horizontal" enctype="multipart/form-data">
				
				<div class="form-group">
					<label for="name">Nom du restaurant</label>
					<input type="text" name="name" id="name" class="form-control" value="<?php echo $req['inf_name']; ?>" placeholder="<?php echo $req['inf_name']; ?>" required>
				</div>


				<div class="form-group">
					<label for="picture">Image d'entête</label><br>
					<img class="img-thumbnail" src="<?php echo $req['inf_picture']; ?>" alt="Entête"><br>
					<input type="file" name="picture" id="picture" required accept="img/*">
				</div>

				<div class="form-group">
					<label for="address">Adresse</label>
					<input type="text" name="address" id="address" value="<?php echo $req['inf_address']; ?>" placeholder="<?php echo $req['inf_address']; ?>" class="form-control" required>			
				</div>

				<div class="form-group">
					<label for="phone">Numéro du restaurant</label>
					<input type="text" name="phone" id="phone" value="<?php echo $req['inf_phone']; ?>" placeholder="<?php echo $req['inf_phone']; ?>" class="form-control" required>
				</div>
				
				<div class="form-group">
					<label for="content">Description</label>
					<textarea name="content" id="content" class="form-control" value="<?php echo $req['inf_content']; ?>" cols="30" rows="10"><?php echo $req['inf_content']; ?></textarea>
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