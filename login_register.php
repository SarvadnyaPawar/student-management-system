<?php
include 'connect.php';
$role = $_GET['role'] ?? 'user';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $role = $_POST["role"];

  $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $password, $role);

  if ($stmt->execute()) {
    echo "<script>alert('Registered successfully'); window.location='login.php?role=$role';</script>";
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo ucfirst($role); ?> Register</title>
  <link rel="stylesheet" href="login_style.css" />
</head>
<body>
  <div class="form-container">
    <h2><?php echo ucfirst($role); ?> Register</h2>
    <form method="post">
      <input type="hidden" name="role" value="<?php echo $role; ?>">
      <input type="text" name="name" placeholder="Name" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Register</button>
    </form>
    <p><a href="login.php?role=<?php echo $role; ?>">Already registered? Login</a></p>
  </div>
</body>
</html>