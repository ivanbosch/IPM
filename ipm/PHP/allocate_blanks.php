<?php
  require "connection.php";
  session_start();
  if(isset($_POST['submit'])){


    $session = intval($_SESSION['id']);
    $bType = $_POST['blank'];
    $unameID = $_POST['username'];
    $amount = $_POST['amount'];
    $amount = intval($db->real_escape_string($amount));

    $maxAmount = mysqli_query($db, "SELECT blank_Type from blanks where blank_Advisor_ID is null and blank_Type = '".$bType."'");

    if($amount <= mysqli_num_rows($maxAmount)){
      mysqli_query($db, "UPDATE blanks set blank_Advisor_ID = '".$unameID."', blank_Manager_ID = '".$session."'
      WHERE blank_Type = '".$bType."' AND blank_Advisor_ID is null LIMIT $amount ");
      header("Location: blanks.php");
      exit();
    }else{
      header("Location: blanks.php");
      exit();
    }
  } else {
    header("Location: ../html/homepage/php");
    exit();
  }
?>
