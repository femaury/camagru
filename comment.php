<?PHP

require('config/setup.php');

if (isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['text']) && is_string($_POST['text']) && $_SESSION['auth'] === 1) {

	if (strlen($_POST['text']) <= 1000) {
	
		$stmt = $conn->prepare("SELECT * FROM pictures WHERE pic_id = :id");
		$stmt->bindParam(':id', $_POST['id']);
		$stmt->execute();

		if ($stmt->rowCount()) {

			$stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
			$stmt->bindParam(':name', $_SESSION['user']);
			$stmt->execute();
			$user_id = $stmt->fetch(PDO::FETCH_ASSOC)['user_id'];

			$stmt = $conn->prepare("INSERT INTO comments (pic_id, user_id, text) VALUES (:pic_id, :user_id, :text)");
			$stmt->bindParam(':pic_id', $_POST['id']);
			$stmt->bindParam(':user_id', $user_id);
			$stmt->bindParam(':text', htmlspecialchars($_POST['text']));
			$stmt->execute();

			$stmt = $conn->prepare("SELECT * FROM pictures INNER JOIN users ON pictures.user_id = users.user_id WHERE pic_id = :pic_id");
			$stmt->bindParam(':pic_id', $_POST['id']);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($result['notif'] == 1) {
				$email = $result['email'];
				$subject = "CAMAGRU | New Comment!";
				$message = "Hello ". $result['name'] .",\r\n\nUser '". $_SESSION['user'] ."' has just made a new comment on your picture!\r\nTo check it out simply click on the following link:\r\nhttp://localhost:8080/gallery.php\r\n\nTo stop receiving these emails, change your notification preferences by going to your profile page.\r\n";
				$header = 'From: noreply@camagru.com' . "\r\n";
	
				mail($email, $subject, $message, $header);
			}
			echo "OK:" . $_SESSION['user'] .":";
		}
	}
}
