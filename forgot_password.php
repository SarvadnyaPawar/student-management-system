<?php
$role = $_GET['role'] ?? 'user';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  echo "<script>alert('Reset link sent to $email');</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password - <?php echo ucfirst($role); ?></title>
  <link rel="stylesheet" href="login_style.css" />
</head>
<body>
  <div class="form-container">
    <h2>Forgot Password (<?php echo ucfirst($role); ?>)</h2>
    <form method="post">
      <input type="email" name="email" placeholder="Email" required><br>
      <button type="submit">Send Reset Link</button>
    </form>
    <p><a href="login.php?role=<?php echo $role; ?>">Back to Login</a></p>
  </div>
</body>
</html>