<?php
require "connection.php";

//header('Content-Type: application/json');

$input = filter_input_array(INPUT_POST);

$username = mysqli_real_escape_string($db, $input["login_username"]);

if ($input['action'] === 'edit') {
  echo $input['action'];
  $query = "UPDATE blanks SET blank_Advisor_ID = (SELECT staff_ID FROM log_in WHERE login_username = '".$input["login_username"]."') WHERE id = '".$input["blank_ID"]."' ";

  mysqli_query($db, $query);
}
?>
