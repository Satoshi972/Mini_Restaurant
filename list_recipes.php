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
		<main class="page">

			<?php include_once 'inc/menu.php'; ?>
			<div id="content" class="container">
				<section class="row">
					<!-- En-Tête de Présentation -->
					<div class="contact col-xs-12">
						<h1 class="list">Les recettes</h1>
						<br>
						<table class="well table">
							<thead>
								<tr>
									<th class="list">Nom</th>
									<th class="list">Recette</th>
								</tr>
							</thead>

							<tbody>
								<?php foreach($restaurant as $recipe): ?>
								<tr>
									<td class="list"><?=$recipe['rcp_title']; ?></td>

									<td>
										<a href="view_recipe.php?id=<?=$recipe['rcp_id']; ?>"><button type="button" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-eye-open"></span>
											Visualiser cette recette</button>
										</a>
									</td>
									<td>
										<a href="admin/modif_recipe.php?id=<?=$recipe['rcp_id']; ?>"><button type="button" class="btn btn-info btn-sm">
											<span class="glyphicon glyphicon-edit"></span> Modifier
											</button>
										</a>
									</td>
									<td>
										<a href="admin/delete_recipe.php?id=<?=$recipe['rcp_id']; ?>"><button type="button" class="btn btn-info btn-sm">
											<span class="glyphicon glyphicon-remove"></span> Remove 
											</button>
										</a>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</main>

		<?php include_once 'inc/script.php'; ?>
	</body>
</html>