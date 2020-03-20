<?php

if (isset($_POST['backup_Restore'])) {
  include 'connection.php';

  $filename = mysqli_real_escape_string($db, $_POST['restore_name']).".sql";
  $handle = fopen($filename, "r+");
  $contents = fread($handle, filesize($filename));

  $sql = explode(';', $contents);
  foreach ($sql as $query) {
    $result = mysqli_query($db, $query);
    if ($result) {
      echo '<tr><td><br></td></tr>';
      echo '<tr><td>'.$query.' <b>SUCCESS</b></td></tr>';
      echo '<tr><td><br></td></tr>';
    }
  }
  fclose($handle);
  echo "Successfully imported";
} else {
  header("Location: ../html/backups.php?error=unauthorizedaccess");
  exit();
}

?>
