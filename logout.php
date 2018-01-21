<!DOCTYPE html>
<?php
	require_once("./users.php");

	//$user = new users();
	//$user->checkLoggedIn($_COOKIE[COL_COOKIE]);
	setcookie(COL_COOKIE, "-1", time()-1);
?>
<html>
<head>
	<title>Logout</title>
	<link rel="stylesheet" href="styleSheets.css">
</head>

<body>
	<h1>Logged Out</h1>
	<nav>
		<ul>
			<li> <a href="index.php">Home</a> </li>
			<li> <a href="game.php">Game</a> </li>
			<li> <a href="score.php">Score Board</a> </li>
			<li> <a href="login.php">Login</a> </li>
			<li> <a href="registration.php">Registration</a> </li>
		</ul>
	</nav>
	<main>
		<p>you are logged out</p>
	</main>
</body>

</html>
