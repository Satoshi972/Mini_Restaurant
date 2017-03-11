<?php 
require_once '../inc/connect.php';

if(!empty($_POST))
{
	$post = trim(strip_tags($_POST));

	if(!filter_var($post,FILTER_VALIDATE_EMAIL))
	{
		$error = 'Erreur mail non valide';
	}
	if(!isset($error))
	{
		$sql = $bdd->prepare('SELECT usr_id, usr_email FROM users WHERE usr_email = :email');
		$sql->bindValue(':email',$post['email']);

		if($sql->execute())
		{
			$info = $sql->fetch(PDO::FETCH_ASSOC);
			die(var_dump($info));

			$insert= $bdd->prepare('INSERT INTO reset_password (psw_token, psw_usr_id) VALUES (:token, :userId) ');
			$insert->bindValue(':token',md5($post['usr_email']));
			$insert->bindValue(':userId',$info['usr_id']);

			if($insert->execute())
			{
				#récupération du token envoyé pour l'envoyer a l'utilisateur via mail afin de vérifier son identitée
				$mail = $bdd->prepare("SELECT LAST(*) FROM reset_password WHERE psw_usr_id = :userId");
				$mail->bindValue(':userId',$info['usr_id']);

				if($mail->execute())
				{
					$token = $mail->fetch(PDO::FETCH_ASSOC);
					
					#  https://www.w3schools.com/php/func_mail_mail.asp
					# Envoi du mail contenant le token a l'utilisateur, token qui servira de verification
				}
				else
				{
					die(var_dump($mail->errorInfo()));
				}

			}
			else
			{
				die(var_dump($insert->errorInfo()));
			}

		}
		else
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