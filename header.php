<?PHP

require("config/setup.php");
?>
<div id="header">
	<a id="titleLink" href="."><div id="title">CAMAGRU</div></a>
	<div id="menu">
<?PHP
if ($_SESSION['auth'] === 1) {
?>
		<div class="menuItem" id="gallery">Gallery</div>
		<div class="menuItem" id="profile">My Profile</div>
		<div class="menuItem" id="logout">Logout</div>
<?PHP
} else {
?>
		<div class="menuItem" id="gallery">Gallery</div>
		<div class="menuItem" id="signup">Signup</div>
		<div class="menuItem" id="login">Login</div>
<?PHP
}
?>
	</div>
</div>
