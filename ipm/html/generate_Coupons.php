<!DOCTYPE html>
<?php include 'header.php'; ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <script type="text/javascript">
      //Function that populates the form according to the decision of the Blank Type
      function chooseType(){
        let generatedHTML ="";
        const selection = document.getElementById("blank_Type").value;
        switch (selection) {
          case '420':
            let j = 0;
            for (i = 0; i < 2; i++){
              generatedHTML += `
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..' required>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..' required><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  <br>`;
            }
            document.getElementById("blank_Type").value = 420;
            console.log(document.getElementById("blank_Type").value);
            document.getElementById("0").innerHTML = generatedHTML;
            document.getElementById("0").innerHTML += '<input type="hidden" value="2" name="coupon_Amount"><button type="submit" id="submit" name="coupon_Submission">Submit Coupons</button>';
            break;

          case '201':
            for (i = 0; i < 2; i++){
              generatedHTML += `
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..' required>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..' required><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  <br>`;
            }
            document.getElementById("blank_Type").value = 201;
            console.log(document.getElementById("blank_Type").value);
            document.getElementById("0").innerHTML = generatedHTML;
            document.getElementById("0").innerHTML += '<input type="hidden" value="2" name="coupon_Amount"><button type="submit" id="submit" name="coupon_Submission">Submit Coupons</button>';
            break;

          case '101':
            for (i = 0; i < 1; i++){
              generatedHTML += `
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..' required>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..' required><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  <br>`;
            }
            document.getElementById("blank_Type").value = 101;
            console.log(document.getElementById("blank_Type").value);
            document.getElementById("0").innerHTML = generatedHTML;
            document.getElementById("0").innerHTML += '<input type="hidden" value="1" name="coupon_Amount"><button type="submit" id="submit" name="coupon_Submission">Submit Coupons</button>';
            break;

          case '444':
            for (i = 0; i < 4; i++){
              generatedHTML += `
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..' required>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..' required><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  <br>`;
            }
            document.getElementById("blank_Type").value = 444;
            console.log(document.getElementById("blank_Type").value);
            document.getElementById("0").innerHTML = generatedHTML;
            document.getElementById("0").innerHTML += '<input type="hidden" value="4" name="coupon_Amount"><button type="submit" id="submit" name="coupon_Submission">Submit Coupons</button>';
            break;
        }
      }
    </script>
  </head>

  <body>
    <form method="post">
      <label for="blank_Type">Choose Blank Type:</label>
      <select id="blank_Type" name="blank_Type">
        <option value="444">444</option>
        <option value="420">420</option>
        <option value="201">201</option>
        <option value="101">101</option>
      </select>
      <button type="button" onclick="chooseType();">Choose Type</button><br>
      <?php
      $result = $db->query("SELECT * from currency;");

      echo "<select name='currency_ID'>";

      while ($row = $result->fetch_assoc()) {
        unset($id, $name);
        $id = $row['currency_ID'];
        $name = $row['currency_Name'];
        echo '<option value="'.$id.'">'.$name.'</option>';
      }

      echo "</select>";

      ?>
    </form>
    <form method="post" id="0" action="../PHP/coupons_Management.php">

    </form>
  </body>

</html>
