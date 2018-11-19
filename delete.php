<?PHP

require('config/setup.php');

if (isset($_POST['id']) && !empty($_POST['id']) && $_SESSION['auth'] === 1) {

	$stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
	$stmt->bindParam(':name', $_SESSION['user']);
	$stmt->execute();
	$res = $stmt->fetch(PDO::FETCH_ASSOC);
	$user_id = $res['user_id'];

	$stmt = $conn->prepare("SELECT link FROM pictures WHERE pic_id = :pic_id AND user_id = :user_id");
	$stmt->bindParam(':pic_id', $_POST['id']);
	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();

	$link = realpath($stmt->fetch(PDO::FETCH_ASSOC)['link']);

	$stmt = $conn->prepare("DELETE FROM pictures WHERE pic_id = :pic_id AND user_id = :user_id");
	$stmt->bindParam(':pic_id', $_POST['id']);
	$stmt->bindParam(':user_id', $user_id);
	$stmt->execute();

	if ($stmt->rowCount() == 1) {
		
		$stmt = $conn->prepare("DELETE FROM likes WHERE pic_id = :pic_id");
		$stmt->bindParam(':pic_id', $_POST['id']);
		$stmt->execute();

		$stmt = $conn->prepare("DELETE FROM comments WHERE pic_id = :pic_id");
		$stmt->bindParam(':pic_id', $_POST['id']);
		$stmt->execute();

		chmod("resources/userpics", 0777);
		unlink($link);
		chmod("resources/userpics", 0755);
	}
}
