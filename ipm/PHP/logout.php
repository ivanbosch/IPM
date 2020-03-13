//CREATE LOGOUT
<?php

session_start();
session_unset();
session_destroy();
header("Location: ../html/loginform.html");
