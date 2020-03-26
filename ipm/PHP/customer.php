<?php require "../PHP/connection.php";
session_start();
?>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>
  <script src="../js/edit_cust.js"></script>
</head>
<body>
  <table id ="editable-cust" class="table">
    <thead class="thead-dark">
      <tr>
        <th>Customer ID</th>
        <th>Type</th>
        <th>Surname</th>
        <th>Name</th>
        <th>Email</th>
        <th>Late payment</th>
        <th>Debt</th>
        <th>Discount ID</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $customer = mysqli_query($db, "SELECT customer_ID, customer_Type, customer_Surname, customer_Name, customer_Email, customer_LP, customer_Debt, discount_ID
      FROM customers");
      while($row = mysqli_fetch_assoc($customer)){?>
        <tr>
          <td class = "table-warning"><?php echo $row['customer_ID'];?></td>
          <td class = "table-warning"><?php echo $row['customer_Type'];?></td>
          <td class = "table-warning"><?php echo $row['customer_Surname'];?></td>
          <td class = "table-warning"><?php echo $row['customer_Name'];?></td>
          <td class = "table-warning"><?php echo $row['customer_Email'];?></td>
          <td class = "table-warning"><?php echo $row['customer_LP'];?></td>
          <td class = "table-warning"><?php echo $row['customer_Debt'];?></td>
          <td class = "table-warning"><?php echo $row['discount_ID'];?></td>
        </tr>
    <?php  } ?>
  </tbody>
</table>
</body>
