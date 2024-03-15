<?php
require_once '../config/config.php';

// Function to sanitize user input
function sanitize_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$errors = [];
$response = []; // Array to store response messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = sanitize_input($_POST['username']);
  $password = sanitize_input($_POST['password']);

  // Validate input (add more validations as needed)
  if (empty($username)) {
    $errors[] = "Username is required.";
  }
  if (empty($password)) {
    $errors[] = "Password is required.";
  }

  // If no errors, validate credentials
  if (empty($errors)) {
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT user_id, username, password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];
        if (password_verify($password, $db_password)) {
          $response['success'] = "Login successful!";

          $_SESSION['username'] = $username;
          // You can set session variables or redirect the user to a dashboard here
          echo $_SESSION['username'];
        } else {
          $errors[] = "Invalid username or password.";
        }
      } else {
        $errors[] = "Invalid username or password.";
      }
      mysqli_free_result($result);
    } else {
      $errors[] = "Database error: " . mysqli_error($conn);
    }
  }

  // Handle errors
  if (!empty($errors)) {
    $response['errors'] = $errors;
  }

  // Send response as JSON
  echo json_encode($response);
}

mysqli_close($conn);
?>
