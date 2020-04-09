<?php
require "../PHP/connection.php";
session_start();

if (isset($_POST['refund_Submission'])) {
  $refundID = $_POST['refundID'];
  $file = 'refund_Log.txt';

  //Get the sale
  $query = $db->query("SELECT * FROM sales WHERE ticket_ID = '$refundID'");
  $result = $query->fetch_assoc();

  $ticketID = $result['ticket_ID'];
  $customerID = $result['customer_ID'];
  $saleID = $result['sales_ID'];

  //Customer Details
  $query_customer = $db->query("SELECT customer_Name AS name, customer_Surname AS surname, customer_Email AS email FROM customers WHERE customer_ID='$customerID'");
  $customer = $query_customer->fetch_assoc();

  //String saved to file
  $string = "Sale ID: ".$saleID." Type: ".$result['sales_Type']." Customer Refunded: ".$customer['name']." ".$customer['surname']
            ." Customer Email: ".$customer['email']. " Amount Refunded: ".$result['sales_Charge']. " Ticket Refunded: ".$ticketID." Refund made by:".$_SESSION['id']."\n";

  //Open, Write and Close file
  $handle = fopen($file, 'a') or die("Unable to open file!");
  fwrite($handle, $string);
  fclose($handle);

  //Delete from DB to make the blanks available again
  $db->query("DELETE FROM sales WHERE sales_ID=$saleID");
  $db->query("DELETE FROM coupons WHERE ticket_ID=$ticketID");
  $db->query("DELETE FROM tickets WHERE ticket_ID=$ticketID");

  header("Location: ../html/sales.php?success");
  exit();

} else {
  header("Location: ../html/sales.php?error=unauthorizedaccess");
  exit();
}
