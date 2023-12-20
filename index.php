<?php
include("header.php");
require('cineticket_db.php');
$pageTitle = "Home Page";


// Function to fetch and initialize movie details
function initializeMovies($conn, $category) {
    $sql = "SELECT * FROM movies WHERE category = '$category'"; // Change the query to select movies by category
    $result = $conn->query($sql);
    
    //Create movies array
    $movies = [];
    
    if ($result->num_rows > 0) {
        //Set rows to 
        while ($row = $result->fetch_assoc()) {

            $movie = [
                'title' => $row['movie_title'],
                'image' => $row['img'],
                'info' => $row['movie_info'],
                'movie_date1' => $row['movie_date1'],
                'movie_date2' => $row['movie_date2'],
                'movie_date3' => $row['movie_date3'],
                'showtime1' => date("H:i", strtotime($row['show1'])),
                'showtime2' => date("H:i", strtotime($row['show2'])),
                'showtime3' => date("H:i", strtotime($row['show3'])),
                'price' => number_format($row['movie_price'], 2),
                'rating'=>$row['movie_rating'],
                'id' => $row['movie_id']
                
            ];
            $movies[] = $movie;
        }
    }

    return $movies;
}
?>

<body>
<main class="container mt-5">
     <!-- Greeting to the logged user-->
    <?php
    if (isset($_SESSION["user_name"])) {
        echo "<h1>Welcome to CineTicket, " . $_SESSION["user_name"] . "!</h1>";
    } else {
        echo "<h1>Welcome to CineTicket</h1>";
    }
    ?>
    <p><h4>Discover the latest movies and book your tickets online</h4></p>

    <!-- Search Bar code-->
    <form method="GET" action="search.php" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="query" placeholder="Search for movies by title or genre">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Search Movies</button>
            </div>
        </div>
    </form>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Movies Now Playing</h2>
            </div>
        </div>
        <div class="row">

            <?php
            //Movies taken from the category 'Now Playing' db
            $nowPlayingMovies = initializeMovies($conn, 'Now Playing');
            
            foreach ($nowPlayingMovies as $movie) {
                echo '<div class="col-md-3 col-sm-6 mb-3">
                    <div class="card  movie-card">
                        <img src="movieImg/' . $movie['image'] . '" class="card-img-top" alt="' . $movie['title'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $movie['title'] . '</h5>
                            <a href="movies.php?movie_id=' . $movie['id'] . '" class="btn btn-primary">More Details</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2>Movies Coming Up</h2>
            </div>
        </div>
        <div class="row">
            <?php
            //Movies taken from the category 'Coming up ' db
            $comingUpMovies = initializeMovies($conn, 'Coming Up');
            
            foreach ($comingUpMovies as $movie) {
                echo '<div class="col-md-3 col-sm-6 mb-3">
                    <div class="card movie-card">
                        <img src="movieImg/' . $movie['image'] . '" class="card-img-top" alt="' . $movie['title'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $movie['title'] . '</h5>
                            <a href="movies.php?movie_id=' . $movie['id'] . '" class="btn btn-primary">More Details</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</main>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include "footer.php";
?>


<style>
    body {
    font-family: Arial, sans-serif; /* font family */
    font-size: 16px; /* font size */
    
    }

    h1, h2{
    font-weight: bold;
    }
    .container{
        margin-bottom: 20px; 
    }
    .card {
        border: bold;
        transition: transform 0.2s ease-in-out;
        border-radius: 10px;
    }
    .movie-card {
        height: 500px; /* card height */
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border: 1px solid #007bff; /* Add border on hover */
    }
    .card-img-top{
        max-width: 100%;
        max-height: 400px;
        width: auto;
        height: auto;
        border-top-right-radius:  10px;
        border-top-right-radius:  10px;
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

