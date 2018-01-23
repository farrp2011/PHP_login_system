<!DOCTYPE html>
<?php
	require_once("./users.php");

	$user = new users();
	if(isset($_COOKIE[COL_COOKIE]))
	{
		if($user->checkLoggedIn($_COOKIE[COL_COOKIE]) == FALSE)
		{
			//echo "Over the wall";
			header("Location: index.php");
			exit();
		}
	}

?>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="styleSheets.css">
</head>

<body>
	<h1>Your Profile Page</h1>
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
		<p>Your Email is: <?php echo $user->getEmail(); ?></p>
		<p>Your User ID is: <?php echo $user->getId(); ?></p>
		<p>Your Name is: <?php echo $user->getName(); ?></p>
	</main>
</body>

</html>
