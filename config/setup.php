<?PHP

session_start();

try {

	$conn = new PDO("mysql:host=127.0.0.1", "root", "root42");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "CREATE DATABASE IF NOT EXISTS camagru";
	$conn->exec($sql);
}

catch(PDOException $err) {

	echo $sql . "<br>" . $err->getMessage();
}

$conn = NULL;

include("config/database.php");

?>
