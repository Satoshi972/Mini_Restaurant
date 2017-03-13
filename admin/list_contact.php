<?php 
session_start(); // Permet de démarrer la session

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

$list_contact = $bdd->prepare('SELECT * FROM contacts');
if($list_contact->execute())
{
	$contacts =  $list_contact->fetchAll(PDO::FETCH_ASSOC);
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
</head>
<body>
	<?php require_once 'inc/menu_admin.php' ?>
	<div>
	
	</div>
	<?php require_once '../inc/script.php' ?>
</body>
</html>