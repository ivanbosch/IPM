<!DOCTYPE html>
<?php include 'header.php'; require "../PHP/connection.php";?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>
    <script type="text/javascript">
    //Function that checks wheter a sale is domestic or interline and display a dropdown
    //with appropiate options in each case.
    function chooseSale(){
      let value1, value2;
      let selection = document.getElementById("sale_Type").value;
      switch (selection) {
        case "Interline":
          value1 = "444";
          value2 = "420";

          break;
        case "Domestic":
          value1 = "201";
          value2 = "101";

          break;
        default:
          document.getElementById("blanks").innerHTML = "";
          document.getElementById("amount").innerHTML = "";
          document.getElementById("submit").innerHTML = "";
          document.getElementById("coupons").innerHTML = "";
          return;
          break;
      }
      let generatedHTML =
      ` <label for="blank_Type">Choose Blank Type:</label>
        <select id="blank_Type" name="blank_Type" onchange="chooseAmount();">
          <option value="-1">--</option>
          <option value="${value1}">${value1}</option>
          <option value="${value2}">${value2}</option>
        </select>
      `;
      document.getElementById("blanks").innerHTML = generatedHTML;
      document.getElementById("amount").innerHTML = "";
      document.getElementById("coupons").innerHTML = "";

    }
    </script>
    <script type="text/javascript">
      //Function that populates the form according to the decision of the Blank Type
      function chooseAmount() {
        let type = document.getElementById("blank_Type");
        let generatedHTML = `<label for='coupon_Amount'>Choose coupon amount:</label>
                             <select id='coupon_Amount'name='coupon_Amount' onchange='couponsBoxes();'><option value='-1'>--</option>`;
        let j = 1;

         //In the case of having no dropdown list
        if (document.getElementById("blank_Type").value == "444") {
          do {
            let generation = `<option value='${j}'>${j}</option>`;
            j++;
            generatedHTML += generation;
          }
          while (j <= 4);
        } else if (document.getElementById("blank_Type").value == "201" || document.getElementById("blank_Type").value == "420") {
          do {
            let generation = `<option value='${j}'>${j}</option>`;
            j++;
            generatedHTML += generation;
          }
          while (j <= 2);
        } else if (document.getElementById("blank_Type").value == "101") {
          let generation = `<option value='${j}'>${j}</option>`;
          generatedHTML+=generation;
        } else {
          document.getElementById("coupons").innerHTML = "";
          document.getElementById("amount").innerHTML = "";
          return;
        }
        document.getElementById("amount").innerHTML = generatedHTML + "</select>";
      }

      function couponsBoxes(){
        let generatedHTML ="";
        let i = 0;
        let amount = document.getElementById("coupon_Amount").value;
        const selection = document.getElementById("blank_Type").value;
        switch (selection) {
          case '420':
            while (i < amount) {
              generatedHTML += `
                    <label for='coupon_Origin${i}'>Enter origin: </label>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..' required>
                    <label for='coupon_Destination${i}'>Enter destination: </label>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..' required><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  <br>`;
              i++;
            }
            break;

          case '201':
            while (i < amount){
              generatedHTML += `
                    <label for='coupon_Origin${i}'>Enter origin: </label>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..' required>
                    <label for='coupon_Destination${i}'>Enter destination: </label>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..' required><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  <br>`;
              i++;
            }
            break;

          case '101':
            generatedHTML += `
                  <label for='coupon_Origin${i}'>Enter origin: </label>
                  <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..' required>
                  <label for='coupon_Destination${i}'>Enter destination: </label>
                  <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..' required><br>
                  <label for='coupon_Date'>Select Coupon Date:</label>
                  <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                  <label for='coupon_Time'>Select Coupon Time:</label>
                  <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                <br>`;
            break;

          case '444':
            while (i < amount) {
              generatedHTML += `
                    <label for='coupon_Origin${i}'>Enter origin: </label>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..' required>
                    <label for='coupon_Destination${i}'>Enter destination: </label>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..' required><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  <br>`;
              i++;
            }
            break;
        }
        document.getElementById("coupons").innerHTML = generatedHTML;
      }

      function card() {
        if (document.getElementById("payment_Type").value === "Card") {
          document.getElementById("card").innerHTML = "<label for='card_Digits'>Enter last 4 card digits:</label><input name='card_Digits' placeholder='xxxx'>";
        } else {
          document.getElementById("card").innerHTML = "";
        }
      }
    </script>
  </head>

  <body>
    <div class="sales_container">
      <!--First element of the container the report sale form-->
      <div>
        <form method="post" action="../PHP/sales_inc.php">
          <div> <!-- ENTER CUSTOMER DETAILS SUCH AS NAME, SURNAME, EMAIL -->
            <label for="customer_Name">Enter Name: </label>
            <input type="text" name="customer_Name">
            <label for="customer_Surname">Enter Surname: </label>
            <input type="text" name="customer_Surname">
            <br>
            <label for="email">Enter Email:</label>
            <input type="email" name="customer_Email">
          </div>
          <div> <!--SELECT SALE TYPE, THEN SELECT BLANK TYPE, THEN SELECT AMOUNT -->
            <label for="sale_Type">Choose sale type: </label>
            <select name="sale_Type" id="sale_Type" onchange="chooseSale();">
              <option>--</option>
              <option value="Interline">Interline</option>
              <option value="Domestic">Domestic</option>
            </select>
          </div>
          <p id="blanks"></p>
          <div id="amount"></div>
          <div id="coupons"></div>
          <?php
          $result = $db->query("SELECT * from currency;");

          echo "<div><label for='currency'>Select a currency: </label><select id='currency' name='currency_ID'>";

          while ($row = $result->fetch_assoc()) {
            unset($id, $name);
            $id = $row['currency_ID'];
            $name = $row['currency_Name'];
            echo '<option value="'.$id.'">'.$name.'</option>';
          }

          echo "</select></div>";

          ?>
          <div>
            <label for="payment_Type">Select payment type:</label>
            <select id="payment_Type" name="payment_Type" onchange="card();">
              <option>--</option>
              <option value="Card">Card</option>
              <option value="Cash">Cash</option>
            </select>
          </div>
          <div id="card"></div>
          <label for="sales_Charge">Amount to pay: </label>
          <input type="number" name="sales_Charge">
          <button type='submit' id='submit' name='coupon_Submission'>Submit</button>
          <div id="submit"></div>
        </form>
      </div>

      <!--Second element of the container AKA the table that shows all the sales so far -->
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
            $sale_query = "SELECT * FROM sales INNER JOIN staff ON sales.staff_ID = staff.staff_ID
                           INNER JOIN currency ON sales.currency_ID = currency.currency_ID
                           INNER JOIN customers ON sales.customer_ID = customers.customer_ID;";

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
    </div>
  </body>
</html>
