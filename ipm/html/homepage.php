<!DOCTYPE html>
<?php
  include 'header.php';
?>
<html>
<body>
<div class="row" style="background:#f2f2f2;border:solid;border-color:rgba(126, 239, 104, 0.8);padding:2%; margin:5%;font-family: 'Roboto', sans-serif;">
  <?php
    if (isset($_SESSION['user_Type'])) {
      if ($_SESSION['user_Type'] == 'Management') {
        echo "
        <div class='col-md'>
          <ul class='hPageActive'>
            <h4>Management</h4>
            <li><a href='../PHP/view_staff.php'>View Travel Advisors</a></li>
            <li><a href='../PHP/blanks.php'>Allocate Blanks</a></li>
            <li><a href='../PHP/view_staff.php'>Set Commission Rate</a></li>
            <li><a href='../PHP/discounts.php'>Set Customer Discount</a></li>
            <li><a href='../PHP/customer.php'>Set Customer Status</a></li>
          </ul>
        </div>";
      } else {
        echo "
        <div class='col-md'>
          <ul class='hPageInactive'>
            <h4>Management</h4>
            <li><a>View Travel Advisors</a></li>
            <li><a>Allocate Blanks</a></li>
            <li><a>Set Commision Rate</a></li>
            <li><a>Set Customer Discount</a></li>
            <li><a>Set Customer Status</a></li>
          </ul>
        </div>";
      }
    }
    if (isset($_SESSION['user_Type'])) {
      if ($_SESSION['user_Type'] == 'Administrator') {
        echo "
        <div class='col-md'>
          <ul class='hPageActive'>
            <h4>Administrator</h4>
            <li><a href='a_Account_Creation.php'>Create Account</a></li>
            <li><a href='add_blanks.php'>Add Blanks</a></li>
            <li><a href='backups.php'>Create Backup</a></li>
            <li><a href='backups.php'>Restore Backup</a></li>
          </ul>
        </div>";
      } else {
        echo "
        <div class='col-md'>
          <ul class='hPageInactive'>
            <h4>Administrator</h4>
            <li><a>Create Account</a></li>
            <li><a>Add Blanks</a></li>
            <li><a>Create Backup</a></li>
            <li><a>Restore Backup</a></li>
          </ul>
        </div>";
      }
    }
    if (isset($_SESSION['user_Type'])) {
      if($_SESSION['user_Type'] == 'Advisor' || $_SESSION['user_Type'] == 'Management') {
        echo "
        <div class='col-md'>
          <ul class='hPageActive'>
            <h4>Sales</h4>
            <li><a href='sales.php'>Manage Sale</a></li>
            <li><a href='view_sales.php'>View Sales</a></li>
          </ul>
        </div>";
      } else {
        echo "
        <div class='col-md'>
          <ul class='hPageInactive'>
            <h4>Sales</h4>
            <li>Manage Sale</li>
            <li>View Sales</li>
          </ul>
        </div>";
      }
    }
    if (isset($_SESSION['user_Type'])) {
      if($_SESSION['user_Type'] == 'Advisor')  {
        echo "
        <div class='col-md'>
          <ul class='hPageActive'>
            <h4>Reports</h4>
            <li><a href=''>View Refund Records</a></li>
            <li><a href='../PHP/ISRI.php' target='_blank'>Individual Sales Report Local</a></li>
            <li><a href='../PHP/ISRL.php' target='_blank'>Individual Sales Report Interline</a></li>
          </ul>
        </div>";
      } else if ($_SESSION['user_Type'] == 'Management') {
        echo "
          <div class='col-md'>
            <ul class='hPageActive'>
              <h4>Reports</h4>
              <li><a href='../PHP/refund_log.txt' download>View Refund Records</a></li>
              <li><a href='../PHP/TST_pdf.php' target='_blank'>Ticket Stock Turnover Report</a></li>
              <li><a href='../PHP/ISRI.php' target='_blank'>Individual Sales Report Local</a></li>
              <li><a href='../PHP/ISRL.php' target='_blank'>Individual Sales Report Interline</a></li>
              <li><a href='../PHP/GSRL.php' target='_blank'>Global Sales Report Local</a></li>
              <li><a href='../PHP/GSRI.php' target='_blank'>Global Sales Report Interline</a></li>
            </ul>
          </div>";
      } else {
        echo "
        <div class='col-md'>
          <ul class='hPageActive'>
            <h4>Reports</h4>
            <li><a href='../PHP/TST_pdf.php' target='_blank'>Ticket Stock Turnover Report</a></li>
          </ul>
        </div>";
      }
  }
  ?>
</div>
</body>
</html>
