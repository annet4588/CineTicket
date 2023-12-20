<?php
include "header.php";
require "cineticket_db.php";

// Initialize variables
$total_price = $_SESSION['total_price'] ?? 0;
$booking_date = $_SESSION['booking_date'] ?? date('d/m/Y');
$selected_movie_title = $_SESSION['selected_movie_title'] ?? "";
$selected_movie_showtime = $_SESSION['selected_movie_showtime'] ?? "";
$selected_movie_price = $_SESSION['selected_movie_price'] ?? "";
$selected_movie_id = $_SESSION['selected_movie_id'] ?? "";
$selected_showtime = ''; 
$selected_movie_date = '';
$selected_seats = '';
$selected_num_tickets = $_SESSION['selected_num_tickets'] ?? 0;
$selected_payment_method = '';


// Handle user input for selected_movie_date 
if (isset($_POST['movie_id']) && isset($_POST['selected_movie_date'])) {
    $selected_movie_id = $_POST['movie_id'];
    $selected_movie_date = $_POST['selected_movie_date'];

    // Reset the selected showtime when the date is changed
    unset($_SESSION['selected_showtime'][$selected_movie_id]);
    

    // Store the selected movie ID and date in session variables
    $_SESSION['selected_movie_id'] = $selected_movie_id;
    $_SESSION['selected_movie_date'][$selected_movie_id] = $selected_movie_date;
}

// Handle user input for selected_showtime
if(isset($_POST['movie_id']) && isset($_POST['selected_showtime'])){
    $selected_movie_id = $_POST['movie_id'];
    $selected_showtime = $_POST['selected_showtime'];

    //Store the selected showtime in a session variable
    $_SESSION['selected_showtime'][$selected_movie_id] = $selected_showtime;
}
// Handle user input for payment_type
if (isset($_POST['selected_payment_method'])) {
    $selected_payment_method = $_POST['selected_payment_method'];
    $_SESSION['selected_payment_method'] = $selected_payment_method;
}

// // // Initialize the selected movie date and showtime arrays if they don't exist
// if (!isset($_SESSION['selected_movie_date']) || !is_array($_SESSION['selected_movie_date'])) {
//     $_SESSION['selected_movie_date'] = array();
// }

if (!isset($_SESSION['selected_showtime']) || !is_array($_SESSION['selected_showtime'])) {
    $_SESSION['selected_showtime'] = array();
}

    // Query the database to find movie details with the selected showtime and movie date
$query = "SELECT movie_title, movie_price, movie_date1, movie_date2, movie_date3, show1, show2, show3 FROM movies WHERE movie_id = '$selected_movie_id'
AND (
    movie_date1 = '$selected_movie_date'      
    OR movie_date2 = '$selected_movie_date'
    OR movie_date3 = '$selected_movie_date'
)
AND (
    show1 = '$selected_showtime'      
    OR show2 = '$selected_showtime'
    OR show3 = '$selected_showtime'
)";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['selected_movie_title'] = $row['movie_title'];
        $_SESSION['selected_movie_price'] = $row['movie_price'];
        $_SESSION['selected_seats'] = $row['selected_seats'] ?? "";
        $_SESSION['selected_movie_rating'] = $row['movie_rating'] ?? "Rating is not available for this movie";
        $_SESSION['booking_date'] = date('d/m/Y');
    }


// Display selected movie details
if (isset($_SESSION['selected_movie_id'])) {
    $selected_movie_id = $_SESSION['selected_movie_id'];

    if (isset($_SESSION['selected_showtime'][$selected_movie_id])) {
        $selected_showtime = $_SESSION['selected_showtime'][$selected_movie_id];
    } else {
        $showtimeMessage = 'Choose showtime for the movie';
    }

    // Query to fetch the selected movie using the showtime
    $sql = "SELECT movie_id, movie_title, movie_info, movie_genre, movie_date1, movie_date2, movie_date3, TIME_FORMAT(show1, '%H:%i') AS show1, TIME_FORMAT(show2, '%H:%i') AS show2, TIME_FORMAT(show3, '%H:%i') AS show3, preview, movie_price, movie_rating, img FROM movies WHERE movie_id = '$selected_movie_id'";
    $result = $conn->query($sql);

    // Display movie details (left-side content)
    echo '<div class="row justify-content-center">';
    while ($row = $result->fetch_assoc()) {
       
        echo '<div class="col-md-6">
        <div class="card mb-3 custom-card">
            <div class="row">
            <div class="col-md-3">
                <img src="movieImg/' . $row['img'] . '" class="card-img-left img-fluid" alt="' . $row['movie_title'] . '">
            </div>
            <div class="col-md-5 align-self-center">
                <div class="card-body">
                    <h5 class="card-title movie-title">' . $row['movie_title'] . '</h5>';

        echo '<p class="card-text"><span class="bold-text">Select Movie Date:</span>
            <form method="post" action="">
                <input type="hidden" name="movie_id" value="' . $row['movie_id'] . '">
                <button type="submit" name="selected_movie_date" value="' . $row['movie_date1'] . '" class="btn btn-primary">' . $row['movie_date1'] . '</button>
                <button type="submit" name="selected_movie_date" value="' . $row['movie_date2'] . '" class="btn btn-primary">' . $row['movie_date2'] . '</button>
                <button type="submit" name="selected_movie_date" value="' . $row['movie_date3'] . '" class="btn btn-primary">' . $row['movie_date3'] . '</button>
            </form>
        </p>';

        echo '<p class="card-text"><span class="bold-text">Select Showtimes:</span>
            <form method="post" action="">
                <input type="hidden" name="movie_id" value="' . $row['movie_id'] . '">
                <input type="hidden" name="selected_movie_date" value="' . $selected_movie_date . '">
                <button type="submit" name="selected_showtime" value="' . $row['show1'] . '" class="btn btn-primary">' . $row['show1'] . '</button>
                <button type="submit" name="selected_showtime" value="' . $row['show2'] . '" class="btn btn-primary">' . $row['show2'] . '</button>
                <button type="submit" name="selected_showtime" value="' . $row['show3'] . '" class="btn btn-primary">' . $row['show3'] . '</button>
            </form>
        </p>';
                    
            if (isset($row['movie_price'])) {
                echo '<p class="card-text"><span class="bold-text">Price:</span> £' . $row['movie_price'] . '</p>';
            }       
                if (isset($row['movie_rating'])) {
                echo '<p class="card-text"><span class="bold-text">Rating:</span> ' . $row['movie_rating'] . '</p>';
            } else{
                echo '<p class="card-text"><span class="bold-text">Rating:</span> Not rated yet</p>';
            
            }                    
            echo '<p class="card-text"><span class="bold-text">Number of tickets:</span>
            <input type="number" name="tickets_quantity" value="' . $selected_num_tickets .'" min="1" max="10">';                   

        echo '</div></div></div></div></div>';

        // Right-hand side content (booking details)
        echo '<div class="col-md-6"> <!-- Right side content -->
        <div class="card mb-3 custom-card">          
            <div class="card-body">
                <h5 class="card-title">Your Booking</h5>';
        echo '<form method="post" action="insert_booking.php">
        <input type="hidden" name="movie_id" value="' . $selected_movie_id . '">
        <input type="hidden" name="movie_title" value="' . $selected_movie_title . '">
        <input type="hidden" name="selected_seats" id="selected-seats-input" value="' .$selected_seats .'">
        <input type="hidden" name="booking_date" value="' . $booking_date . '">
        <input type="hidden" name="selected_movie_date" value="' . $selected_movie_date . '">';
        // <input type="hidden" name="tickets_quantity" value="'. $selected_num_tickets . '">';
        
        // Display the selected movie date
        if(isset($_SESSION['selected_movie_title'])){
            $movie_title = $_SESSION['selected_movie_title'];
            //Display the movie title
            echo '<p class="card-text"><span class="bold-text">Movie Name: ' . $selected_movie_title . '</p>';
        }
        if (!empty($selected_movie_date)) {
            echo '<input type="hidden" id="selected-moviedate-input" name="selected_movie_date" value="' . $selected_movie_date . '">';
            } else {
            echo '<span style="color: red;">Please select a date for the movie</span>';
            }
            echo '<p class="card-text"><span class="bold-text">Movie Date: </span><span id="selected-moviedate" name="selected_movie_date">' . $selected_movie_date . '</span></p>';
        if (empty($selected_showtime)) {
            echo '<span style="color: red;">Please select showtime</span>';
            } else {
            echo '<input type="hidden" name="selected_showtime" value="' . $selected_showtime . '">';
            }
        echo '<p class="card-text"><span class="bold-text">Showtime: </span><span id="selected-showtime" name="selected_showtime">' . $selected_showtime . '</span></p>';
        if (empty($selected_seats)) {
            echo '<span name="selected_seats" style="color: red;">Please select seats</span>';          
            }else{
                echo '<input type="hidden" name="selected_seats" value="' . $selected_seats . '">';
            }     
        echo '<p class="card-text"><span class="bold-text">Seats: </span><span id="selected-seats" name="selected_seats">' . $selected_seats . '</span></p>
        
        <p class="card-text"><span class="bold-text">Total £: </span><input type="text" name="total_price" value="0" id="totalInput" readonly></p>
       
        <p class="card-text"><span class="bold-text">Date of Booking: </span>' . $booking_date . '</p>';
        
        //Display the Number of tickets
        echo '<span style="color: red;">Please select the number of tickets</span>';
        echo '<p class="card-text"><span class="bold-text">Number of tickets: </span>';
        if(isset($_SESSION['selected_num_tickets'])){
            echo '<input type="number" name="tickets_quantity" value="' . $_SESSION['selected_num_tickets'] .'" min="1" max="10">'; 
        } else {
            echo '<input type="number" name="tickets_quantity" value="0" min="1" max="10">';  // Set a default value or adjust as needed
           echo '<br>';
           echo '<br>';
        }
        
        // Display the Payment Method
        echo '<span style="color: red;">Please select your Payment Method</span>';
        echo '<p class="card-text"><span class="bold-text">Payment Method: </span>';

        // Check if payment method is set and not empty
        if (isset($_POST['selected_payment_method']) && !empty($_POST['selected_payment_method'])) {
            
            $selected_payment_method = htmlspecialchars($_POST['selected_payment_method']);
            // Display payment form based on the selected payment method
            echo '<div class="form-group">';
            // Add a hidden input for selected_payment_method
            echo '<input type="hidden" name="selected_payment_method" value="' . $selected_payment_method . '">';
           
            if ($selected_payment_method == 'Paypal') {
                // Display PayPal email input form
                echo '<label for="paypal_email">PayPal Email</label>';
                echo '<input type="email" class="form-control" id="paypal_email" name="paypal_email" placeholder="Enter your PayPal email" required>';
            } elseif ($selected_payment_method == 'Creditcard') {
                // Display Credit Card input form
                echo '<label for="credit_card_number">Credit Card Number</label>';
                echo '<input type="text" class="form-control" id="credit_card_number" name="credit_card_number" placeholder="Enter your credit card number" required>';
            }
            // Add more conditions for other payment methods if needed
            echo '</div>';

            // Display the hidden input for selected_payment_method
            echo '<input type="hidden" name="selected_payment_method" value="' . $selected_payment_method . '">';

            // Close the "Payment Method" text
            echo $selected_payment_method;

        } else {
            // Payment method is not set or empty
            
            // echo '<span style="color: red;">Please select your Payment Method</span>';
        }

        // Close the "Payment Method" paragraph
        echo '</p>';

        // Display the radio buttons for payment type
        echo '<div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="selected_payment_method" id="paypal" value="Paypal">
                <label class="form-check-label" for="paypal">Pay with PayPal</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="selected_payment_method" id="credit_card" value="Creditcard">
                <label class="form-check-label" for="credit_card">Pay with credit or debit card</label>
            </div><br>

            <button type="submit" class="btn btn-primary" name="buy">Buy</button>
        </form>';
        
        // Unset the payment method
        if (isset($_POST['buy'])) {
            // Unset the payment method when Buy button is pressed
            unset($_SESSION['selected_num_tickets']);
            unset($_SESSION['selected_payment_method']);
        }
        echo '</div>
        </div>
        </div>
        </div>';
         // Choose Seats content 
         echo '<div class="col-md-12 custom-seats"> 
         <div class="card mb-6 custom-card">     
             <div class="card-body">
             <h5 class="card-title">Select Seats</h5>';
             // Include the seat grid as a table here
             echo '<table class="cinema-seats">
                 <tbody>';

                 // Define the number of rows and columns
                 $rows = 6;
                 $columns = 10;
                 // Array of available seats
                 $availableSeats = ["A1", "A2", "A3", "A6", "A7", "A8", "B4", "B5", "C6", "C7", "D8", "D9", "E10"];
                 // Sanitize the array by removing empty strings
                 $availableSeats = array_filter($availableSeats, 'strlen');

                 // Loop to create the seat grid
                 for ($row = 1; $row <= $rows; $row++) {
                     echo '<tr>';
                     for ($col = 1; $col <= $columns; $col++) {
                         $seat = chr(64 + $row) . $col; // Convert row number to letter (e.g., 1 -> A)

                         // Check if the seat is available or reserved
                         $seatClass = in_array($seat, $availableSeats) ? 'available' : 'reserved';

                         // Output the seat button with the data-seat attribute
                         echo '<td><button class="seat ' . $seatClass . '" data-seat="' . $seat . '">' . $seat . '</button></td>';
                     }
                     echo '</tr>';
                 }
             echo '</tbody>
             </table>';
             // End of seat grid    
         echo '</div>
         </div>
     </div>
 </div>';
    }
    
} else {
    echo '<div class="row justify-content-center">';
    echo '<div class="col-md-12">';
    echo '<div class="card mb-3 custom-card">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">Your Shopping Basket</h5>';
    echo '<p>Your Shopping Basket is empty</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

$conn->close();
?>

<script>
//JavaScript to handle movie_date selection
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script loaded!');
    const movieDateButtons = document.querySelectorAll('button[name="moviedate"]');
    const selectedMovieDate = document.getElementById('selected-moviedate');

    movieDateButtons.forEach(function(movieDateButton) {
        movieDateButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            const movieDate = movieDateButton.getAttribute('value');
            console.log('Selected date:', movieDate);
            selectedMovieDate.textContent = movieDate;

            // Update the hidden form field value
            const dateInput = document.getElementById('selected-moviedate-input');
            dateInput.value = movieDate;

            // Submit the form
            const dateForm = document.getElementById('date-form');
            dateForm.submit();
        });
    });
});

// JavaScript to handle seat selection and calculate the total price
document.addEventListener('DOMContentLoaded', function() {
    const seatButtons = document.querySelectorAll('.seat.available');
    const selectedSeats = new Set();
    const numTicketsInput = document.querySelector('input[name="tickets_quantity"]');
    const moviePrice = <?php echo isset($_SESSION['selected_movie_price']) ? $_SESSION['selected_movie_price'] : 0; ?>; // Get the movie price from PHP

    seatButtons.forEach(function(seatButton) {
        seatButton.addEventListener('click', function() {
            const seat = seatButton.getAttribute('data-seat');

            if (selectedSeats.has(seat)) {
                // Seat was selected, so unselect it
                selectedSeats.delete(seat);
                seatButton.classList.remove('selected');
                seatButton.style.backgroundColor = ''; // Reset background color
                
            } else {
                // Seat was unselected, so select it
                selectedSeats.add(seat);
                seatButton.classList.add('selected');
                seatButton.style.backgroundColor = 'green'; // Set background color to green
            }

            // Update the "Seats" field in the shoppingCart
            const selectedSeatsDiv = document.getElementById('selected-seats');
            selectedSeatsDiv.textContent = Array.from(selectedSeats).join(', ');


            // Update the hidden input field with selected seats
            const selectedSeatsInput = document.getElementById('selected-seats-input');
            selectedSeatsInput.value = JSON.stringify(Array.from(selectedSeats));

            // Calculate the total price based on the number of selected seats and the movie price
            const totalTickets = selectedSeats.size;
            const totalPrice = totalTickets * moviePrice;

            // // Update the total price in the shoppingCart
            // const totalInput = document.querySelector('input[name="total_price"]');
            // totalInput.value = totalPrice.toFixed(2);

            // Update the total price in the shoppingCart
            const totalInput = document.getElementById('totalInput');
            totalInput.value = totalPrice.toFixed(2); //display the total price with two decimal places

            // Update the number of tickets input field
            numTicketsInput.value = totalTickets;

        });
    });
});
</script>

<style>
    .available {
        background-color: grey; /* Background color for available seats */
        color: white;
    }

    .reserved {
        background-color: red; /* Background color for reserved seats */
        color: white;
    }

    .selected {
        background-color: green; /* Background color for selected seats */
        color: white;
    }
</style>
<style>
    /* Style for the movie details card */
    .custom-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin: 20px;
        height: 100%;
    }

    .custom-seats{
        margin-top:20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card-img-left{
        margin-top: 20px;
        margin-left: 20px;
    }
    .card-title {
        font-size: 20px;
    }

    .bold-text {
        font-weight: bold;
    }

    .movie-title {
        font-size: 24px;
    }

    /* Style for the seat selection card */
    .cinema-seats {
        margin-top: 10px;
    }

    /* Style for buttons */
    .btn {
        margin: 5px;
    }
</style>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include "footer.php";
?>