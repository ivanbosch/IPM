<?php
require "../PHP/connection.php";

$input = filter_input_array(INPUT_POST);

$commission = (int)mysqli_real_escape_string($db, $input["commission_ID"]);
$validCommission = mysqli_query($db, "SELECT commission_ID from commissions WHERE commission_ID = $commission");

if($input['action'] === 'edit' && mysqli_num_rows($validCommission) > 0){
  mysqli_query($db, "UPDATE staff SET commission_ID = '".$commission."' WHERE staff_ID = '".$input["staff_ID"]."'");
}

echo json_encode($input);
?>
