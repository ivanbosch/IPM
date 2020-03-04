<?php

//Use advisor/Management ID to check the blanks available to them
//Then check whether the blank is being used in a coupon or not
//If not Use the first available blank ID that corresponds to the blank Type choosen
//Then Insert all the values into the coupons table with the corresponding blank ID
//But not before creating a ticket entry
include '../html/header.php';

if (isset($_POST['coupon_Submission'])) {
  require 'connection.php';

  $coupon_Type = (int)mysqli_real_escape_string($_POST['coupon_Type']);
  $coupon_Origin = "";
  $coupon_Destination = "";
  $coupon_Date = "";
  $coupon_Time = "";
  $user_ID = (int)$_POST['id'];
  $coupon_Number = 1000000;

  //Generate blank
  $blankSql = "SELECT blank_ID FROM blanks
          WHERE NOT EXISTS (SELECT blank_ID FROM coupons
          WHERE blanks.blank_ID = coupons.blank_ID) AND blank_Type = $coupon_Type
          AND blank_Advisor_ID = $user_ID
          LIMIT 1";
  $result = mysqli_query($db, $blankSql);
  if ($result <= 0) {
      header("Location: ../html/generate_Coupons.php?error=noblank");
      exit();
  }
  $blankAssoc = mysqli_fetch_assoc($result);
  $blankID = (int)$blankAssoc['blank_ID'];

  //Create a ticket
  $ticketSql = "INSERT INTO tickets (ticket_ID) VALUES (NULL);";
  $db->query($ticketSql);
  //Select a ticket
  $ticketSql = "SELECT ticket_ID from tickets
                WHERE NOT EXISTS (SELECT ticket_ID FROM coupons
                WHERE tickets.ticket_ID and coupons.ticket_ID)
                LIMIT 1";
  $ticketResult =$db->query($ticketSql);
  while ($row = mysqli_fetch_assoc($ticketResult)) {
    $ticketId = (int)$row['ticket_ID'];
  }

  for ($y = 0; $y <= $_POST['coupon_Amount']; $y++) {
    $coupon_Origin = (int)mysqli_real_escape_string($_POST['coupon_Origin'.$y]);
    $coupon_Destination = (int)mysqli_real_escape_string($_POST['coupon_Destination'.$y]);
    $coupon_Time = (int)$_POST['coupon_Time'.$y];
    $coupon_Date = (int)$_POST['coupon_Date'.$y];

    //Problem might be Time and date, the script goes through and is coupon_Submission_Successful
    //It is a sql thing that coupon doesn't accept my variables
    //The ID's are int(10), origin and destination are varchar(30), coupon number int(8)
    //Time and date their respective type Time and Date
    $sql = "INSERT INTO coupons (blank_ID, ticket_ID, coupon_Origin, coupon_Destination, coupon_Time, coupon_Date, coupon_Number)
            VALUES (?, ?, ?, ?, $coupon_Time, $coupon_Date, ?)";

    $stmt = mysqli_stmt_init($db);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../html/generate_Coupons.php?error=sqlerror=coupon_submission");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "iissi", $blankID, $ticketId, $coupon_Origin, $coupon_Destination, $coupon_Number);
      mysqli_stmt_execute($stmt);

      header("Location: ../html/sales.html?coupon_Submission_Successful");
      exit();
    }
  }
}
else {
  header("Location: ../html/generate_Coupons.php?error");
  exit();
}
?>
