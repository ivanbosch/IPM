<?php include 'header.php'; ?>
<html>
  <head>
    <link rel="stylesheet" href="../resources/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "../resources/css/styles.css">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
    function validate(){
      let password = document.getElementById("password");
      let verify = document.getElementById("verify");
      let inputs = document.getElementByTagName("INPUT");
      if (password.value.trim() !== verify.value.trim()) {
        alert("Password does not match");
        password.style.border = "solid 3px red";
        verify.style.border = "solid 3px red";
        return false;
      } else {
        return true;
      }
    }
    </script>
  </head>
  <body>
    <div class="row justify-content-center" style="margin-top:2%"><h3>Create New Account</h3></div>
    <div class="container-md" style="background:#f2f2f2;border:solid;border-color:rgba(126, 239, 104, 0.8);padding:2%;margin-top:1%; font-family: 'Roboto', sans-serif;">
      <form onsubmit="return validate();" action="../PHP/signup_inc.php" method="post" class="login_form">
      <div class="form-row">
        <div class="form-group col">
          <input type="text" class="form-control" name="name" placeholder="Name"/ required>
        </div>
        <div class="form-group col">
          <input type="text" class="form-control" name="surname" placeholder="Surname"/ required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col">
          <input type="email" class="form-control" name="email" placeholder="Email"/ required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col">
          <input type="password" class="form-control" name="password" placeholder="Password"/ pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required>
        </div>
        <div class="form-group col">
          <input type="password" class="form-control" name="verify" placeholder="Repeat password"/ required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col">
          <input type="radio" name="type" value="Management" >
          <label  for="Manager">Manager</label>
        </div>
        <div class="form-group col">
          <input type="radio" name="type" value="Administrator" >
          <label  for="Administrator">Administrator</label>
        </div>
        <div class="form-group col">
          <input type="radio" name="type" value="Advisor" >
          <label  for="Advisor">Advisor</label><br>
        </div>
      </div>
      <div class="form-row justify-content-center">
        <button type ="submit" class="btn cAcc " name="signup_submit">Create account</button>
      </div>
      </form>
    </div>
  </body>

</html>
