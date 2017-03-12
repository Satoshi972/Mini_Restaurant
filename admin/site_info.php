<?php 
require_once '../inc/connect.php';

#définition de quelques variables pour gerer les images
$maxSize = (1024 * 1000) * 2; // Taille maximum du fichier
$uploadDir = 'uploads/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$errors = [];

$displayForm = true;

if(!empty($_POST))
{
	var_dump($_POST);
	foreach ($_POST as $key => $value) 
	{
		$post[$key] = trim(strip_tags($value));
	}

	if(empty($post['name']))
	{
		$errors[] = 'Veuillez rentrer un nom pour votre restaurant';
	}

	if(empty($post['address']))
	{
		$errors[] = 'Veuillez renseigner l\'adresse du restaurant';
	}

	if(!is_numeric($post['phone']) || strlen($post['phone']) !== 10)
	{
		$errors[] = 'Le numero doit être composé de 10 chiffres';
	}

	if(empty($post['content']))
	{
		$errors[] = 'Veuillez replir la description de votre restaurant';
	}

	if(isset($_FILE['picture']) && $_FILE['picture']['error'] === 0)
	{
		$finfo = new finfo();
		$mimeType = $finfo->file($_FILE['picture']['tmp_name'],FILEINFO_MIME_TYPE);
		$extension = pathinfo($_FILE['picture']['name'], PATHINFO_EXTENSION);

		if(in_array($mimeType, $mimeTypeAvailable))
		{
			if($_FILE['picture']['size']<=$maxSize)
			{
				if(!is_dir($uploadDir))
				{
					mkdir($uploadDir, 0755);
				}

				$newPictureName = uniqid('img_').'.'.$extension;

				if(!move_uploaded_file($_FILE['picture']['tmp_name'], $uploadDir.$newPictureName))
				{
					$errors[] = 'Erreur lors de l\'envoi de l\'image, veuiller contacter votre admin réseau';
				}
			}
			else
			{
				$errors[] = 'Erreur, fichier tros gros, il doit faire 2mo max';
			}
		}
		else
		{
			$errors[] = 'Erreur, le fichier n\'est pas une image valide' ;
		}
	}
	else
	{
		$errors[] = 'Erreur lors de l\'envoi du fichier' ;
	}

	if(count($errors>0))
	{
		$errorsText = implode('<br>', $errors);
	}
	else
	{
		$insert = $bdd->prepare('INSERT INTO site_info (inf_name, inf_content, inf_phone, inf_address, inf_picture) VALUES(:name, :content, :phone, :address, :picture) ');
		$insert->bindValue(':name',$post['name']);
		$insert->bindValue(':content',$post['content']);
		$insert->bindValue(':phone',$post['phone'], PDO::PARAM_INT);
		$insert->bindValue('address',$post['address']);
		$insert->bindValue(':picture',$uploadDir.$newPictureName);

		if($insert->execute())
		{
			$success = 'Informations rentrées';
		}
		else
		{
			die(var_dump($insert));
		}
	}


}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Modifier les information du site</title>
	<?php require_once '../inc/head.php'; ?>
</head>
<body>
	<main class="container">
		<?php require_once '../inc/menu_admin.php'; ?>
		<div class="jumbotron">
		<?php 
			if(isset($success))
			{
				echo '<p class="text-success">'.$success.'</p>';
			}

			if($displayForm):
		?>
			<form method="post" class="form-horizontal" enctype="multipart/form-data">
			<?php 
				if(isset($errorsText))
				{
					echo '<p class="text-danger">'.$errorsText.'</p>';
				}
			?>
				<div class="form-group">
					<label for="name">Nom du restaurant</label>
					<input type="text" name="name" id="name" required class="form-control">
				</div>

				<div class="form-group">
					<label for="phone">numéro de tel</label>
					<input type="text" name="phone" id="phone" required class="form-control">
				</div>

				<div class="form-group">
					<label for="content">Description du restaurant</label>
					<textarea name="content" id="content" cols="30" rows="10" required class="form-control"></textarea>
				</div>

				<div class="form-group">
					<label for="address">Adresse du restaurant</label>
					<input type="text" name="address" id="address" required class="form-control">
				</div>

				<div class="form-group">
					<label for="picture">Photo de couverture</label>
					<input type="file" name="picture" id="picture" required accept="image/*">
				</div>
				
				<div class="text-center">
					<input type="submit" class="btn btn-primary" value="Envoyer">
				</div>
			</form>
		<?php 
			endif;
		?>
		</div>
	</main>
	<?php require_once '../inc/script.php'; ?>
</body>
</html>