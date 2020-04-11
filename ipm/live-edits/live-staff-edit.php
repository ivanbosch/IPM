<?php
require "../PHP/connection.php";

$input = filter_input_array(INPUT_POST);


if($input['action'] === 'edit'){
  $updateField = '';
  if(isset($input["interline"])){
    $updateField.= "commission_Interline='".$input["interline"]."'";
  }else if(isset($input["domestic"])){
    $updateField.= "commission_Local='".$input["domestic"]."'";
  }
  if($updateField && $input["staff_ID"]){
    $query = "UPDATE staff SET $updateField WHERE staff_ID = '".$input["staff_ID"]."' ";
    mysqli_query($db, $query);
  }
}

echo json_encode($input);
?>
