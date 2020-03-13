<?php
require "../PHP/connection.php";

$input = filter_input_array(INPUT_POST);

$commission = (int)mysqli_real_escape_string($db, $input["staff_Commission"]);

if($input['action'] === 'edit' && $commission < 100 && $commission > -1){
  mysqli_query($db, "UPDATE staff SET staff_Commission = '".$commission."' WHERE staff_ID = '".$input["staff_ID"]."'");
}

echo json_encode($input);
?>
