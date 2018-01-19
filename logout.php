<!DOCTYPE html>
<?php
	require_once("./users.php");

	//$user = new users();
	//$user->checkLoggedIn($_COOKIE[COL_COOKIE]);
	setcookie(COL_COOKIE, "-1", time()-1);
?>
<html>
<head>
	<title>Home</title>
</head>

<body>
	<h1>Logged Out</h1>
	<main>
		<a href="index.php">Home</a>
	</main>
</body>

</html>
