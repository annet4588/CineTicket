<?php
include "header.php";
require "cineticket_db.php";

//Query to find a movie by title and genre
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT * FROM movies WHERE movie_title LIKE '%$query%' OR movie_genre LIKE '%$query%'";
    $result = $conn->query($sql);

    //Display the searching movie 
    if ($result->num_rows > 0) {
        echo '<div class="container mt-5 justify-content-center">'; // Make the content centered
        echo '<h2>Search Results</h2>';
        echo '<div class="row">';

        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-3 col-sm-6 mb-3">
                        <div class="card movie-card">
                            <img src="movieImg/' . $row['img'] . '" class="card-img-top" alt="' . $row['movie_title'] . '">
                            <div class="card-body">
                                <h5 class="card-title" style="max-height: 3em; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $row['movie_title'] . '</h5>
                            
                                <a href="movies.php?movie_id=' . $row['movie_id'] . '" class="btn btn-primary">More Details</a>
                            </div>
                        </div>
                    </div>';
        }

        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="container mt-5">';
        echo '<h2>No results found for your query: ' . htmlspecialchars($query) . '</h2>';
        echo '</div>';
    }
}

// Close the database connection
$conn->close();
?>
<?php
include "footer.php";
?>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 16px;
    }

    h2 {
        font-weight: bold;
    }

    .container {
        margin-bottom: 20px;
    }

    .card {
        border: bold;
        transition: transform 0.2s ease-in-out;
        border-radius: 10px;
    }
    .movie-card {
        height: 500px; /* Set the desired height here */
    }


    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border: 1px solid #007bff;
    }

    .card-img-top {
        max-width: 100%;
        max-height: 400px;
        width: auto;
        height: auto;
        border-top-right-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        overflow: hidden; 
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .card-text {
        margin-bottom: 0.5rem;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>