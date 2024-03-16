<?php
require '../config/config.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // If user is not logged in, redirect to the login page or perform other actions
    // For example, redirect to login page
    header("Location: ../auth/login.html");
    exit; // Stop further execution
}




?>  

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Welcome to the Dashboard</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>Authors</h3>
            <?php include './authors/authors.php'; ?>

            <br>
            <a href="./authors/add_author.php"><button>Add author</button></a>

        </div>
        <div class="col-md-6">
            <h3>Books</h3>
            <?php include './books/add_books.php'; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3>Genres</h3>
            <?php include './genre/show_genre.php'; ?>
        </div>
        <div class="col-md-6">
            <h3>Reviews</h3>
            <?php include './reviews/add_review.php'; ?>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
