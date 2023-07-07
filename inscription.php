<!DOCTYPE html>
<html>
	<?php 
	$title = 'Inscription';
	include('includes/head.php');

	?>
		<script defer src = "js/arial.js"> </script>

	<body>

		<?php include('includes/header.php'); ?>

		<main>
			<div class="container">
				<h1>Inscription</h1>

				<?php include('includes/message.php'); ?>

				<form method="POST" action="verification_inscription.php" enctype="multipart/form-data">
					<div class="mb-3">
						<label for="inputNom" class="form-label">Nom</label>
						<input id="inputNom" class="form-control" type="text" name="nom" placeholder="Votre nom">
					</div>
					<div class="mb-3">
						<label for="inputPrenom" class="form-label">Prénom</label>
						<input id="inputPrenom" class="form-control" type="text" name="prenom" placeholder="Votre prénom">
					</div>
					<div class="mb-3">
						<!--<label for="inputAge" class="form-label">Âge</label>
						<input id="inputAge" class="form-control" type="number" name="age" placeholder="Votre âge">-->
						<label for="date_naissance">Date de naissance :</label>
					    <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>

					</div>
					<div class="mb-3">
						<label for="inputSexe" class="form-label">Sexe</label>
						<select id="inputSexe" class="form-select" name="sexe">
							<option value="homme">Homme</option>
							<option value="femme">Femme</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="inputEmail" class="form-label">Adresse email</label>
						<input id="inputEmail" class="form-control" type="email" name="email" placeholder="exemple@site.com" value="<?= (isset($_COOKIE['email']) ? $_COOKIE['email'] : '') ?>">
					</div>
					<div class="mb-3">
						<label for="inputPassword" class="form-label">Mot de passe</label>
						<input id="inputPassword" class="form-control" type="password" name="mdp" aria-describedby="passwordHelp">
						<div id="passwordHelp" class="form-text">Le mot de passe doit faire entre 6 et 12 caractères.</div>
					</div>
					<div class="mb-3">
						<label for="inputFile" class="form-label">Image de profil</label>
						<input id="inputFile" class="form-control" type="file" name="image" accept="image/jpeg, image/png, image/gif" aria-describedby="FileHelp">
						<div id="FileHelp" class="form-text">2Mo maximum.</div>
					</div>
					<div class="mb-3">
						<button type="submit" id ="bouton" class="btn btn-primary">S'inscrire</button>
					</div>
				</form>


			</div>
		</main>

		<?php include('includes/footer.php'); ?>

	</body>
</html>