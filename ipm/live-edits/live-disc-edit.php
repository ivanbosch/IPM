<?php
require "../PHP/connection.php";

$input = filter_input_array(INPUT_POST);

$amount = (int)mysqli_real_escape_string($db, $input["discount_Amount"]);

if($input['action'] === 'edit'){
  mysqli_query($db, "UPDATE discounts SET discount_Amount = '".$amount."' WHERE discount_ID = '".$input["discount_ID"]."'");
}

echo json_encode($input);
 ?>
