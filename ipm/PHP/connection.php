<?php
  //server name, user, password, name of database

$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "ats";

$db = mysqli_connect($serverName, $dbUsername,$dbPassword,$dbName);

if (!$db) {
  die("Connection failed: ".mysqli_connect_error());
}

