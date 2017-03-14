<?php 
session_start(); // Permet de démarrer la session

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

$users = $bdd->prepare('SELECT usr_id, usr_lastname, usr_firstname FROM users');
if($users->execute())
{
	$res = $users->fetchAll(PDO::FETCH_ASSOC);
}
else
{
	die(var_dump($users));
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Liste des Utilisateurs</title>
	<?php require_once '../inc/head.php' ?>
	<link rel="stylesheet" type="text/css" href="./assets/css/styleAdmin.css">
</head>
<body>
	<?php require_once './inc/menu_admin.php' ?>
	
	<div class="container">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prémon</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($res as $key => $value): ?>
			<tr>
				<td><?php echo $value['usr_firstname'];?></td>
				<td><?php echo $value['usr_lastname'];?></td>
				<td><a href="delete_user.php?id=<?php echo $value['usr_id'];?>">+ d'infos</a></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php require_once '../inc/script.php' ?>
</body>
</html>