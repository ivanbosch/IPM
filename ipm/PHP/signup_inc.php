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
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $verify = mysqli_real_escape_string($db, $_POST['verify']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $surname = mysqli_real_escape_string($db, $_POST['surname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $user = $name.'.'.$surname;
    $type = $_POST['type'];

    //In case of any empty fields
    if(empty($password || $verify || $name || $surname || $email || $type)) {
        header("Location: ../html/a_Account_Creation.php?error=emptyfields");
        exit();
    }
    //Username can only have the specified characters
    else if (!preg_match("/^[a-zA-Z]*$/" , $name)) {
        header("Location: ../html/a_Account_Creation.php?error=invalidname");
        exit();
    }
    else if (!preg_match("/^[a-zA-Z]*$/" , $surname)) {
        header("Location: ../html/a_Account_Creation.php?error=invalidsurname");
        exit();
    }
    //Password and verify have to match
    else if ($password !== $verify) {
        header("Location: ../html/a_Account_Creation.php?error=invalidpassword");
        exit();
    }
    else { //Check if the login username is already taken
        $sql ="SELECT login_username FROM log_in WHERE login_username=?;";
        $stmt = mysqli_stmt_init($db);
        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../html/a_Account_Creation.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $user);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $result = mysqli_stmt_num_rows($stmt);
            //Check the database for repetition of username
            if ($result > 0) {
                header("Location: ../html/a_Account_Creation.php?error=usernametaken");
                exit();
            }
            else { //insert the values into the staff table
                $sql = "INSERT INTO staff (staff_Type, staff_Name, staff_Surname, staff_Email) VALUES (?, ?, ?, ?);";
                $stmt = mysqli_stmt_init($db);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../html/a_Account_Creation.php?error=sqlerror");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssss", $type, $name, $surname, $email);
                    mysqli_stmt_execute($stmt);
                    //insert the values into the log_in table
                    $sql = "INSERT INTO log_in (login_username, login_password) VALUES (?, ?)";
                    $stmt = mysqli_stmt_init($db);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                      header("Location: ../html/a_Account_Creation.php?error=sqlerror");
                      exit();
                    }
                    else {
                      //Hashing of the password, so it is secure
                      $hashPass = password_hash($password, PASSWORD_DEFAULT);
                      mysqli_stmt_bind_param($stmt, "ss", $user, $hashPass);
                      mysqli_stmt_execute($stmt);

                      header("Location: ../html/a_Account_Creation.php?account_creation=success");
                      exit();
                    }
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($db);
}
else {
    //If wasn't accessed through the submit button
    header("Location: ../html/a_Account_Creation.php");
    exit();
}
