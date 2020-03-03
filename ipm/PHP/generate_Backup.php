<?php

if(isset($_POST['backup_Submit'])) {
  include 'connection.php';

  $filename = $_POST['filename'];

  $result=exec('mysqldump ats --password="" --user=root --single-transaction >/Downloads/'.$filename, $output);

  if ($output==''){
    header("Location: ../html/backups.php?error=nooutput");
    exit();
  } else {
    header("Location: ../html/backups.php?success=outputgenerated");
    exit();
  }
} else {
  header("Location: ../html/backups.php?error");
  exit();
}
