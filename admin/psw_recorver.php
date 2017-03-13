<?php 
require_once '../inc/connect.php';

if(!empty($_POST))
{
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(!filter_var($post['email'],FILTER_VALIDATE_EMAIL))
	{
		$error = 'Erreur mail non valide';

	}else{

		$sql = $bdd->prepare('SELECT usr_id, usr_email FROM users WHERE usr_email = :email');

		$sql->bindValue(':email',$post['email']);

		if($sql->execute())
		{
				$info = $sql->fetch(PDO::FETCH_ASSOC);
				
				$nbretour = count($info);

				if($nbretour == 2){
					
					$token = md5($info['usr_email']);

					$insert= $bdd->prepare('INSERT INTO reset_password (psw_token, psw_usr_id) VALUES (:token, :userId) ');
					$insert->bindValue(':token', $token);
					$insert->bindValue(':userId',$info['usr_id']);

					if($insert->execute()){


							$data = "<a href='psw_recorver_update?token=".$token."'>Votre lien de récupération</a>";							

							mail($post['email'],'Réinitialisation de mot de passe', $data);

							
					}else
					{
						die(var_dump($insert->errorInfo()));
					}
				}else{
					$error = 'email inconnu ! ';
				}
		}else
		{
			die(var_dump($sql->errorInfo()));
		}
	}
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Récuperation de mot de passe</title>
	<?php require_once '../inc/head.php'; ?>
</head>
<body>
	<main class="container">

		<?php require_once '../inc/menu_admin.php'; ?>
		<div class="jumbotron">

			<form method="post" class="formhorizontal">
				<legend>Récupération de mot de passe</legend>

				<?php 	
					if(isset($error))
					{
						echo '<p class="text-danger">'.$error.'</p>';
					}
				 ?>

				<div class="form-group">
					<label for="email">Rentrez votre email</label>
					<input type="mail" class="form-control" name="email" id="email" placeholder="email@mail.mail" required>
				</div>

				<div class="text-center">					
				<input type="submit" class="btn btn-primary">
				</div>
			</form>
			
		</div>
	</main>
	<?php require_once '../inc/script.php'; ?>
</body>
</html>