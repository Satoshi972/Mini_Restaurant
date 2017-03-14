<?php
require_once 'inc/connect.php';

//- Definitions des variables
$user   = [];
$errors = [];

$site_info = $bdd->prepare('SELECT * FROM site_info ORDER BY inf_id DESC LIMIT 3');
if($site_info->execute())
{
	$info = $site_info->fetch(PDO::FETCH_ASSOC);
}
else
{
	die(var_dump($site_info->errorInfo()));
}


if(!empty($_POST)) { // si le tableau n'est pas vide alors on fait une boucle qui verifie les valeurs de chaque input, récupere pour chaque clé sa valeur et regarde si il n'y a pas d'espaces avant et apres
	foreach($_POST as $key => $value){ //
		$user[$key] = trim(strip_tags($value));// sert a retirer les balises html ou php.  
	}
	if(!preg_match('#^[A-z0-9._-]{3,}$#',$user["last_name"])) {
		$errors[] = "<p>Votre nom doit être complété</p><br>";
	}

	if(!preg_match('#^[A-z0-9._-]{3,}$#',$user["first_name"])) {
		$errors[] = "<p>Votre prénom doit être complété</p><br>";
	}
	if(!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $user['email'])){
		$errors[] = "<p>Votre EMAIL est invalide !!!</p><br>";         
	}
	if(!preg_match('#^[a-z0-9._-]{10,}$#',$user["comment"])) {
		$errors[] = "<p>Votre message doit être complété</p><br>";
	}

	if(count($errors) === 0) {

		$req = $bdd->prepare("INSERT INTO contacts (cts_content,cts_date) VALUES(:cts_content, now() )");

		$req->bindValue(":cts_content", json_encode($user));


		if($req->execute()) {
			$success = 'Merci, votre message est parti avec succès.';

		} else {
			// Erreur de développement
			var_dump($req->errorInfo());
			die; // alias de exit(); => die('Hello world');
		}

	} else {
		$textErrors = implode('<br>', $errors);
	}

}

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Contact</title>

		<?php include_once 'inc/head.php'; ?>

	</head>

	<body>

		<?php require_once 'inc/navFront.php'; ?>
		<main class="page">

			<div id="content" class="container">
				<?php
				if(isset($textErrors)){ ?>
				<div class="alert alert-danger" role="alert">
					<?php echo '<p>'.$textErrors.'</p>'; ?>
				</div>
				<?php }
				if(isset($success)){ ?>
				<div class="alert alert-success" role="alert">
					<?php echo '<p>'.$success.'</p>'; ?>
				</div>
				<?php }
				?>
				<form class="well form-horizontal" method="post" id="contact_form">
					<fieldset>
						<!-- Form Name -->
						<legend class="nameForm">Contactez-nous!</legend>

						<!-- last_name-->
						<div class="form-group">
							<label class="col-md-3 control-label" >Nom</label> 
							<div class="col-md-6 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input name="last_name" placeholder="Nom" class="form-control"  type="text">
								</div>
							</div>
						</div>

						<!-- first_name-->

						<div class="form-group">
							<label class="col-md-3 control-label">Prénom</label>  
							<div class="col-md-6 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input  name="first_name" placeholder="Prénom" class="form-control"  type="text">
								</div>
							</div>
						</div>

						<!-- email-->

						<div class="form-group">
							<label class="col-md-3 control-label">E-Mail</label>  
							<div class="col-md-6 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
									<input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
								</div>
							</div>
						</div>

						<!-- Text area -->

						<div class="form-group">
							<label class="col-md-3 control-label">Message</label>
							<div class="col-md-6 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
									<textarea class="form-control"  rows="5" name="comment" placeholder="Votre message"></textarea>
								</div>
							</div>
						</div>

						<!-- Success message -->
						<div class="alert alert-success" style="display: none" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Merci de vous contacter, nous vous repondrons au plus vite !!!</div>

						<!-- Button -->
						<div class="form-group text-center">
							<label class="col-md-4 control-label"></label>
							<div class="col-md-4">
								<button type="submit" class="btn btn-warning" >Envoyer <span class="glyphicon glyphicon-send"></span></button>
							</div>
						</div>

					</fieldset>
				</form>
			</div><!-- /.container -->
			
			<?php include_once 'inc/script.php'; ?>
			
		
		</main>
		<?php require_once 'inc/footer.php'; ?>

			</body>
			</html>