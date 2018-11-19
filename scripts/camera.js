(function() {
	'use strict';
	var video = document.querySelector('video');
	var canvas = document.querySelector('canvas');

	function takeSnapshot() {

		if (document.getElementById('takePhoto').classList.contains('ready')) {

			if (document.getElementsByClassName('absolute')[1].src) {

				var img = document.getElementById('photo');
				img.src = document.getElementsByClassName('absolute')[1].src;
				img.style.width = "500px";
				img.style.height = "375px";
				document.getElementsByClassName('absolute')[2].src = "resources/" + checkedFilter + ".png";
				document.getElementById('snapshots').classList.add('photoContainer');
				document.getElementById('savePhoto').style.display = "inline";
				setTimeout(function() { window.scrollTo(0,document.body.scrollHeight); }, 1);
			} else {
				var img = document.getElementById('photo');
				var context;
				var width = video.offsetWidth;
				var height = video.offsetHeight;
	
				canvas.width = width;
				canvas.height = height;
	
				context = canvas.getContext('2d');
				context.drawImage(video, 0, 0, width, height);
	
				img.src = canvas.toDataURL('image/png');
				document.getElementsByClassName('absolute')[2].src = "resources/" + checkedFilter + ".png";
				document.getElementById('snapshots').classList.add('photoContainer');
				document.getElementById('savePhoto').style.display = "inline";
				setTimeout(function() { window.scrollTo(0,document.body.scrollHeight); }, 1);
			}
		} else {

			createErrorNotif('Please select a filter before taking a picture...');
		}
	}

	if (navigator.mediaDevices) {
		navigator.mediaDevices.getUserMedia({ video: true })
		.then(function(mediaStream) {
					var vid = document.querySelector('video');
					vid.srcObject = mediaStream;
		})
		.catch(function(err) {
					console.log('Error trying to use getUserMedia: ' + err);
		});
	}

	if (document.getElementById('takePhoto')) {
		document.getElementById('takePhoto').addEventListener('click', takeSnapshot);
	}
})();

var saveBtn = document.getElementById('savePhoto');

saveBtn.onclick = function() {
	
	var src = document.getElementById('photo').src;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			location.reload();
		}
	}
	xhttp.open("POST", "image.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("src=" + encodeURIComponent(src) + "&filter=" + checkedFilter + ".png");
};

var cameraFilter = document.getElementsByClassName('absolute')[0];
var checkedFilter;

document.getElementsByClassName('filterImg')[0].onclick = function() {
			
	cameraFilter.src = "resources/astronaut_filter.png";
	checkedFilter = "astronaut_filter";
	document.getElementsByClassName('selection')[0].style.backgroundColor = "black";
	document.getElementsByClassName('selection')[1].style.backgroundColor = "white";
	document.getElementsByClassName('selection')[2].style.backgroundColor = "white";
	if (document.getElementById('takePhoto'))
		document.getElementById('takePhoto').classList.add('ready');
}

document.getElementsByClassName('filterImg')[1].onclick = function() {
			
	cameraFilter.src = "resources/wingsuit_filter.png";
	checkedFilter = "wingsuit_filter";
	document.getElementsByClassName('selection')[0].style.backgroundColor = "white";
	document.getElementsByClassName('selection')[1].style.backgroundColor = "black";
	document.getElementsByClassName('selection')[2].style.backgroundColor = "white";
	if (document.getElementById('takePhoto'))
		document.getElementById('takePhoto').classList.add('ready');
}

document.getElementsByClassName('filterImg')[2].onclick = function() {
			
	cameraFilter.src = "resources/motorcycle_filter.png";
	checkedFilter = "motorcycle_filter";
	document.getElementsByClassName('selection')[0].style.backgroundColor = "white";
	document.getElementsByClassName('selection')[1].style.backgroundColor = "white";
	document.getElementsByClassName('selection')[2].style.backgroundColor = "black";
	if (document.getElementById('takePhoto'))
		document.getElementById('takePhoto').classList.add('ready');
}

function uploadFile(elem) {

	var file = elem.files[0];

	if (file) {

		if (file.size > 50000000) {
			createErrorNotif('File is too large...');
		} else {
			var reader = new FileReader();
			var newImg = document.getElementsByClassName('absolute')[1];

			reader.onload = function(e) {

				var img = new Image();
				img.src = e.target.result;
				img.onload = function() {

					var canvas = document.createElement('canvas');
					canvas.width = 500;
					canvas.height = 375;
					var ctx = canvas.getContext('2d');
					ctx.drawImage(img, 0, 0, 500, 375);
					newImg.src = canvas.toDataURL('image/png');
					document.getElementById('fileRemove').style.display = "inline";
				}
			}
			reader.readAsDataURL(file);
		}
	}
}

var removeBtn = document.getElementById('fileRemove');

removeBtn.onclick = function() {

	document.getElementsByClassName('absolute')[1].removeAttribute('src');
	removeBtn.style.display = "none";
}
