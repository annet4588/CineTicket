<?php
include "header.php";
$pageTitle = "Signup";

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Connect to the database.
    require('cineticket_db.php');

    # Initialize an error array.
    $errors = array();

    # Check for a first name.
    if (empty($_POST['first_name'])) {
        $errors[] = 'Enter your first name.';
    } else {
        $fn = mysqli_real_escape_string($conn, trim($_POST['first_name']));
    }

    # Check for a last name.
    if (empty($_POST['last_name'])) {
        $errors[] = 'Enter your last name.';
    } else {
        $ln = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    }

    # Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($conn, trim($_POST['email']));
    }

    # Check for a password and matching input passwords.
    if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['password'] != $_POST['confirm_password']) {
            $errors[] = 'Passwords do not match.';
        } else {
            $p = mysqli_real_escape_string($conn, trim($_POST['password']));
        }
    } else {
        $errors[] = 'Enter your password and confirm password.';
    }

    # Check if email address already registered.
    if (empty($errors)) {
        $q = "SELECT user_id FROM users WHERE email='$e'";
        $r = @mysqli_query($conn, $q);
        if (mysqli_num_rows($r) != 0) {
            $errors[] = 'Email address already registered. Sign In Now';
        }
    }

    # On success, register the user by inserting into 'users' database table.
    if (empty($errors)) {
        $q = "INSERT INTO users (first_name, last_name, email, pass, registration_date) 
        VALUES ('$fn', '$ln', '$e', SHA2('$p', 256), NOW())";
        $r = @mysqli_query($conn, $q);
        if ($r) {
            echo 'You are now registered.
                    <a class="alert-link" href="login.php">Login</a>';
            //Redirect to index.php
            header('Location: index.php');
            exit;       
        }

        # Close database connection.
        mysqli_close($conn);

        exit();
    }
    # Or report errors.
    else {
        echo 'The following error(s) occurred:';
        foreach ($errors as $msg) {
            echo " - $msg";
        }
        echo 'or please try again.';
        # Close database connection.
        mysqli_close($conn);
    }
}
?>

<body>
<div class="container d-flex justify-content-center align-items-start" style="min-height: 100vh;">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create an Account</h5>
            <?php if (isset($errorMessage)) : ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <form method="post" action="signup.php">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Create password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Create Account</button>
            </form>
            <div class="mt-3 text-center">
                <p>Already have an account? <a href="login.php">Login</a></p>
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


<!-- .center-card {
        display: flex;
        flex-direction: column; /* Stack elements vertically */
        align-items: center;
        margin-top: 10vh; /* Adjust as needed to move the card down */
        margin-bottom:20px;
    } -->