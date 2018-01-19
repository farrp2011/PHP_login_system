<!DOCTYPE html>

<?php
	require_once("./users.php");
?>

<html>
<head>
	<title>Registration</title>
</head>

<body>
	<main>
		<form action="./welcome.php" method="post">
			Email: <input type="text" name=<?php echo'"'.COL_EMAIL.'"' ?>>
			Password: <input type="password" name=<?php echo'"'.COL_PASSWORD.'"' ?>>
			<input type="submit" value="Register">
		</form>
	</main>
</body>

</html>
