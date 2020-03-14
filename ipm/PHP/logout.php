//CREATE LOGOUT
<?php
//Will close the session and destroy it and go back to the first page
session_start();
session_unset();
session_destroy();
header("Location: ../html/loginform.html");
