<!DOCTYPE html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Connexion</title>
</head>
<div class="graybackground">
<style> 
	main {
		min-height: 500px;
		color : white;
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
		color : white;

	}

	.contact-form {
		width : 40%;
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
		display : flex;
		flex-direction: row-reverse;
		margin-top : -20px;
	}
	.connexion_graytext {
		font-size : 14px;
		color : whitesmoke;

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
						<input id="inputEmail" class="form-control" type="email" name="email" placeholder="exemple@site.com"  value="<?= (isset($_COOKIE['email']) ? $_COOKIE['email'] : '') ?>">
					</div>
					<div class="mb-3">
						<label for="inputPassword" class="form-label">Mot de passe</label>
						<input id="inputPassword" class="form-control" type="password" name="mdp" aria-describedby="passwordHelp">
						<div id="passwordHelp" class="connexion_graytext">Le mot de passe doit faire entre 6 et 12 caractères.</div>
					</div>
					<div class="mb-6">
						<a href="mdp.php" class="mdp_oublie">Mot de passe oublié ?</a>
					</div>
					<div class="mb-3">
						<button type="submit" class="btn btn-primary" style='background-color: #DC5E18 ;
						border-color: #DC5E18; '>Se connecter</button>
					</div>
					<div class="mb-12">
						<a href="inscription.php" class="mdp_oublie">Pas encore inscit ? Cliquez ici !</a>
					</div>
				</form>
				<a href="mailing/formulaire_mdp.php"> Mot de passe oublié ? </a>
			</div>

		</main>

		<?php include('includes/footer.php'); ?>

	</body>
</div>
</html>