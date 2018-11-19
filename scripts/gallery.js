var galleryTab = document.getElementById("gallery");

galleryTab.classList.add("currentItem");

function likePicture(elem) {
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	
		if (this.readyState == 4 && this.status == 200) {

			if (this.responseText.substring(0, 2) == "OK") {

				if (elem.src.includes("resources/heartEmpty.png")) {
					elem.src = "resources/heartFull.png";
					var likes = parseInt(document.getElementById('like' + elem.id).textContent) + 1;
					document.getElementById('like' + elem.id).textContent = likes.toString();
				} else {
					elem.src = "resources/heartEmpty.png";
					var likes = parseInt(document.getElementById('like' + elem.id).textContent) - 1;
					document.getElementById('like' + elem.id).textContent = likes.toString();
				}
			}
		}
	}
	xhttp.open("POST", "like.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("id=" + elem.id);
}


function addNewComment(elemId) {

	var elem = document.getElementById(elemId);
	if (elem.value.trim != "" && elem.value.length < 1000) {
	
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {

			if (this.readyState == 4 && this.status == 200) {

				if (this.responseText.substring(0, 2) == "OK") {

					var container = document.createElement('div');
					container.classList.add('comment');
					
					var userDiv = document.createElement('div');
					userDiv.classList.add('commUser');
					userDiv.textContent = this.responseText.substring(this.responseText.indexOf(':') + 1);
					var tmp = document.createElement('textarea');
					tmp.innerHTML = userDiv.textContent;
					userDiv.textContent = tmp.value;

					var textDiv = document.createElement('div');
					textDiv.classList.add('commText');
					textDiv.textContent = elem.value;

					container.appendChild(userDiv);
					container.appendChild(textDiv);
					var id = elemId.replace(/[^\d.]/g, '');
					document.getElementById('comm' + id).appendChild(container);
					elem.value = "";
				}
			}
		}
		xhttp.open("POST", "comment.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("id=" + elem.id.replace(/[^\d.]/g, '') + "&text=" + encodeURIComponent(elem.value));
	} else {
		createErrorNotif('Comment is empty or exceeds the 1000 character limit...');
	}
}

var newComments = document.getElementsByClassName('newComment');

for (var i = 0; i < newComments.length; i++) {

	newComments[i].addEventListener("keydown", function(e) {
		if ((e.keyCode == 13 || e.which == 13) && !e.shiftKey) {
			addNewComment(this.id);
		}
	});
}
