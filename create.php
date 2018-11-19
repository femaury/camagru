<?PHP

require('config/setup.php');

if (isset($_POST['username']) && is_string($_POST['username']) && isset($_POST['passwd']) && is_string($_POST['passwd']) && isset($_POST['email'])) {

	$username = htmlspecialchars($_POST['username']);
	$email = $_POST['email'];

	$uppercase = preg_match('/[A-Z]/', $_POST['passwd']);
	$lowercase = preg_match('/[a-z]/', $_POST['passwd']);
	$number    = preg_match('/[0-9]/', $_POST['passwd']);

	if(!$uppercase || !$lowercase || !$number || strlen($_POST['passwd']) < 8) {
		echo "error:passwd;";
	} elseif (strlen($username) < 4 || strlen($username) > 50) {
		echo "error:len;";
	} else {
		$passwd = hash("whirlpool", $_POST['passwd']);
	
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo "error:email;";
		} else {

			$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
			$stmt->bindParam(':email', $email);
			$stmt->execute();

			if ($stmt->rowCount() === 1) {
				echo "error:email2;";
			} else {
	
				$stmt = $conn->prepare("SELECT * FROM users WHERE name = :username");
				$stmt->bindParam(':username', $username);
				$stmt->execute();
				if ($stmt->rowCount() === 0) {
			
					while (true) {
						$emailCode = md5(dechex(rand(0, 1000000)));
						
						$stmt = $conn->prepare("SELECT * FROM users WHERE code = :code");
						$stmt->bindParam(':code', $emailCode);
						$stmt->execute();
						if ($stmt->rowCount() === 0)
							break ;
					}
			
					$stmt = $conn->prepare("INSERT INTO users (name, passwd, email, code)
						VALUES (:username, :passwd, :email, :code)");
					$stmt->bindParam(':username', $username);
					$stmt->bindParam(':passwd', $passwd);
					$stmt->bindParam(':email', $email);
					$stmt->bindParam(':code', $emailCode);
					$stmt->execute();
			
					$subject = "CAMAGRU | Signup Verification";
					$message = "Thanks for joining Camagru!\r\nYour account has been created, to log in you now only need to click the following activation link:\r\n\nhttp://localhost:8080/verify.php?id=". $emailCode ."\r\n";
					$header = 'From: noreply@camagru.com' . "\r\n";
			
					mail($email, $subject, $message, $header);
				} else {
					echo "error:user;";
				}
			}
		}
	}
}

?>
<div class="modal" id="mCreate">
	<div class="modalContent">
		<span class="modalClose" id="cCreate">&times;</span>
		<form class="modalForm" novalidate>
			<h1 class="formTitle">New Account</h1>
			<div class="formContent">
				<label for="user">Username</label>
				<input id="uCreate" type="text" name="user" placeholder="Enter username..." required>
				<label for="email">Email</label>
				<input id="eCreate" type="email" name="email" placeholder="Enter email address..." required>
				<label for="passwd">Password</label>
				<input type="password" class="passCheck" id="pCreate" name="passwd" placeholder="Enter password..." required>
			</div>
		</form>
		<div class="formSubmit" id="sCreate">Submit</div>
	</div>
	<div id="passPolicy">
	  <h4>Password must contain:</h4>
	  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
	  <p id="capital" class="invalid">An <b>uppercase</b> letter</p>
	  <p id="number" class="invalid">A <b>digit</b></p>
	  <p id="length" class="invalid">At least <b>8 characters</b></p>
	</div>
</div>
<script src="scripts/create.js"></script>
<script src="scripts/passcheck.js"></script>
