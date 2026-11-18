<!DOCTYPE html>
<html><head><title>Login - ISProject1</title></head>
<body>
<h1>Login</h1>
<?php if (isset($_GET['error'])) echo '<p>Invalid username or password.</p>'; ?>
<?php if (isset($_GET['registered'])) echo '<p>Registration successful. Please log in.</p>'; ?>
<form method="post" action="login_process.php">
  <label>Username <input type="text" name="username" required maxlength="50"></label><br>
  <label>Password <input type="password" name="password" required></label><br>
  <button type="submit">Login</button>
</form>
<p><a href="register.php">Create an account</a></p>
</body></html>
