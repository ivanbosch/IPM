<html>
  <head>
      <link rel = "stylesheet" href = "../resources/css/styles.css">
  </head>
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

  <form onsubmit="return validate();" action="../PHP/signup_inc.php" method="post" class="login_form">
    <input type="radio" name="type" value="Management">
    <label for="Manager">Manager</label><br>
    <input type="radio" name="type" value="Administrator">
    <label for="Administrator">Administrator</label><br>
    <input type="radio" name="type" value="Advisor">
    <label for="Advisor">Advisor</label><br>
    <input type="text" name="name" placeholder="Name"/ required>
    <input type="text" name="surname" placeholder="Surname"/ required>
    <input type="email" name="email" placeholder="Email"/ required>
    <input type="password" name="password" placeholder="Password"/ pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required>
    <input type="password" name="verify" placeholder="Repeat password"/ required>
    <button type ="submit" name="signup_submit">Create account</button>
  </form>

</html>
