<?php require "../PHP/connection.php";
?>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <!--<link rel = "stylesheet" href = "../resources/css/styles.css">-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-tabledit@1.0.0/jquery.tabledit.min.js"></script>
  <!--<script src="../js/edit_blank_alloc.js"></script>-->
</head>
<body>
<table id= "editable-table" class="table">
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
<script>
$(document).ready(function(){
  $('#editable-table').Tabledit({
    url: 'live-blank-alloc.php',
    deleteButton: false,
    editButton: false,
    restoreButton: false,
    hideIdentifier: false,
    columns: {
      identifier: [0, 'blank_ID'],
      editable: [[1, 'login_username']]
    },
    onDraw: function() {
    console.log('onDraw()');
},
onSuccess: function(data, textStatus, jqXHR) {
    console.log('onSuccess(data, textStatus, jqXHR)');
    console.log(data);
    console.log(textStatus);
    console.log(jqXHR);
    location.reload();
},
onFail: function(jqXHR, textStatus, errorThrown) {
    console.log('onFail(jqXHR, textStatus, errorThrown)');
    console.log(jqXHR);
    console.log(textStatus);
    console.log(errorThrown);
},
onAlways: function() {
    console.log('onAlways()');
},
onAjax: function(action, serialize) {
    console.log('onAjax(action, serialize)');
    console.log(action);
    console.log(serialize);
}
  });
});
</script>
</body>
