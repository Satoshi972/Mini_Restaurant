<?php

session_start();
require_once '../inc/connect.php';

#requette pour afficher les role de façon dynamique 
$sql = $bdd->prepare('SELECT * FROM role');
if($sql->execute())
{
	$role= $sql->fetchAll(PDO::FETCH_ASSOC);
}
else
{
	die(var_dump($sql));
}



$error = array(); 
$post = array();

#si le formulaire est soumis, ont verrifie les données, apres les avoir nettoyer des espaces de debut et de fin + des tags html, php js
if(!empty($_POST))
{
	foreach($_POST as $key => $value)
	{
		$post[$key] = trim(strip_tags($value));
	}

	if(strlen($post['firstname']) < 3)
	{
		$error[] = 'Le prénom doit faire au moins 3 caractères';
	}

	if(strlen($post['lastname']) < 3)
	{
		$error[] = 'Le nom doit faire au moins 3 caractères';
	}

	if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL))
	{
		$error[] = 'L\'adresse email est invalide';
	}

	if(strlen($post['password']) < 8 || strlen($post['password']) > 20)
	{
		$error[] = 'Le mot de passe doit comporter entre 8 et 20 caractères maximum';
	}

	if(!is_numeric($post['role']))
	{
		$error[] = 'Erreur lors du choix du role';
	}

	if(count($error) > 0) //s'il y a une erreur on affiche la "section" des erreur, qui afficherons les erreur relevées
	{		
		$formError = true;
	}
	else //sinon on envoie les données dans la base de données
	{
		$req = $bdd->prepare('INSERT INTO users(usr_firstname, usr_lastname, usr_email, usr_password, usr_subscribedate, usr_rol_id) VALUES(:prenom, :nom, :email, :mdp, now(), :rol_id)');
		$req->bindValue(':prenom', $post['firstname'], PDO::PARAM_STR);
		$req->bindValue(':nom', $post['lastname'], PDO::PARAM_STR);
		$req->bindValue(':email', $post['email'], PDO::PARAM_STR);
		$req->bindValue(':mdp', password_hash($post['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
		$req->bindValue(':rol_id', $post['role']);
		if($req->execute())
		{
			$createSuccess = true;
			header('Location: loggin.php'); // On redirige vers la page de connexion
			die();
		}
		else
		{
			var_dump($req->errorInfo()); //afficher une erreur si l'envoi a la base de données c'est mal produite
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<meta charset="utf-8">
	<?php include '../inc/head.php' ;?>
</head>
<body>
	<main class="container">
		<?php 
				include '../inc/menu_admin.php';
				if(isset($formError) && $formError)
				{ 
					echo '<p class="error">'.implode('<br>', $error).'</p>';
				}
				if(isset($createSuccess) && $createSuccess)
				{
					echo '<p class="success">Votre inscription est réussie !</p>';
				}
			?>
		<form method="post" class="form-horizontal jumbotron">

			<div class="form-group">
			<label for="firstname">Prénom</label>
			<input class="form-control" type="text" id="firstname" name="firstname" placeholder="Votre prénom.." required>
			</div>

			<div class="form-group">
			<label for="lastname">Nom</label>
			<input class="form-control" type="text" id="lastname" name="lastname" placeholder="Votre nom de famille.." required>
			</div>

			<div class="form-group">
			<label for="email">Email</label>
			<input class="form-control" type="email" id="email" name="email" placeholder="votre@email.fr">
			</div>

			<div class="form-group">
			<label for="password">Mot de passe</label>
			<input class="form-control" type="password" id="password" name="password" placeholder="Un mot de passe super compliqué" required>
			</div>

			<div class="form-group">
				<label for="role">Role</label>
				<select class="selectpicker" id="role" name="role"  required>
					<?php foreach ($role as $key => $value): ?>
						<option value="<?php echo $value['rol_id'] ?>"><?php echo $value['rol_name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="text-center">
			<input type="submit" value="Envoyer" class="btn btn-default">
			</div>

		</form>
	</main>
			
	<?php include '../inc/script.php' ;?>

</body>
</html>