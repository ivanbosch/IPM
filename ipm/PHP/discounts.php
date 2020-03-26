<?php require "../PHP/connection.php";
  session_start();
?>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>
  <script src="../js/edit_disc.js"></script>
</head>
<body>
  <table id ="editable-cust" class="table">
    <thead class="thead-dark">
      <tr>
        <th>Discount ID</th>
        <th>Type</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $discount = mysqli_query($db, "SELECT * FROM discounts");
      while($row = mysqli_fetch_assoc($discount)){?>
        <tr>
          <td class = "table-danger"><?php echo $row['discount_ID'];?></td>
          <td class = "table-danger"><?php echo $row['discount_Type'];?></td>
          <td class = "table-danger"><?php echo $row['discount_Amount'];?></td>
  <?php  } ?>
</tbody>
</table>
</body>
