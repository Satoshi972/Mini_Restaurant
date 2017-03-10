<?php

require_once 'inc/connect.php';

// On selectionne les colonnes id & title de la table recettes
$select = $bdd->prepare('SELECT rcp_id,	rcp_title, rce_content FROM recipe ORDER BY rcp_id DESC');
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
	<meta charset="utf-8">
	<title>Liste de recettes</title>
</head>
<body>
	<h1>Les recettes</h1>

	<br>
	<table>
		<thead>
			<tr>
				<th>Nom</th>
				<th>Instructions</th>
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
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

</body>
</html>