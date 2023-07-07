<!DOCTYPE html>
<html>
<head>
  <title>Formulaire de contact</title>
</head>
<body>
  <h1>Formulaire de contact</h1>
  
  <form action="send_news.php" method="post">
    <label for="objet">Objet :</label>
    <input type="text" id="objet" name="objet" required><br><br>
    
    <label for="contenu">Contenu :</label><br>
    <textarea id="contenu" name="content" rows="4" cols="50" required></textarea><br><br>
    
    <input type="submit" value="Envoyer">
  </form>
</body>
</html>
