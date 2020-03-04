<?php
    include '../PHP/connection.php';
    session_start();
    date_default_timezone_set('Europe/London');
?>

<header>
    <div class="header_container">
      <div>
        <nav>
            <ul>
                <li><a href="homepage.html">Homepage</a>
                <li><a href="administrator.html">Administrator</a>
                <li><a href="management.html">Management</a>
                <li><a href="sales.html">Sales</a></li>
                <li><a href="reports.html">Reports</a></li>
            </ul>
        </nav>
      </div>
      <div class="header-buttons">
          <?php
              if (isset($_SESSION['id'])){ //In case of login show the log out button.
                  //Need to echo out the account details username and account type.
                  echo '<div>'.$_SESSION["id"].'</div> <div>'.$_SESSION["username"].'</div>';
                  echo '<form action="../PHP/logout.php" method="post"> <button type="submit" name="logout-submit">Logout</button> </form>';
              } else { //in case of being logged out show the login form, username and password can be entered here.
                  echo '<form action="loginform.html"><button type="submit">Login</button></form>';
              }
          ?>
      </div>
    </div>
</header>
