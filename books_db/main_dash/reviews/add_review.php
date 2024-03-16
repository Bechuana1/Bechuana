<?php
require_once '../../config/config.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // If user is not logged in, redirect to the login page
    header("Location: ../../auth/login.html");
    exit; // Stop further execution
}

$errors = [];
$success_message = '';

// Fetch all books from the database
$sql_books = "SELECT * FROM books";
$result_books = mysqli_query($conn, $sql_books);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];

    // Validate input (add more validations as needed)
    if (empty($book_id)) {
        $errors[] = "Please select a book.";
    }
    if (empty($rating)) {
        $errors[] = "Rating is required.";
    }
    if (empty($comment)) {
        $errors[] = "Comment is required.";
    }

    // If no errors, insert the new review into the database
    if (empty($errors)) {
    // Construct SQL query
    $sql_insert = "INSERT INTO reviews (book_id, user_id, rating, comment) VALUES ('$book_id', '$user_id', '$rating', '$comment')";

    // Execute the query
    if (mysqli_query($conn, $sql_insert)) {
        $success_message = "Review added successfully!";
    } else {
        $errors[] = "Failed to add review: " . mysqli_error($conn);
    }
} else {
    $errors[] = "Database error: " . mysqli_error($conn);
}
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Add Review</h4>
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
                            <label for="book_id">Select Book:</label>
                            <select class="form-control" id="book_id" name="book_id" required>
                                <option value="">Select Book</option>
                                <?php while ($row = mysqli_fetch_assoc($result_books)): ?>
                                    <option value="<?php echo $row['book_id']; ?>"><?php echo $row['title']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
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
