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
        document.getElementById("Currency").innerHTML =
        `<label for='currency'>Select a currency: </label><select id='currency' name='currency_ID'>
        <option value='1'>Dollars</option>
        <option value='2'>Argentinian Pesos</option></select>`;
          value1 = "444";
          value2 = "420";

          break;
        case "Domestic":
          document.getElementById("Currency").innerHTML =
          `<label for='currency'>Select a currency: </label><select id='currency' name='currency_ID'>
          <option value='2'>Argentinian Pesos</option></select>`;
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
          document.getElementById("card").innerHTML = "<label for='card_Digits'>Enter card digits:</label><input name='card_Digits' minlength='16' maxlength='16' required>";
        } else {
          document.getElementById("card").innerHTML = "";
        }
      }
    </script>
  </head>

  <body>
    <h3>Sale</h3>
    <div class="sales_container">
      <!--First element of the container the report sale form-->
      <div>
        <form method="post" action="../PHP/sales_inc.php">
          <div> <!-- ENTER CUSTOMER DETAILS SUCH AS NAME, SURNAME, EMAIL -->
            <label for="customer_Name">Enter Name: </label>
            <input type="text" name="customer_Name" required>
            <label for="customer_Surname">Enter Surname: </label>
            <input type="text" name="customer_Surname" required>
            <br>
            <label for="email">Enter Email:</label>
            <input type="email" name="customer_Email" required>
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
          <div id="Currency"></div>
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
          <input type="number" name="sales_Charge" min="1" required>
          <input type="checkbox" name="late_Payment" value="true">
          <label for="late_Payment">Is a Late Payment?</label><br>
          <button type='submit' id='submit' name='coupon_Submission'>Submit</button>
          <div id="submit"></div>
        </form>
      </div>
<<<<<<< HEAD
=======
      <div>
        <h3>Refund a Sale</h3>
        <form action="../PHP/refund.php" method="post">
          <label for="refundID">Enter ticket:</label>
          <input type="text" name="refundID"/>
          <button type="submit" name="refund_Submission">Submit</button>
        </form>
      </div>
      <!--Second element of the container AKA the table that shows all the sales so far -->
>>>>>>> c295ca434d854a5c7ff269ca0c2512d4fb5f3b0d
      <div>
        <h3>Refund a Sale</h3>
        <form action="../PHP/refund.php" method="post">
          <label for="refundID">Enter ticket:</label>
          <input type="text" name="refundID"/>
          <button type="submit" name="refund_Submission">Submit</button>
        </form>
      </div>
    </div>
  </body>
</html>
