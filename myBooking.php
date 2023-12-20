<?php
include "header.php";
require "cineticket_db.php";
$pageTitle = "My Booking";
?>

<!DOCTYPE html>
<html>

<body>
    <div class="container d-flex justify-content-center align-items-start" style="min-height: 100vh;">
       
        <div class="card ">
            <div class="card-body">
                <h5 class="card-title">Booking History</h5>
                <?php
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    // Retrieve all booking details from the database for the current user
                    $query = "SELECT * FROM movie_bookings WHERE user_id = ?";
                    $stmt = mysqli_prepare($conn, $query);

                    if ($stmt) {
                        // Bind parameters and execute the query
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);

                        // Fetch the results
                        $result = mysqli_stmt_get_result($stmt);

                        if (mysqli_num_rows($result) > 0) {
                            // Loop through the results and display each booking in a card
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<div class="card m-2" style="width: 18rem;">';
                                echo '<div class="card-body">';
                                $booking_id = $row['booking_id'];
                                echo "<h5 class='card-title'>Booking ID: " . $booking_id . "</h5>";
                                echo "<p class='card-text'>Movie: " . $row['movie_title'] . "</p>";
                                $selected_movie_date = date('d/m/Y', strtotime($row['selected_movie_date']));
                                $selected_time = date('H:i', strtotime($row['selected_time']));
                                echo "<p class='card-text'>Movie Date: " . $selected_movie_date . "</p>";
                                echo "<p class='card-text'>Showtime: " . $selected_time . "</p>"; $selected_seats = $row['selected_seats'];
                                $sanitizedSeats = preg_replace("/[^a-zA-Z0-9]+/", ",", $selected_seats);
                                // Use ltrim to remove leading commas
                                $sanitizedSeats = ltrim($sanitizedSeats, ',');
                                echo "<p class='card-text'>Seats: " . $sanitizedSeats . "</p>";
                                
                                echo "<p class='card-text'>Total Price: £" . number_format($row['total_price'], 2) . "</p>";
                                $booking_date = date('d/m/Y', strtotime($row['booking_date']));
                                echo "<p class='card-text'>Booking Date: " . $booking_date . "</p>";
                                echo '</div></div>';
                            }
                        } else {
                            echo "<p class='error'>No bookings found for this user.</p>";
                        }

                        // Close the database connection
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "<p class='error'>Database query preparation failed.</p>";
                    }

                    // Close the database connection (if not already closed)
                    mysqli_close($conn);
                } else {
                    echo "User ID not found in the session.";
                }
                ?>


            </div>
        </div>
    </div>
</body>
</html>
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    h1{
        margin:20px;
    }
    .center-card {
        display: flex;
        flex-direction: column; /* Stack elements vertically */
        align-items: center;
        margin-top: 10vh; /* Adjust as needed to move the card down */
    }

    .card {
        margin: 20px;
        width: 400px;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 24px;
        font-weight: bold;
        text-align: left;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }

    .form-check-input {
        margin-right: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .mt-3 {
        margin-top: 15px;
    }

    .text-center {
        text-align: center;
    }
</style>
<?php
include "footer.php";
?>