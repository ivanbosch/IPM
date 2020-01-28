<?php
/**
 * Created by PhpStorm.
 * User: sellm
 * Date: 28/01/2020
 * Time: 14:59
 */

//only if it was entered through the login button
if (isset($_POST['login_submit'])) {

    //connection to the database
    require 'connection.php';

    //declaring the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //if any of the text fields are empty
    if (empty($username || $password)) {
        header("Location: ../html/loginform.html?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM log_in WHERE username=?;";
        $statement = mysqli_stmt_init($db);

        //error looking for information related to the username in the database/table AKA sqlerror
        if (!mysqli_stmt_prepare($statement, $sql)) {
            header("Location: ../html/loginform.html?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);

            if ($row = mysqli_fetch_assoc($result)) {
                $pwd_check = password_verify($password, $row['password']);
                //wrong password error
                if($pwd_check == false){
                    header("Location: ../html/loginform.html?error=wrongpassword");
                    exit();
                } else if ($pwd_check == true) { //Success! Login start of a session, will be closed on log off
                    session_start();
                    $_SESSION[id] = $row['id'];
                    $_SESSION[username] = $row['username'];

                    //redirects to homepage since you get access, rather than going back to login form
                    header("Location: ../html/homepage.html?login=success");
                    exit();
                } else { //any other sort of weird errors that go through the if's above will end up in wrong password
                    header("Location: ../html/loginform.html?error=wrongpassword");
                    exit();
                }
            } else { //No user found in the table
                header("Location: ../html/loginform.html?error=nouser");
                exit();
            }
        }
    }
}
else {
    //if someone tries to write directly into the url
    header("Location: ../html/loginform.html");
    exit();
}