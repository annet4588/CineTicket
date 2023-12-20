<?php
include "header.php";
$pageTitle = "Forgot Password";
?>
<body>

<body>
    <div class="container d-flex justify-content-center align-items-start" style="min-height: 100vh;">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Forgot Password</h5>
                <form method="post" action="reset-password.php">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                </form>
                <div class="mt-3 text-center">
                    <p>Remember your password? <a href="login.php">Login</a></p>
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