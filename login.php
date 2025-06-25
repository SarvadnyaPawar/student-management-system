<?php
include 'connect.php';
$role = $_GET['role'] ?? 'user';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
  $stmt->bind_param("ss", $email, $role);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

 if ($user && password_verify($password, $user['password'])) {
  if ($role === 'admin') {
    header("Location: admin.php");
  } else {
    header("Location: dashboard.php");
  }
  exit();
}

     else {
    echo "<script>alert('Invalid credentials');</script>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo ucfirst($role); ?> Login</title>
  <link rel="stylesheet" href="login_style.css" />
</head>
<body>
  <div class="form-container">
    <h2><?php echo ucfirst($role); ?> Login</h2>
    <form method="post">
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Login</button>
    </form>
    <p><a href="login_register.php?role=<?php echo $role; ?>">New user? Register</a></p>
    <p><a href="forgot_password.php?role=<?php echo $role; ?>">Forgot Password?</a></p>
  </div>
</body>
</html>