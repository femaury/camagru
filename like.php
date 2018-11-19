<?PHP

require('config/setup.php');

if (isset($_POST['id']) && !empty($_POST['id']) && $_SESSION['auth'] === 1) {

	$stmt = $conn->prepare("SELECT * FROM pictures WHERE pic_id = :id");
	$stmt->bindParam(':id', $_POST['id']);
	$stmt->execute();

	if ($stmt->rowCount()) {

		$stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
		$stmt->bindParam(':name', $_SESSION['user']);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_id = $res['user_id'];

		$stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = :user_id AND pic_id = :pic_id");
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':pic_id', $_POST['id']);
		$stmt->execute();

		if ($stmt->rowCount() === 0) {
			$stmt = $conn->prepare("INSERT INTO likes (user_id, pic_id) VALUES (:user_id, :pic_id)");
			$stmt->bindParam(':user_id', $user_id);
			$stmt->bindParam(':pic_id', $_POST['id']);
			$stmt->execute();

			echo "OK";
		 } else {
			$stmt = $conn->prepare("DELETE FROM likes WHERE user_id = :user_id AND pic_id = :pic_id");
			$stmt->bindParam(':user_id', $user_id);
			$stmt->bindParam(':pic_id', $_POST['id']);
			$stmt->execute();

			echo "OK";
		 }
	}
}
