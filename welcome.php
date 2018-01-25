<!DOCTYPE html>
<?php
	require_once("./users.php");


	//check email and password is cool
	if(isset($_POST[COL_EMAIL]) == FALSE || isset($_POST[COL_PASSWORD]) == FALSE || isset($_POST[COL_NAME]) == FALSE)
	{
		header("Location: registration.php");
		exit();
	}


	//lets create a user
	//if we get a true back we are good!!!! and the user data will be in the obj
	//if we got a false back we have a bad email
	$newUser = new users();
	$isPasswordGood = TRUE;

	if($newUser->creatNewUser($_POST[COL_EMAIL], $_POST[COL_PASSWORD], $_POST[COL_NAME]) == FALSE)//the createNewUser is self cleaning
	{
		$isPasswordGood = FALSE;
	}
	else
	{
		header("Location: login.php");
		exit();
	}
	//don't worry about anything after this
?>
<html>
<head>
	<title>Oops...</title>
	<link rel="stylesheet" href="styleSheets.css">
</head>

<body>
	<h1>Oops...</h1>
	<nav>
		<ul>
			<li> <a href="index.php">Home</a> </li>
			<li> <a href="game.php">Game</a> </li>
			<li> <a href="score.php">Score Board</a> </li>
			<li> <a href="registration.php">Registraion</a> </li>
		</ul>
	</nav>
	<main>
		<?php
			if($isPasswordGood == TRUE)
			{
				//echo "You are in";
			}
			else
			{
				echo "Email Taken or Name Taken";
			}
		?>
	</main>
</body>

</html>
