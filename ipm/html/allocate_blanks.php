<?php require "../PHP/connection.php" ?>

<!DOCTYPE html>
<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="dist/jquery.tabledit.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="custom_table_edit.js"></script>
</head>
<body>
<table id= "data_table" class="table">
  <thead class="thead-dark">
    <tr>
      <th>Staff ID</th>
      <th>Advisor name</th>
      <th>Mananger name</th>
      <th>Blanks</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $blank_query = "SELECT blanks.blank_Type, blanks.blank_Advisor_ID, staff.staff_Name, staff.staff_Surname
      FROM blanks
      INNER JOIN Staff ON blanks.blank_Advisor_ID = staff.staff_ID";
      $result = mysqli_query($db, $blank_query);
      $fetch_users = "SELECT staff_Name FROM staff";
      $staff_name = mysqli_query($db, $fetch_users);
      $real = mysqli_fetch_assoc($staff_name);
      while($row = mysqli_fetch_assoc($result)) {
    ?>
      <tr>
        <td class="table-info"><?php echo "ID ", $row ['blank_Advisor_ID']; ?></td>
        <td class="table-info"><?php echo $row['staff_Name']," ", $row['staff_Surname']; ?></td>
        <td class="table-info"><?php ?></td>
        <td class="table-info"><?php echo  $row ['blank_Type']; ?></td>
      </tr>
<?php } ?>
</tbody>
</table>
<button type="button" class="btn btn-success">New</button>
<button type="button" class="btn btn-warning">Edit</button>
<button type="button" class="btn btn-danger">Delete</button>
</body>
</html>
