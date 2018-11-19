// ---- Login / Create / Forgot ---- //

var mLogin = document.getElementById('mLogin');
var mCreate = document.getElementById('mCreate');
var mForgot = document.getElementById('mForgot');

var loginBtn = document.getElementById('login');
var createBtn = document.getElementById('signup');
var forgotBtn = document.getElementById('forgotBtn');
var logoutBtn = document.getElementById('logout');
var profileBtn = document.getElementById('profile');
var galleryBtn = document.getElementById('gallery');

// Gallery Button //

if (galleryBtn) {
	galleryBtn.onclick = function() {
		window.location.href = "gallery.php";
	}
}

// Logout Button //

if (logoutBtn) {
	logoutBtn.onclick = function() {
		window.location.href = "logout.php";
	}
}

// Profile Button //

if (profileBtn) {
	profileBtn.onclick = function() {
		window.location.href = "profile.php";
	}
}

// Display Modals //

if (loginBtn) {
	loginBtn.onclick = function() {
		mLogin.style.display = "block";
		loginBtn.classList.add("currentItem");
	}
}

if (createBtn) {
	createBtn.onclick = function() {
		mCreate.style.display = "block";
		createBtn.classList.add("currentItem");
	}
}

if (forgotBtn) {
	forgotBtn.onclick = function() {
		mForgot.style.display = "block";
		mLogin.style.display = "none";
	}
}

var cLogin = document.getElementById('cLogin');
var cCreate = document.getElementById('cCreate');
var cForgot = document.getElementById('cForgot');

// Hide Modals //

if (cLogin) {
	cLogin.onclick = function() {
		mLogin.style.display = "none";
		loginBtn.classList.remove("currentItem");
	}
}

if (cForgot) {
	cForgot.onclick = function() {
		mForgot.style.display = "none";
	}
}

if (cCreate) {
	cCreate.onclick = function() {
		mCreate.style.display = "none";
		createBtn.classList.remove("currentItem");
	}
}

window.onclick = function(event) {
	if (event.target.className == "modal") {
		if (mLogin) {
			mLogin.style.display = "none";
			if (loginBtn.classList.contains("currentItem"))
				loginBtn.classList.remove("currentItem");
		}
		if (mCreate) {
			mCreate.style.display = "none";
			if (createBtn.classList.contains("currentItem"))
				createBtn.classList.remove("currentItem");
		}
		if (mForgot) {
			mForgot.style.display = "none";
		}
	}
}

// Error Notification Function //

function createErrorNotif(text) {
	var notif = document.createElement("div");
	notif.setAttribute('class', "errorNotif");
	notif.appendChild(document.createTextNode(text));
	document.getElementsByTagName('body')[0].appendChild(notif);
	
    var fadeTarget = document.getElementsByClassName("errorNotif")[document.getElementsByClassName("errorNotif").length - 1];
    setTimeout(function() {
		var fadeEffect = setInterval(function () {
			if (!fadeTarget.style.opacity) {
				fadeTarget.style.opacity = 1;
			}
			if (fadeTarget.style.opacity > 0) {
				fadeTarget.style.opacity -= 0.1;
			} else {
				clearInterval(fadeEffect);
			}
		}, 100);
	}, 2000);

	setTimeout(function() {
		var toDel = document.getElementsByClassName("errorNotif")[document.getElementsByClassName("errorNotif").length - 1];
		toDel.parentNode.removeChild(toDel);
	}, 4000);
}

function createSuccessNotif(text) {
	var notif = document.createElement("div");
	notif.setAttribute('class', "successNotif");
	notif.appendChild(document.createTextNode(text));
	document.getElementsByTagName('body')[0].appendChild(notif);

    var fadeTarget2 = document.getElementsByClassName("successNotif")[document.getElementsByClassName("successNotif").length - 1];
    setTimeout(function() {
		var fadeEffect2 = setInterval(function () {
			if (!fadeTarget2.style.opacity) {
				fadeTarget2.style.opacity = 1;
			}
			if (fadeTarget2.style.opacity > 0) {
				fadeTarget2.style.opacity -= 0.1;
			} else {
				clearInterval(fadeEffect2);
			}
		}, 100);
	}, 2000);

	setTimeout(function() {
		var toDel = document.getElementsByClassName("successNotif")[document.getElementsByClassName("successNotif").length - 1];
		toDel.parentNode.removeChild(toDel);
	}, 4000);
}
