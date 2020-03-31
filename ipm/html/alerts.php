<!DOCTYPE html>
<?php include '../PHP/connection.php'; ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body class="alert_Container">

    <h1>Late Payments:</h1>
    <?php

      //Set today's date
      $today = new DateTime(date('Y-m-d H:i:s'));

      //Get all customers with a debt and have the option to have one meaning either Regular or Valued Customers
      $alertSQL = 'SELECT * FROM customers WHERE customer_Type IS NOT NULL AND customer_Debt IS NOT NULL;';
      $alertResult = mysqli_query($db, $alertSQL);
      while ($row = $alertResult -> fetch_assoc()) {
        //Last time the customer paid is stored in the db
        $lastPayment = new DateTime($row['customer_LP']);

        //Get the difference between the two dates
        $interval = date_diff($lastPayment, $today);

        //If the difference is more than 30 (a month) Print the name of the customer, amount
        //and how long has it been since he paid and he has a debt, if he doesn't have a debt it means
        //he doesn't own any money
        if ($interval->format('%a') >= 30 && $row['customer_Debt'] > 0) {
          echo "<div class ='alert'>Payment Due by: ".$row['customer_Name']. " ". $row['customer_Surname'];
          echo "<br>Amount: ". $row['customer_Debt'];
          echo "<br>Last Paid: ".$interval->format('%a')." Days ago <br></div>";
        }
      }
    ?>
    <h3><a href="homepage.php">Go to Homepage<a/></h3>

  </body>
</html>
