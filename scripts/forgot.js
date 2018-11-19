var sForgot = document.getElementById('sForgot');

sForgot.onclick = function() {
	submitForgot();
}

document.getElementById('mForgot').addEventListener("keydown", function(e) {
	if (e.keyCode == 13 || e.which == 13) {
		e.preventDefault();
		submitForgot();
	}
});

function submitForgot() {
	var email = document.getElementById('eForgot').value;

	var mailCheck = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (mailCheck.test(String(email).toLowerCase())) {

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {

			if (this.readyState == 4 && this.status == 200) {

				var response = this.responseText;
				if (response.substring(0, response.indexOf(';')) == "error") {
					createErrorNotif("User with this address not found...");
					document.getElementById('eForgot').value = "";
				} else {
					createSuccessNotif("Reset email sent!");
					setTimeout(function() {
						window.location.href = ".";
					}, 2000);
				}
			}
		}
		xhttp.open("POST", "forgot.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("email=" + email);
	} else {
		createErrorNotif("Invalid email address...");
	}
}
