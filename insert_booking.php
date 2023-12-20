<?php
require('header.php');
require('cineticket_db.php');

// Initialize an error array.
$errors = array();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user_id is set in the session
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Check for movie ID
        $movie_id = $_POST['movie_id'] ?? '';
        if (empty($movie_id)) {
            $errors[] = "Movie ID not found.";
        }

        // Check for movie title
        $movie_title = $_POST['movie_title'] ?? '';
        if (empty($movie_title)) {
            $errors[] = "Movie title not found.";
        }

        // Check for selected movie date
        $selected_movie_date = $_POST['selected_movie_date'] ?? '';
        if (empty($selected_movie_date)) {
            $errors[] = "Select the movie date.";
        }

        // Check for selected showtime
        $selected_time = $_POST['selected_showtime'] ?? '';
        if (empty($selected_time)) {
            $errors[] = "Select the showtime.";
        }

        // Check for selected seats
        $selected_seats = $_POST['selected_seats'] ?? '';
        if (empty($selected_seats)) {
            $errors[] = "Select the seats.";
        }

        // Check for selected number of tickets
        $selected_num_tickets = isset($_POST['tickets_quantity']) ? intval($_POST['tickets_quantity']) : 0;
        if (empty($selected_num_tickets)) {
            $errors[] = "Select the number of tickets.";
        }

        // Check for total price
        $total_price = $_POST['total_price'] ?? '';
        if (empty($total_price)) {
            $errors[] = "Total price not found.";
        }

        // Check for booking date
        $booking_date = $_POST['booking_date'] ?? '';
        if (empty($booking_date)) {
            $errors[] = "Booking date not found.";
        }

        //Check for payment method
        $selected_payment_method = $_POST['selected_payment_method'] ?? '';
        if(empty($selected_payment_method)){
            $errors[] = "Payment method not selected";
        }

        // If no errors, insert the booking into the database
        if (empty($errors)) {
            $query = "INSERT INTO movie_bookings (user_id, movie_id, movie_title, booking_date, selected_movie_date, selected_time, selected_seats, tickets_quantity, total_price, selected_payment_method) 
                      VALUES (?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?,?, ?, ?)";
            
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "iisssssids", $user_id, $movie_id, $movie_title, $booking_date, $selected_movie_date, $selected_time, $selected_seats,$selected_num_tickets, $total_price, $selected_payment_method);

            if (mysqli_stmt_execute($stmt)) {
                // Booking was successful
                echo "Booking successful!";

                // Unset Session variables
                unset($_SESSION['selected_movie_id']);
                unset($_SESSION['selected_movie_title']);
                unset($_SESSION['selected_showtime']);

                // Redirect to myBooking.php with the retrieved booking_id as a query parameter
                header('Location: myBooking.php');
                exit;
            } else {
                // Error in the database insert
                $errors[] = "Error booking the movie.";
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        // User_id is not set in the session
        $errors[] = "User ID not found in the session.";
    }
} else {
    // Request method is not POST
    $errors[] = "Invalid request.";
}

// Display any errors
if (!empty($errors)) {
    echo 'The following error(s) occurred:<br>';
    foreach ($errors as $msg) {
        echo "- $msg<br>";
    }   
    exit; // Exit the script, as there are errors
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
</head>
<body>
    <div class="container">
        <h1>Booking Details</h1>

        <?php
        // Display the booking details
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            // Display the selected user
            echo "<p>User ID: CT2023/$user_id</p>";
        } else {
            echo "<p class='error'>User not found</p>";
        }

        if(isset($_SESSION['selected_movie_id'])){
            $movie_id = $_SESSION['selected_movie_id'];
           //Display the movie id
           echo "<p>Movie ID: CTM2023/$movie_id</p>";
        }
        if(isset($_SESSION['selected_movie_title'])){
            $movie_title = $_SESSION['selected_movie_title'];
            //Display the movie title
            echo "<p>Movie Name: $movie_title</p>";
        }
        if(isset($_SESSION['selected_movie_date'])){
            $selected_movie_date = $_SESSION['selected_movie_date'];
            //Display the movie date
            echo "<p>Movie Date: $selected_movie_date</p>";
        }
        
        if (isset($_SESSION['selected_showtime']) && is_array($_SESSION['selected_showtime'])) {
            $selected_showtimes = $_SESSION['selected_showtime'];

            // Display the selected showtime
            echo "<p>Selected Showtime: " . reset($selected_showtimes) . "</p>";
        } else {
            echo "<p class='error'>Selected showtime not found in the session</p>";
        }

        if (isset($_POST['selected_seats'])) {
            $selectedSeats = json_decode($_POST['selected_seats']);
            
            // Remove empty strings and trim any whitespace from each seat
            $sanitizedSeats = array_filter(array_map('trim', $selectedSeats), function ($seat) {
                return $seat !== '' && $seat !== '\\';
            });
            // Store the selected seats in the session
            $_SESSION['selected_movie'] = $sanitizedSeats;
            echo "<p>Selected Seats: " . implode(' , ', $sanitizedSeats) . "</p>";
        } else {
            echo "<p class='error'>Seats not picked</p>";
        }

        if (isset($_SESSION['total_price'])) {
            $total_price = floatval($_SESSION['total_price']);
            // Format $total_price to display with 2 decimal places
            $total_price = number_format($total_price, 2);
            echo "<p>Total Price: $total_price</p>";
        } else {
            echo "<p class='error'>Total price not found</p>";
        }
        
        if(isset($_SESSION['booking_date'])){
            $booking_date = $_SESSION['booking_date'];
            echo "<p>Booking Date:$booking_date</p>";
        }else{
            echo "<p class='error'>Booking date not found in the session</p>";
        }

        if(isset($_SESSION['selected_payment_method'])){
            $selected_payment_method = $_SESSION['selected_payment_method'];
            echo "<p>Payment Method:$selected_payment_method</p>";
        }else{
            echo "<p class='error'>Payment Method not found in the session</p>";
        }
           
        ?>
    </div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        
        .container {
            height: 100vh;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin: 10px 0;
        }

        .error {
            color: #f00;
            font-weight: bold;
        }
    </style>
<?php
include "footer.php";
?>
