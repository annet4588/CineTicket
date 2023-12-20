<?php
include "header.php";
require "cineticket_db.php";


// Clear the previous movie session data
if (isset($_SESSION['selected_movie_id'])) {
    unset($_SESSION['selected_movie_id']);
    unset($_SESSION['selected_movie_title']);
    unset($_SESSION['selected_movie_price']);
    unset($_SESSION['selected_seats']);
    unset($_SESSION['selected_payment_method']);
    // unset other session data related to the movie if needed
}
// Check if a movie_id is provided in the query string
if (isset($_GET['movie_id'])) {
    $selected_movie_id = $_GET['movie_id'];

 // Query to fetch the selected movie from the database using a prepared statement
 $sql = "SELECT movie_id, movie_title, movie_info, movie_genre, movie_date1, movie_date2, movie_date3, TIME_FORMAT(show1, '%H:%i') AS show1, TIME_FORMAT(show2, '%H:%i') AS show2, TIME_FORMAT(show3, '%H:%i') AS show3, preview, movie_price, movie_rating, img FROM movies WHERE movie_id = ?";
    
 // Use a prepared statement to prevent SQL injection
 $stmt = $conn->prepare($sql);
 $stmt->bind_param("i", $selected_movie_id);
 $stmt->execute();
 $result = $stmt->get_result();

    if ($result->num_rows > 0) {
             
        while ($row = $result->fetch_assoc()) {
            // Store the selected movie details in the session
            $_SESSION['selected_movie_id'] = $selected_movie_id;
            $_SESSION['selected_movie_title'] = $row['movie_title'];
            $_SESSION['selected_movie_price'] = $row['movie_price'];
            $_SESSION['selected_movie_rating'] = $row['movie_rating'];
            $_SESSION['selected_movie_info'] = $row['movie_info'];
            $_SESSION['selected_movie_genre'] = $row['movie_genre'];
           
            $_SESSION['selected_movie_preview'] = $row['preview'];   
            $_SESSION['selected_movie_img'] = $row['img'];         


            // Store other movie details in the session if needed    

            echo '<div class="col-md-12 ">
                <div class="card mb-3 custom-card">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="movieImg/' . $row['img'] . '" class="card-img-left img-fluid" alt="' . $row['movie_title'] . '">
                        </div>
                        <div class="col-md-5 align-self-center">
                            <div class="card-body">
                                <h5 class="card-title movie-title">' . $row['movie_title'] . '</h5>';
                               
                                // Add a "Read Aloud" button to read the card's content.
                            echo ' <button class="btn btn-primary read-aloud-button" data-content="';
                                echo htmlentities($row['movie_title']);
                                echo '';
                                if (isset($row['movie_info'])) {
                                    echo 'Description: ' . htmlentities($row['movie_info']);
                                }
                                if (isset($row['movie_genre'])) {
                                    echo 'Genre: ' . htmlentities($row['movie_genre']);
                                }
                                if (isset($row['movie_date1']) && isset($row['movie_date2']) && isset($row['movie_date3'])) {
                                    echo 'Movie Dates: ' . htmlentities($row['movie_date1'] . ', ' . $row['movie_date2'] . ', ' . $row['movie_date3']);
                                }
                                                           
                                if (isset($row['show1']) && isset($row['show2']) && isset($row['show3'])) {
                                    echo 'Showtimes: ' . htmlentities($row['show1'] . ', ' . $row['show2'] . ', ' . $row['show3']);
                                }
                                if (isset($row['movie_price'])) {
                                    echo 'Price: £' . htmlentities($row['movie_price']);
                                }
                            echo '">Read Aloud</button>';
                            echo ' <button id="stop-read-aloud" class="btn btn-danger">Stop</button>';
                           
                                if (isset($row['movie_info'])) {
                                    echo '<p class="card-text"><span class="bold-text">Description:</span> ' . $row['movie_info'] . '</p>';
                                }
                                if(isset($row['movie_genre'])) {
                                echo '<p class="card-text"><span class="bold-text">Genre:</span>'. $row['movie_genre'] . '</p>';
                                }
                                //Movie dates
                                 // Display movie date buttons
                                echo '<div class="showtimes">
                                <p class="card-text"><span class="bold-text">Movie Dates:</span> 
                                    <div class="btn-group" role="group">';
                                        // Loop over movie_date1, movie_date2, and movie_date3
                                        foreach (['movie_date1', 'movie_date2', 'movie_date3'] as $dateKey) {
                                            $date = $row[$dateKey];
                                            echo '<form method="post" action=>
                                                <input type="hidden" name="movie_id" value="' . $row['movie_id'] . '">
                                                <button disabled type="submit" name="selected_movie_date" value="' . $date . '" class="btn btn-primary btn-sm" style="margin-right: 10px;">' . $date . '</button>
                                            </form>';
                                        }
                                    echo '</div>
                                </p>
                            </div>';
             
                                    
                                //Showtimes
                               // Disabled buttons show1, show2, and show3 on the movies page to see the movie's showtimes
                               echo ' <div class="showtimes">
                               <p class="card-text"><span class="bold-text">Showtimes:</span> 
                               <div class="btn-group" role="group">
                               <form method="post" action=>
                                   <input type="hidden" name="movie_id" value="' . $row['movie_id'] . '">
                                   <button disabled type="submit" name="showtime" value="' . $row['show1'] . '" class="btn btn-primary btn-sm">' . $row['show1'] . '</button>
                                   <button disabled type="submit" name="showtime" value="' . $row['show2'] . '" class="btn btn-primary btn-sm">' . $row['show2'] . '</button>
                                   <button disabled type="submit" name="showtime" value="' . $row['show3'] . '" class="btn btn-primary btn-sm">' . $row['show3'] . '</button>
                               </form>
                               </div>
                              </p>
                              </div>';
                                if (isset($row['movie_price'])) {
                                    echo '<p class="card-text"><span class="bold-text">Price:</span> £' . $row['movie_price'] . '</p>';
                                }
                                // var_dump($row['movie_rating']);
                                if (isset($row['movie_rating'])) {
                                    echo '<p class="card-text"><span class="bold-text">Rating:</span> ' . $row['movie_rating'] . '</p>';
                                }

                                 // Query to calculate the average rating for the selected movie
                                $averageRatingQuery = "SELECT AVG(rating) AS average_rating FROM ratings WHERE movie_id = ?";
                                $stmtAverage = $conn->prepare($averageRatingQuery);
                                $stmtAverage->bind_param("i", $selected_movie_id);
                                $stmtAverage->execute();
                                $resultAverage = $stmtAverage->get_result();

                                if ($resultAverage->num_rows > 0) {
                                    while ($rowAverage = $resultAverage->fetch_assoc()) {
                                        // Display the average rating
                                        echo '<p class="card-text"><span class="bold-text">Average Rating:</span> ' . number_format($rowAverage['average_rating'], 1) . '</p>';
                                    }
                                }else{
                                    echo '<p class="card-text"><span class="bold-text">Average Rating:</span> Not Rated Yet</p>';
                                
                                }

                                // Check if the user is logged in to display the booking page
                                  // Check if the user had a booking_id with the same movie_id and if so, let the user rate the movie
                                
                                  if (isset($_SESSION['user_id'])) {
                                    $user_id = $_SESSION['user_id'];

                                    // Check if the user has a booking for the selected movie
                                    $bookingCheckQuery = "SELECT booking_id FROM movie_bookings WHERE user_id = '$user_id' AND movie_id = '$selected_movie_id'";
                                    $bookingCheckResult = $conn->query($bookingCheckQuery);

                                    if ($bookingCheckResult->num_rows > 0) {
                                        // User has a booking, provide a link to the rating page
                                        echo '<a href="submit_rating.php?movie_id=' . $selected_movie_id . '" class="btn btn-primary" style="margin-right: 10px;">Rate This Movie</a>';
                                    } else {
                                        // User doesn't have a booking, prompt them to book the movie
                                        echo '<a href="shoppingCart.php" class="btn btn-primary" style="margin-right: 10px;">Rate the movie</a>';
                                    }
                                } else {
                                    // User is not logged in, show a login message or redirect to the login page
                                    echo '<a href="login.php" class="btn btn-primary" style="margin-right: 10px;">Log in to rate</a>'; // If the user is not logged in display the login page
                                }

                                if (isset($_SESSION['user_email'])) {
                                    echo '<a href="shoppingCart.php" class="btn btn-primary">Proceed to Booking</a>';
                                } else {
                                    echo '<a href="login.php" class="btn btn-primary">Log in to book</a>'; //If the user is not logged in display the login page
                                }
                                
                            echo '</div>
                        </div>
                    </div>
                </div>
            </div>';
    
            
            // Open a new row for the preview card
            echo '<div class="row justify-content-center">';
            // Add the "Preview" container below the card
            if (isset($row['preview'])) {
                echo '<div class="col-md-12">
                <div class="container">
                    <div class="card mb-3 custom-card">
                        <div class="card-body">
                            <h5 class="card-title">Watch Trailer</h5>
                            <iframe width="600" height="400" src="' . $row['preview'] . '" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    </div>
                </div>';
            }
            echo '</div>';
        }
    } else {
        echo "Movie not found.";
    }
} else {
    // Handle cases where a movie_id is not provided
    echo "Please select a movie to view.";
}

// Close the database connection
$conn->close();
?>
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://code.responsivevoice.org/responsivevoice.js"></script>

<!-- Read Aloud code-->
<script>
    let currentSpeech;

    // Add a click event listener to all "Read Aloud" buttons with the read-aloud-button class.
    const readAloudButtons = document.querySelectorAll('.read-aloud-button');
    readAloudButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const content = button.getAttribute('data-content');
            
            // Stop any ongoing speech before starting a new one.
            if (currentSpeech) {
                console.log('Stopping speech'); // Debugging
                responsiveVoice.cancel(currentSpeech);
            }
             console.log('Starting speech'); // Debugging
            currentSpeech = responsiveVoice.speak(content, "UK English Female");
        });
    });

    // Add a click event listener to the "Stop" button.
    const stopButton = document.getElementById('stop-read-aloud');
    stopButton.addEventListener('click', function () {
        console.log("Stop button clicked"); // Debugging
        if (currentSpeech) {
            console.log('Stopping speech');
            responsiveVoice.cancel(currentSpeech);
        }
    });
</script>

<?php
include "footer.php";
?>

<style>
    body {
    font-family: Arial, sans-serif; /* font family */
    font-size: 16px; /* font size */ 
   
    }

    h5{
    font-weight: bold;
    font-size: 25px;
    }
   

    /* Add padding to the image and title */
    .card-img-left {
        padding: 20px;
     
    }

    .card-body{
        padding: 20px;
    }
    /* Adjust the video size to fit the view */
    .custom-card iframe {
        width: 100%;
        height: 300px;
    }

    .bold-text {
    font-weight: bold;
}
</style>








