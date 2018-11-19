// ---- Password Policy Box ---- //

var passPolicy = document.getElementById("passPolicy");
var passCheck = document.getElementsByClassName("passCheck")[0];
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

function resetPassCheck() {
	letter.classList.remove("valid");
	capital.classList.remove("valid");
	number.classList.remove("valid");
	length.classList.remove("valid");
	letter.classList.add("invalid");
	capital.classList.add("invalid");
	number.classList.add("invalid");
	length.classList.add("invalid");
}

passCheck.onfocus = function() {
	passPolicy.style.display = "block";
}

passCheck.onblur = function() {
	passPolicy.style.display = "none";
}

passCheck.onkeyup = function() {

	if (passCheck.value.match(/[a-z]/g)) {
		letter.classList.remove("invalid");
		letter.classList.add("valid");
	} else {
		letter.classList.remove("valid");
		letter.classList.add("invalid");
	}
	
	if (passCheck.value.match(/[A-Z]/g)) {
		capital.classList.remove("invalid");
		capital.classList.add("valid");
	} else {
		capital.classList.remove("valid");
		capital.classList.add("invalid");
	}

	if (passCheck.value.match(/[0-9]/g)) {
		number.classList.remove("invalid");
		number.classList.add("valid");
	} else {
		number.classList.remove("valid");
		number.classList.add("invalid");
	}

	if (passCheck.value.length >= 8) {
		length.classList.remove("invalid");
		length.classList.add("valid");
	} else {
		length.classList.remove("valid");
		length.classList.add("invalid");
	}
}
