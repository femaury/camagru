<?PHP

require('config/setup.php');

if (isset($_POST['user']) && is_string($_POST['user']) && isset($_POST['passwd']) && is_string($_POST['passwd'])) {

	$user = htmlspecialchars($_POST['user']);
	$passwd = hash("whirlpool", $_POST['passwd']);

	$stmt = $conn->prepare("SELECT * FROM users WHERE name = :user AND passwd = :passwd");
	$stmt->bindParam(':user', $user);
	$stmt->bindParam(':passwd', $passwd);
	$stmt->execute();
	if ($stmt->rowCount() === 1) {

		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($res['active'] == 1) {

			$_SESSION['user'] = $user;
			$_SESSION['auth'] = 1;

			$stmt = $conn->prepare("SELECT notif FROM users WHERE name = :user");
			$stmt->bindParam(':user', $user);
			$stmt->execute();

			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			$_SESSION['notif'] = $res['notif'];
		} else {
			echo "error:auth;";
		}
	} else {
		echo "error:creds;";
	}
}

?>
<div class="modal" id="mLogin">
	<div class="modalContent">
		<span class="modalClose" id="cLogin">&times;</span>
		<form class="modalForm" novalidate>
			<h1 class="formTitle">Login</h1>
			<div class="formContent">
				<label for="user">Username</label>
				<input id="uLogin" type="text" name="user" placeholder="Enter username..." required>
				<label for="passwd">Password</label>
				<input id="pLogin" type="password" name="passwd" placeholder="Enter password..." required>
				<div class="forgotPass"><a id="forgotBtn">Forgot password?</a></div>
			</div>
		</form>
		<div class="formSubmit" id="sLogin">Submit</div>
	</div>
</div>
<script src="scripts/login.js"></script>
