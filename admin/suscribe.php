<?php
session_start();

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

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

if(!empty($_POST))
{
	
	$post= array_map('trim', array_map('strip_tags', $_POST));

	if(!preg_match('#^[a-z0-9._-]{3,}$#', $post['firstname']))
	{
		$error[] = 'Le prénom doit faire au moins 3 caractères';
	}

	if(!preg_match('#^[a-z0-9._-]{3,}$#', $post['lastname']))
	{
		$error[] = 'Le nom doit faire au moins 3 caractères';
	}

	if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $post['email'])) 
	{
		$error[] = 'L\'adresse email est invalide';
	}

	if(!preg_match('#^[a-z0-9._-]{8,20}$#', $post['password'])) 
	{
		$error[] = 'Le mot de passe doit comporter entre 8 et 20 caractères maximum';
	}

	if(!is_numeric($post['role']))
	{
		$error[] = 'Erreur lors du choix du role';
	}


	if(count($error) > 0)
	{		
		$formError = true;
	}
	else 
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
			header('Location: list_users.php'); // On redirige vers la page de connexion
			die();
		}
		else
		{
			var_dump($req->errorInfo());
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title>Inscription</title>

	<?php include '../inc/head.php'; ?>

	<link rel="stylesheet" type="text/css" href="assets/css/styleAdmin.css">


</head>
<body>
	<?php include 'inc/menu_admin.php'; ?>
	<main class="container">
		<?php 
				// include '../inc/menu_admin.php';
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
				<label for="role">Rôle</label>
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