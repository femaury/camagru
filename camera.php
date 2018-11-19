<?PHP
require('config/setup.php');

if ($_SESSION['auth'] !== 1)
	header("Location: .");
?>
<div id="wrapper">
	<div id="main">
		<div id="camera">
			<img id="topImg" class="absolute">
			<img class="absolute">
			<video id="cameraStream" width="500" autoplay>Video stream not available</video>
			<input id="fileInput" type="file" accept=".jpg, .png" onChange="uploadFile(this)">
			<button id="fileRemove">Remove File</button>
		</div>
		<div id="filterText">Pick a filter!</div>
		<div id="filters">
			<div class="selection">
				<img class="filterImg" src="resources/astronaut_filter.png">
			</div>
			<div class="selection">
				<img class="filterImg" src="resources/wingsuit_filter.png">
			</div>
			<div class="selection">
				<img class="filterImg" src="resources/motorcycle_filter.png">
			</div>
		</div>
		<?PHP if ($_SESSION['auth'] === 1) {echo '<div class="center"><button id="takePhoto">Take photo</button></div>';} ?>
		<canvas id="canvas"></canvas>
		<div id="snapshots">
			<img class="absolute">
			<img id="photo">
		</div>
		<div class="center">
			<button id="savePhoto">Save photo</button>
		</div>
	</div>
	<div id="side">
		<div id="sideTitle">Last Photos</div>
		<div id="myPhotos">
			<?PHP
			$stmt = $conn->prepare("SELECT user_id FROM users WHERE name = :name");
			$stmt->bindParam(':name', $_SESSION['user']);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$user_id = $result['user_id'];
			
			$stmt = $conn->prepare("SELECT * FROM pictures WHERE user_id = :user_id ORDER BY pic_id DESC LIMIT 5");
			$stmt->bindParam(':user_id', $user_id);
			$stmt->execute();
			$pictures = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($pictures as $pic)
				echo '<img class="userPhotos" src="'. $pic['link'] .'">';
			?>
		</div>
	</div>
</div>
<script src="scripts/camera.js"></script>
