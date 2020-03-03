<html>
<head>
</head>

  <h3>Backups</h3><br>


  <form name="backup_form" action="../PHP/generate_Backup.php" method="post">
    <?php
      echo "<input type='hidden' name='filename' value='ats_backup_".date('dmY').".sql'>";
    ?>
    <button type="submit" name="backup_Submit">Generate Backup</button>
  </form>

  <form name="backup_form" action="../PHP/restore_Backup.php" method="post">
      <input type="text" name="restore_name" placeholder="Enter file">
      <button type="submit" name="backup_Restore">Restore Backup</button>
  </form>


</html>
