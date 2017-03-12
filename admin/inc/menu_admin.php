	<div class="container-fluid">
		<div class="topinfo">
				<?php if($roleUser == 'admin'): ?>
						<h4>ADMINISTRATEUR</h4>
					<?php elseif ($roleUser == 'editor'): ?>
						<h4>EDITEUR</h4>
					<?php endif; ?>
			<div class="container">
					<div class="inforight">
						<h5>Bonjour <?=$nomUser.' '.$prenomUser?> / </h5>
						<a href="./loggout.php">Vous Deconnecter</a>
					</div>
			</div>
		</div>
	</div>
	<nav class="sidebar">
			<?php if($roleUser == 'admin'): ?>
				<div class="navside">
					<ul>
						<div class="titreMenu">Gestion du Site</div>
						<li><a href="#">Coordonnées</a></li>
						<li><a href="#">Photo de couverture</a></li>
					</ul>	
				</div>
				<div class="navside">
					<ul>
						<div class="titreMenu">Gestion des recettes</div>
						<li><a href="#">Liste des recettes</a></li>
						<li><a href="#">Modifer une recette</a></li>
						<li><a href="#">Supprimer une recette</a></li>
						<li><a href="#">Ajouter une recette</a></li>
					</ul>	
				</div>
				<div class="navside">
					<ul>
						<div class="titreMenu">Gestion des Contacts</div>
						<li><a href="#">menu 1</a></li>
						<li><a href="#">menu 2</a></li>

					</ul>	
				</div>
				<div class="navside">
					<ul>
						<div class="titreMenu">Gestion des Utilisateurs</div>
						<li><a href="#">Creer un Utilisateur</a></li>
						<li><a href="#">menu 2</a></li>

					</ul>	
				</div>
			<?php endif; ?>
			<?php if($roleUser == 'editor'): ?>
				<div class="navside">
					<ul>
						<div class="titreMenu">Gestion des recettes</div>
						<li><a href="#">Liste des recettes</a></li>
						<li><a href="#">Modifer une recette</a></li>
						<li><a href="#">Supprimer une recette</a></li>
						<li><a href="#">Ajouter une recette</a></li>
					</ul>	
				</div>
			<?php endif; ?>
	</nav>
	<div class="content">