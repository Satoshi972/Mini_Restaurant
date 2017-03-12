<?php
session_start();

require_once '../inc/connect.php';

// Permet de vérifier que mon id est présent et de type numérique
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){

	$recipe_id = (int) $_GET['id'];

	// On sélectionne la recette pour être sur qu'elle existe et faire un rappel
	$select = $bdd->prepare('SELECT * FROM recipe WHERE rcp_id = :idRecipe');
	$select->bindValue(':idRecipe', $recipe_id, PDO::PARAM_INT);

	if($select->execute()){
		$my_recipe = $select->fetch(PDO::FETCH_ASSOC);
	}
	if(!empty($_POST)){
		// Si la valeur du champ caché ayant pour name="action" est égale a delete, alors je supprime
		if(isset($_POST['action']) && $_POST['action'] === 'delete'){
			$delete = $bdd->prepare('DELETE FROM recipe WHERE rcp_id = :idRecipe');
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
		<?php include_once '../inc/head.php'; ?>
		<link rel="stylesheet" href="../assets/css/style.css">
		<meta charset="utf-8">
		<title>Supprimer une recette</title>
	</head>
	<body>
		<main class="page">
			<?php include_once '../inc/menu.php'; ?>

			<div id="content" class=" well container">
				<section class="row">
					<div class="contact col-xs-12">

						<?php if(!isset($my_recipe) || empty($my_recipe)): ?>

						<p class="alert alert-danger" role="alert"><strong>Désolé</strong>, aucune recette correspondante</p>

						<?php elseif(isset($success)): ?>
						<?php echo $success; ?>

						<?php else: ?>
						<p class="alert alert-danger" role="alert">Voulez-vous supprimer :<strong> <?=$my_recipe['rcp_title'];?></strong></p>

						<form method="post">

							<input type="hidden" name="action" value="delete">

							<!-- history.back() permet de revenir à la page précédente -->
							<button type="button" class="btn btn-default btn-sm" onclick="javascript:history.back();">Annuler</button>
							<button class="btn btn-default btn-sm" type="submit" value="Supprimer cette recette">Supprimer cette recette   <span class="glyphicon glyphicon-remove"></span></button>
						</form>
						<p class="list"><pre><?=$my_recipe['rcp_title'].'<br><br> '.$my_recipe['rcp_content'];?></pre></p>
					<?php endif; ?>
					<?php include_once '../inc/script.php'; ?>

					</div>
				</section>
			</div>
		</main>
	</body>
</html>