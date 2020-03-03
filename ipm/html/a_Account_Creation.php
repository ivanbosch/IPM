<html>
  <head>
      <link rel = "stylesheet" href = "../resources/css/styles.css">
  </head>

  <form action="../PHP/signup_inc.php" method="post" class="login_form">
    <input type="radio" name="type" value="Management">
    <label for="Manager">Manager</label><br>
    <input type="radio" name="type" value="Administrator">
    <label for="Administrator">Administrator</label><br>
    <input type="radio" name="type" value="Advisor">
    <label for="Advisor">Advisor</label><br>
    <input type="text" name="user" placeholder="Username"/>
    <input type="text" name="name" placeholder="Name"/>
    <input type="text" name="surname" placeholder="Surname"/>
    <input type="text" name="email" placeholder="Email"/>
    <input type="password" name="password" placeholder="Password"/>
    <input type="password" name="verify" placeholder="Repeat password"/>
    <button type ="submit" name="signup_submit">Create account</button>
  </form>

</html>
