<?php
	if(isset($_SESSION['is_logged'])){
		$nomUser = $_SESSION['nom'];
		$prenomUser = $_SESSION['prenom'];
		$roleUser = $_SESSION['role'];
	}else{
		header('location: ./../loggin.php');
	}
?>