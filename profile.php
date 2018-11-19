<?PHP

require("config/setup.php");

if ($_SESSION['auth'] !== 1)
	header("Location: .");

?>
<html>
	<head>
		<title>Camagru</title>
		<link rel="stylesheet" href="stylesheets/header.css">
		<link rel="stylesheet" href="stylesheets/index.css">
		<link rel="stylesheet" href="stylesheets/modal.css">
		<link rel="stylesheet" href="stylesheets/profile.css">
		<link rel="stylesheet" href="stylesheets/footer.css">
		<link rel="shortcut icon" href="resources/CLogo.png">
	</head>
	<body>
		<?PHP require("header.php"); ?>
		<?PHP require("login.php"); ?>
		<?PHP require("create.php"); ?>
		<?PHP require("forgot.php"); ?>
		<div id="profileContent">
			<div id="userName"><?PHP echo $_SESSION['user']; ?></div>
			<div id="modifContainer">
				<div class="modifChild">
					<div class="modifTitle">Change username <span class="arrow" id="arrowName">&or;</span></div>
					<div class="modifHidden">
						<input id="newName" type="text" placeholder="Enter new username...">
						<button class="sendBtn" id="sendName">Submit</button>	
					</div>
				</div>
				<div class="modifChild">
					<div class="modifTitle">Change password <span class="arrow" id="arrowPass">&or;</span></div>
					<div class="modifHidden">
						<input id="oldPass" type="password" placeholder="Enter current password...">
						<input class="passCheck" id="newPass" type="password" placeholder="Enter new password..." title="Password must contain at least one upper and one lower case character, one digit and 8 or more characters">
						<button class="sendBtn" id="sendPass">Submit</button>
					</div>
				</div>
				<div class="modifChild">
					<div class="modifTitle">Change email address <span class="arrow" id="arrowEmail">&or;</span></div>
					<div class="modifHidden">
						<input id="newEmail" type="email" placeholder="Enter new email address...">
						<button class="sendBtn" id="sendEmail">Submit</button>	
					</div>
					<div id="notifContainer">
					<input id="notifCheck" type="checkbox" value="yes" onchange="toggleCheckbox(this)" <?PHP echo $_SESSION['notif'] ? "checked" : ""; ?>>  I wish to be notified when someone comments my pictures
					</div>
				</div>
			</div>
		</div>
		<div id="myPicsTitle">My Photos</div>
		<div id="myPictures">
<?PHP
	$stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
	$stmt->bindParam(':name', $_SESSION['user']);
	$stmt->execute();
	$user_id = $stmt->fetch(PDO::FETCH_ASSOC)['user_id'];

	$stmt = $conn->prepare("SELECT * FROM pictures INNER JOIN users ON pictures.user_id = users.user_id WHERE users.user_id = :user_id ORDER BY date DESC");
	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();
	$pictures = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach ($pictures as $pic) {

		echo '<div class="photoContainer">
				<img class="photo" src="'. $pic['link'] .'">
				<div id="'. $pic['pic_id'] .'" class="deletePhoto" onclick="deletePhoto(this)">DELETE</div>
			</div>';
	}
?>
		</div>
		<?PHP require("footer.php"); ?>
		<script src="scripts/index.js"></script>
		<script src="scripts/profile.js"></script>
	</body>
</html>
