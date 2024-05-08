<?php
	$host 		= "localhost";
	$username 	= "root";
	$password 	= "";
	$dbName		= "midland";
	$conn = mysqli_connect($host,$username,$password,$dbName);
	date_default_timezone_set("Africa/Nairobi");

    //PLEASE CHANGE THE IP ADDRESS TO YOURS HERE
    $base = 'http://localhost/midland/';

	//$base = "http://".$ip."/midland/";
    $profile_url = $base."uploads/profile_pics/";
    $product_url = $base."uploads/product_images/";

	function e($val){
	global $conn;
	return mysqli_real_escape_string($conn, trim($val));
	}
?>