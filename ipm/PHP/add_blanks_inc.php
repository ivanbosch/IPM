<?php

if(isset($_POST['blanks_submit'])) {

  require 'connection.php';

  $blanks = $_POST['blanks'];
  $amount = $_POST['blanks_Amount'];
  $date = $_POST['blanks_date'];

  if(empty($blanks || $amount)) {
    header("Location: ../html/add_blanks.php?error=emptyfields");
    exit();
  }
  else {

    for ($x = 0; $x < $amount; $x++) {
      $sql = "INSERT INTO blanks (blank_Type, blank_date) VALUES (?, ?);";
      $stmt = mysqli_stmt_init($db);

      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../html/add_blanks.php?error=sqlerror");
        exit();
      }
      else {
        mysqli_stmt_bind_param($stmt, "si", $blanks, $date);
        mysqli_stmt_execute($stmt);
      }
    }
    header("Location: ../html/add_blanks.php?addition=success");
    exit();
  }
  mysqli_stmt_close($stmt);
  mysqli_close($db);
}
else {
  header("Location: ../html/add_blanks.php");
  exit();
}
