<?php 
require_once '../inc/connect.php';

$displayForm = true;

if(isset($_GET['token']) && !empty($_GET['token']))
{

	$checkToken = $bdd->prepare("SELECT * FROM reset_password WHERE psw_token = :token");
	$checkToken->bindValue(':token',$GET['token']);

	if($checkToken->execute())
	{
		if(!empty($_POST))
		{
			$post = trim(strip_tags($_POST));
		}

		if(strlen($post['password'])<8)
		{
			$error = 'Le mot de passe doit fait minimum 8 charactères';
		}

		if(!isset($error))
		{
			$change_psw = $bdd->prepare('UPDATE users, reset_password SET (usr_psw) VALUES (:psw) WHERE urs_id = psw_urs_psw');
			$change_psw-> bindValue(':psw', password_hash($post['password'],PASSWORD_DEFAULT));

			if($change_psw->execute())
			{
				$del = $bdd->prepare('DELETE FROM reset_password WHERE psw_token = :token');
				$del->bindValue('token', $GET['token']);

				if(!$del->execute())
				{
					die(var_dump($del->errorInfo()));
				}
			}
			else
			{
				die(var_dump($change_psw->errorInfo()));
			}
		}	
	}
	else
	{
		die(var_dump($checkToken->errorInfo()));
	}

}
else
{
	$displayForm = false;
	$error = 'Erreur, token non reconnu';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Récuperation de mot de passe</title>
	<!-- contien mes entetes de page -->   
	<?php require_once '../inc/head.php'; ?>
</head>
<body>
	<main class="container">
		
		<!-- contient mon menu -->
		<?php require_once '../inc/menu_admin.php'; ?>
		<div class="jumbotron">

			<?php 
				if($displayForm):
			?>
			<form method="post" class="formhorizontal">
				<legend>Récupération de mot de passe</legend>

				<?php 	
					if(isset($error))
					{
						echo '<p class="text-danger">'.$error.'</p>';
					}
				 ?>

				<div class="form-group">
					<label for="password">Rentrez votre nouveau mot de passe</label>
					<input type="password" class="form-control" name="password" id="password" placeholder="*******" required>
				</div>

				<div class="text-center">					
				<input type="submit" class="btn btn-primary">
				</div>
			</form>

				<?php 
					else:
						echo '<p class="text-danger">'.$error.'</p>';
					endif;
				?>
		</div>
	</main>
	<?php require_once '../inc/script.php'; ?>
</body>
</html>