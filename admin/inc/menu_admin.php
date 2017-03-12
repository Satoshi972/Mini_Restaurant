<?php
session_start();

if(isset($_SESSION['is_logged'])){
	$nomUser = $_SESSION['nom'];
	$prenomUser = $_SESSION['prenom'];
	$roleUser = $_SESSION['role'];
}else{
	header('location: ./../loggin.php');
}
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Menu admin</title>
	
	<?php include_once '../../inc/head.php'; ?>

	<link rel="stylesheet" type="text/css" href="../assets/css/styleAdmin.css">

</head>
<body>

	<nav class="sidebar">
		<div class="brand">
			<?php if($roleUser == 'admin'): ?>
				ADMINISTRATEUR
			<?php elseif ($roleUser == 'editor'): ?>
				EDITEUR
			<?php endif; ?>
		</div>
			<div class="navside">
				<ul>
					<li><a href="#">menu 1</a></li>
					<li><a href="#">menu 2</a></li>
					<li><a href="#">menu 3</a></li>
					<li><a href="#">menu 4</a></li>
				</ul>	
			</div>	
	</nav>
	<div class="content">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>

	
</body>
</html>