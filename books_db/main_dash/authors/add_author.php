<?php
require_once '../../config/config.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // If user is not logged in, redirect to the login page or perform other actions
    // For example, redirect to login page
    header("Location: ../../auth/login.html");
    exit; // Stop further execution
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];

  // Validate input
  if (empty($name)) {
    $error = "Name is required.";
  } else {
    // Insert author into database
    $sql = "INSERT INTO authors (name) VALUES ('$name')";
    if (mysqli_query($conn, $sql)) {
      $success = "Author added successfully!";
    } else {
      $error = "Failed to add author: " . mysqli_error($conn);
    }
  }
}

// mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Author</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>Add Author</h4>
          </div>
          <div class="card-body">
            <?php if (isset($error)): ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
              </div>
            <?php endif; ?>
            <?php if (isset($success)): ?>
              <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
              </div>
            <?php endif; ?>
            <form action="" method="POST">
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <button type="submit" class="btn btn-primary">Add Author</button>

              
            </form>
            <br><br>
  <a href="../dash.php"><button type="submit" class="btn btn-success"> Back to Dashboard</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
