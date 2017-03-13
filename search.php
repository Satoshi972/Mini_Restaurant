<?php
session_start();

require_once './inc/connect.php';

if(isset($_GET['search']) && !empty($_GET['search'])){

	$search = strval($_GET['search']);


	$select = $bdd->prepare('SELECT rcp_title, rcp_content, rcp_id FROM recipe WHERE rcp_title LIKE :search OR rcp_content LIKE :search');

	if($select->execute(array(':search' => $search.'%'))){

		$res = $select->fetchAll(PDO::FETCH_ASSOC);
		var_dump($res);

	}else{

	}

}




?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Recherche</title>

	<?php require_once './inc/head.php'; ?>

</head>
<body>
	
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
	</div>
</body>
</html>