<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <style>
		p {
			color : white;
		}
		.container h1 {
			color : white;
		}
        .background-image {
            background-image: url('imagerie/pexels-victor-freitas-949131.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .header, .footer {
            background-image: url('imagerie/pexels-victor-freitas-949131.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    <!-- style carrousel -->
    <style>
        
        .carousel-indicators {
        position: absolute;
        bottom: 10px;
        left: auto;
        right : auto;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        margin: 0;
        padding: 0;
        list-style: none;
        z-index: 10;
        }

        .carousel-indicators li {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        margin: 0 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .carousel-indicators li.active {
        background-color: #fff;
        }
        .carousel {
        width: 100%;
        height: 400px;
        overflow: hidden;
        position: relative;
        }

        .carousel-inner {
        width: 100%;
        height: 100%;
        display: flex;
        }

        .carousel-item {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        background-size: 150%;
        }

        .carousel-item.active {
        opacity: 1;
        }

        .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        }

        .carousel-control {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background-color: rgba(0, 0, 0, 0.3);
        color: #fff;
        text-align: center;
        line-height: 40px;
        font-size: 24px;
        border-radius: 50%;
        opacity: 0.5;
        transition: opacity 0.3s ease-in-out;
        }

        .carousel-control:hover {
        opacity: 1;
        }

        .carousel-control-prev {
        left: 10px;
        }

        .carousel-control-next {
        right: 10px;
        }
        h1, h3, label, p {
            color : white;
        }
        
  </style>
</head>

<!--script carrousel -->
<script>    
    document.addEventListener('DOMContentLoaded', function() {
    var carouselItems = document.querySelectorAll('.carousel-item');
    var carouselIndicators = document.querySelectorAll('.carousel-indicators li');
    var slides = document.querySelectorAll('.texteSlide1, .texteSlide2, .texteSlide3');

    function showSlide(index) {
    carouselItems.forEach(function(item, i) {
        item.classList.remove('active');
        carouselIndicators[i].classList.remove('active');
        slides[i].style.display = 'none';
    });
    carouselItems[index].classList.add('active');
    carouselIndicators[index].classList.add('active');
    slides[index].style.display = 'block';
    }

    function goToSlide(index) {
    showSlide(index);
    }

    function goToPrevSlide() {
    var activeIndex = Array.from(carouselItems).findIndex(function(item) {
        return item.classList.contains('active');
    });
    var prevIndex = (activeIndex === 0) ? carouselItems.length - 1 : activeIndex - 1;
    goToSlide(prevIndex);
    }

    function goToNextSlide() {
    var activeIndex = Array.from(carouselItems).findIndex(function(item) {
        return item.classList.contains('active');
    });
    var nextIndex = (activeIndex === carouselItems.length - 1) ? 0 : activeIndex + 1;
    goToSlide(nextIndex);
    }

    carouselIndicators.forEach(function(indicator, index) {
    indicator.addEventListener('click', function() {
        goToSlide(index);
    });
    });

    var carouselPrev = document.querySelector('.carousel-control-prev');
    carouselPrev.addEventListener('click', goToPrevSlide);

    var carouselNext = document.querySelector('.carousel-control-next');
    carouselNext.addEventListener('click', goToNextSlide);

    showSlide(0); // Affiche la première diapositive par défaut
    });
</script>



<body>
    <div class="background-image">
        <?php 
        $title = 'Accueil';
        include('includes/head.php');
        ?>

        <header class="header">
            <?php include('includes/header.php'); ?>
        </header>

        <main>
            <div class="container" style="height:1000px">
                <h1>Accueil</h1>
                
                <p>
                    <?php 
                    if(!isset($_SESSION['email'])){
                        echo 'Veuillez vous connecter';
                    }else{
                        echo 'Bienvenu sur JIB Sports :)';
                    }
                    ?>
                </p>
                <div id="" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators" style="margin-left:50%">
                        <li data-target="#IMCcalc" data-slide-to="0" class="active"></li>
                        <li data-target="#CookingClasses" data-slide-to="1"></li>
                        <li data-target="#Hammam" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="imagerie/pexels-photo-263194.jpeg" alt="First slide">

                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="imagerie/pexels-photo-1267320.jpeg" alt="Second slide">

                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="imagerie/iStock-176877542.jpg" alt="Third slide">

                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="texteSlide1">
                    <h3 style="color:white">IMCcalc</h3>
                    <p>Essayer notre <a href="imcalc.php" target="_blank">nouvel outil</a> en ligne complet pour évaluer votre condition physique et atteindre vos objectifs de remise en forme. Notre service vous permet de calculer votre Indice de Masse Corporelle (IMC), votre fréquence cardiaque maximale et votre pourcentage de masse graisseuse, vous offrant ainsi des informations précieuses pour suivre vos progrès et prendre des décisions éclairées dans votre parcours de remise en forme.</p>
                </div>
                <div class="texteSlide2">
                <h3 style="color:white">Transformez votre cuisine, transformez votre corps !</h3>
                    <p>Êtes-vous prêt(e) à prendre le contrôle de votre alimentation pour atteindre vos objectifs de forme physique ? Découvrez notre service de cours de cuisine diététique, conçu pour vous aider à gagner de la masse musculaire, perdre du poids et adopter une alimentation saine et équilibrée. Nos cours vous fournissent les compétences nécessaires pour préparer des repas délicieux, nutritifs et adaptés à vos objectifs de remise en forme.</p>
                    <p>Notre service de cours de cuisine diététique est spécialement conçu pour résoudre ce problème. Nos chefs experts en nutrition vous guideront à travers des recettes innovantes et faciles à suivre, en vous enseignant les bases de la cuisine diététique. Vous apprendrez à choisir les bons ingrédients, à préparer des repas équilibrés et à adapter vos recettes préférées pour répondre à vos besoins nutritionnels spécifiques.</p>
                    <p>Des compétences durables : Nos cours vous fournissent les compétences nécessaires pour préparer des repas sains et délicieux à la maison. Vous serez en mesure de continuer à cuisiner selon vos besoins et vos préférences même après avoir terminé nos cours.</p>
                </div>
                <div class="texteSlide3">
                <h3 style="color:white">Hamam & Spa</h3>
                    <p>Plongez dans un monde de détente et de bien-être ultime avec notre service Hamam & Spa. Notre luxueux établissement combine les bienfaits revigorants d'un hamam traditionnel avec l'expertise de nos masseurs qualifiés pour vous offrir une expérience de relaxation inégalée. Laissez le stress et les tensions s'évanouir tandis que vous vous abandonnez à une oasis de tranquillité et de soins personnalisés.</p>
                    <p>Nous vous offrons une solution complète pour revitaliser votre corps et votre esprit. Notre équipe de masseurs expérimentés combine les bienfaits apaisants du hammam avec des techniques de massage thérapeutiques pour vous offrir une expérience holistique de guérison et de relaxation profonde. Chaque session est adaptée à vos besoins individuels pour vous offrir une expérience sur mesure.</p>
                    <p>L'authenticité du hammam : Profitez des bienfaits éprouvés du hammam, une tradition ancestrale de purification et de détente. Notre hammam offre une atmosphère chaleureuse et apaisante où vous pouvez profiter des vapeurs revitalisantes, purifier votre peau et stimuler votre circulation sanguine</p>
                    <p></p>
                    <p></p>
 
                </div>
                <br><br><br><br><br><br>
                <div class="line"></div> <br>
                    <form method="post" action = "mailing/newsletter/add_address_newsletter.php">
                        <input type = "email" name = "email" placeholder = "Entrez votre email">
                        <input type = "submit" value = "S'inscrire">
                    </form>
            </main>
            
        
            <style> 
                .modal-content {
                background-color: #f2f2f2;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 300px;
                font-family: Arial, sans-serif;
                color: black;
                }

                .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
                }

                .close:hover,
                .close:focus {
                color: #fff;
                text-decoration: none;
                }

                #emailForm {
                display: flex;
                flex-direction: column;
                }

                label {
                margin-bottom: 10px;
                color: grey;
                }

                input[type="email"] {
                padding: 8px;
                margin-bottom: 10px;
                border-radius: 3px;
                border: 1px solid #ccc;
                }

                input[type="submit"] {
                padding: 10px;
                background-color: #4CAF50;
                color: #fff;
                border: none;
                border-radius: 3px;
                cursor: pointer;
                }

                input[type="submit"]:hover {
                background-color: #45a049;
                }
                .line {
                margin-top: 20px;
                height: 1px;
                background-color: #ccc;
                border: none;
                }
                </style>
                
                <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <form id="emailForm" action="mailing/newsletter/add_address_newsletter.php" method="post">
                    <label for="email">Inscrivez-vous à notre Newsletter</label>
                    <input type="email" id="email" name="email" placeholder="Entrez votre email" required>
                    <input type="submit" value="S'inscrire">
                    </form>
                </div>
                </div>



			<script>
                // Sélectionner la boîte de dialogue modale
                const modal = document.getElementById('myModal');

                // Ouvrir la boîte de dialogue lorsque la page se charge
                window.addEventListener('load', function() {
                modal.style.display = 'block';
                });

                // Fermer la boîte de dialogue lorsque l'utilisateur clique sur la croix
                const closeBtn = document.getElementsByClassName('close')[0];
                closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
                });

                // Soumettre le formulaire
                const form = document.getElementById('emailForm');
                form.addEventListener('submit', function(e) {
                e.preventDefault();

                const emailInput = document.getElementById('email');
                const email = emailInput.value;

                if (isValidEmail(email)) {
                    alert('Inscription réussie !');
                    modal.style.display = 'none';

                    // Envoie l'e-mail à l'URL spécifiée
                    const url = form.action;
                    const formData = new FormData(form);
                    fetch(url, {
                    method: 'POST',
                    body: formData
                    })
                    .catch(error => {
                        console.error('Une erreur s\'est produite lors de l\'inscription :', error);
                    });
                } else {
                    alert('Veuillez entrer une adresse e-mail valide !');
                }
                });

                // Fonction de validation d'e-mail simple (à améliorer selon vos besoins)
                function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
                }

            </script>

        <footer class="footer">
            <?php include('includes/footer.php'); ?>
        </footer>
    </div>
</body>
</html>
