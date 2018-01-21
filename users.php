<?php

/*

Made by Paul Farr

I don't care what you do with this I'm not reliable for anything bad.

*/

define("DB_FILE","/var/www/users.DB");
define("USERS_TABLE", "user_tb");
define("COL_ID", "id");
define("COL_EMAIL", "email");
define("COL_COOKIE", "cookie");
define("COL_PASSWORD", "password");//this is the hash
define("COL_SALT","salt");
define("SALT_LEN",16);//making this much longer will have little effect on secrity

//You should change this when you set up the system for the frist time.
define("PEPPER","a769iyiHSCGS9");//used with the salt for one last bit of secrity

define("ERR_BAD_EMAIL", 5);
define("ERR_BAD_PASSWORD", 6);

class users
{
	private $id;
	private $email;
	private $passwordHash;
	private $salt;//for the password
	private $cookie;//side note, I love cookies
	private $isLogged = FALSE;

	public function isLogged()
	{
		return($this->isLogged);
	}

	public function getId()
	{
		//We will only give the id if the user is logged
		if($this->isLogged())
		{
			return($this->id);
		}
		return(FALSE);
	}

	public function getEmail()
	{
		if($this->isLogged())
		{
			return($this->email);
		}
		return(FALSE);
	}

	private function creatDB()
	{
		$db = new SQLite3(DB_FILE);
		$db->query("CREATE TABLE IF NOT EXISTS "
			.USERS_TABLE." (".COL_ID." INTEGER PRIMARY KEY, "
			.COL_EMAIL." TEXT,"
			.COL_COOKIE." TEXT,"
			.COL_PASSWORD." TEXT,"
			.COL_SALT." TEXT);");
	}

	private function createSalt()
	{
		return(bin2hex(random_bytes(SALT_LEN)));
	}

	private function sha512_hash($_password, $salt)
	{

		return( hash("sha512",PEPPER.$_password.$this->salt));

	}

	public function checkLoggedIn($_cookie)
	{
		//I see all parameters as drity and need to be cleaned
		$this->cookie = cleanInput($_cookie);
		$db = new SQLite3(DB_FILE);
		$result = $db->query("SELECT ".COL_ID.", ".COL_EMAIL." FROM ".USERS_TABLE." WHERE ".COL_COOKIE." = '".$this->cookie."';");
		$row = $result->fetchArray();
		//if the $row var is false the user is logged out and we need to send a false back
		if($row == FALSE)
		{
			return(FALSE);
		}
		//if we made it this farr there is a row with that a cookie we want
		//normaly I would clean the input but it is coming our of the database
		$this->id = $row[COL_ID];
		//var_dump($this->id);
		$this->email = $row[COL_EMAIL];
		$this->isLogged = TRUE;
		return(TRUE);
	}

	public function login($_email, $_password)
	{

		//cleaning time!!!!
		$this->email = cleanInput($_email);
		//we don't have the password hash so I don't  want to save the passowrd any where yet

		//we need check the email and get the salt
		$db = new SQLite3(DB_FILE);
		$result = $db->query("SELECT ".COL_ID.", ".COL_SALT.", ".COL_PASSWORD." FROM ".USERS_TABLE." WHERE ".COL_EMAIL." = '".$this->email."' ;");
		//if results come back false the email was bad.

		$row = $result->fetchArray();
		if($row == FALSE)
		{
			//we did not find an email
			return(ERR_BAD_EMAIL);
		}

		//if we made it this far something is in the $row var
		//time to put the salt into the obj
		$this->salt = cleanInput($row[COL_SALT]);//squeaky clean!
		//now we will check the password hash to see if it matches
		//we will start by hashing

		$this->password = cleanInput($this->sha512_hash($_password, $this->salt));
		//testing the password!!!
		if($this->password  != $row[COL_PASSWORD])
		{
			//Oh No!!! the password didn't work

			return(ERR_BAD_PASSWORD);
		}

		//if we got this farr then the password works!!!
		//we now have to set the cookie and I do love cookies
		$this->id = $row[COL_ID];
		//var_dump($this->id);
		$this->cookie = cleanInput($this->createSalt());//always want to stay clean
		//this is the only time the cookie will be set so I'm not going to
		//make a separat method.

		setcookie(COL_COOKIE, $this->cookie, time() + 3600 * 12);//the cookie will exire in 12 hours
		//now is the time to add the cookie to the database

		$db->query("UPDATE ".USERS_TABLE." SET ".COL_COOKIE." = '".$this->cookie."' WHERE ".COL_ID." = ".$this->id." ;");


		//we are cool!!
		return(TRUE);
	}

	public function creatNewUser($_email, $_password)
	{
		//everything that is saved in the obj needs to get cleaned
		//I'm getting a random input that could mess up the SQL query
		$this->salt = cleanInput($this->createSalt());
		$this->email = cleanInput($_email);
		$this->password = cleanInput(hash("sha512",PEPPER.$_password.$this->salt));//We want the hash
		//Don't need to worry about a cookie becaues the user is not logged in
		//They will get there cookie when they loggin.

		//checking the email
		$this->creatDB();//make sure that we have a Database

		//we need to check if the the email is taken
		$db = new SQLite3(DB_FILE);
		$result = $db->query("SELECT ".COL_EMAIL." FROM ".USERS_TABLE." WHERE ".COL_EMAIL." = '".$this->email."' ;");
		$row = $result->fetchArray();
		var_dump($row);

		//we want the email to not have pass the
		//validor and we want the email to not be taken
		if(filter_var($this->email, FILTER_VALIDATE_EMAIL)  == FALSE  || $row != FALSE)
		{
			//if this happens the email is bad.
			//I do not care what the password looks like on this side
			return(FALSE);
		}

		//if we are here we are be good


		//Now we know we have a DB and good user data.

		$db->query("INSERT INTO ".USERS_TABLE." (".
			COL_EMAIL.", ".
			COL_PASSWORD.", ".
			COL_SALT.") VALUES('".
			$this->email."', '".
			$this->password."', '".
			$this->salt."');");
		return(TRUE);
	}
}


function cleanInput($string)
{
	//God I hope I replced enough of the chars to not
	//allow the guys to do anything.
	$string = htmlspecialchars($string);
	$string = str_replace("'", "&#39;", $string);
	$string = str_replace("/", "&#47;", $string);
	$string = str_replace("\\", "&#92;", $string);
	$string = str_replace("=", "&#61;", $string);
	$string = str_replace("{", "&#123;", $string);
	$string = str_replace("}", "&#125;", $string);
	$string = str_replace("[", "&#91;", $string);
	$string = str_replace("]", "&#93;", $string);
	$string = str_replace("`", "&#96;", $string);
	return($string);
}
