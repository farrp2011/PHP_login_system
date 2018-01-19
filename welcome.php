<!DOCTYPE html>
<?php
	require_once("./users.php");


	//check email and password is cool
	if(isset($_POST[COL_EMAIL]) == FALSE || isset($_POST[COL_PASSWORD]) == FALSE)
	{
		header("Location: registration.php");
		exit();
	}


	//lets create a user
	//if we get a true back we are good!!!! and the user data will be in the obj
	//if we got a false back we have a bad email
	$newUser = new users();
	$isPasswordGood = TRUE;

	if($newUser->creatNewUser($_POST[COL_EMAIL], $_POST[COL_PASSWORD]) == FALSE)//the createNewUser is self cleaning
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
	<tile>Welcome!!!</tite>
</head>

<body>
	<main>
		<?php
			if($isPasswordGood == TRUE)
			{
				echo "You are in";
			}
			else
			{
				echo "Email Taken";
			}
		?>
	</main>
</body>

</html>
