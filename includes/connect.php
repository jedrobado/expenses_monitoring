<?php
// define variables
$dbhost = "localhost";
$dbname = "expenses_tracker";
$dbusername = "root";
$dbpassword = "fr3shk4b4y1";
// intialize PDO
$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// functions to be used for database
// 
// manage function use for: INSERT, UPDATE, DELETE
// manage("INSERT INTO table_name (field1,field2) VALUES (?,?)",array(1,2)); 
// manage("UPDATE table_name SET field1 = ? WHERE field2 = ?",array(1,2)); 
// manage("DELETE FROM table_name WHERE field1 = ?",array(1)); 
// $check is optional (1 or 0 or leave it blank)
function manage($statement,$value,$checker){
	// replace (') with (`)
	$search=array("'");
	$value=str_replace($search, "`", $value);
	global $pdo;
	$return=0;
	if($pdo->prepare($statement)->execute($value)){
		$return=1;
	}
	return ($checker==1?$return:'');
}
// retrieve function use for: SELECT
// retrieve("SELECT * FROM table_name WHERE field1 = ?",array(1));
// retrieve("SELECT COUNT(*) AS count FROM table_name WHERE field1 = ?",array(1));
function retrieve($statement,$value){
	global $pdo;
	$statement = $pdo->prepare($statement);
	$statement->execute($value); 
	$data = $statement->fetchAll();
	$data = json_decode( json_encode($data), true);
	return $data;
}
?>