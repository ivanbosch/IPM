<?php include '../html/header.php'; ?>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>
  <script src="../js/edit_blank_alloc.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style>
* {
  box-sizing: border-box;
}
#blankSearch, #advisorSearch {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
</style>
<body>
  <?php
    $usernameQuery = mysqli_query($db, "SELECT login_username, staff_ID FROM log_in");
  ?>
  <form action="allocate_blanks.php" method ="post">
  <label for="username">Choose username:</label>
  <select id ="username" name ="username">
    <?php
    while($username = mysqli_fetch_assoc($usernameQuery))
      echo "<option value = '".$username['staff_ID']."'>" . $username['login_username']. "</option>";
    ?>
  </select>
  <?php $blankQuery = mysqli_query($db, "SELECT blank_Type, blank_ID FROM blanks WHERE blank_Advisor_ID IS NULL GROUP BY blank_Type DESC");
  ?>
  <label for="blank">Choose available blank type:</label>
  <select id ="blank" name="blank">
    <?php
    while($blank = mysqli_fetch_assoc($blankQuery))
     echo "<option value = '".$blank['blank_Type']."'>" . $blank['blank_Type']. "</option>";
     ?>
  </select>
  <label for="amount">Choose amount:</label>
  <input type="text" id="amount" name ="amount">
  <button type="submit" name ="submit"  class="btn btn-success">Allocate</button>
  <?php
    $quantity = mysqli_query($db, "SELECT COUNT(blank_Type) as maximum, blank_Type from blanks where blank_Advisor_ID is null group by blank_Type desc");
    echo "<br> Maximum allocation: <br>";
    while($type = mysqli_fetch_assoc($quantity)){
      echo $type['blank_Type']. ": ". $type['maximum']. " <br>";
    }
  ?>
  </form>

  <!-- Search for blank type-->
  <input type="text" id="blankSearch" onkeyup="search(5, id)" placeholder="Search for blank..." name="search">

  <input type="text" id="advisorSearch" onkeyup="search(1, id)" placeholder="Search for username..." name="search">

<table id= "editable-table" class="table">
  <thead class="thead-dark">
    <tr>
      <th>Blank ID</th>
      <th>Username</th>
      <th>Staff ID</th>
      <th>Surname</th>
      <th>Name</th>
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

      //call to perform the query on database
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
<script>
function search(a, b) {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById(b);
  filter = input.value.toUpperCase();
  table = document.getElementById("editable-table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[a];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</body>
