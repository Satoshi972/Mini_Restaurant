<?php 

session_start();

require_once '../inc/connect.php';

$err = array();
$display = true;

if(!empty($_POST))
{

	foreach($_POST as $key => $value)
	{
		$post[$key] = trim(strip_tags($value));
	}

	if(!filter_var($post['ident'], FILTER_VALIDATE_EMAIL))
	{
		$err[] = 'Veuillez saisir votre identifiant';
	}

	if(empty($post['passwd']))
	{
		$err[] = 'Veuillez saisir votre mot de passe';
	}

	if(count($err) > 0)
	{		
		$formError = true;
	}
	else 
	{
		$req = $bdd->prepare('SELECT * FROM users, role WHERE usr_rol_id = rol_id AND usr_email = :login LIMIT 1');
		$req->bindValue(':login', $post['ident']);

		if($req->execute())
		{
			$user = $req->fetch();
			if(!empty($user))
			{
				if(password_verify($post['passwd'], $user['usr_password']))
				{
					$_SESSION = array(
							'id'    => $user['usr_id'],
							'nom' 	=> $user['usr_lastname'],
							'prenom'=> $user['usr_firstname'],
							'email' => $user['usr_email'],
							'role'	=> $user['rol_name']
							);
					$_SESSION['is_logged'] = true;
					$display = false;
				}
				else 
				{ 
					$errorLogin = true;
				}
			}
			else 
			{ 
				$errorLogin = true; 
			}
		}
		else
		{
			die(var_dump($req->errorInfo()));
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Connexion</title>
	<meta charset="utf-8">
	<?php include '../inc/head.php';?>
</head>
<body>

	<main class="container">
	<?php include '../inc/menu.php'; ?>
		<div class="jumbotron">
			<?php 
				if(isset($formError) && $formError){
					echo '<p class="error">'.implode('<br>', $err).'</p>';
				}
				if(isset($errorLogin) && $errorLogin){
					echo '<p class="error">Erreur d\'identifiant ou de mot de passe</p>';
				}

				if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['email']))
				{
					echo '<p class="success">Salut '.$_SESSION['prenom']. ' ' . $_SESSION['nom'];
					//echo '<br>Tu es déjà connecté :-)</p>';
				}
				if(isset($display) && $display):
			?>

			<form method="POST" class="form-horizontal">
				<div class="form-group">
					<label for="ident">Identifiant</label>
					<input class="form-control" type="email" id="ident" name="ident" placeholder="votre@email.fr">
				</div>
				

				<div class="form-group">
					<label for="passwd">Mot de passe</label>
					<input class="form-control" type="password" id="passwd" name="passwd" placeholder="Votre mot de passe">
				</div>
				

				<div class="text-center">
					<input type="submit" value="Se connecter" class="btn btn-default">
				</div>
				
			</form>
		<?php endif; ?>
		</div>
		
	</main>
	<?php include '../inc/script.php' ?>
</body>
</html>