    <?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: index.php');
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>  
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <title>Créateur d'avatar</title>
        <style>
            #canvas {
                width: 300px;
                height: 300px;
                border: 1px solid black;
            }
            #overlay-images {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            .overlay-image {
                width: 100px;
                height: 100px;
            }
        </style>
    </head>
    <header>
        <?php
		$title = "Avatar";
		include('includes/header.php') ?>
    </header>
    <div class="container">
    <body>
        <h1>Créateur d'avatar</h1>

        <div>
            <h2>Avatar</h2>
            <canvas id="canvas"></canvas>
        </div>

        <div>
            <h2>Superpositions</h2>
            <div id="overlay-images">
                <img class="overlay-image" src="avatar/moustache.png" alt="Moustache">
                <img class="overlay-image" src="avatar/lunettes.png" alt="Lunettes">
                <img class="overlay-image" src="avatar/visage_homme.png" alt="Visage Homme">
                <img class="overlay-image" src="avatar/visage_femme.png" alt="Visage Femme">

                <!-- Ajoutez d'autres images d'overlay ici -->
            </div>
        </div>

        <div class="avatarform" id="form">
            <h2>Enregistrer l'avatar</h2>
            <form id="avatar-form" method="POST" action="save_avatar.php">
                <!-- Champ caché pour stocker les données de l'image de l'avatar -->
                <input type="hidden" name="avatar-input" id="avatar-input" value="">
                <br>
                <button type="button" id="export-button">Exporter en PNG</button>
                <button type="submit" id="save-button" disabled>Enregistrer</button>

            </form>
        </div>

        <script>
        window.addEventListener('load', () => {
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');

            const avatarWidth = 300;
            const avatarHeight = 150;
            

            const backgroundImage = new Image();
            // Remplacez "background.png" par le chemin de votre image de fond pour l'avatar
            backgroundImage.src = 'background.png';
            backgroundImage.onload = () => {
                context.drawImage(backgroundImage, 0, 0, avatarWidth, avatarHeight);
            };

            function drawOverlayImage(image) {
                context.drawImage(image, 0, 0, avatarWidth, avatarHeight);
            }

            const overlayImageElements = document.querySelectorAll('.overlay-image');
            overlayImageElements.forEach(imageElement => {
                imageElement.addEventListener('click', () => {
                    const overlay = new Image();
                    overlay.src = imageElement.src;
                    overlay.onload = () => {
                        drawOverlayImage(overlay);
                    };
                });
            });

            const clearButton = document.createElement('button');
            clearButton.textContent = 'Effacer tout';
            clearButton.addEventListener('click', () => {
                context.clearRect(0, 0, avatarWidth, avatarHeight);
                context.drawImage(backgroundImage, 0, 0, avatarWidth, avatarHeight);
            });


            const exportButton = document.getElementById('export-button');
            exportButton.addEventListener('click', () => {
                const dataURL = canvas.toDataURL('image/png');
                const formData = new FormData();
                formData.append('avatar', dataURL);
                const image = new Image();
                image.src = dataURL;
                image.onload = () => {
                    context.drawImage(image, 0, 0, avatarWidth, avatarHeight);
                    document.getElementById('avatar-input').value = dataURL;
                    document.getElementById('save-button').disabled = false;
                    document.getElementById('form').appendChild(clearButton);

                    
                };

            });

        });
    </script>

    </body>
    </div>
    </html>
    <?php include('includes/footer.php') ?>
