<?PHP

require('config/setup.php');

if (isset($_POST['email']) && is_string($_POST['email'])) {

	$email = $_POST['email'];

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "error;";
	} else {
		
		$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() === 1) {
			
			$id = $result['user_id'];
			$code = $result['code'];

			$subject = "CAMAGRU | Password Reset";
			$message = "A new password was requested for the camagru account using this email address.\r\nTo activate your new password, click on the following link:\r\n\nIF YOU DID NOT RESET YOUR PASSWORD, PLEASE SIMPLY IGNORE THIS MESSAGE\r\n\nhttp://localhost:8080/reset.php?id=". $id ."&code=". $code ."\r\n";
			$header = 'From: noreply@camagru.com' . "\r\n";

			mail($email, $subject, $message, $header);
		}
	}
}

?>
<div class="modal" id="mForgot">
	<div class="modalContent">
		<span class="modalClose" id="cForgot">&times;</span>
		<form class="modalForm" novalidate>
			<h1 class="formTitle">Send new Password</h1>
			<div class="formContent">
				<label>Send to:</label>
				<input id="eForgot" type="email" name="email" placeholder="Enter your email address..." required>
			</div>
		</form>
		<div class="formSubmit" id="sForgot">Send</div>
	</div>
</div>
<script src="scripts/forgot.js"></script>
