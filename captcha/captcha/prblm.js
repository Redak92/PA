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

  const board = document.getElementById("board");

  for (let i = 0; i < 2; i++) {
    for (let j = 0; j < 2; j++) {
      let id = caseIds[i * 2 + j];
      let imgSrc = "./asset/" + puzzlePaths[0] + "/" + id + ".jpg";
      idToImage[id] = imgSrc;

      let Case = document.createElement("img");
      Case.id = id;
      Case.src = imgSrc;
      Case.classList.add("case");

      Case.addEventListener("dragstart", start);
      Case.addEventListener("dragover", over);
      Case.addEventListener("dragenter", enter);
      Case.addEventListener("dragleave", leave);
      Case.addEventListener("drop", drop);
      Case.addEventListener("dragend", end);
      document.getElementById("board").append(Case);
    }
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
   if (successElement) { // Make sure the element was found
     successElement.innerHTML = "VOUS ETES VIVANT ;)";
   } else {
     console.log('Could not find element with id "success"');
   }
 }
}
main();
