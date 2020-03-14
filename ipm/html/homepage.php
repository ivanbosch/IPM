<!DOCTYPE html>
<html>
<?php
  include 'header.php'
?>

<div class='homepage_Container'>
  <?php
    if (isset($_SESSION['user_Type'])) {
      if ($_SESSION['user_Type'] == 'Management') {
        echo "
        <div class='homepage_Lists'>
          <h2>Management</h2>
          <ul>
            <li><a href='' target ='_blank'>View Travel Advisors</a></li>
            <li><a href='../PHP/allocate_blanks.php' target ='_blank'>Allocate Blanks</a></li>
            <li><a href='' target ='_blank'>Set Commision Rate</a></li>
            <li><a href='' target ='_blank'>Set Customer Discount</a></li>
            <li><a href='' target ='_blank'>Set Customer Status</a></li>
          </ul>
        </div>";
      }
       else {
        echo "
          <div class='homepage_Lists'>
            <h2>Management</h2>
            <ul>
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
            <div class='homepage_Lists'>
              <h2>Administrator</h2>
              <ul>
                <li><a href='a_Account_Creation.php' target ='_blank'>Create Account</a></li>
                <li><a href='add_blanks.php' target ='_blank'>Add Blanks</a></li>
                <li><a href='' target ='_blank'>Create Backup</a></li>
                <li><a href='' target ='_blank'>Restore Backup</a></li>
              </ul>
            </div>";
      }
      else {
        echo "
            <div class='homepage_Lists'>
              <h2>Administrator</h2>
              <ul>
                <li><a>Create Account</a></li>
                <li><a>Add Blanks</a></li>
                <li><a>Create Backup</a></li>
                <li><a>Restore Backup</a></li>
              </ul>
            </div>";
      }
    }
    if (isset($_SESSION['user_Type'])) {
      if($_SESSION['user_Type'] == 'Advisor') {
        echo "
          <div class='homepage_Lists'>
            <h2>Sales</h2>
            <ul>
              <li><a href='sales.php' target ='_blank'>Create Sale</a></li>
              <li><a href='' target ='_blank'>Cancel Ticket</a></li>
            </ul>
          </div>";
      }

      else {
        echo "
          <div class='homepage_Lists'>
            <h2>Sales</h2>
            <ul>
              <li><a>Create Sale</a></li>
              <li><a>Cancel Ticket</a></li>
            </ul>
          </div>";
      }
    }
    if (isset($_SESSION['user_Type'])) {
      if($_SESSION['user_Type'] == 'Advisor' || $_SESSION['user_Type'] == 'Management') {
        echo "
          <div class='homepage_Lists'>
            <h2>Reports</h2>
            <ul>
              <li><a href='' target ='_blank'>View Reports</a></li>
              <li><a href='' target ='_blank'>View Refund Records</a></li>
              <li><a href='' target ='_blank'>Generate Report</a></li>
            </ul>
          </div>";
      }
      else {
        echo "
          <div class='homepage_Lists'>
            <h2>Reports</h2>
            <ul>
              <li><a>View Reports</a></li>
              <li><a>View Refund Records</a></li>
              <li><a>Generate Report</a></li>
            </ul>
          </div>";
      }
  }
  ?>
</div>
</html>
