<?PHP

require('config/setup.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {

	$stmt = $conn->prepare("SELECT * FROM users WHERE code = :code");
	$stmt->bindParam(':code', $_GET['id']);
	$stmt->execute();
	if ($stmt->rowCount() === 1) {

		$stmt = $conn->prepare("UPDATE users SET active = 1 WHERE code = :mailcode");
		$stmt->bindParam(':mailcode', $_GET['id']);
		$stmt->execute();
	}
}

header("Location: .");

?>
