<?php
require "../PHP/connection.php";

//header('Content-Type: application/json');

$input = filter_input_array(INPUT_POST);

$username = mysqli_real_escape_string($db, $input["login_username"]);

$validUsername = mysqli_query($db, "SELECT login_username FROM log_in WHERE login_username = '$username'");

$id = substr($input['Blank'], 4);

$ifUsed = mysqli_query($db, "SELECT * FROM coupons WHERE blank_ID = '$id' ");

if ($input['action'] === 'edit' && mysqli_num_rows($ifUsed) == 0) {
  if(empty($username)){
    $remove = "UPDATE blanks SET blank_Advisor_ID = NULL WHERE blank_ID = '$id' ";
    mysqli_query($db, $remove);
  }else if(mysqli_num_rows($validUsername) > 0){
    $reassign = "UPDATE blanks SET blank_Advisor_ID = (SELECT staff_ID FROM log_in WHERE login_username = '$username') WHERE blank_ID = '$id' ";
    mysqli_query($db, $reassign);
  }
}
echo json_encode($input);
?>
