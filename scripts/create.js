var sCreate = document.getElementById('sCreate');

sCreate.onclick = function() {
	submitCreate();
};

document.getElementById('mCreate').addEventListener("keydown", function (e) {
	if (e.keyCode == 13 || e.which == 13) {
		submitCreate();
	}
});

function submitCreate() {
	var user = document.getElementById('uCreate').value;
	var email = document.getElementById('eCreate').value;
	var passwd = document.getElementById('pCreate').value;

	if (user.length < 4 || user.length > 50) {
		createErrorNotif("Username needs to be between 4 and 50 characters...");
	} else if (!passwd.match(/[a-z]/g) || !passwd.match(/[A-Z]/g) || !passwd.match(/[0-9]/g) || !passwd.length >= 8) {
		createErrorNotif("Invalid password...");
	} else {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var response = this.responseText;
				if (response.substring(0, response.indexOf(':')) == "error") {
					if (response.substring(0, response.indexOf(';')) == "error:user") {
						createErrorNotif("Username already taken...");
					} else if (response.substring(0, response.indexOf(';')) == "error:len") {
						createErrorNotif("Username needs to be between 4 and 50 characters long...")
					} else if (response.substring(0, response.indexOf(';')) == "error:passwd") {
						createErrorNotif("Invalid password...")
					} else if (response.substring(0, response.indexOf(';')) == "error:email") {
						createErrorNotif("Invalid email address...");
					} else if (response.substring(0, response.indexOf(';')) == "error:email2") {
						createErrorNotif("Email address already in use...");
					}
				} else {
					createSuccessNotif("User created! Email sent for confirmation...");
					document.getElementById('mCreate').style.display = "none";
					document.getElementById('signup').classList.remove("currentItem");
				}
				document.getElementById('uCreate').value = "";
				document.getElementById('eCreate').value = "";
				document.getElementById('pCreate').value = "";
				resetPassCheck();
			}
		}
		xhttp.open("POST", "create.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("username=" + user + "&passwd=" + passwd + "&email=" + email);
	}
}
