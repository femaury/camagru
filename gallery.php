<?PHP

require("config/setup.php");

?>
<html>
	<head>
		<title>Camagru</title>
		<link rel="stylesheet" href="stylesheets/header.css">
		<link rel="stylesheet" href="stylesheets/index.css">
		<link rel="stylesheet" href="stylesheets/modal.css">
		<link rel="stylesheet" href="stylesheets/gallery.css">
		<link rel="stylesheet" href="stylesheets/footer.css">
		<link rel="shortcut icon" href="resources/CLogo.png">
	</head>
	<body>
		<?PHP require("header.php"); ?>
		<?PHP require("login.php"); ?>
		<?PHP require("create.php"); ?>
		<?PHP require("forgot.php"); ?>
<div class="galleryContainer">
	<div class="galleryItems">
		<?PHP
		$stmt = $conn->prepare("SELECT * FROM pictures INNER JOIN users ON pictures.user_id = users.user_id ORDER BY date DESC");
		$stmt->execute();
		$pictures = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (isset($_POST['page']) && !empty($_POST['page']))
			$page = intval($_POST['page']);
		else
			$page = 1;
		$pageCount = ceil($stmt->rowCount() / 6);
		$counter = 0;
		foreach ($pictures as $pic) {
			if ($counter >= $page * 6 - 6 && $counter < $page * 6) {
				echo '<div class="photoContainer">
						<img class="galleryPhotos" src="'. $pic['link'] .'">
						<div class="photoTitle">
							<div class="userName">'. $pic['name'] .'</div>
							<div class="likesContainer"><div id="like'. $pic['pic_id'] .'" class="likes">';
				$stmt = $conn->prepare("SELECT * FROM likes WHERE pic_id = :pic_id");
				$stmt->bindParam(':pic_id', $pic['pic_id']);
				$stmt->execute();
				echo $stmt->rowCount();
				echo '</div><img class="heart" id="'. $pic['pic_id'] .'" onclick="likePicture(this)" src="resources/heart';
				if ($_SESSION['auth'] === 1) {

					$stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");
					$stmt->bindParam(':name', $_SESSION['user']);
					$stmt->execute();
					$user_id = $stmt->fetch(PDO::FETCH_ASSOC)['user_id'];

					$stmt = $conn->prepare("SELECT * FROM likes WHERE pic_id = :pic_id AND user_id = :user_id");
					$stmt->bindParam(':pic_id', $pic['pic_id']);
					$stmt->bindParam(':user_id', $user_id);
					$stmt->execute();
					if ($stmt->rowCount())
						echo 'Full';
					else
						echo 'Empty';
				} else {
					echo 'Empty';
				}
				echo '.png"></div>
						</div>
						<hr>
						<div id="comm'. $pic['pic_id'] .'" class="photoComments">';
				$stmt = $conn->prepare("SELECT * FROM comments INNER JOIN users ON comments.user_id = users.user_id WHERE pic_id = :pic_id");
				$stmt->bindParam(':pic_id', $pic['pic_id']);
				$stmt->execute();
				$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($comments as $comm) {
					echo '<div class="comment">
							<div class="commUser">'. $comm['name'] .':</div>
							<div class="commText">'. $comm['text'] .'</div>
							</div>';
				}
				echo '</div>
						<div class="addComment">';
				if ($_SESSION['auth'] === 1)
					echo '<input id="input'. $pic['pic_id'] .'" class="newComment" type="text" placeholder="Add new comment...">';
				echo '</div>
					</div>';
			}
			$counter++;
		}
		?>
	</div>
	<form class="pageLinks" method="POST">
	<?PHP 
		for ($i = 1; $i <= $pageCount; $i++) {
			if ($page == $i)
				echo '<button class="links currentLink" type="submit" name="page" value="'.$i.'">'.$i.'</button>';
			else
				echo '<button class="links" type="submit" name="page" value="'.$i.'">'.$i.'</button>';
		}
	?>
	</form>
</div>
		<?PHP require("footer.php"); ?>
		<script src="scripts/index.js"></script>
		<script src="scripts/gallery.js"></script>
	</body>
</html>
