<?php

require_once 'inc/connect.php';

// On selectionne les colonnes id & title de la table recettes
$select = $bdd->prepare('SELECT rcp_id,	rcp_title FROM recipe ORDER BY rcp_id DESC');
if($select->execute()){
	$restaurant = $select->fetchAll(PDO::FETCH_ASSOC);
}
else {
	var_dump($select->errorInfo());
	die;
}

?><!DOCTYPE html>
<html>
	<head>
		<?php include_once 'inc/head.php'; ?>
		<meta charset="utf-8">
		<title>Liste de recettes</title>
	</head>
	<body>
		<?php include_once 'inc/menu.php'; ?>
		<section class="row">
			<!-- En-Tête de Présentation -->
			<div class="contact col-xs-12">
				<h1>Les recettes</h1>
				<br>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Recette</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($restaurant as $recipe): ?>
						<tr>
							<td><?=$recipe['rcp_title']; ?></td>
							
							<td>
								<a href="view_recipe.php?id=<?=$recipe['rcp_id']; ?>">
									Visualiser cette recette
								</a>
							</td>
							<td>
								<a href="delete_recipe.php?id=<?=$recipe['rcp_id']; ?>"><button type="button" class="btn btn-default btn-sm">
								<span class="glyphicon glyphicon-remove"></span> Remove 
								</button>
					</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php include_once 'inc/script.php'; ?>
	</body>
</html>