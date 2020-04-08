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
<<<<<<< HEAD
        <div class='col-md'>
          <ul class='hPageActive'>
            <h4>Management</h4>
            <li><a href='../PHP/view_staff.php'>View Travel Advisors</a></li>
            <li><a href='../PHP/blanks.php'>Allocate Blanks</a></li>
            <li><a href='../PHP/view_staff.php'>Set Commission Rate</a></li>
            <li><a href='../PHP/discounts.php'>Set Customer Discount</a></li>
            <li><a href='../PHP/customer.php'>Set Customer Status</a></li>
=======
        <div class='homepage_Lists'>
          <h2>Management</h2>
          <ul>
            <li><a href='../PHP/view_staff.php' target ='_blank'>View Travel Advisors</a></li>
            <li><a href='../PHP/blanks.php' target ='_blank'>Allocate Blanks</a></li>
            <li><a href='../PHP/view_staff.php' target ='_blank'>Set Commission Rate</a></li>
            <li><a href='../PHP/discounts.php' target ='_blank'>Set Customer Discount</a></li>
            <li><a href='../PHP/customer.php' target ='_blank'>Set Customer Status</a></li>
>>>>>>> c295ca434d854a5c7ff269ca0c2512d4fb5f3b0d
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
<<<<<<< HEAD
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
=======
            <div class='homepage_Lists'>
              <h2>Administrator</h2>
              <ul>
                <li><a href='a_Account_Creation.php' target ='_blank'>Create Account</a></li>
                <li><a href='add_blanks.php' target ='_blank'>Add Blanks</a></li>
                <li><a href='backups.php' target ='_blank'>Create Backup</a></li>
                <li><a href='backups.php' target ='_blank'>Restore Backup</a></li>
              </ul>
            </div>";
      }
      else {
>>>>>>> c295ca434d854a5c7ff269ca0c2512d4fb5f3b0d
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
<<<<<<< HEAD
        <div class='col-md'>
          <ul class='hPageActive'>
            <h4>Sales</h4>
            <li><a href='sales.php'>Manage Sale</a></li>
            <li><a href='view_sales.php'>View Sales</a></li>
          </ul>
        </div>";
      } else {
=======
          <div class='homepage_Lists'>
            <h2>Sales</h2>
            <ul>
              <li><a href='sales.php' target ='_blank'>Create Sale</a></li>
              <li><a href='sales.php' target ='_blank'>Cancel Ticket</a></li>
            </ul>
          </div>";
      }

      else {
>>>>>>> c295ca434d854a5c7ff269ca0c2512d4fb5f3b0d
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
<<<<<<< HEAD
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
              <li><a href=''>View Refund Records</a></li>
              <li><a href='../PHP/TST_pdf.php' target='_blank'>Ticket Stock Turnover Report</a></li>
              <li><a href='../PHP/ISRI.php' target='_blank'>Individual Sales Report Local</a></li>
              <li><a href='../PHP/ISRL.php' target='_blank'>Individual Sales Report Interline</a></li>
              <li><a href='../PHP/GSRL.php' target='_blank'>Global Sales Report Local</a></li>
              <li><a href='../PHP/GSRI.php' target='_blank'>Global Sales Report Interline</a></li>
=======
          <div class='homepage_Lists'>
            <h2>Reports</h2>
            <ul>
              <li><a href='' target ='_blank'>View Refund Records</a></li>
              <li><a href='../PHP/TST_pdf.php' target ='_blank'>Ticket Stock Turnover Report</a></li>
              <li><a href='../PHP/ISRI.php' target ='_blank'>Individual Sales Report Local</a></li>
              <li><a href='../PHP/ISRL.php' target ='_blank'>Individual Sales Report Interline</a></li>
            </ul>
          </div>";
      } else if ($_SESSION['user_Type'] == 'Management') {
        echo "
          <div class='homepage_Lists'>
            <h2>Reports</h2>
            <ul>
              <li><a href='' target ='_blank'>View Refund Records</a></li>
              <li><a href='../PHP/TST_pdf.php' target ='_blank'>Ticket Stock Turnover Report</a></li>
              <li><a href='../PHP/ISRI.php' target ='_blank'>Individual Sales Report Local</a></li>
              <li><a href='../PHP/ISRL.php' target ='_blank'>Individual Sales Report Interline</a></li>
              <li><a href='../PHP/GSRL.php' target ='_blank'>Global Sales Report Local</a></li>
              <li><a href='../PHP/GSRI.php' target ='_blank'>Global Sales Report Interline</a></li>
            </ul>
          </div>";
      } else {
        echo "
          <div class='homepage_Lists'>
            <h2>Reports</h2>
            <ul>
              <li><a>View Reports</a></li>
              <li><a>View Refund Records</a></li>
>>>>>>> c295ca434d854a5c7ff269ca0c2512d4fb5f3b0d
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
