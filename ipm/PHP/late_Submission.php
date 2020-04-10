<?php


if (isset($_POST['late_Submission'])) {
require 'connection.php';

  $customerEmail = $_POST['late_Email'];
  $Amount = $_POST['LateID'];

  //Select debt of customer
  $sql = $db->query("SELECT customer_Debt FROM customers WHERE customer_Email='$customerEmail'");
  $result = $sql->fetch_assoc();

  $debt = $result['customer_Debt']-$Amount;

  $sql = $db->query("UPDATE customers SET customer_Debt='$debt' WHERE customer_Email='$customerEmail'");

  header("Location: ../html/sales.php?CustomerUpdated");
  exit();
}

?>
