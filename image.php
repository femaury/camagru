<?PHP

require('config/setup.php');

if ($_SESSION['auth'] !== 1)
	header("Location: .");

if (isset($_POST['src']) && is_string($_POST['src']) && isset($_POST['filter']) && is_string($_POST['filter'])) {

	$src = explode(',', $_POST['src'], 2)[1];
	$src = base64_decode($src);
	$filters = array("astronaut_filter.png", "wingsuit_filter.png", "motorcycle_filter.png");
		
	if (file_put_contents("tmp.png", $src)) {

		$img = imagecreatefrompng("tmp.png");
		unlink("tmp.png");

		if (in_array($_POST['filter'], $filters)) {
			
			$filter = imagecreatefrompng("resources/". $_POST['filter']);
			imagecopy($img, $filter, 0, 0, 0, 0, 500, 375);

			$stmt = $conn->prepare("SELECT user_id FROM users WHERE name = :name");
			$stmt->bindParam(':name', $_SESSION['user']);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$user_id = $result['user_id'];

			$stmt = $conn->prepare("SELECT pic_id FROM pictures ORDER BY pic_id DESC LIMIT 1");
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$new_id = $result['pic_id'] + 1;
			$link = "resources/userpics/img_". $new_id .".png";

			if (imagepng($img, $link)) {

	
				$stmt = $conn->prepare("INSERT INTO pictures (user_id, link) VALUES (:user, :link)");
				$stmt->bindParam(':user', $user_id);
				$stmt->bindParam(':link', $link);
				$stmt->execute();
			}
		}
	}
}

?>
