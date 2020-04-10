<?php
include 'header.php';
?>

<html>
<head>
    <link rel="stylesheet" href="../resources/css/styles.css">
</head>
<form action="../PHP/add_blanks_inc.php" method="post" class="login_form">
    <?php
    //gets the date
    echo "<input type='hidden' name='blanks_date' value='" . date('dmY') . "'>";
    ?>
    <!-- Adding blanks -->

    <body>
    <div class="row justify-content-center" style="margin-top:2%"><h3>BLONK</h3></div>
    <div class="container-md"
         style="background:#f2f2f2;border:solid;border-color:rgba(126, 239, 104, 0.8);padding:2%;margin-top:1%; font-family: 'Roboto', sans-serif;">
        <form action="../PHP/add_blanks_inc.php" method="post" class="login_form">
            <div class="form-row">
                <label for="blanks">Choose Blank Type:</label>
                <select id="blanks" name="blanks">
                    <option value="444">444</option>
                    <option value="440">440</option>
                    <option value="420">420</option>
                    <option value="201">201</option>
                    <option value="101">101</option>
                </select>
                <input type="number" name="blanks_Amount" placeholder="Enter amount" min="1"/>
                <button type="submit" name="blanks_submit">Add Blanks</button>
            </div>

            <div class="form-row">
                <label for="blanks">Choose Blank Type:</label>
                <select id="remove" name="remove">
                    <option value="444">444</option>
                    <option value="440">440</option>
                    <option value="420">420</option>
                    <option value="201">201</option>
                    <option value="101">101</option>
                    <input type="number" name="removeAmount" placeholder="Enter amount" min="1"/>
                    <button type="submit" name="remove_Submit">Remove Blanks</button>
                </select>
            </div>
        </form>

    </div>
    </body>

</html>