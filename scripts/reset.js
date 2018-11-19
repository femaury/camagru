var mReset = document.getElementById('mReset');
mReset.style.display = "block";

document.getElementById('cReset').onclick = function() {
	window.location.href = ".";
}

document.getElementById('sReset').onclick = function() {
	submitReset();
}

mReset.addEventListener("keydown", function (e) {
	if (e.keyCode == 13 || e.which == 13) {
		submitReset();
	}
});

function submitReset() {

	var newPass = document.getElementById('pReset').value;
	var code = document.getElementById('codeReset').value;

	if (newPass && code) {
		if (!newPass.match(/[a-z]/g) || !newPass.match(/[A-Z]/g) || !newPass.match(/[0-9]/g) || newPass.length < 8) {
			createErrorNotif("Invalid password...");
		} else {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var response = this.responseText;
					if (response.substring(0, response.indexOf(';')) == "error") {
						createErrorNotif("Invalid information...");
						document.getElementById('pReset').value = "";
						resetPassCheck();
					} else {
						createSuccessNotif("Password changed!");
						setTimeout(function() {
							window.location.href = ".";
						}, 2000);
					}
				}
			}
			xhttp.open("POST", "reset.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("code=" + code + "&passwd=" + newPass);
		}
	} else {
		createErrorNotif("Invalid information...");
	}
}

function createErrorNotif(text) {
	var notif = document.createElement("div");
	notif.setAttribute('class', "errorNotif");
	notif.appendChild(document.createTextNode(text));
	document.getElementsByTagName('body')[0].appendChild(notif);
	setTimeout(function() {
		var toDel = document.getElementsByClassName("errorNotif")[0];
		toDel.parentNode.removeChild(toDel);
	}, 5000);
}

function createSuccessNotif(text) {
	var notif = document.createElement("div");
	notif.setAttribute('class', "successNotif");
	notif.appendChild(document.createTextNode(text));
	document.getElementsByTagName('body')[0].appendChild(notif);
	setTimeout(function() {
		var toDel = document.getElementsByClassName("successNotif")[0];
		toDel.parentNode.removeChild(toDel);
	}, 5000);
}
