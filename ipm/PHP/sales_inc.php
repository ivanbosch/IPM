<?php

//Use advisor/Management ID to check the blanks available to them
//Then check whether the blank is being used in a coupon or not
//If not Use the first available blank ID that corresponds to the blank Type choosen
//Then Insert all the values into the coupons table with the corresponding blank ID
//But not before creating a ticket entry

if (isset($_POST["coupon_Submission"])) {
  require 'connection.php';
  session_start();

  //initialisation of variables
  $blank_Type = intval($_POST['blank_Type']);
  $coupon_Origin = "";
  $coupon_Destination = "";
  $coupon_Date = "";
  $coupon_Time = "";
  $user_ID = intval($_SESSION['id']);
  $customerName = mysqli_real_escape_string($db, $_POST['customer_Name']);
  $customerSurname = mysqli_real_escape_string($db, $_POST['customer_Surname']);
  $customerEmail = $_POST['customer_Email'];
  $saleType = $_POST['sale_Type'];
  $currencyID = $_POST['currency_ID'];
  $paymentType = $_POST['payment_Type'];
  $date = date('Y-m-d');
  $charge =  $_POST['sales_Charge'];
  $coupon_Amount = intval($_POST['coupon_Amount']);

  if (isset($_POST['late_Payment'])) {
    $query = $db->query("SELECT customer_Type, customer_Debt FROM customers WHERE customer_Email = '$customerEmail'");
    $result = $query->fetch_assoc();
    if ($result['customer_Type'] == 'Regular' || $result['customer_Type'] == 'Valued') {
      $debt = $result['customer_Debt'] + $charge;
      $db->query("UPDATE customers SET customer_Debt='$debt', customer_LP='$date' WHERE customer_Email = '$customerEmail'");
    } else {
      header("Location: ../html/sales.php?error=NotEligibleCustomer");
      exit();
      }
  }
  //Generate blank
  $blankSql = "SELECT blank_ID FROM blanks
          WHERE NOT EXISTS (SELECT blank_ID FROM coupons
          WHERE blanks.blank_ID = coupons.blank_ID) AND blank_Type = '".$blank_Type."'
          AND blank_Advisor_ID = '".$user_ID."'
          LIMIT 1";
  $blankSTMT = mysqli_query($db, $blankSql);

  if (mysqli_num_rows($blankSTMT) == 0) {
    header("Location: ../html/sales.php?error=NoBlanksAvailable");
    mysqli_close($db);
    exit();
  } else {
    $blank_Row = mysqli_fetch_assoc($blankSTMT);
  }

  //Create a ticket
  $ticketSql = "INSERT INTO tickets (ticket_ID) VALUES (NULL);";
  $db->query($ticketSql);

  //Select a ticket
  $ticketSql = "SELECT ticket_ID from tickets
                WHERE NOT EXISTS (SELECT ticket_ID FROM coupons
                WHERE tickets.ticket_ID = coupons.ticket_ID)
                LIMIT 1";
  $ticketResult =mysqli_query($db, $ticketSql);
  $row = mysqli_fetch_assoc($ticketResult);
  $ticketId = $row['ticket_ID'];

  for ($y = 0 ; $y < $coupon_Amount ; $y++) {
    $coupon_Origin = mysqli_real_escape_string($db, $_POST['coupon_Origin'.$y]);
    $coupon_Destination = mysqli_real_escape_string($db, $_POST['coupon_Destination'.$y]);
    $coupon_Time = $_POST['coupon_Time'.$y];
    $coupon_Date = $_POST['coupon_Date'.$y];

    //Insertion into coupons
    $sql = "INSERT INTO coupons (blank_ID, ticket_ID, coupon_Origin, coupon_Destination, coupon_Time, coupon_Date)
            VALUES ('".$blank_Row["blank_ID"]."', '".$ticketId."', '".$coupon_Origin."', '".$coupon_Destination."', '".$coupon_Time."', '".$coupon_Date."')";
    $result = mysqli_query($db, $sql);
  }
  //Insert into  customer
  //Check if customer already EXISTS
  $customerSQL = "SELECT * FROM customers WHERE customer_Email = '".$customerEmail."'";
  $customerSTMT = mysqli_query($db, $customerSQL);
  //Check if it is a new customer or not
  if (mysqli_num_rows($customerSTMT) > 0) {
    //Customer already exists use his ID for the sale query

  } else {
    //Insert him into the database and give him an ID
    $customerSQL = "INSERT INTO customers (customer_Name, customer_Surname, customer_Email) VALUES (?, ?, ?)";
    $customerSTMT = mysqli_stmt_init($db);
      if (!mysqli_stmt_prepare($customerSTMT, $customerSQL)) {
        echo "<br>Blank ID: ". $blank_Row['blank_ID'] . "<br>Blank Type:" . $blank_Type . ' <br>Ticket ID: ' . $ticketId . ' <br>Origin: ' . $coupon_Origin . ' <br>Destination: ' . $coupon_Destination . ' <br>Time: ' . $coupon_Time . ' <br>Date: ' . $coupon_Date;
      } else {
        mysqli_stmt_bind_param($customerSTMT, "sss", $customerName, $customerSurname, $customerEmail);
        mysqli_stmt_execute($customerSTMT);
      }
    }
    //Select the id and utilise it in the sales sql
    $customerSQL = "SELECT * FROM customers WHERE customer_Email = '".$customerEmail."'";
    $customerExec = mysqli_query($db, $customerSQL);
    $customerResult = mysqli_fetch_assoc($customerExec);
    $customerID = $customerResult['customer_ID'];
    if (isset($customerResult['discount_ID'])) {
      $x = $customerResult["discount_ID"];
      $discountSQL = "SELECT * FROM discounts WHERE discount_ID='$x'";
      $discountResult = $db->query($discountSQL);
      $discount = $discountResult->fetch_assoc();
      $charge = ($charge*(100-$discount['discount_Amount']))/100;
    }
    //Get the currency rate so that it can be inserted into the sales table
    $currencySQL = "SELECT * FROM currency WHERE currency_ID = '".$currencyID."'";
    $currencyResult = mysqli_query($db, $currencySQL);
    $currencyRate = mysqli_fetch_assoc($currencyResult);

    //Get the commission
    if ($saleType == 'Interline') {
      $commissionSQL = $db->query("SELECT commission_Interline FROM staff WHERE staff_ID='$user_ID'");
      $commissionResult = $commissionSQL->fetch_assoc();
      $commissionID = $commissionResult['commission_Interline'];
      $commissionSQL = $db->query("SELECT commission_Rate FROM commissions WHERE commission_ID='$commissionID'");
      $commissionResult1 = $commissionSQL->fetch_assoc();
      $commissionRate = intval($commissionResult1['commission_Rate']);
    } else if ($saleType == 'Domestic') {
      $commissionSQL = $db->query("SELECT commission_Local FROM staff WHERE staff_ID='$user_ID'");
      $commissionResult = $commissionSQL->fetch_assoc();
      $commissionID = $commissionResult['commission_Local'];
      $commissionSQL = $db->query("SELECT commission_Rate FROM commissions WHERE commission_ID='$commissionID'");
      $commissionResult1 = $commissionSQL->fetch_assoc();
      $commissionRate = intval($commissionResult1['commission_Rate']);
    }

    $salesSQL = "INSERT INTO sales(sales_Type, staff_ID, currency_ID, currency_Rate, customer_ID, ticket_ID, sales_Charge, payment_Type, commission_Rate)
                 VALUES (?,?,?,?,?,?,?,?,?)";
    $salesSTMT = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($salesSTMT, $salesSQL)) {
      header("Location: ../html/sales.php?error=salesqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($salesSTMT, "siiiiiisi", $saleType, $user_ID, $currencyID, $currencyRate['currency_Rate'], $customerID, $ticketId, $charge, $paymentType, $commissionRate);
      mysqli_stmt_execute($salesSTMT);

      if (isset($_POST['card_Digits'])) {
        $cardDetails = $_POST['card_Digits'];
        $db->query("UPDATE sales SET card_Digits='$cardDetails' WHERE ticket_ID='$ticketId'");
      }

      header("Location: ../html/sales.php?saleSuccessful");
      exit();
    }
    mysqli_close($db);
} else {
  header("Location: ../html/sales.php?error=unauthorizedaccess");
  exit();
}
?>
