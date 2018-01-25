<!DOCTYPE html>

<?php
	require_once("./users.php");

	$user = new users();
	if(isset($_COOKIE[COL_COOKIE]))
	{
		//echo "there is a cookie\n";
		if($user->checkLoggedIn($_COOKIE[COL_COOKIE]) == TRUE);
		{
			//echo"\n We are logged in\n";
			header("Location: index.php");
			exit();
		}
	}

?>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" href="styleSheets.css">
</head>

<body>
	<h1>Registration</h1>
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
		<p style="color:red"> Warning!!! No HTTPS!!! Passwords are sent over the wire in clear text! Use a unique password that is different from any other password you use. </p>
		<form action="./welcome.php" method="post">
			Email: <input type="text" name=<?php echo'"'.COL_EMAIL.'"' ?>><br/>
			Password: <input type="password" name=<?php echo'"'.COL_PASSWORD.'"' ?>><br/>
			Name: <input type="text" name=<?php echo '"'.COL_NAME.'"' ?>><br/>
			<input type="submit" value="Register">
		</form>

	</main>
</body>

</html>
