<?PHP

require("config/setup.php");

if (isset($_POST['code']) && is_string($_POST['code']) && isset($_POST['passwd']) && is_string($_POST['passwd'])) {

	$code = htmlspecialchars($_POST['code']);

	$uppercase = preg_match('/[A-Z]/', $_POST['passwd']);
	$lowercase = preg_match('/[a-z]/', $_POST['passwd']);
	$number    = preg_match('/[0-9]/', $_POST['passwd']);

	if(!$uppercase || !$lowercase || !$number || strlen($_POST['passwd']) < 8) {
		echo "error;";
	} else {
		$passwd = hash("whirlpool", $_POST['passwd']);

		$stmt = $conn->prepare("UPDATE users SET passwd = :passwd WHERE code = :code");
		$stmt->bindParam(':passwd', $passwd);
		$stmt->bindParam(':code', $code);
		$stmt->execute();

		if ($stmt->rowCount() == 0)
			echo "error;";
	}
}

if (isset($_GET['id']) && is_string($_GET['id']) && isset($_GET['code']) && is_string($_GET['code'])) {

	$id = htmlspecialchars($_GET['id']);
	$code = htmlspecialchars($_GET['code']);

	$stmt = $conn->prepare("SELECT name FROM users WHERE user_id = :id AND code = :code");
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':code', $code);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$user = $result['name'];
}
?>
<html>
	<head>
		<link rel="stylesheet" href="stylesheets/header.css">
		<link rel="stylesheet" href="stylesheets/index.css">
		<link rel="stylesheet" href="stylesheets/modal.css">
	</head>
	<body>
		<?PHP require("header.php"); ?>
		<div class="modal" id="mReset">
			<div class="modalContent">
				<span class="modalClose" id="cReset">&times;</span>
				<form class="modalForm" novalidate>
					<h1 class="formTitle">Reset Password</h1>
					<div class="formContent">
						<label for="passwd">For user: <?PHP echo $user; ?></label>
						<input class="passCheck" id="pReset" type="password" name="passwd" placeholder="Enter new password..." required>
						<input style="display: none;" id="codeReset" value="<?PHP echo $code; ?>">
					</div>
				</form>
				<div class="formSubmit" id="sReset">Submit</div>
			</div>
			<div id="passPolicy">
			  <h4>Password must contain:</h4>
			  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
			  <p id="capital" class="invalid">An <b>uppercase</b> letter</p>
			  <p id="number" class="invalid">A <b>digit</b></p>
			  <p id="length" class="invalid">At least <b>8 characters</b></p>
			</div>
		</div>
		<script src="scripts/passcheck.js"></script>
		<script src="scripts/reset.js"></script>
	</body>
</html>
