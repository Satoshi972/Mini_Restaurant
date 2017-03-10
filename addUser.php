<?php 
session_start();
require_once 'inc/connect.php';

?>
	<!DOCTYPE html>
	<html lang="fr">

	<head>
		<?php include_once 'inc/head.php'; ?>
			<meta charset="UTF-8">
			<title>AjoutUser</title>
	</head>

	<body>
		<main class="container">

			<section class="row">
				<!-- En-Tête de Présentation -->
				<div class="contact col-xs-12">
					<h1>Gestion de mes Contacts</h1>
				</div>

				<?php if(isset($success)): ?>
					<p style="color:green;">
						<?php echo $success; ?>
					</p>
					<?php endif; ?>


			</section>

			<section class="row">

				<!-- Début Formulaire -->
				<div class="col-sm-12">
					<form id="contact" class="form-horizontal well" method="post" action=" " method="post">
						<fieldset>

							<!-- Nom du Formulaire -->
							<legend>Ajouter un Contact</legend>

							<!-- Nom -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">Nom</label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input id="nom" name="nom" type="text" placeholder="Nom" class="form-control input-md">
									</div>
								</div>
							</div>

							<!-- Prénom -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">Prénom</label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input id="prenom" name="prenom" type="text" placeholder="Prénom" class="form-control input-md">
									</div>
								</div>
							</div>

							<!-- Password -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">Password</label>
								<div class="col-md-8">
									<input id="password" name="password" type="text" placeholder="Mot de passe" class="form-control input-md">
								</div>
							</div>

							<!-- Email -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">Adresse Email</label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
										<input id="email" name="email" type="email" placeholder="Adresse Email" class="form-control input-md">
									</div>
								</div>
							</div>

							<!-- Téléphone -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">Téléphone</label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
										<input id="tel" name="tel" type="tel" placeholder="Téléphone" class="form-control input-md">
									</div>
								</div>
							</div>


							<!-- Adresse -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">Adresse</label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<input id="Adresse" name="adress" type="text" placeholder="Tapez votre adresse" class="form-control input-md">
									</div>
								</div>
							</div>

							<!-- Code postal -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">code postal</label>
								<div class="col-md-8">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
										<input id="zipcode" name="zipcode" type="text" placeholder="Votre code postal" class="form-control input-md">
									</div>
								</div>
							</div>


							<!-- Ville -->
							<div class="form-group">
								<label class="col-md-2 control-label" for="textinput">Ville</label>
								<div class="col-md-8">

									<input id="city" name="city" type="text" placeholder="Votre ville" class="form-control input-md">
								</div>
							</div>


							<!-- Bouton d'Envoi -->
							<div class="form-group">
								<div class="<col-xs-7></col-xs-7> col-xs-offset-3">
									<button type="submit" class="btn btn-primary" name="inscription" value="Ajouter le Contact">Ajouter le Contact<span class="glyphicon glyphicon-send"></span></button>
								</div>
							</div>

						</fieldset>
					</form>
				</div>
				<!-- /.col-sm-6 -->
				<!-- Fin Formulaire -->

			</section>
		</main>
	</body>

	</html>