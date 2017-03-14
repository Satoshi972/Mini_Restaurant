<?php 
session_start(); // Permet de démarrer la session

require_once 'inc/verif_session.php';
require_once '../inc/connect.php';

$displayForm = false;

if(isset($_GET['id']) && !empty($_GET['id']))
{
	$getId = (int) $_GET['id'];
	$displayForm = true;
}

$list_contact = $bdd->prepare('SELECT * FROM contacts WHERE cts_id = :id');
$list_contact->bindValue(':id', $getId, PDO::PARAM_INT);

if($list_contact->execute())
{
	$contacts =  $list_contact->fetch(PDO::FETCH_ASSOC);
}
else
{
	die(var_dump($list_contact));
}

$post = [];
$errors = [];

if(!empty($_POST))
{
	$post = array_map('trim', array_map('strip_tags', $_POST));

	$update = $bdd->prepare('UPDATE contacts SET cts_statuts= :statut WHERE cts_id = :id');
	$update->bindValue(':statut', $post['statut'], PDO::PARAM_BOOL);
	$update->bindValue(':id', $getId, PDO::PARAM_INT);

	if($update->execute())
	{
		$success = 'Statut mis a jour';
	}
	else
	{
		die(var_dump($update->errorInfo()));
	}

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Liste des fiches de contact</title>
	<?php include '../inc/head.php'; ?>

	<link rel="stylesheet" type="text/css" href="assets/css/styleAdmin.css">
</head>
<body>
	<?php require_once 'inc/menu_admin.php' ?>
	<div class="container">
		

		<div class="jumbotron text-center">
			<?php 
				if($displayForm){
			?>
			<div class="list-group-item">
				<h4 class="list-group-item-heading">#</h4>
				<p class="list-group-item-text"><?php echo $contacts['cts_id'] ;?></p>
			</div>	

			<div class="list-group-item">
				<h4 class="list-group-item-heading">Date</h4>
				<p class="list-group-item-text"><?php echo $contacts['cts_date']; ?></p>
			</div>	
			<div class="list-group-item">
				<h4 class="list-group-item-heading">Contenu</h4>
				<p class="list-group-item-text"><?php 

				$infoContact = json_decode($contacts['cts_content'], true);
					
					echo '<p>Prenom :'.($infoContact['first_name']).'</p>';
					echo '<p>Nom :'.($infoContact['last_name']).'</p>';
					echo '<p>Email :'.($infoContact['email']).'</p>';
					echo '<p>Message :'.($infoContact['comment']).'</p>';

				?></p>
			</div>	
			<form method="post">
				Marquer comme lu :<input type="checkbox" value="1" name="statut">	<br>
				<input type="submit" class="btn btn-primary" value="Modifier le statut">
			</form>
			<?php 
				}elseif(isset($success)){
					echo '<p class="text-success">'.$success.'</p>';
				}
				else{
					echo '<p class="text-info"> Aucune fiche sélectionnée </p>';
				}

			?>
		</div>
		</div>
	<?php require_once '../inc/script.php' ?>
</body>
</html>