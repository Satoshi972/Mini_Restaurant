<?php
require_once 'inc/connect.php';

if(isset($_GET['id']) && !empty($_GET['id'])){
	$idRecipe = (int) $_GET['id'];
	
	$select = $bdd->prepare('SELECT * FROM site_info WHERE inf_id = :inf_id');
	$select->bindValue(':inf_id', $idRecipe, PDO::PARAM_INT);
	if($select->execute()){
		$restaurant = $select->fetch(PDO::FETCH_ASSOC);
	}
	else {
		var_dump($select->errorInfo());
		die;
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php include_once 'inc/head.php'; ?>
		<meta charset="UTF-8">
		<title>A Propos</title>

	</head>
	<body>
		<?php include_once 'inc/menu.php'; ?>
		<div class="container">
			<div class="row">
				<?php if(isset($restaurant) && !empty($restaurant)) : ?>	
				<img src='<?=$restaurant["inf_picture"]; ?>'>
				<h3><?=$restaurant["inf_name"]; ?></h3>    
				<h3><?=$restaurant["inf_number"]; ?></h3>    
			</div>                                     
		</div>
		<?php endif; ?>                              
		<?php include_once 'inc/script.php'; ?>
	</body>
</html>