<?php

//Use advisor/Management ID to check the blanks available to them
//Then check whether the blank is being used in a coupon or not
//If not Use the first available blank ID that corresponds to the blank Type choosen
//Then Insert all the values into the coupons table with the corresponding blank ID
//But not before creating a ticket entry

if (isset($_POST["coupon_Submission"])) {
  require 'connection.php';

  $blank_Type = intval($_POST['blank_Type']);
  echo "Coupon Type: " . $blank_Type;
  $coupon_Origin = "";
  $coupon_Destination = "";
  $coupon_Date = "";
  $coupon_Time = "";
  $user_ID = intval($_POST['id']);
  echo "User ID: " . $user_ID;
  $coupon_Number = 1000000;
  $coupon_Amount = intval($_POST['coupon_Amount']);
  echo "Coupon Amount: " . $coupon_Amount;

  //Generate blank
  $blankSql = "SELECT blank_ID FROM blanks
          WHERE NOT EXISTS (SELECT blank_ID FROM coupons
          WHERE blanks.blank_ID = coupons.blank_ID) AND blank_Type = '".$blank_Type."'
          AND blank_Advisor_ID = '".$user_ID."'
          LIMIT 1";
  $result = mysqli_query($db, $blankSql);
  if (mysqli_num_rows($result) == 0) {
    echo "Blank ID: ". $blankID . "User ID: " . "<br><br>";
  } else {
    $row = mysqli_fetch_assoc($result);
    $blankID = $row['blank_ID'];
  }

  //Create a ticket
  $ticketSql = "INSERT INTO tickets (ticket_ID) VALUES (NULL);";
  $db->query($ticketSql);
  //Select a ticket
  $ticketSql = "SELECT ticket_ID from tickets
                WHERE NOT EXISTS (SELECT ticket_ID FROM coupons
                WHERE tickets.ticket_ID and coupons.ticket_ID)
                LIMIT 1";
  $ticketResult =$db->query($ticketSql);
  $row = mysqli_fetch_assoc($ticketResult);
  $ticketId = $row['ticket_ID'];

  for ($y = 0 ; $y < $coupon_Amount ; $y++) {
    $coupon_Origin = mysqli_real_escape_string($db, $_POST['coupon_Origin'.$y.'']);
    $coupon_Destination = mysqli_real_escape_string($db, $_POST['coupon_Destination'.$y.'']);
    $coupon_Time = $_POST['coupon_Time'.$y.''];
    $coupon_Date = $_POST['coupon_Date'.$y.''];

    //Insertion into coupons
    $sql = "INSERT INTO coupons (blank_ID, ticket_ID, coupon_Origin, coupon_Destination, coupon_Time, coupon_Date)
           VALUES ('".$blankID."', '".$ticketId."', '".$coupon_Origin."', '".$coupon_Destination."', '".$coupon_Time."', '".$coupon_Date."')";
    $result = mysqli_query($db, $sql);

  echo "Blank ID: ". $blankID . ' Ticket ID: ' . $ticketId . ' Origin: ' . $coupon_Origin . ' Destination: ' . $coupon_Destination . ' Time: ' . $coupon_Time . ' Date: ' . $coupon_Date;

  //   header("Location: ../html/coupon.html?coupon_Submission_Successful");
  //   exit();
  }
}
else {
  header("Location: ../html/generate_Coupons.php?error=unauthorizedaccess");
  exit();
}
?>
