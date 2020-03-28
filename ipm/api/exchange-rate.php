<?php
  require "../PHP/connection.php";
  $rates = file_get_contents("https://api.exchangeratesapi.io/latest?base=USD");
  if(isset($rates)){
    $rates = json_decode($rates, true);
    foreach ($rates['rates'] as $key => $value) {
      $doesExist = mysqli_query($db, "SELECT currency_Name FROM currency WHERE currency_Name = '".$key."' ");
      if(mysqli_num_rows($doesExist) == 0){
        $query = "INSERT INTO currency (currency_Name, currency_Rate) VALUES(?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("si", $key, $value);
        $stmt->execute();
      }else{
        mysqli_query($db, "UPDATE currency SET currency_Rate = '".$value."' WHERE currency_Name = '".$key."' ");
      }
    }
  }
?>
