<?php
require "../PHP/connection.php";

$input = filter_input_array(INPUT_POST);

if($input['action'] === 'edit'){
  $updateField = '';
  if(isset($input["customer_Type"])) {
    $updateField.= "customer_Type='".$input["customer_Type"]."'";
  } else if(isset($input["customer_LP"])) {
    $updateField.= "customer_LP='".$input["customer_LP"]."'";
  } else if(isset($input["customer_Debt"])) {
    $updateField.= "customer_Debt='".$input["customer_Debt"]."'";
  } else if(isset($input["discount_ID"])) {
    $updateField.= "discount_ID='".$input["discount_ID"]."'";
  }
  if($updateField && $input["customer_ID"]) {
    $sql_query = "UPDATE customers SET $updateField WHERE customer_ID='" . $input["customer_ID"] . "'";
    mysqli_query($db, $sql_query);
  }
}
echo json_encode($input);
?>
