<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion</title>
</head>
<div class="graybackground">
<style> 
.captcha-row {
    display: flex;
    justify-content: center;
}

.captcha-case {
    margin: 1px;
}
	main {
		min-height: 500px;
		color: white;
	}

	.graybackground {
		background-image: url('imagerie/pexels-photo-669576.jpeg');
		background-repeat: no-repeat;
        background-size: cover;
		background-color: #515151;
	}
	

	.btn-orange {
		background-color: #DC5E18;
		border-color: #DC5E18;
		color: white;
	}

	.contact-form {
		width: 40%;
		justify-content: center;
		align-items: center;
		margin-left: auto;
		margin-right: auto;
	}

	.contact-form h1 {
		text-align: center;
	}

	.contact-form button {
		text-align: center;
		margin-left: auto;
		margin-right: auto;
		justify-content: center;
	}

	.mdp_oublie {
		display: flex;
		flex-direction: row-reverse;
		margin-top: -20px;
	}

	.connexion_graytext {
		font-size: 14px;
		color: whitesmoke;
	}
</style>
	<?php 
	$title = 'Connexion';
	include('includes/head.php');
	?>
	<body>

		<?php include('includes/header.php'); ?>

		<main>
			<div class="container">
				<?php include('includes/message.php'); ?>

				<form method="POST" action="verification.php" class="contact-form">
					<h1>Connexion</h1>
					<div class="mb-3">
						<label for="inputEmail" class="form-label">Adresse email</label>
						<input id="inputEmail" class="form-control" type="email" name="email" placeholder="exemple@site.com" value="<?= (isset($_COOKIE['email']) ? $_COOKIE['email'] : '') ?>">
					</div>
					<div class="mb-3">
						<label for="inputPassword" class="form-label">Mot de passe</label>
						<input id="inputPassword" class="form-control" type="password" name="mdp" aria-describedby="passwordHelp">
						<div id="passwordHelp" class="connexion_graytext">Le mot de passe doit faire entre 6 et 12 caractères.</div>
					</div>
					<div class="mb-6">
						<a href="mailing/formulaire_mdp.php">Mot de passe oublié ?</a>
					</div>
					<div id="captcha-container"></div>
					<script>
						let clicked;
						let dropped;
						let puzzlePaths = ["puzzle1", "puzzle2"];
						let caseIds = ["1", "2", "3", "4"];
						let idToImage = {};

						function randomlst(lst) {
							lst.sort(() => Math.random() - 0.5);
						}

						function main() {
							randomlst(caseIds);

							const board = document.getElementById("captcha-container");

							let row1 = document.createElement("div");
							row1.classList.add("captcha-row");
							board.appendChild(row1);

							let row2 = document.createElement("div");
							row2.classList.add("captcha-row");
							board.appendChild(row2);

							for (let i = 0; i < 4; i++) {
								let id = caseIds[i];
								let imgSrc = "./asset/" + puzzlePaths[0] + "/" + id + ".jpg";
								idToImage[id] = imgSrc;

								let caseDiv = document.createElement("div");
								caseDiv.classList.add("captcha-case");

								let caseImg = document.createElement("img");
								caseImg.id = id;
								caseImg.src = imgSrc;
								caseImg.classList.add("case");

								caseImg.addEventListener("dragstart", start);
								caseImg.addEventListener("dragover", over);
								caseImg.addEventListener("dragenter", enter);
								caseImg.addEventListener("dragleave", leave);
								caseImg.addEventListener("drop", drop);
								caseImg.addEventListener("dragend", end);

								if (i < 2) {
									row1.appendChild(caseDiv);
								} else {
									row2.appendChild(caseDiv);
								}

								caseDiv.appendChild(caseImg);
							}
						}

						function start() {
							clicked = this;
						}

						function over(event) {
							event.preventDefault();
						}

						function enter(event) {
							event.preventDefault();
						}

						function leave() {}

						function drop() {
							dropped = this;
						}

						function end() {
							let clickedImage = clicked.src;
							let droppedImage = dropped.src;
							clicked.src = droppedImage;
							dropped.src = clickedImage;

							let idClicked = clicked.id;
							let idDropped = dropped.id;
							console.log(idClicked);
							console.log(idDropped);

							verification(idClicked, idDropped);
						}

						function verification(idClicked, idDropped) {
							let temp = idToImage[idDropped];
							idToImage[idDropped] = idToImage[idClicked];
							idToImage[idClicked] = temp;

							console.log(idToImage);

							let success = caseIds.every((id, index) => idToImage[id] === "./asset/" + puzzlePaths[0] + "/" + (index + 1) + ".jpg");

							if (success) {
								console.log("success");
								let successElement = document.getElementById("success");
								if (successElement) {
									successElement.innerHTML = "VOUS ETES VIVANT ;)";
								} else {
									console.log('Could not find element with id "success"');
								}

								// Activer le bouton "Se connecter"
								document.getElementById("connexion-btn").disabled = false;
							}
						}

						main();
					</script>
					<div class="mb-3">
						<button type="submit" id="connexion-btn" class="btn btn-primary btn-orange" disabled>Se connecter</button>
					</div>
					<div class="mb-12">
						<a href="inscription.php" class="mdp_oublie">Pas encore inscrit ? Cliquez ici !</a>
					</div>
				</form>
			</div>
		</main>

		<?php include('includes/footer.php'); ?>

	</body>
</div>
</html>
