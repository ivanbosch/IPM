<!DOCTYPE html>
<?php include 'header.php'; ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <script type="text/javascript">
      function chooseType(){
        let generatedHTML ="";
        const selection = document.getElementById("coupon_Type").value;
        switch (selection) {
          case '420':
            let j = 0;
            for (i = 0; i < 2; i++){
              document.getElementById("coupon_Amount").innerHTML = '<input type="hidden" id="coupon_Amount" name="coupon_Amount" value="2"/>'
              generatedHTML += `
                  <form class='generate_Coupons' action='../PHP/coupons.php' method='post'>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..'>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..'><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  </form><br>`;
              document.getElementById("coupon_Amount").value = i
            }
            document.getElementById("0").innerHTML = generatedHTML;
            document.getElementById("0").innerHTML += '<button type="submit" id="submit" name="coupon_Submission">Submit Coupons</button>';
            break;

          case '201':
            for (i = 0; i < 2; i++){
              document.getElementById("coupon_Amount").innerHTML = '<input type="hidden" id="coupon_Amount" name="coupon_Amount" value="2"/>'
              generatedHTML += `
                  <form class='generate_Coupons' action='../PHP/coupons.php' method='post'>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..'>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..'><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  </form><br>`;
              document.getElementById("coupon_Amount").value = i
            }
            document.getElementById("0").innerHTML = generatedHTML;
            document.getElementById("0").innerHTML += '<button type="submit" id="submit" name="coupon_Submission">Submit Coupons</button>';
            break;

          case '101':
            for (i = 0; i < 1; i++){
              document.getElementById("coupon_Amount").innerHTML = '<input type="hidden" id="coupon_Amount" name="coupon_Amount" value="1"/>'
              generatedHTML += `
                  <form class='generate_Coupons' action='../PHP/coupons.php' method='post'>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..'>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..'><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  </form><br>`;
              document.getElementById("coupon_Amount").value = i
            }
            document.getElementById("0").innerHTML = generatedHTML;
            document.getElementById("0").innerHTML += '<button type="submit" id="submit" name="coupon_Submission">Submit Coupons</button>';
            break;

          case '444':
            document.getElementById("coupon_Amount").innerHTML = '<input type="hidden" id="coupon_Amount" name="coupon_Amount" value="4"/>'
            for (i = 0; i < 4; i++){
              generatedHTML += `
                  <form class='generate_Coupons' action='../PHP/coupons.php' method='post'>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..'>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..'><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  </form><br>`;
              document.getElementById("coupon_Amount").value = i
            }
            document.getElementById("0").innerHTML = generatedHTML;
            document.getElementById("0").innerHTML += '<button type="submit" id="submit" name="coupon_Submission">Submit Coupons</button>';
            break;
        }
      }
    </script>
  </head>

  <body>
    <form method="post">
      <label for="coupon_Type">Choose Blank Type:</label>
      <select id="coupon_Type" name="blanks">
        <option value="444">444</option>
        <option value="420">420</option>
        <option value="201">201</option>
        <option value="101">101</option>
      </select>
      <button type="button" onclick="chooseType();">Choose Type</button><br>
    </form>
    <input type="hidden" id="coupon_Amount" name="coupon_Amount"/>
    <form method="post" action="../PHP/coupons_Management.php">
      <p id="0"></p>
    </form>
    <?php echo "<input type='hidden' value='".$_SESSION['id']."' name='id'" ?>
    <?php echo "<h1>hello".$_SESSION['id']."</h1>" ?>
  </body>

</html>
