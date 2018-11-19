<?PHP

require("config/setup.php");

?>
<html>
	<head>
		<title>Camagru</title>
		<link rel="stylesheet" href="stylesheets/header.css">
		<link rel="stylesheet" href="stylesheets/index.css">
		<link rel="stylesheet" href="stylesheets/modal.css">
		<link rel="stylesheet" href="stylesheets/camera.css">
		<link rel="stylesheet" href="stylesheets/footer.css">
		<link rel="shortcut icon" href="resources/CLogo.png">
	</head>
	<body>
		<?PHP require("header.php"); ?>
		<?PHP require("login.php"); ?>
		<?PHP require("create.php"); ?>
		<?PHP require("forgot.php"); ?>
		<?PHP if ($_SESSION['auth'] ===  1) {
			require("camera.php"); 
		} else { ?>
		<div id="loginArrowContainer">
			<div id="loginArrow">
				<img id="arrowImg" src="resources/arrowSignup.png">
			</div>
		</div>
		<div id="indexContainer">
			<div class="box">
				<img class="textPics" src="resources/textLive.png">
				<img class="stockPics" src="resources/stock_astronaut.png">
			</div>
			<div class="box">
				<img class="textPics" id="rightText" src="resources/textYour.png">
				<img class="stockPics" id="rightSide" src="resources/stock_wingsuit.png">
			</div>
			<div class="box">
				<img class="textPics" src="resources/textDreams.png">
				<img class="stockPics" src="resources/stock_motorcycle.png">
			</div>
		</div>
		<?PHP } ?>
		<?PHP require("footer.php"); ?>
		<script src="scripts/index.js"></script>
	</body>
</html>
