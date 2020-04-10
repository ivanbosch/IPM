<?php
  include 'header.php';
?>

<html>
  <head>
      <link rel = "stylesheet" href = "../resources/css/styles.css">
  </head>

  <h3>Add or remove blanks</h3><br>

  <form action="../PHP/add_blanks_inc.php" method="post" class="login_form">
    <?php
      //gets the date
      echo "<input type='hidden' name='blanks_date' value='".date('dmY')."'>";
    ?>
    <!-- Adding blanks -->
    <label for="blanks">Choose Blank Type:</label>
    <select id="blanks" name="blanks">
      <option value="444">444</option>
      <option value="420">420</option>
      <option value="201">201</option>
      <option value="101">101</option>
    </select>
    <input type="number" name="blanks_Amount" placeholder="Enter amount" min="1"/>
    <button type ="submit" name="blanks_submit">Add Blanks</button><br><br>

    <!-- Removing blanks -->
    <label for="remove">Choose Blank Type:</label>
    <select id="remove" name="remove">
      <option value="444">444</option>
      <option value="420">420</option>
      <option value="201">201</option>
      <option value="101">101</option>
    </select>
    <input type="number" name="removeAmount" placeholder="Enter amount" min="1"/>
    <button type ="submit" name="remove_Submit">Remove Blanks</button>
  </form>

</html>
