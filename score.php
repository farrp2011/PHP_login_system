<!DOCTYPE html>
<?php
	require_once("./users.php");

	$user = new users();
	if(isset($_COOKIE[COL_COOKIE]))
	{
		$user->checkLoggedIn($_COOKIE[COL_COOKIE]);
	}
	$newScore = FALSE;


	$db = new SQLite3(DB_FILE);
	$db->query("CREATE TABLE IF NOT EXISTS game_tb (id INTEGER PRIMARY KEY, user_id INTEGER, score INTEGER );");

	//var_dump($_POST["score"]);
	//var_dump($user->getId());
	//var_dump($newScore);
	//var_dump($user->isLogged());


	if(isset($_POST["score"]) && is_numeric($_POST["score"]) && $user->isLogged())
	{
		$newScore = $_POST["score"];
		$db->query("INSERT INTO game_tb ( user_id , score ) VALUES ( ".$user->getId().", ".$newScore." );");
	}

	$result = $db->query("SELECT ".USERS_TABLE.".".COL_EMAIL.", game_tb.score FROM game_tb LEFT JOIN ".USERS_TABLE." ON game_tb.user_id = ".USERS_TABLE.".".COL_ID." ;");

?>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="styleSheets.css">
</head>

<body>
	<h1>Score Board</h1>
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
		<?php
			while($row = $result->fetchArray())
			{
				echo "";
				echo '<li>'.$row[COL_EMAIL].' got '.$row["score"].'</li>';
			}
		?>
	</main>
</body>

</html>
