<?php
session_start();

if(isset($_GET['loggout']) && ($_GET['loggout'] == 'yes')) //si loggout est passé en paramettre dans l'url et que c'est egal a yes
{
	unset($_SESSION['nom'], $_SESSION['prenom'], $_SESSION['email'], $_SESSION['role'], $_SESSION['is_logged']); //on retire les entré de notre tableau
	session_destroy();
	header('Location: loggin.php');//redirection apres destrution de la session
	die();//fin du script
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Déconnexion</title>
	<meta charset="utf-8">
	<?php include '../inc/head.php'; ?>
</head>
<body>

	<main class="container">
		<?php 
		include '../inc/menu_admin.php';
		?>
		<div class="jumbotron">
			<?php 
			#s'il y a une session active, alors
			if(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['email'])): ?>
					<p style="text-align:center;">
						<?php echo $_SESSION['prenom']; ?>, veux-tu te déconnecter ? Vraiment ?

						
						<br><br>

						<a href="log_out.php?loggout=yes">Oui, je veux me déconnecter</a>
					</p>

				<?php else: ?>
					<p style="text-align:center;">
						Vous etes déjà déconnecté
					</p>
			<?php 
			endif; ?>
		</div>
		
	</main>


<?php include '../inc/script.php' ;?>
</body>
</html>