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
</head>

<body>
	<h1>Home</h1>
	<main>
		<?php
			if($user->isLogged())
			{
				echo "<p>Logged in as ".$user->getEmail().', <a href="logout.php">Logout</a></p>';
			}

			echo'<ul>';

			if($user->isLogged() == FALSE)
			{
				echo '<li><a href="login.php">Login</a></li>';
				echo '<li><a href="registration.php">Register</a></li>';
			}
			if($user->isLogged())
			{
				echo '<li><a href="profile.php">Profile</a></li>';
			}

			echo '</ul>';
		?>
	</main>
</body>

</html>
