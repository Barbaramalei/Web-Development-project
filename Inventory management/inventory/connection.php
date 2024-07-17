<?php


//Testing XAMPP
$host="localhost";
$user="root";
$password="";
//$password="**IoT2023**";
$database="inventory";



/*
//Plesk
$host="localhost:3306";
$user="studyhelp";

*/

$connection=new mysqli("$host", "$user", "$password", "$database");
if(!$connection){
	die ("Connection Failed: ".$connection->connect_error);
}


?>