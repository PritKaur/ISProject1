<!DOCTYPE html>
<html><head><title>Register - ISProject1</title></head>
<body>
<h1>Register</h1>
<!-- TODO (Malcolm): add input validation and write register_process.php -->
<form method="post" action="register_process.php">
  <label>Username <input type="text" name="username" required pattern="[A-Za-z0-9_]{3,30}" title="3-30 letters, numbers, underscores"></label><br>
  <label>Email <input type="email" name="email" required maxlength="100"></label><br>
  <label>Password <input type="password" name="password" required minlength="8"></label><br>
  <label>Confirm password <input type="password" name="confirm_password" required minlength="8"></label><br>
  <button type="submit">Register</button>
</form>
<p><a href="login.php">Already have an account?</a></p>
</body></html>
