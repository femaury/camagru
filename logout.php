<?PHP

require('config/setup.php');

if (isset($_SESSION['auth']) && $_SESSION['auth'] === 1) {
	$_SESSION = array();
	session_destroy();
}

header("Location: .");

?>
