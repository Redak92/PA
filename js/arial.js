let divs = document.getElementsByClassName("mb-3");
let inputs = document.querySelectorAll("form input, form select");
let bouton = document.getElementById("bouton");
let clickCount = 0; // Compteur de clics

for (let i = 2; i < inputs.length; i++) {
  divs[i].style.display = "none";
}

divs[divs.length - 1].style.display = "block";
bouton.textContent = "Continuer";

function del1(event) {
  if (inputs[0].value === "" || inputs[1].value === "") {
    alert("Les champs ne sont pas remplis");
  } else {
    divs[0].style.display = "none";
    divs[1].style.display = "none";
    divs[2].style.display = "block";
    divs[3].style.display = "block";
  }

  bouton.removeEventListener("click", del1);

  function del2(event) {
    if (inputs[2].value === 0) {
      alert("Les champs ne sont pas remplis 1");
    } else {
      divs[2].style.display = "none";
      divs[3].style.display = "none";
      divs[4].style.display = "block";
      divs[5].style.display = "block";
      divs[6].style.display = "block";
      bouton.textContent = "S'inscrire"
    }

    clickCount++; // Incrémente le compteur de clics

    if (clickCount >= 2) {
      bouton.removeEventListener("click", del2);
    }
  }

  bouton.addEventListener("click", del2);
}

bouton.type = "button";
console.log(inputs);
bouton.addEventListener("click", del1);

// Changement du type du bouton à "submit" après la deuxième fois que le bouton est cliqué
bouton.addEventListener("click", function () {
  if (clickCount >= 1) {
    
    bouton.type = "submit";
  }
});
