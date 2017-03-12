<?php 

session_start();

require_once '../inc/connect.php';

$err = array(); //contiendra les erreurs 
$display = true; //permet l'affichage du formulaire

if(!empty($_POST))//si le formulaire est soumis
{

	foreach($_POST as $key => $value)
	{
		$post[$key] = trim(strip_tags($value)); //nettoyages des données, enlever les tags html et les espaces de début/fin
	}

	if(!filter_var($post['ident'], FILTER_VALIDATE_EMAIL))//si le mail n'a pas un bon format
	{
		$err[] = 'Veuillez saisir votre identifiant';
	}

	if(empty($post['passwd']))//si le mdp est vide
	{
		$err[] = 'Veuillez saisir votre mot de passe';
	}

	if(count($err) > 0) //s'il y a au moins 1 erreur
	{		
		$formError = true;
	}
	else 
	{
		#preparation de ma requette
		$req = $bdd->prepare('SELECT * FROM users, role WHERE usr_rol_id = rol_id AND usr_email = :login LIMIT 1');
		$req->bindValue(':login', $post['ident']);

		if($req->execute())//s'il n'y a pas de probleme a l'execution et que la requette renvoie des données
		{
			$user = $req->fetch();
			if(!empty($user))
			{
				if(password_verify($post['passwd'], $user['usr_password']))//verification de la correspondance du mdp recu et celui en bdd
				{
					#assignation a mon tableau session des données relatives a mon utilisateur
					$_SESSION = array(
							'id'    => $user['usr_id'],
							'nom' 	=> $user['usr_lastname'],
							'prenom'=> $user['usr_firstname'],
							'email' => $user['usr_email'],
							'role'	=> $user['rol_name']
							);
					$_SESSION['is_logged'] = true;//variable pour permettre une certaine aisance dans certaine manipulation, quant a savoir si l'utilisateur est connecté
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
			die(var_dump($req->errorInfo())); //affiche les erreurs d'execution de la requete et arrete le script 
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
	<?php include '../inc/menu_admin.php'; ?>
		<div class="jumbotron">
			<?php 
				if(isset($formError) && $formError)
				{
					#s'il y a des erreur, on affiche les erreurs
					echo '<p class="error">'.implode('<br>', $err).'</p>';
				}
				if(isset($errorLogin) && $errorLogin)
				{
					echo '<p class="error">Erreur d\'identifiant ou de mot de passe</p>';
				}

				if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['email']))
				{
					echo '<p class="success">Bonjour '.$_SESSION['prenom']. ' ' . $_SESSION['nom'];
					//echo '<br>Tu es déjà connecté :-)</p>';
				}
				#gere l'affichage du formulaire en fonction de la valeur de display
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
					<a href="psw_recorver.php">Mot de passe oublié ?</a>
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