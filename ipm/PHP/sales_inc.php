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
  $coupon_Amount = intval($_POST['coupon_Amount']);

  //Generate blank
  $blankSql = "SELECT blank_ID FROM blanks
          WHERE NOT EXISTS (SELECT blank_ID FROM coupons
          WHERE blanks.blank_ID = coupons.blank_ID) AND blank_Type = '".$blank_Type."'
          AND blank_Advisor_ID = '".$user_ID."'
          LIMIT 1";
  $stmt = mysqli_stmt_init($db);
  if (!mysqli_stmt_prepare($stmt, $blankSql)){
    echo 'Failed to prepare statement';
  } else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $blank_Row = mysqli_fetch_assoc($result);
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
    $coupon_Origin = mysqli_real_escape_string($db, $_POST['coupon_Origin'.$y.'']);
    $coupon_Destination = mysqli_real_escape_string($db, $_POST['coupon_Destination'.$y.'']);
    $coupon_Time = $_POST['coupon_Time'.$y.''];
    $coupon_Date = $_POST['coupon_Date'.$y.''];

    //Insertion into coupons
    $sql = "INSERT INTO coupons (blank_ID, ticket_ID, coupon_Origin, coupon_Destination, coupon_Time, coupon_Date)
           VALUES ('".$blank_Row["blank_ID"]."', '".$ticketId."', '".$coupon_Origin."', '".$coupon_Destination."', '".$coupon_Time."', '".$coupon_Date."')";
    $result = mysqli_query($db, $sql);

   echo "<br>Blank ID: ". $blank_Row['blank_ID'] . "<br>Blank Type:" . $blank_Type . ' <br>Ticket ID: ' . $ticketId . ' <br>Origin: ' . $coupon_Origin . ' <br>Destination: ' . $coupon_Destination . ' <br>Time: ' . $coupon_Time . ' <br>Date: ' . $coupon_Date;

    header("Location: ../html/sales.php?coupon_Submission_Successful");
    exit();
  }
}
else {
  header("Location: ../html/sales.php?error=unauthorizedaccess");
  exit();
}
?>
