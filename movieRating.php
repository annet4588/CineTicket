<?php
include "header.php";
require "cineticket_db.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if a movie_id is provided in the query string
    if (isset($_GET['movie_id'])) {
        $selected_movie_id = $_GET['movie_id'];

        // Query to fetch the selected movie from the database.
        $sql = "SELECT movie_id, movie_title, movie_info, movie_genre, movie_rating, img FROM movies WHERE movie_id = $selected_movie_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="row justify-content-center">';

            while ($row = $result->fetch_assoc()) {
                // Store the selected movie details in the session
                $_SESSION['selected_movie_id'] = $selected_movie_id;
                $_SESSION['selected_movie_title'] = $row['movie_title'];

                echo '<div class="col-md-12">
                    <div class="card mb-3 custom-card">
                        <div class="row">
                            <!-- Movie details here -->
                        </div>
                    </div>
                </div>';

                // Add the rating form
                echo '<div class="col-md-12">
                    <div class="card mb-3 custom-card">
                        <div class="card-body">
                            <h5 class="card-title">Rate This Movie</h5>
                            <form action="submit_rating.php" method="POST">
                                <input type="hidden" name="movie_id" value="' . $selected_movie_id . '">
                                <label for="rating">Rating (1-5):</label>
                                <input type="number" name="rating" min="1" max="5" required>
                                <button type="submit" class="btn btn-primary">Submit Rating</button>
                            </form>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo "Movie not found.";
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
?>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
