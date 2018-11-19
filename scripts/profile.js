var profileTab = document.getElementById("profile");

profileTab.classList.add("currentItem");

var userDrop = document.getElementsByClassName('modifTitle')[0];
var passDrop = document.getElementsByClassName('modifTitle')[1];
var mailDrop = document.getElementsByClassName('modifTitle')[2];

var userHidden = document.getElementsByClassName('modifHidden')[0];
var passHidden = document.getElementsByClassName('modifHidden')[1];
var mailHidden = document.getElementsByClassName('modifHidden')[2];

userDrop.onclick = function() {
	if (userHidden.style.display == "inline") {
		userHidden.style.display = "none";
		userDrop.style.backgroundColor = "grey";
		document.getElementById('arrowName').innerHTML = "&or;";
	} else {
		userHidden.style.display = "inline";
		userDrop.style.backgroundColor = "#aaaaaa";
		document.getElementById('arrowName').innerHTML = "&and;";
	}
};

passDrop.onclick = function() {
	if (passHidden.style.display == "inline") {
		passHidden.style.display = "none";
		passDrop.style.backgroundColor = "grey";
		document.getElementById('arrowPass').innerHTML = "&or;";
	} else {
		passHidden.style.display = "inline";
		passDrop.style.backgroundColor = "#aaaaaa";
		document.getElementById('arrowPass').innerHTML = "&and;";
	}
};

mailDrop.onclick = function() {
	if (mailHidden.style.display == "inline") {
		mailHidden.style.display = "none";
		mailDrop.style.backgroundColor = "grey";
		document.getElementById('arrowEmail').innerHTML = "&or;";
	} else {
		mailHidden.style.display = "inline";
		mailDrop.style.backgroundColor = "#aaaaaa";
		document.getElementById('arrowEmail').innerHTML = "&and;";
	}
};

var userSend = document.getElementById('sendName');
var passSend = document.getElementById('sendPass');
var mailSend = document.getElementById('sendEmail');

userSend.onclick = function() {
	var newName = document.getElementById('newName').value;

	if (newName && newName.length > 3 && newName.length < 51) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				if (response.substring(0, response.indexOf(':')) == "error") {
					if (response.substring(0, response.indexOf(';')) == "error:taken") {
						createErrorNotif("Username is already taken...");
					} else {
						createErrorNotif("Username needs to be between 4 and 50 characters long...");
					}
				} else {
					createSuccessNotif("Username changed!");
					document.getElementById('userName').textContent = newName;
				}
				document.getElementById('newName').value = "";
			}
		}
		xhttp.open("POST", "modify.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("action=name&name=" + newName);
	} else {
		createErrorNotif("Username needs to be between 4 and 50 characters long...");
	}
};

passSend.onclick = function() {
	var oldPass = document.getElementById('oldPass').value;
	var newPass = document.getElementById('newPass').value;

	if (newPass.match(/[a-z]/g) && newPass.match(/[A-Z]/g) && newPass.match(/[0-9]/g) && newPass.length > 7) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				if (response.substring(0, response.indexOf(':')) == "error") {
					if (response.substring(0, response.indexOf(';')) == "error:newpass") {
						createErrorNotif("Invalid new password...");
					} else {
						createErrorNotif("User password is incorrect...");
					}
				} else {
					createSuccessNotif("Password changed!");
				}
				document.getElementById('oldPass').value = "";
				document.getElementById('newPass').value = "";
			}
		}
		xhttp.open("POST", "modify.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("action=pass&oldPass=" + oldPass + "&newPass=" + newPass);
	} else {
		createErrorNotif("Invalid new password...");
	}
};

mailSend.onclick = function() {
	var newMail = document.getElementById('newEmail').value;

	if (newMail) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				if (response.substring(0, response.indexOf(':')) == "error") {
					if (response.substring(0, response.indexOf(';')) == "error:email") {
						createErrorNotif("Invalid email address...");
					} else {
						createErrorNotif("Email address already in use...");
					}
				} else {
					createSuccessNotif("Email address changed!");
				}
				document.getElementById('newEmail').value = "";
			}
		}
		xhttp.open("POST", "modify.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("action=email&email=" + newMail);
	} else {
		createErrorNotif("Please enter a new email address...");
	}
};

function toggleCheckbox(e) {

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				createSuccessNotif("Notification preference changed!");
			}
		}
		xhttp.open("POST", "modify.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("action=notif&check=" + e.checked);
};

function deletePhoto(elem) {

	if (confirm("Are you sure you want to delete this photo?")) {

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
	
			if (this.readyState == 4 && this.status == 200) {
				var toDel = elem.parentNode;
				toDel.parentNode.removeChild(toDel);
			}
		}
		xhttp.open("POST", "delete.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("id=" + elem.id);
	}
}
