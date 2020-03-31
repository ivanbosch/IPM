<?php
  require "connection.php";
  session_start();
  if(isset($_POST['submit'])){
  // $uname = $db->real_escape_string($username['login_username']);
  // $type = $db->real_escape_string($blank['blank_Type']);

  $session = intval($_SESSION['id']);
  $bID = $_POST['blank'];
  $unameID = $_POST['username'];

  mysqli_query($db, "UPDATE blanks set blank_Advisor_ID = '".$unameID."', blank_Manager_ID = '".$session."'
  WHERE blank_ID = '".$bID."' ");
  header("Location: blanks.php");
  exit();
} else {
  header("Location: ../html/homepage.php");
  exit();
}
?>
