<!DOCTYPE html>
<?php
	require_once("./users.php");


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
</head>

<body>
	<h1>Login</h1>
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
