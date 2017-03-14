<?php 
session_start(); // Permet de démarrer la session

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

$users = $bdd->prepare('SELECT usr_id, user_lastname, user_firstname FROM users');
if($users->execute())
{
	$res = fetchAll->FetchAll(PDO::FECTH_ASSOC);
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
</head>
<body>
	<?php require_once '../inc/menu_admin.php' ?>
	<div>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prémon</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				foreach ($res as $key => $value):
			?>
				<tr><?php echo $value['usr_firstname'];?></tr>
				<tr><?php echo $value['usr_lastname'];?></tr>
				<tr><a href="delete_user.php?id=<?php echo $value['usr_id'];?>"></a></tr>
			<?php 
				endforeach;
			?>
			</tbody>
		</table>
	</div>
	<?php require_once '../inc/script.php' ?>
</body>
</html>