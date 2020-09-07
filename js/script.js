//Sign-Up
function signUp() {
  document.getElementById("main1").setAttribute("id", "main");
  document.getElementById("sign-up").style.display = "block";
}
function closeSignUp() {
  document.getElementById("main1").removeAttribute("id", "main");
  document.getElementById("sign-up").style.display = "none";
}

//Question Pop-Up
function questionPopUp() {
  document.getElementById("question").style.display = "block";
}
function questionClose() {
  document.getElementById("question").style.display = "none";
}

//Gender Question Pop-Up
function genderQuestion() {
  document.getElementById("gender-question").style.display = "block";
}
function genderQuestionClose() {
  document.getElementById("gender-question").style.display = "none";
}

function checkPassword() {}
