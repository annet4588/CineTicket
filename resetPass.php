<!-- <?php
include "header.php";
$pageTitle = "Forgot Password";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user's email from the form
    $email = $_POST['email'];

    // Validate the email (you can add more robust email validation)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Generate a unique reset token (you can use a library for this)
        $resetToken = generateResetToken();

        // Store the reset token in a database (associate it with the user's email)
        storeResetTokenInDatabase($email, $resetToken);

        // Send a password reset email to the user with a link containing the reset token
        sendResetEmail($email, $resetToken);

        // Redirect the user to a confirmation page
        header("Location: reset-confirmation.php");
        exit();
    } else {
        $errorMessage = "Invalid email format.";
    }
}
?>

<body>
<style>
    /* Your styling here */
</style>
<div class="center-card">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Forgot Password</h5>
            <?php if (isset($errorMessage)) : ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <form method="post" action="reset-password.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
            </form>
            <div class="mt-3 text-center">
                <p>Remember your password? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</div> -->
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>