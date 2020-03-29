<?php require "../PHP/connection.php";
session_start();
?>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>
  <script src="../js/edit_staff.js"></script>
</head>
<body>
  <table id = "editable-staff" class="table">
    <thead class="thead-dark">
      <tr>
        <th>Staff ID</th>
        <th>Type</th>
        <th>Surname</th>
        <th>Name</th>
        <th>Email</th>
        <th>Commission ID</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $staff = mysqli_query($db, "SELECT * FROM staff"); // query to select all staff
        while($row = mysqli_fetch_assoc($staff)){
          ?>
          <tr>
            <td bgcolor="#9933ff"><?php echo  $row ['staff_ID']; ?></td>
            <td bgcolor="#9933ff"><?php echo  $row ['staff_Type']; ?></td>
            <td bgcolor="#9933ff"><?php echo  $row ['staff_Surname']; ?></td>
            <td bgcolor="#9933ff"><?php echo $row['staff_Name']; ?></td>
            <td bgcolor="#9933ff"><?php echo $row['staff_Email']; ?></td>
            <td bgcolor="#9933ff"><?php echo  $row ['commission_ID']; ?></td>
          </tr>
      <?php  } ?>
    </tbody>
  </table>
</body>
