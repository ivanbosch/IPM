<!DOCTYPE html>
<?php include 'header.php'; require "../PHP/connection.php";?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel = "stylesheet" href = "../resources/css/styles.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script type="text/javascript">
    //Function that checks wheter a sale is domestic or interline and display a dropdown
    //with appropiate options in each case.
    function chooseSale(){
      let value1, value2;
      let selection = document.getElementById("sale_Type").value;
      switch (selection) {
        case "Interline":
        document.getElementById("Currency").innerHTML =
        `<div class='form-group col-2'><label for='currency'>Currency: </label></div><div class='form-group col-6'><select id='currency' class='form-control' name='currency_ID'>
        <option value='1'>Dollars</option>
        <option value='2'>Argentinian Pesos</option></select></div>`;
          value1 = "444";
          value2 = "420";

          break;
        case "Domestic":
          document.getElementById("Currency").innerHTML =
          `<div class='form-group col-2'><label class='label' for='currency'>Currency: </label></div><div class='form-group col-6'><select id='currency' class='form-control' name='currency_ID'>
          <option value='2'>Argentinian Pesos</option></select></div>`;
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
      ` <div class='form-row justify-content-center'><div class='form-group col-2'><label for='blank_Type'>Blank Type:</label></div>
        <div class='form-group col-6'><select id='blank_Type' class='form-control' name='blank_Type' onchange='chooseAmount();'>
          <option value="-1">--</option>
          <option value="${value1}">${value1}</option>
          <option value="${value2}">${value2}</option>
        </select></div></div>
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
        let generatedHTML = `<div class='form-group col-2'><label for='coupon_Amount'>Choose coupon amount:</label></div>
                             <div class='form-group col-6'><select class='form-control' id='coupon_Amount'name='coupon_Amount' onchange='couponsBoxes();'><option value='-1'>--</option>`;
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
        document.getElementById("amount").innerHTML = generatedHTML + "</select></div>";
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
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Origin${i}'>Enter origin: </label></div>
                    <div class='form-group col-6'><input type='text' class='form-control' name='coupon_Origin${i}' placeholder='Enter Origin..' required></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Destination${i}'>Enter destination: </label></div>
                    <div class='form-group col-6'><input type='text' class='form-control' name='coupon_Destination${i}' placeholder='Enter Destination..' required></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Date'>Select Coupon Date:</label></div>
                    <div class='form-group col-6'><input type='date' class='form-control' name='coupon_Date${i}' id='coupon_Date'></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Time'>Select Coupon Time:</label></div>
                    <div class='form-group col-6'><input type='time' class='form-control' name='coupon_Time${i}' id='coupon_Time'></div></div>
                  `;
              i++;
            }
            break;

          case '201':
            while (i < amount){
              generatedHTML += `
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Origin${i}'>Enter origin: </label></div>
                    <div class='form-group col-6'><input type='text' class='form-control' name='coupon_Origin${i}' placeholder='Enter Origin..' required></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Destination${i}'>Enter destination: </label></div>
                    <div class='form-group col-6'><input type='text' class='form-control' name='coupon_Destination${i}' placeholder='Enter Destination..' required></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Date'>Select Coupon Date:</label></div>
                    <div class='form-group col-6'><input type='date' class='form-control' name='coupon_Date${i}' id='coupon_Date'></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Time'>Select Coupon Time:</label></div>
                    <div class='form-group col-6'><input type='time' class='form-control' name='coupon_Time${i}' id='coupon_Time'></div></div>
                  `;
              i++;
            }
            break;

          case '101':
            generatedHTML += `
                  <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Origin${i}'>Enter origin: </label></div>
                  <div class='form-group col-6'><input type='text' class='form-control' name='coupon_Origin${i}' placeholder='Enter Origin..' required></div></div>
                  <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Destination${i}'>Enter destination: </label></div>
                  <div class='form-group col-6'><input type='text' class='form-control' name='coupon_Destination${i}' placeholder='Enter Destination..' required></div></div>
                  <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Date'>Select Coupon Date:</label></div>
                  <div class='form-group col-6'><input type='date' class='form-control' name='coupon_Date${i}' id='coupon_Date'></div></div>
                  <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Time'>Select Coupon Time:</label></div>
                  <div class='form-group col-6'><input type='time' class='form-control' name='coupon_Time${i}' id='coupon_Time'></div></div>
                `;
            break;

          case '444':
            while (i < amount) {
              generatedHTML += `
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Origin${i}'>Enter origin: </label></div>
                    <div class='form-group col-6'><input type='text' class='form-control' name='coupon_Origin${i}' placeholder='Enter Origin..' required></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Destination${i}'>Enter destination: </label></div>
                    <div class='form-group col-6'><input type='text' class='form-control' name='coupon_Destination${i}' placeholder='Enter Destination..' required></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Date'>Select Coupon Date:</label></div>
                    <div class='form-group col-6'><input type='date' class='form-control' name='coupon_Date${i}' id='coupon_Date'></div></div>
                    <div class='form-row justify-content-center'><div class='form-group col-2 align-self-center'><label for='coupon_Time'>Select Coupon Time:</label></div>
                    <div class='form-group col-6'><input type='time' class='form-control' name='coupon_Time${i}' id='coupon_Time'></div></div>
                  `;
              i++;
            }
            break;
        }
        document.getElementById("coupons").innerHTML = generatedHTML;
      }

      function card() {
        if (document.getElementById("payment_Type").value === "Card") {
          document.getElementById("card").innerHTML = "<div class='form-group col-2'><label for='card_Digits'>Enter card digits:</label></div><div class='form-group col-6'><input name='card_Digits' class='form-control' minlength='16' maxlength='16' required></div>";
        } else {
          document.getElementById("card").innerHTML = "";
        }
      }
    </script>
  </head>

  <body>
    <div  class="row justify-content-center" style="margin-top:2%"><h3>Sales</h3></div>
    <div class="container sales_container" style="background:#f2f2f2;border:solid;border-color:rgba(126, 239, 104, 0.8);padding:2%;margin-top:1%;">
      <!--First element of the container the report sale form-->

        <form method="post" action="../PHP/sales_inc.php">
          <div class="form-row justify-content-center"> <!-- ENTER CUSTOMER DETAILS SUCH AS NAME, SURNAME, EMAIL -->
            <div class="form-group col-4">
              <input type="text" class="form-control" name="customer_Name" placeholder="Name" required>
            </div>
            <div class="form-group col-4">
              <input type="text" class="form-control" name="customer_Surname" placeholder="Surname" required>
            </div>
          </div>
          <div class="form-row justify-content-center">
            <div class="form-group col-8 align-content-center">
              <input type="email" class="form-control" name="customer_Email" placeholder="Email" required>
            </div>
          </div>
          <div class="form-row justify-content-center"> <!--SELECT SALE TYPE, THEN SELECT BLANK TYPE, THEN SELECT AMOUNT -->
            <div class="form-group col-2">
              <label class="label" for="sale_Type">Choose sale type:</label>
            </div>
            <div class="form-group col-6">
            <select name="sale_Type" class="form-control" id="sale_Type" onchange="chooseSale();">
              <option>--</option>
              <option value="Interline">Interline</option>
              <option value="Domestic">Domestic</option>
            </select>
            </div>
          </div>
          <div class='form=row justify-content-center' id="blanks"></div>
          <div class="form-row justify-content-center" id="amount"></div>
          <div class="container" id="coupons"></div>
          <div class="form-row justify-content-center" id="Currency"></div>
          <div class="form-row justify-content-center">
            <div class="form-group col-2">
              <label for="payment_Type">Select payment type:</label>
            </div>
            <div class="form-group col-6">
              <select  class="form-control" id="payment_Type" name="payment_Type" onchange="card();">
                <option>--</option>
                <option value="Card">Card</option>
                <option value="Cash">Cash</option>
                </select>
            </div>
          </div>
          <div class='form-row justify-content-center' id="card"></div>
          <div class='form-row justify-content-center'>
            <div class='form-group col-2 align-self-center'>
              <label for="sales_Charge">Amount to pay: </label>
            </div>
            <div class='form-group col-6'>
              <input type="number" class="form-control" name="sales_Charge" min="1" required>
            </div>
          </div>
          <div class='form-row justify-content-center'>
            <div class='form-group col-2 align-self-center'>
              <input type="checkbox" name="late_Payment" value="true">
              <label for="late_Payment">Is a Late Payment?</label>
            </div>
          </div>
          <div class='form-row justify-content-center'>
            <button type='submit' class="btn cAcc" id='submit' name='coupon_Submission'>Submit</button>
    </div>
          <div id="submit"></div>
        </form>

    </div>
    <div class="container" style="background:#f2f2f2;border:solid;border-color:rgba(126, 239, 104, 0.8);margin-top:1%;">
    <div class="row justify-content-center" style="margin-top:1.5%">
      <h3>Refund a Sale</h3>
    </div>
      <form action="../PHP/refund.php" method="post">
      <div class="row justify-content-center" style="margin-bottom:1.5%;">
        <div class="col-4 text-right"><label for="refundID">Enter ticket:</label></div>
        <div class="col-4"><input type="text" class="form-control" name="refundID"/></div>
        <div class="col-4"><button type="submit" class="btn cAcc" name="refund_Submission">Submit</button></div>
        </div>
      </form>
      </div>
      <div class="container" style="background:#f2f2f2;border:solid;border-color:rgba(126, 239, 104, 0.8);margin-top:1%;">
        <div class="row justify-content-center" style="margin-top:1.5%">
          <h3>Submit a Late Payment</h3>
        </div>
        <form action="../PHP/late_Submission.php" method="post">
            <div class="row justify-content-left" style="margin-top:1.5%">
              <div class="col-4 text-right">
                <label for="customer_Name">Enter Name: </label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control" name="late_Name" required>
              </div>
            </div>
            <div class="row justify-content-left" style="margin-top:1.5%">
              <div class="col-4 text-right">
                <label for="customer_Surname">Enter Surname: </label>
              </div>
              <div class="col-4">
                <input type="text" class="form-control" name="late_Surname" required>
              </div>
            </div>
            <div class="row justify-content-left" style="margin-top:1.5%">
              <div class="col-4 text-right">
                <label for="email">Enter Email:</label>
              </div>
              <div class="col-4">
                <input type="email" class="form-control" 1name="late_Email" required>
              </div>
            </div>
            <div class="row justify-content-left" style="margin-top:1.5%">
              <div class="col-4 text-right">
                <label for="LateID">Enter Amount:</label>
              </div>
              <div class="col-4">
                <input type="number" class="form-control" name="LateID" min="1"/>
              </div>
            </div>
            <br>
            <div class="row justify-content-center" style="margin-bottom:1.5%;">
              <button type="submit" name="late_Submission" class="btn cAcc">Submit</button>
            </div>
        </form>
      </div>
    </div>
    </div>
  </body>
</html>
