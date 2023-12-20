<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header.php</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Include font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
    /* Add custom CSS for centering */
        .navbar {
            justify-content: space-between;
            background-color: #063970;
        }
        .navbar-brand {
            margin-right: 30px; /* Adjust margin as needed */
            margin-left: 30px;;
        }
        .navbar-nav {
            margin-left: auto;
        }
        .nav-item {
            margin-right: 30px; /* Add spacing between nav items */
        }
        #cart-item-count{
            color:orange;
        }
     </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid p-2">
        <a class="navbar-brand" href="index.php"><h3 style="color:white;"><img src="logoImg/logoTicketCircle.ico" alt="CineTicket Logo"> CineTicket</h3></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="notifications.php" style="color:white";><i class="fas fa-bell" style="color:orange";></i> Notifications</a>
                </li>
                <li class="nav-item">                    
                    <?php
                    //Check if the user has a movie in the cart
                    if(isset($_SESSION['user_email']) && isset($_SESSION['selected_movie_id'])){
                        echo '<a class="nav-link" href="shoppingCart.php" style="color:white";><i class="fas fa-shopping-cart" style="color:orange";></i> Cart <span id="cart-item-count">1</span></a>';
                    }else{
                        echo '<a class="nav-link" href="shoppingCart.php" style="color:white";><i class="fas fa-shopping-cart" style="color:orange";></i> Cart <span id="cart-item-count">0</span></a>';
                    }
                    ?>
                </li>
                <li class="nav-item dropdown"> <!-- Dropdown menu -->
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" style="color:white"; role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <?php
                      // Check if the user is logged in
                      if (isset($_SESSION['user_email'])) {
                        echo '<i class="fas fa-user" style="color:orange;"></i> '. $_SESSION['user_name']; //The user's name displaied if logged in
                    } else {
                        echo '<i class="fas fa-user" style="color:orange;"></i> Account'; //User is logged out
                    }
                    ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="accountDropdown">
                    <?php
                    // Check if the user is logged in
                    if (isset($_SESSION['user_email'])) {
                        echo '<a class="dropdown-item" href="myBooking.php">My Booking</a>';
                        echo '<a class="dropdown-item" href="#">My Watchlist</a>';
                        echo '<a class="dropdown-item" href="account.php">My Account</a>';
                        echo '<a class="dropdown-item" href="logout.php">Logout</a>'; // Add a logout link
                    } else {
                        echo '<a class="dropdown-item" href="login.php">Login</a>';
                    }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    </nav>
</header>
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


