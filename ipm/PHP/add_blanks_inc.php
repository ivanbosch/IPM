<?php

if(isset($_POST['blanks_submit'])) {

  require 'connection.php';
  //Getting the data from the inputs by name, this are not escaped
  //because they are string input by the user
  $blanks = $_POST['blanks'];
  $amount = $_POST['blanks_Amount'];
  $date = $_POST['blanks_date'];

  //Cant insert with empty fields so will just go back to the page
  if(empty($blanks || $amount)) {
    header("Location: ../html/add_blanks.php?error=emptyfields");
    exit();
  }
  else {
    //Loop that repeats the insertion the until the desired amount is completed
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
