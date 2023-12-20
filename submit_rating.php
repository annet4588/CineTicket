<?php
include "header.php";
require "cineticket_db.php";


//Function to add movie rating
function addRating($conn, $user_id, $selected_movie_id, $rating, $rating_date){
   
    $query = "INSERT INTO ratings (user_id, movie_id, rating, rating_date) VALUES (?, ?, ?, NOW())";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $user_id, $selected_movie_id, $rating);

    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Error: " . $stmt->error);
        return false;
    }
}


// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])){
    $errors = array();

    //Retrive variables from the session and the form
    $user_id = $_SESSION['user_id'];
    $selected_movie_id = $_POST['movie_id'];

    // Initialize variables
    $rating = $rating_date = null;
   
    
    if (isset($_POST['rating']) && is_numeric($_POST['rating']) && $_POST['rating'] >= 1 && $_POST['rating'] <= 5) {
        $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    } else {
        $errors[] = 'Select a valid rating between 1 and 5.';
    }

    if (empty($errors)){
        $addRating = addRating($conn, $user_id, $selected_movie_id, $rating, $rating_date);

        if ($addRating){
            //Unset the session after successful submission
            unset($_SESSION['selected_movie_id']);
             
            //Redirect to movies.php after successful submission 
            header("Location: movies.php?movie_id=" . $selected_movie_id);
            exit();
        } else {
            $errors[] = "Failed to add rating.";
        }
    }
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if a movie_id is provided in the query string
    if (isset($_GET['movie_id'])) {
        $selected_movie_id = $_GET['movie_id'];

        // Display movie details
        $sql = "SELECT movie_id, movie_title, movie_info, movie_genre, movie_rating, img FROM movies WHERE movie_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $selected_movie_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Declare $rating_stmt here
        $rating_stmt = null;

        if ($result->num_rows > 0) {
            echo '<div class="row justify-content-center card-container">';

            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-6">
                        <div class="card mb-3 custom-card">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="movieImg/' . $row['img'] . '" class="card-img-left img-fluid" alt="' . $row['movie_title'] . '">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <h5 class="card-title movie-title">' . $row['movie_title'] . '</h5>';

                if (isset($row['movie_info'])) {
                    echo '<p class="card-text"><span class="bold-text">Description:</span> ' . $row['movie_info'] . '</p>';
                }
                if (isset($row['movie_genre'])) {
                    echo '<p class="card-text"><span class="bold-text">Genre:</span>' . $row['movie_genre'] . '</p>';
                }

                // Display average rating and number of ratings
                $rating_sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as num_ratings FROM ratings WHERE movie_id = ?";
                $rating_stmt = $conn->prepare($rating_sql);
                $rating_stmt->bind_param("i", $selected_movie_id);
                $rating_stmt->execute();
                $rating_result = $rating_stmt->get_result();

                if ($rating_result->num_rows > 0) {
                    $rating_data = $rating_result->fetch_assoc();
                    echo '<p class="card-text"><span class="bold-text">Average Rating:</span> ' . number_format($rating_data['avg_rating'], 1) . '</p>';
                    echo '<p class="card-text"><span class="bold-text">Number of Ratings:</span> ' . $rating_data['num_ratings'] . '</p>';
                }

                // Rating form
                echo '<p class="card-text"><span class="bold-text">Rate This Movie</span></p>';
                echo '<form action="" method="POST">
                        <input type="hidden" name="movie_id" value="' . $selected_movie_id . '">
                        <label for="rating">Rating (1-5):</label>
                        <input type="number" name="rating" min="1" max="5" required>
                        <button type="submit" class="btn btn-primary" name="submit">Submit Rating</button>
                      </form>';

                echo '</div>
                        </div>
                    </div>
                </div>';
            }

            echo '</div>';
        } else {
            echo "Movie not found.";
        }

        // Close the prepared statement
        $stmt->close();
        // Close $rating_stmt inside the if block
        if ($rating_stmt) {
            $rating_stmt->close();
        }
    } else {
        // Handle cases where a movie_id is not provided
        echo "Please select a movie to view.";
    }
} else {
    // User is not logged in, show a login message or redirect to the login page
    echo "Please log in to rate this movie.";
}

// Close the database connection
$conn->close();

include "footer.php";
?>
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    body {
    font-family: Arial, sans-serif; 
    font-size: 16px; 
    
    }

    h5{
    font-weight: bold;
    font-size: 25px;
    }
    .card-container {
        margin-top: 20px; 
    }

    .card-img-left {
        padding: 10px;
     
    }

    .card-body{
        padding: 10px;
    }
</style>