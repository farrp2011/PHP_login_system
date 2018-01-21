<!DOCTYPE html>
<?php
	require_once("./users.php");


	//if the user is logged in send them to the home page
	$user = new users();
	if(isset($_COOKIE[COL_COOKIE]))
	{
		if($user->checkLoggedIn($_COOKIE[COL_COOKIE]) == TRUE)
		{
			header("Location: index.php");
			exit();
		}
	}


	$err = NULL;

	if(isset($_GET["err"]) == TRUE && is_numeric($_GET["err"]) == TRUE)
	{
		//echo 'working';
		$err = $_GET["err"];
	}

?>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="styleSheets.css">
</head>

<body>
	<h1>Login</h1>
	<ul>
		<li> <a href="index.php">Home</a> </li>
		<li> <a href="game.php">Game</a> </li>
		<li> <a href="score.php">Score Board</a> </li>
		<li> <a href="login.php">Login</a> </li>
		<li> <a href="registration.php">Registraion</a> </li>
	</ul>
	<main>
		<?php
			if(is_numeric($err) )
			{
				echo "<p>Bad Email or Password</p>";
			}
		?>
		<br/>
		<form action="_login.php" method="post">
			Email: <input type="text" name=<?php echo '"'.COL_EMAIL.'"' ?>><br/>
			Password: <input type="password" name=<?php echo '"'.COL_PASSWORD.'"' ?>><br/>
			<input type="submit" value="Login">
		</form>
	</main>
</body>

</html>
