<?php    
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: index.php');
        exit;
    }
    ?> <div class="background-image">
<?php
    include('includes/header.php')

?>
<!DOCTYPE html>
<html>
<head>
  <title>Calculateur de forme physique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <style>

.background-image {
            background-image: url('imagerie/heartback.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }    

    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }
    h1, h2, H3, p, label {
        color : white;
    }
    h1 {
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 10px;
    }

    input {
      width: 100%;
      padding: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      display: block;
      margin: 10px auto;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #4caf50;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
   .heart-rate-chart {
      width: 100%;
      height: 100px;
      background-color: grey;
      margin-bottom: 10px;
      position: relative;
      border-radius: 5px;
      overflow: hidden;
    }

    
    .bar-progress {
      height: 100%;
      background-color: #4caf50;
      width: 0;
      border-radius: 5px;
      transition: width 1s ease-in-out;
      background-image: url('ecg.gif');
      background-size: 30%;
      background-repeat: repeat; /* Répéter l'image de fond */
      background-position: 50% 50%;
    }

    .progress-bar {
      width: 100%;
      height: 30px;
      background-color: #f2f2f2;
      margin-bottom: 10px;
      position: relative;
      border-radius: 5px;
    }
    .progress {
      height: 100%;
      background-color: #4caf50;
      width: 0;
      transition: width 1s ease-in-out;
      border-radius: 5px;
    }
    .progress.green {
      background-color: #4caf50;
    }
    .progress.orange {
      background-color: #ff9800;
    }
    .progress.red {
      background-color: #f44336;
    }
    .bar-container {
      width: 100%;
      height: 30px;
      background-color: #f2f2f2;
      margin-bottom: 10px;
      position: relative;
      border-radius: 5px;
    }
    .bar {
      height: 100%;
      background-color: #4caf50;
      width: 0;
      transition: width 1s ease-in-out;
      border-radius: 5px;
    }
    .bar-label {
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      padding-left: 5px;
    }
  </style>
<body>

    <div class="container">
        <h1>Calculateur de forme physique</h1>
    
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="weight">Poids (kg):</label>
            <input type="number" id="weight" step="0.01" class="form-control" />
          </div>
          <div class="col-md-6 form-group">
            <label for="height">Taille (m):</label>
            <input type="number" id="height" step="0.01" class="form-control" />
          </div>
        </div>
    
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="age">Âge:</label>
            <input type="number" id="age" class="form-control" />
          </div>
          <div class="col-md-6 form-group">
            <label for="waist">Tour de taille (cm):</label>
            <input type="number" id="waist" step="0.01" class="form-control" />
          </div>
        </div>
    
          <div class="col-md-6 form-group">
            <label for="restingHeartRate">Fréquence cardiaque au repos:</label>
            <input type="number" id="restingHeartRate" class="form-control" />
          </div>
      
          <button class="form-group" onclick="calculateForm()">Calculer</button>
      
          <div class="progress-bar">
            <div id="progress" class="progress"></div>
            <div class="bar-label" style="color:white">IMC</div>

          </div>
    
        <div class="bar-container">
          <div id="bodyFatBar" class="bar"></div>
          <div class="bar-label" style="color:white">Taux de masse grasse</div>
        </div>
    
        <div class="heart-rate-chart">
          <div id="heartRateBar" class="bar-progress"></div>
          <div class="bar-label" style="color:white">Fréquence cardiaque max</div>
        </div>
</div>
  <p id="result"></p>
</body>

  <script>
    function updateMaxHeartRate(age) {
      var maxHeartRate = calculateMaxHeartRate(age);
      drawHeartRateChart(maxHeartRate);
    }

    function calculateMaxHeartRate(age) {
      return 220 - age;
    }

    function drawHeartRateChart(maxHeartRate) {
      var chart = document.getElementById("heartRateBar");
      var progress = (maxHeartRate / 230) * 100; // Calcul du pourcentage de progression

      chart.style.width = progress + "%";
    }

    function calculateForm() {
      var weight = parseFloat(document.getElementById("weight").value);
      var height = parseFloat(document.getElementById("height").value);
      var age = parseInt(document.getElementById("age").value);
      var waist = parseFloat(document.getElementById("waist").value);
      var restingHeartRate = parseInt(document.getElementById("restingHeartRate").value);

      if (isNaN(weight) || isNaN(height) || isNaN(age) || isNaN(waist) || isNaN(restingHeartRate) ||
          weight <= 0 || height <= 0 || age <= 0 || waist <= 0 || restingHeartRate <= 0) {
        document.getElementById("result").innerHTML = "Veuillez entrer des valeurs valides pour les champs.";
        return;
      }

      var bmi = weight / (height * height);
      bmi = bmi.toFixed(2);

      var bodyFatPercentage;

      switch (true) {
        case (age >= 20 && age <= 39):
          bodyFatPercentage = 1.20 * bmi + 0.23 * age - 10.8 - 5.4;
          break;
        case (age >= 40 && age <= 59):
          bodyFatPercentage = 1.20 * bmi + 0.23 * age - 10.8 - 5.4;
          break;
        case (age >= 60):
          bodyFatPercentage = 1.20 * bmi + 0.23 * age - 10.8 - 5.4;
          break;
      }

      bodyFatPercentage = bodyFatPercentage.toFixed(2);

      var maxHeartRate = calculateMaxHeartRate(age);

      var progress = document.getElementById("progress");
      var progressBarWidth = (bmi / 50) * 100;
      progressBarWidth = Math.min(progressBarWidth, 100); // Limiter à 100%

      progress.style.width = progressBarWidth + "%";

      if (bmi >= 18.5 && bmi <= 24.9) {
        progress.className = "progress green";
      } else if (bmi >= 25 && bmi <= 29.9) {
        progress.className = "progress orange";
      } else {
        progress.className = "progress red";
      }

      var bodyFatBar = document.getElementById("bodyFatBar");
      var bodyFatBarWidth = (bodyFatPercentage / 100) * 100;

      bodyFatBar.style.width = bodyFatBarWidth + "%";

      document.getElementById("result").innerHTML = "Votre IMC est de " + bmi + "<br>" +
        "Votre taux de masse grasse est de " + bodyFatPercentage + "%<br>" +
        "Votre rythme cardiaque maximal est de " + maxHeartRate + " bpm";
        

      drawHeartRateChart(maxHeartRate);
    }

  </script>

</html>

<?php include('includes/footer.php'); ?>
</div>