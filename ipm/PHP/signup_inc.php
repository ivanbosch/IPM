<?php
/**
 * Created by PhpStorm.
 * User: sellm
 * Date: 28/01/2020
 * Time: 18:12
 */

if(isset($_POST['signup_submit'])) {

    require 'connection.php';

    //declaration
    $user = $_POST['user'];
    $password = $_POST['password'];
    $verify = $_POST['verify'];
    $class = $_POST['type'];

    //In case of any empty fields
    if(empty($user || $password || $verify || $class)) {
        header("Location: ../html/account_creation.html?error=emptyfields&username=".$user);
        exit();
    }
    //Username can only have the specified characters
    else if (!preg_match("/^[a-zA-Z0-9]*$/" , $user)) {
        header("Location: ../html/account_creation.html?error=invalidusername");
        exit();
    }
    //Password and verify have to match
    else if ($password !== $verify) {
        header("Location: ../html/account_creation.html?error=invalidpassword");
        exit();
    }
    else {
        $sql ="SELECT username FROM log_in WHERE username=?";
        $stmt = mysqli_stmt_init($db);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../html/account_creation.html?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $result = mysqli_stmt_num_rows($stmt);
            //Check the database for repetition of username
            if ($result > 0) {
                header("Location: ../html/account_creation.html?error=usernametaken");
                exit();
            }
            else {
                $sql = "INSERT INTO log_in (username, password, class) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($db);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../html/account_creation.html?error=sqlerror");
                    exit();
                }
                else {
                    //Hashing of the password, so it is secure
                    $hashPass = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "sss", $user, $hashPass, $class);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../html/account_creation.html?account_creation=success");
                    exit();

                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($db);
}
else {
    //If wasn't accessed through the submit button
    header("Location: ../html/account_creation.html");
    exit();
}