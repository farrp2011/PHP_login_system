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
	//$db->close();
	//var_dump($_POST["score"]);
	//var_dump($user->getId());
	//var_dump($newScore);
	//var_dump($user->isLogged());


	if(isset($_POST["score"]) && is_numeric($_POST["score"]) && $user->isLogged())
	{
		$newScore = $_POST["score"];
		$smt = $db->prepare("INSERT INTO game_tb ( user_id , score ) VALUES ( :id , :score );");
		$smt->bindValue(":id", $user->getId(), SQLITE3_INTEGER);
		$smt->bindValue(":score", $_POST["score"], SQLITE3_INTEGER);
		$result = $smt->execute();
		//$db->close();
	}
	//$db-> new SQLite3(DB_FILE);
	$result = $db->query("SELECT ".USERS_TABLE.".".COL_NAME.", game_tb.score FROM game_tb LEFT JOIN ".USERS_TABLE." ON game_tb.user_id = ".USERS_TABLE.".".COL_ID." ORDER BY score DESC ;");

?>
<html>
<head>
	<title>Score Board</title>
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
		<ol>
		<?php
			while($row = $result->fetchArray())
			{
				echo '<li>'.$row[COL_NAME].' got a score of '.$row["score"].'</li>';
			}
			$db->close();
		?>
		</ol>
	</main>
</body>

</html>
