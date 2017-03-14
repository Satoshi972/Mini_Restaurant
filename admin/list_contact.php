<?php 
session_start(); // Permet de démarrer la session

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

$list_contact = $bdd->prepare('SELECT * FROM contacts ORDER BY cts_id DESC');
if($list_contact->execute())
{
	$contacts =  $list_contact->fetchAll(PDO::FETCH_ASSOC);
	//var_dump($contacts);
}
else
{
	die(var_dump($list_contact));
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Liste des fiches de contact</title>
	<?php require_once '../inc/head.php' ?>
	<link rel="stylesheet" type="text/css" href="./assets/css/styleAdmin.css">
</head>
<body>
	<?php require_once 'inc/menu_admin.php' ?>
	<div class="container">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($contacts as $key => $value):
				?>
				<tr>
					<td><?php echo $value['cts_id'] ?></td>
					<td><?php echo $value['cts_date'] ?></td>
					<td><a href="view_contact.php?id=<?php echo $value['cts_id'];?>">Voir plus...</a></td>
				</tr>
				<?php 
					endforeach;
				?>
			</tbody>
		</table>
	</div>
	<?php require_once '../inc/script.php' ?>
</body>
</html>