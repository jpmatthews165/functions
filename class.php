<?php

class db {

	var $hostname = "sql1.njit.edu";
	var $username = "jm775";
	var $password = "m2JBjuN1E";
	var $conn = NULL;
	try 
	{
    	$conn = new PDO("mysql:host=$hostname;dbname=$username",
    	$username, $password);
	}
	catch(PDOException $e)
	{
		// echo "Connection failed: " . $e->getMessage();
		http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
	}

	// Runs SQL query and returns results (if valid)
	function runQuery($query) {
		global $conn;
    	try {
			$q = $conn->prepare($query);
			$q->execute();
			$results = $q->fetchAll();
			$q->closeCursor();
			return $results;	
		} catch (PDOException $e) {
			http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage());
		}	  
	}

	function http_error($message) 
	{
		header("Content-type: text/plain");
		die($message);
	}
	
	function display()
	{
		$sql = "select * from jm775.accounts;";
		$results = $this->runQuery($sql);
		return $results;
	}
	function insert($email, $fname, $lname, $phone, $birthday, $gender, $password)
	{
		$sql = "insert into accounts (email, fname, lname,phone, birthday, gender,password) values ($email, $fname, $lname, $phone, $birthday, $gender, $password);";
		$results = $this->runQuery($sql);
		return $results;
	}
	function delete($email)
	{
		$sql = "delete from accounts where email = $email;";
		$results = $this->runQuery($sql);
		return $results;
	}
	function update($email, $password)
	{
		$sql = "update accounts set password = $password where email = $email;";
		$results = $this->runQuery($sql);
		return $results;
	}
}
/*
class User{
	new db;
	var $email = "jm775@aol.com";
	var $fname = "Josh";
	var $lname = "Matthews";
	var $phone = "1234567890";
	var $birthday = "1/2/33";
	var $gender = "Male";
	var $password = "12345";
	var $newpassword = "54321";
	function show($results){
		if(count($results) > 0)
		{
			echo "<table border=\"1\"><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Birthday</th><th>Gender</th><th>Pass</th></tr>";
			foreach ($results as $row) {
				echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["phone"]."</td><td>".$row["birthday"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td></tr>";
			}
	
		}else{
 		   echo '0 results';
		}
	}
	$this->show($db->display());
	$b = $db->insert($email, $fname, $lname, $phone, $birthday, $gender, $password);
	$this->show($db->display());
	$c = $db->delete($email);
	$this->show($db->display());
	$d = $db->update($email, $newpassword);
	$this->show($db->display());


}
new User;
*/
?>