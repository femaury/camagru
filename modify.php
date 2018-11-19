<?PHP

require('config/setup.php');

if ($_SESSION['auth'] === 1 && isset($_POST['action'])) {
	
	switch ($_POST['action']) {
	
		case ("name"):
			
			if (isset($_POST['name']) && is_string($_POST['name'])) {

				$newName = htmlspecialchars($_POST['name']);

				if (strlen($newName) > 3 && strlen($newName) < 51) {

					$stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
					$stmt->bindParam(':name', $newName);
					$stmt->execute();

					if ($stmt->rowCount() === 0) {

						$stmt = $conn->prepare("UPDATE users SET name = :newName WHERE name = :oldName");
						$stmt->bindParam(':newName', $newName);
						$stmt->bindParam(':oldName', $_SESSION['user']);
						$stmt->execute();
						$_SESSION['user'] = $newName;
					} else {
						echo "error:taken;";
					}
				} else {
					echo "error:len;";
				}
			}
			break;
		case ("pass"):

			if (isset($_POST['oldPass']) && is_string($_POST['oldPass']) && isset($_POST['newPass']) && is_string($_POST['newPass'])) {
				
				$oldPass = hash("whirlpool", $_POST['oldPass']);

				$uppercase = preg_match('/[A-Z]/', $_POST['newPass']);
				$lowercase = preg_match('/[a-z]/', $_POST['newPass']);
				$number    = preg_match('/[0-9]/', $_POST['newPass']);

				if(!$uppercase || !$lowercase || !$number || strlen($_POST['newPass']) < 8) {
					echo "error:newpass;";
				} else {

					$newPass = hash("whirlpool", $_POST['newPass']);

					$stmt = $conn->prepare("SELECT * FROM users WHERE name = :name AND passwd = :oldPass");
					$stmt->bindParam(':name', $_SESSION['user']);
					$stmt->bindParam(':oldPass', $oldPass);
					$stmt->execute();

					if ($stmt->rowCount() === 1) {

						$stmt = $conn->prepare("UPDATE users SET passwd = :newPass WHERE name = :name");
						$stmt->bindParam(':newPass', $newPass);
						$stmt->bindParam(':name', $_SESSION['user']);
						$stmt->execute();
					} else {
						echo "error:oldpass;";
					}
				}
			}
			break;
		case ("email"):

			if (isset($_POST['email']) && !empty($_POST['email'])) {

				$email = $_POST['email'];

				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					echo "error:email;";
				} else {

					$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
					$stmt->bindParam(':email', $email);
					$stmt->execute();

					if ($stmt->rowCount() === 0) {

						$stmt = $conn->prepare("UPDATE users SET email = :email WHERE name = :name");
						$stmt->bindParam(':email', $email);
						$stmt->bindParam(':name', $_SESSION['user']);
						$stmt->execute();
					} else {
						echo "error:emailtaken;";
					}
				}
			}
			break;
		case ("notif"):

			if (isset($_POST['check']) && !empty($_POST['check'])) {

				if ($_POST['check'] == "true" || $_POST['check'] == "false") {
					
					$check = $_POST['check'] == "true" ? 1 : 0;

					$stmt = $conn->prepare("UPDATE users SET notif = :check WHERE name = :name");
					$stmt->bindParam(':check', $check);
					$stmt->bindParam(':name', $_SESSION['user']);
					$stmt->execute();

					$_SESSION['notif'] = $check;
				}
			}
			break;
	}
}

?>
