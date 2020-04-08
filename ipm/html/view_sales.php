<?php include 'header.php'; ?>
<div>
  <table class="table">
    <thead>
      <tr>
        <th>Sale Type</th>
        <th>Customer Name</th>
        <th>Staff Name</th>
        <th>Currency</th>
        <th>Exchange Rate</th>
        <th>Ticket</th>
        <th>Payment Type</th>
        <th>Card_Digits</th>
        <th>Amount Charged</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($_SESSION['user_Type'] == 'Management') {
        $sale_query = "SELECT * FROM sales INNER JOIN staff ON sales.staff_ID = staff.staff_ID
                       INNER JOIN currency ON sales.currency_ID = currency.currency_ID
                       INNER JOIN customers ON sales.customer_ID = customers.customer_ID;";
      } else {
        $id=$_SESSION['id'];
        $sale_query = "SELECT * FROM sales INNER JOIN staff ON sales.staff_ID = staff.staff_ID
                       INNER JOIN currency ON sales.currency_ID = currency.currency_ID
                       INNER JOIN customers ON sales.customer_ID = customers.customer_ID WHERE sales.staff_ID = '$id'";
      }


      $sale_result = mysqli_query($db, $sale_query);

      while($row = mysqli_fetch_assoc($sale_result)) {
        ?>
        <tr>
          <td class="table-info"><?php echo $row['sales_Type']; ?></td>
          <td class="table-info"><?php echo $row['customer_Name'] ." ". $row['customer_Surname']; ?></td>
          <td class="table-info"><?php echo $row['staff_Name'] ." ". $row['staff_Surname'];?></td>
          <td class="table-info"><?php echo $row['currency_Name']; ?></td>
          <td class="table-info"><?php echo $row['currency_Rate']; ?></td>
          <td class="table-info"><?php echo $row['ticket_ID']; ?></td>
          <td class="table-info"><?php echo $row['payment_Type']; ?></td>
          <td class="table-info"><?php echo $row['card_Digits']; ?></td>
          <td class="table-info"><?php echo $row['sales_Charge']; ?></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>
