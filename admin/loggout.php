<?php
session_start();

require_once 'inc/verif_session.php';

if(isset($_GET['loggout']) && ($_GET['loggout'] == 'yes'))
{
	unset($_SESSION['nom'], $_SESSION['prenom'], $_SESSION['email'], $_SESSION['role']); 
	session_destroy();
	header('Location: ./loggin.php');
	die();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Déconnexion</title>

	<?php include '../inc/head.php'; ?>

</head>
<body>

	<?php include './inc/menu_admin.php'; ?>
		<main class="container">

		<div class="jumbotron">
			<?php 

			if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['email'])): ?>
					<p style="text-align:center;">
						<?php echo $_SESSION['prenom']; ?>, veux-tu te déconnecter ? Vraiment ?

						<br><br>
						<img src="http://ronron.e-monsite.com/medias/images/chaton-triste.jpg" style="height:200px;border-radius:10px;">
					
						<br><br>

						<a href="loggout.php?loggout=yes">Oui, je veux me déconnecter</a>
					</p>

				<?php else: ?>
					<p style="text-align:center;">
						Tu es déjà déconnecté, tu n'existes pas !!

						<br><br>
						<img src="http://captainquizz.s3.amazonaws.com/quizz/551aeb19366880.99678770.jpg" style="height:200px;border-radius:10px;">
					</p>
			<?php 
			endif; ?>
		</div>
		
	</main>


<?php include '../inc/script.php' ;?>
</body>
</html>