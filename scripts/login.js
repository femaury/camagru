var sLogin = document.getElementById('sLogin');

sLogin.onclick = function() {
	submitLogin();
}

document.getElementById('mLogin').addEventListener("keydown", function(e) {
	if (e.keyCode == 13 || e.which == 13) {
		submitLogin();
	}
});

function submitLogin() {
	var user = document.getElementById('uLogin').value;
	var passwd = document.getElementById('pLogin').value;

	if (user.length < 4) {
		createErrorNotif("Invalid username...");
	} else if (!passwd.match(/[a-z]/g) || !passwd.match(/[A-Z]/g) || !passwd.match(/[0-9]/g) || !passwd.length >= 8) {
		createErrorNotif("Invalid password...");
	} else {

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {

			if (this.readyState == 4 && this.status == 200) {

				var response = this.responseText;
				if (response.substring(0, response.indexOf(':')) == "error") {
					
					if (response.substring(0, response.indexOf(';')) == "error:creds") {
						createErrorNotif("Invalid credentials...");
					} else if (response.substring(0, response.indexOf(';')) == "error:auth") {
						createErrorNotif("Please check your emails to validate this account...");
					}
					document.getElementById('uLogin').value = "";
					document.getElementById('pLogin').value = "";
				} else {
					window.location.reload();
				}
			}
		}
		xhttp.open("POST", "login.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("user=" + user + "&passwd=" + passwd);
	}
}
