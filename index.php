<!DOCTYPE html>
<?php
	require_once("./users.php");

	$user = new users();
	if(isset($_COOKIE[COL_COOKIE]))
	{
		$user->checkLoggedIn($_COOKIE[COL_COOKIE]);
	}
?>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="styleSheets.css">
</head>

<body>
	<h1>Home Page</h1>
	<nav>
		<ul>
			<li> <a href="index.php">Home</a> </li>
			<li> <a href="game.php">Game</a></li>
			<li> <a href="score.php">Score Board</a></li>
			<?php
				if($user->isLogged())
				{
					//user is logged in
					echo '<li> <a href="logout.php">Logout</a> </li>';
					echo '<li> <a href="profile.php">Profile</a> </li>';
				}
				else
				{
					//user is not logged in
					echo '<li> <a href="login.php">Login</a> </li>';
					echo '<li> <a href="registration.php">Registration</a> </li>';
				}
			 ?>
		</ul>
	</nav>
	<main>
		<p>Welcome to this is a simple and ugly website to demostrate a login system using PHP and SQLite3.</p>
		<p>The sources code is avaiable at <a href="https://github.com/farrp2011/PHP_login_system">GitHub</a>.</p>
		<p>This site was created by Paul Farr (farrp2011@live.com)</p>
	</main>
</body>

</html>
