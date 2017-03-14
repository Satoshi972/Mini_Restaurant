<?php
session_start();

require_once 'inc/connect.php';

$site_info = $bdd->prepare('SELECT * FROM site_info ORDER BY inf_id DESC LIMIT 3');
if($site_info->execute()){
	$info = $site_info->fetch(PDO::FETCH_ASSOC);
}
else{
	die(var_dump($site_info->errorInfo()));
}

/**
*
*
*
*
*/
function hightlight($pattern, $string){
	return preg_replace( '/('.$pattern.')/i', '<span style="font-weight: bold; color: red;">$1</span>', $string); 
}



if(isset($_GET['search']) && !empty($_GET['search'])){

	$search = strval($_GET['search']);

	$select = $bdd->prepare('SELECT rcp_title, rcp_content, rcp_id FROM recipe WHERE rcp_title LIKE :search OR rcp_content LIKE :search');

	$select->bindValue(':search', '%'.$search.'%');
	if($select->execute()){

		$resSearch = $select->fetchAll(PDO::FETCH_ASSOC);
		if(count($resSearch) == 0){
			$error = 'Désolé aucune recette trouver !';
		}
	}else{
		die(var_dump($select->errorInfo()));
	}

}else{
	$select = $bdd->prepare('SELECT * FROM recipe');
	if($select->execute()){
		$allRecipe = $select->fetchAll(PDO::FETCH_ASSOC);
	}
}

?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Recherche</title>

	<?php require_once 'inc/head.php'; ?>

</head>
<body>
	<?php require_once 'inc/navFront.php'; ?>
	<div class="container">
		<form  method="GET" class="form-horizontal" role="form">
				<div class="form-group">
					<legend>Recherche</legend>
				</div>
		
				<div class="form-group">
					<input type="text" name="search" id="Search" class="form-control" placeholder="Que rechercher-vous ?">
				</div>
		
				<div class="form-group">
					<div class="col-xs-12 text-center">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
		</form>
		
		<?php if(!isset($error)): ?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>titre</th>
							<th>Déscription</th>
							<th>En savoir +</th>
						</tr>
					</thead>
					<tbody>
			<?php if(isset($allRecipe)): 

					foreach ($allRecipe as $key): ?>
						<tr>
							<td><?= $key['rcp_title'] ?></td>
							<td><?= $key['rcp_content'] ?></td>
							<td><a href="view_recipe.php?id=<?= $key['rcp_id'] ?>" class="btn btn-default">En savoir +</a></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
			<?php if(isset($resSearch)): 

					foreach ($resSearch as $key): ?>
					<table>
					<tbody>
						<tr>
							<td><?= hightlight($search, $key['rcp_title']); ?></td>
							<td><?= hightlight($search, $key['rcp_content']); ?></td>
							<td><a href="view_recipe.php?id=<?= $key['rcp_id'] ?>" class="btn btn-default">En savoir +</a></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>

		<?php else: ?>
			<div class="alert alert-warning alert-dismissible text-center" role="alert">
				<h3><?=$error?></h3>
			</div>
		<?php endif; ?>
		
	</div>
	<?php require_once 'inc/footer.php'; ?>
</body>
</html>