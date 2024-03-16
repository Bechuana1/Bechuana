<?php
require_once '../config/config.php';

// Function to sanitize user input
function sanitize_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
 }

$errors= [];
$responce = []; // Array to store errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = sanitize_input($_POST['username']);
  $password = sanitize_input($_POST['password']);

  // Validate input (add more validations as needed)
 // Validate input (add more validations as needed)
if (!isset($username) || empty($username)) {
  $responce['errors'][] = "Username is required.";
}
if (!isset($password) || empty($password)) {
  $responce['errors'][] = "Password is required.";
}



  // If no errors, prepare and execute the registration query
  if (empty($responce['errors'])) {
    $sql = "INSERT INTO users (username, password, time) VALUES (?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
      $responce['errors'][] = "Failed to prepare statement: " . mysqli_error($conn);
    } else {
      // Hash the password securely before inserting
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
      if (!mysqli_stmt_execute($stmt)) {
        $responce['errors'][] = "Registration failed: " . mysqli_error($conn);
      } else {
        $responce['success'] = "Registration successful!";
        header("location: ./login.html");
      }
      mysqli_stmt_close($stmt);
    }
  }
}

mysqli_close($conn);
?>
