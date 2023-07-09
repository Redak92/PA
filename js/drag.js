
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');

// Empêcher le comportement par défaut du navigateur lors d'un glisser-déposer
dropZone.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropZone.classList.add('highlight');
});

dropZone.addEventListener('dragleave', () => {
  dropZone.classList.remove('highlight');
});

dropZone.addEventListener('drop', (e) => {
  e.preventDefault();
  dropZone.classList.remove('highlight');
  
  const files = e.dataTransfer.files;
  fileInput.files = files;
});

// Écouter le changement de fichier via le bouton de sélection de fichier
fileInput.addEventListener('change', () => {
  const files = fileInput.files;
  console.log(files);
  // Faire quelque chose avec les fichiers sélectionnés
});
