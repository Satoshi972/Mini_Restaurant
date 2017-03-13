<?php 
session_start();


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


							// le header indispenssable pour des mail avec du html
							// To send HTML mail, the Content-type header must be set
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";


							$siteAdd = $_SERVER['SERVER_NAME'];

							// $data = "<a href='psw_recorver_update?token=.$token.'>Votre lien de récupération</a>";
							$data = "<a href='http://localhost/WF3_PERDAF/GitubProject/Projet WF3/Mini_Restaurant/admin/psw_recorver_update.php?token=.$token.'>Changer votre mot de passe</a>";


							mail($post['email'],'Réinitialisation de mot de passe', $data, $headers);

							
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
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Récuperation de mot de passe</title>

	<?php include '../inc/head.php'; ?>



</head>
<body>

	<main class="container">

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