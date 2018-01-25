<!DOCTYPE html>

<?php
	require_once("./users.php");

	//check the email and password was posted correctly or if the user is lo
	if(isset($_POST[COL_EMAIL]) == FALSE || isset($_POST[COL_PASSWORD]) == FALSE)
	{
		header("Location: login.php");//add a get with a error later
		exit();
	}
	//okay the post was good now we have to see if the everthing else is cool

	$user = new users();
	$err = "";

	//var_dump($user->login($_POST[COL_EMAIL], $_POST[COL_PASSWORD]));
	$err = $user->login($_POST[COL_EMAIL], $_POST[COL_PASSWORD]);
	var_dump($err);
	if(is_int($err) == TRUE )
	{
		//Oh No there is somthing wrong
		//send them back over the wall with an err
		header("Location: login.php?err=".ERR_BAD_PASSWORD);
		exit();
	}

	//everthing is good time to move on!!!

	header("Location: profile.php");
	exit();

?>

<html>
<head>
	<title></title>
</head>

<body>
	<h1>You Should Not Be Here</h1>
</body>

</html>
