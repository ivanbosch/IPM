<!DOCTYPE html>
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
              generatedHTML += `
                  <form class='generate_Coupons' action='../PHP/coupons.php' method='post'>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..'>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..'><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  </form><br>`;
            }
            document.getElementById("0").innerHTML = generatedHTML;
          break;
          case '201':
            for (i = 0; i < 2; i++){
              generatedHTML += `
                  <form class='generate_Coupons' action='../PHP/coupons.php' method='post'>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..'>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..'><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  </form><br>`;
            }
            document.getElementById("0").innerHTML = generatedHTML;
          break;
          case '101':
            for (i = 0; i < 1; i++){
              generatedHTML += `
                  <form class='generate_Coupons' action='../PHP/coupons.php' method='post'>
                    <input type='text' name='coupon_Origin${i}' placeholder='Enter Origin..'>
                    <input type='text' name='coupon_Destination${i}' placeholder='Enter Destination..'><br>
                    <label for='coupon_Date'>Select Coupon Date:</label>
                    <input type='date' name='coupon_Date${i}' id='coupon_Date'>
                    <label for='coupon_Time'>Select Coupon Time:</label>
                    <input type='time' name='coupon_Time${i}' id='coupon_Time'>
                  </form><br>`;
            }
          document.getElementById("0").innerHTML = generatedHTML;
          break;
          case '444':
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
            }
            const a = "s'tr";
            const b = 'S"TR';
            const c = `${a} ${b}`;
          document.getElementById("0").innerHTML = generatedHTML;
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
      <button type="button" onclick="chooseType();">Choose Type</button>
    </form>
    <p id="0"></p>

  </body>

</html>
