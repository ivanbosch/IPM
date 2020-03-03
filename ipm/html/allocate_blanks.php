<?php require "../PHP/connection.php" ?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--<link rel = "stylesheet" href = "../resources/css/styles.css">-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../dist/jquery.tabledit.js"></script>
</head>
<body>
  <script> alert("please thanks"); </script>
<table id= "data_table" class="table">
  <thead class="thead-dark">
    <tr>
      <th>Blank ID</th>
      <th>Username</th>
      <th>Staff ID</th>
      <th>Name</th>
      <th>Surname</th>
      <th>Blanks</th>
    </tr>
  </thead>
  <tbody>
    <?php
      //query to display details about allocated blanks
      $blank_query = "SELECT blanks.blank_ID, blanks.blank_Type, blanks.blank_Advisor_ID, staff.staff_Name, staff.staff_Surname, log_in.login_username
      FROM blanks
      INNER JOIN staff ON blanks.blank_Advisor_ID = staff.staff_ID
      INNER JOIN log_in ON blanks.blank_Advisor_ID = log_in.staff_ID";

      //call to peform the query on database
      $result = mysqli_query($db, $blank_query);

      //while loop to go thorugh the result of the query row by row
      while($row = mysqli_fetch_assoc($result)) {
    ?>
      <tr>
        <td class="table-info"><?php echo  $row ['blank_ID']; ?></td>
        <td class="table-info"><?php echo  $row ['login_username']; ?></td>
        <td class="table-info"><?php echo  $row ['blank_Advisor_ID']; ?></td>
        <td class="table-info"><?php echo $row['staff_Surname']; ?></td>
        <td class="table-info"><?php echo $row['staff_Name']; ?></td>
        <td class="table-info"><?php echo  $row ['blank_Type']; ?></td>
      </tr>
<?php } ?>
</tbody>
</table>
</body>
<script type="text/javascript" src="../js/edit_blank_alloc.js"></script>
</html>
