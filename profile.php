<!DOCTYPE html>

<?php
	require_once("./users.php");

	$user = new users();

	//cleaning happens in the method
	if($user->checkLoggedIn($_COOKIE[COL_COOKIE]) == FALSE)
	{
		//some pages are accessible form both users and guest
		//do this by not redirecting them

		header("Location: index.php");
		exit();
	}

?>

<html>
<head>
	<title>Home</title>
</head>

<body>
	<h1>Profile Page</h1>
	<main>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><?php echo $user->getId()?></li>
			<li><?php echo $user->getEmail()?></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</main>
</body>

</html>
