<?php
include 'header.php'
?>
<html>
<head>
  <link rel="stylesheet" href="../resources/css/bootstrap.min.css">
  <link rel = "stylesheet" href = "../resources/css/styles.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</head>
<body>
  <div class="row justify-content-center" style="margin-top:2%"><h3>Backups</h3></div>
  <div class="container" style="background:#f2f2f2;border:solid;border-color:rgba(126, 239, 104, 0.8);padding:2%;margin-top:1%;" >
    <form name="backup_form" action="../PHP/generate_Backup.php" method="post">
      <div class="form-row justify-content-center" style="margin-top:1%">
        <div class="form-group col">
          <input type="text" class="form-control" name="filename" placeholder="Insert filename..."/>
        </div>
        <div class="form-group col">
          <button type="submit" class="btn cAcc" name="backup_Submit">Generate Backup</button>
        </div>
      </div>
    </form>
    <form name="backup_form" action="../PHP/restore_Backup.php" method="post">
      <div class="form-row justify-content-center" style="margin-top:1%">
        <div class="form-group col">
          <input type="text" class="form-control" name="restore_name" placeholder="Insert filename...">
        </div>
        <div class="form-group col">
          <button type="submit" class="btn cAcc" name="backup_Restore">Restore Backup</button>
        </div>
      </div>
    </form>
  </div>
</body>
</html>
