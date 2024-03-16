<?php
require '../../config/config.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // If user is not logged in, redirect to the login page 
    header("Location: ../../auth/login.html");
    exit; 
}



$errors = [];
$success_message = '';

// Fetch all authors from the database
$sql_authors = "SELECT * FROM authors";
$result_authors = mysqli_query($conn, $sql_authors);

// Fetch all genres from the database
$sql_genres = "SELECT * FROM genres";
$result_genres = mysqli_query($conn, $sql_genres);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $genre_id = $_POST['genre_id'];
    $publication_year = $_POST['publication_year'];

    // Validate input (add more validations as needed)
    if (empty($title)) {
        $errors[] = "Title is required.";
    }
    if (empty($author_id)) {
        $errors[] = "Please select an author.";
    }
    if (empty($genre_id)) {
        $errors[] = "Please select a genre.";
    }

    // If no errors, insert the new book into the database
    if (empty($errors)) {
        $sql_insert = "INSERT INTO books (title, author_id, genre_id, publication_year) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_insert);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "siis", $title, $author_id, $genre_id, $publication_year);
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Book added successfully!";
            } else {
                $errors[] = "Failed to add book: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Book</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($errors as $error): ?>
                                <?php echo $error; ?><br>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ($success_message): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="author">Author:</label>
                            <select class="form-control" id="author_id" name="author_id" required>
                                <option value="">Select Author</option>
                                <?php while ($row = mysqli_fetch_assoc($result_authors)): ?>
                                    <option value="<?php echo $row['author_id']; ?>"><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="genre">Genre:</label>
                            <select class="form-control" id="genre_id" name="genre_id" required>
                                <option value="">Select Genre</option>
                                <?php while ($row = mysqli_fetch_assoc($result_genres)): ?>
                                    <option value="<?php echo $row['genre_id']; ?>"><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="publication_year">Publication Year:</label>
                            <input type="number" class="form-control" id="publication_year" name="publication_year" min="1800" max="<?php echo date("Y"); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Book</button>
                    </form>
                </div>
            </div>
        </div>
        <a href="../dash.php" class="justify-content-center"><button class="btn-success">Back to Dashboard</button></a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
