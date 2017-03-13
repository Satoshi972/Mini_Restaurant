<?php
session_start();

require_once './inc/verif_session.php';
require_once '../inc/connect.php';

// Permet de vérifier que mon id est présent et de type numérique
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']))
{

	$user_id = (int) $_GET['id'];
	
	// On sélectionne l'utilisateur et ses recettes pour être sur qu'elle existe et faire un rappel
	$select = $bdd->prepare('SELECT users.usr_lastname, users.usr_firstname, recipe.rcp_title, recipe.rcp_content FROM users INNER JOIN recipe ON users.usr_id = recipe.rcp_usr_id WHERE usr_id = :idUser');
	$select->bindValue(':idUser', $user_id, PDO::PARAM_INT);

	if($select->execute())
	{
		$my_user_recipe = $select->fetch(PDO::FETCH_ASSOC);
	} 
	
	if(!empty($_POST))
	{
		// Si la valeur du champ caché ayant pour name="action" est égale a delete, alors je supprime
		if(isset($_POST['action']) && $_POST['action'] === 'delete')
		{
			try
			{
				$delU = $bdd->prepare('DELETE FROM users WHERE usr_id = :id');
				$delU->bindValue(':id', $user_id, PDO::PARAM_INT);
				
				$delR = $bdd->prepare('DELETE FROM recipe WHERE rcp_usr_id = usr_id');
				$delR->bindValue(':id', $user_id, PDO::PARAM_INT);

				$delR->execute();
				$delU->execute();

				$success = 'La recette a bien été supprimée';

			}
			catch (Exception $e)
			{
				echo 'Exception reçue : ',  $e->getMessage(), "\n";
				die;
			}
		}
	}
}

?><!DOCTYPE html>
<html lang="fr">
<head>
<?php include_once '../inc/head.php'; ?>
	<meta charset="UTF-8">
	<title>Au revoir</title>
</head>
<body>
	<main class="page">
			<?php include_once '../inc/menu.php'; ?>

			<div id="content" class=" well container">
				<section class="row">
					<div class="contact col-xs-12">

						<?php if(!isset($my_user_recipe) || empty($my_user_recipe)): ?>

						<p class="alert alert-danger" role="alert"><strong>Désolé</strong>, aucun editeur correspondant</p>

						<?php elseif(isset($success)): ?>
						<?php echo $success; ?>

						<?php else: ?>
						<p class="alert alert-danger" role="alert">Voulez-vous supprimer l'editeur : <strong><?=$my_user_recipe['usr_lastname']. ' ' .$my_user_recipe['usr_firstname']. '</strong> et ses recettes : <strong>' .$my_user_recipe["rcp_title"]. '</srtong>'; ?></p>

						<form method="post">

							<input type="hidden" name="action" value="delete">

							<!-- history.back() permet de revenir à la page précédente -->
							<button type="button" class="btn btn-default btn-sm" onclick="javascript:history.back();">Annuler</button>
							<button class="btn btn-default btn-sm" type="submit" value="Supprimer cette recette">Supprimer cet editeur  <span class="glyphicon glyphicon-remove"></span></button>
						</form>
						<p class="list"><pre><?=$my_user_recipe['rcp_title'].'<br><br> '.$my_user_recipe['rcp_content'];?></pre></p>
					<?php endif; ?>
					<?php include_once '../inc/script.php'; ?>

					</div>
				</section>
			</div>
		</main>
	
</body>
</html>