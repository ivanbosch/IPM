<?php

if(isset($_POST['backup_Submit'])) {
  include 'connection.php';

  $filename = mysqli_real_escape_string($db, $_POST['filename']).".sql";
  //get all the tables of the SQLiteDatabase
  $tables = array();
  $result = mysqli_query($db, "SHOW TABLES");
  while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
  }

  $return = '';
  foreach ($tables as $table) {
    $result = mysqli_query($db, "SELECT * FROM ".$table);
    $num_fields = mysqli_num_fields($result);

    //First drop the tables in the db
    $return .= 'DROP TABLE '.$table.';';
    //Create the tables once again
    $row2 = mysqli_fetch_row(mysqli_query($db, 'SHOW CREATE TABLE '.$table));
    $return .= "\n\n".$row2[1].";\n\n";


    for ($i=0; $i<$num_fields; $i++) {
      //Go through each row
      while($row = mysqli_fetch_row($result)) {
        $return .= 'INSERT INTO '.$table.' VALUES(';
        for ($j=0; $j<$num_fields; $j++) {
          $row[$j] = addslashes($row[$j]);
          if (isset($row[$j])) {
            $return .= '"'.$row[$j].'"';
          } else {
            $return .= '""';
          }
          if ($j<$num_fields-1) {
            $return .= ',';
          }
        }
        $return .= ");\n";
      }
    }
    $return .= "\n\n\n";
  }

  $handle = fopen($filename, 'w+');
  fwrite($handle, $return);
  fclose($handle);

  header("Location: ../html/backups.php?backupsuccessful");
  exit();
} else {
  header("Location: ../html/backups.php?error");
  exit();
}
