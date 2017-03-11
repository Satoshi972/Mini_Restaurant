<?php
session_start();

require_once 'inc/connect.php';

// Permet de vérifier que mon id est présent et de type numérique
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	$recipe_id = (int) $_GET['id'];

	// On sélectionne la recette pour être sur qu'elle existe et faire un rappel
	$select = $bdd->prepare('SELECT * FROM recipe WHERE id = :idRecipe');
	$select->bindValue(':idRecipe', $recipe_id, PDO::PARAM_INT);

	if($select->execute()){
		$my_recipe = $select->fetch(PDO::FETCH_ASSOC);
	}
	if(!empty($_POST)){
		// Si la valeur du champ caché ayant pour name="action" est égale a delete, alors je supprime
		if(isset($_POST['action']) && $_POST['action'] === 'delete'){
			$delete = $bdd->prepare('DELETE FROM recipe WHERE id = :idRecipe');
			$delete->bindValue(':idRecipe', $recipe_id, PDO::PARAM_INT);

			if($delete->execute()){
				$success = 'La recette a bien été supprimée';
			}
			else {
				var_dump($delete->errorInfo()); 
				die;
			}
		}
	}
}


?><!DOCTYPE html>
<html>
	<head>
	<?php include_once 'inc/head.php'; ?>
		<meta charset="utf-8">
		<title>Supprimer une recette</title>
	</head>
	<body>
		<?php include_once 'inc/menu.php'; ?>

		<?php if(!isset($my_recipe) || empty($my_recipe)):
		var_dump($my_recipe);?>
		<p class="alert alert-danger" role="alert"><strong>Désolé</strong>, aucune recette correspondante</p>

		<?php elseif(isset($success)): ?>
		<?php echo $success; ?>

		<?php else: ?>
		<p class="alert alert-danger" role="alert">Voulez-vous supprimer : <?=$my_recipe['rcp_title'].' '.$my_recipe['rcp_content']. ' - '.$my_recipe['rcp_picture'];?>

		<form method="post">

			<input type="hidden" name="action" value="delete">

			<!-- history.back() permet de revenir à la page précédente -->
			<button type="button" onclick="javascript:history.back();">Annuler</button>
			<input type="submit" value="Supprimer cet utilisateur">
		</form>
		<?php endif; ?>
		<?php include_once 'inc/script.php'; ?>

	</body>
</html>