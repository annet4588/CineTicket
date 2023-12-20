<?php
// Include the header.php where is session_start() 
include "header.php";
require "cineticket_db.php";
require "login_tools.php";
$pageTitle = "Login";


// Check if the user is already logged in and redirect if needed
if (isset($_SESSION['user_email'])) {
    header("Location: home.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $errors = array(); // Initialize an error array

    // Get user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate user input (implement proper validation as needed)
    if (empty($email) || empty($password)) {
        $errors[] = "Both email and password are required.";
    }

    if (empty($errors)) {
        // Perform user authentication
        list($check, $data) = validate($conn, $email, $password);

        if ($check) {
            // User is authenticated, set session variables
            $_SESSION["user_email"] = $email;
            $_SESSION["user_id"] = $data["user_id"]; // Assign user_id from the query result
            $_SESSION["user_name"] = $data["first_name"];
             // Display a welcome message
             echo "Hello, " . $_SESSION["user_name"]; //For Debug: Check the value of user_name

            // Redirect to a secure page (e.g., index.php)
            load("index.php");

           
        } else {
            $errors[] = "Invalid email or password.";
        }
    }

    mysqli_close($conn); // Close the database connection
}
?>
<body>
<div class="container d-flex justify-content-center align-items-start" style="min-height: 100vh;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Login</h5>
                <?php
                if (!empty($errors)) {
                    echo '<div class="alert alert-danger">';
                    foreach ($errors as $error) {
                        echo "<p>$error</p>";
                    }
                    echo '</div>';
                }
                ?>
                <form method="POST" action="login.php"> <!-- Add method and action -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"> <!-- Add name attribute -->
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"> <!-- Add name attribute -->
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember login</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <p><a href="signup.php">Create an account</a></p>
                    <p><a href="forgotPass.php">Forgot password?</a></p>
                </div>
            </div>
        </div>
</div>
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
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .card {
        margin-top: 50px;
        width: 400px;
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
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