<?php
$host = "localhost";
$username = "root";
$db = "books";
$password = "";


$conn = mysqli_connect($host,$username,$password,$db);

if ($conn){
    echo 'connected';
session_start();
}
else{
    echo mysqli_connect_error();
}



// Define database
// define('dbhost', 'localhost');
// define('dbuser', 'root');
// define('dbpass', '');
// define('dbname', 'books');


// // Using PDO
// try {
// 	$connect = new PDO("mysql:host=" . dbhost . ";dbname=" . dbname, dbuser, dbpass);
// 	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	echo 'connected';
//  session_start();

// } catch (PDOException $e) {
// 	echo $e->getMessage();
// }


