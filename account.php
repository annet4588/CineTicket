<?php
include "header.php";
require "cineticket_db.php";
require "account_tools.php";

$pageTitle = "Account";

$firstName = "";
$lastName = "";
$email = "";


// Check if the user is logged in
if (isset($_SESSION['user_email']) && !empty($_SESSION['user_email'])) {
    $userEmail = $_SESSION['user_email'];

    // Display user details
    $userDetails = getUserDetails($conn, $userEmail);

    if ($userDetails) {
        $user_id = $userDetails['user_id']; // This line assigns the user_id to the local variable $user_id
        $firstName = $userDetails['first_name'];
        $lastName = $userDetails['last_name'];
        $email = $userDetails['email'];
        $regDate = $userDetails['registration_date'];
   

         // Check if the form is submitted for user profile update
         if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_profile'])) {
            $errors = array();

            // Get user input
            $firstName = mysqli_real_escape_string($conn, $_POST["first_name"]);
            $lastName = mysqli_real_escape_string($conn, $_POST["last_name"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);

            // Validate user input 
            if (empty($firstName) || empty($lastName) || empty($email)) {
                $errors[] = "All fields are required.";
            }
            //If empy errors - proceed
            if (empty($errors)) {
                // Update user's information in the database 
                $result = updateUserProfile($conn, $firstName, $lastName, $email);

                if ($result) {
                    $successMessage = "Profile updated successfully.";
                } else {
                    $errorMessage = "Error updating profile: " . mysqli_error($conn);
                }
            }
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_card_billing'])) {

            //Existing code for adding card and billing details
            $errors = array();

            $user_id = $_SESSION['user_id'];
             // Initialize variables
            $cardType = $cardholderName = $cardNumber = $expirationDate = $cvv = $billingAddress1 = $billingAddress2 = $city = $county = $postalCode = null;

            // Get the user input for card details
            if (isset($_POST['card_type']) && !empty(trim($_POST['card_type']))) {
                $cardType = mysqli_real_escape_string($conn, $_POST['card_type']);
            }else{
                $errors[] = 'Choose Card Type';
            }
            

            if (isset($_POST['cardholder_name']) && !empty(trim($_POST['cardholder_name']))) {
                $cardholderName = mysqli_real_escape_string($conn, $_POST['cardholder_name']);
            }else{
                $errors[] = 'Insert Cardholder Name';
            }

            if (isset($_POST['card_number']) && !empty(trim($_POST['card_number']))) {
                $cardNumber = mysqli_real_escape_string($conn, $_POST['card_number']);
            }else{
                $errors[] = 'Insert Card Number';
            }

            if (isset($_POST['expiration_date'])  && !empty(trim($_POST['expiration_date']))) {
                $expirationDate = mysqli_real_escape_string($conn, $_POST['expiration_date']);
            }else{
                $errors[] = 'Insert Expiration date';
            }

            if (isset($_POST['cvv'])  && !empty(trim($_POST['cvv']))) {
                $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
            }else{
                $errors[] = "CVV is required.";
            }

            // Get the user input for billing address
            if (isset($_POST['billing_address1']) && !empty(trim($_POST['billing_address1']))) {
                $billingAddress1 = mysqli_real_escape_string($conn, $_POST['billing_address1']);
            }else{
                $errors[] = 'Insert billing address';
            }

            if (isset($_POST['billing_address2'])) {
                $billingAddress2 = mysqli_real_escape_string($conn, $_POST['billing_address2']);
            }

            if (isset($_POST['city']) && !empty(trim($_POST['city']))) {
                $city = mysqli_real_escape_string($conn, $_POST['city']);
            }else{
                $errors[] = 'Insert City';
            }

            if (isset($_POST['county']) && !empty(trim($_POST['county']))) {
                $county = mysqli_real_escape_string($conn, $_POST['county']);
            }else{
                $errors[] = 'Insert County';
            }

            if (isset($_POST['postal_code']) && !empty(trim($_POST['postal_code']))) {
                $postalCode = mysqli_real_escape_string($conn, $_POST['postal_code']);
            }else{
                $errors[] = 'Insert Postal Code';
            }

            // Check if any errors occurred
            if (empty($errors)){
            // Use the addCardAndBillingDetails function to handle database insertion
            $updateResult = addCardAndBillingDetails($conn, $user_id, $cardType, $cardholderName, $cardNumber, $expirationDate, $cvv, $billingAddress1, $billingAddress2, $city, $county, $postalCode);

                if ($updateResult) {
                    echo "Details inserted successfully";
                    header("Location: account.php");
                    exit;
                } else {
                    $errors[] = "Details are not found";
                }
            }

        }  elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_card_details'])) {
            $errors = array();

            // Get user_id from the session
            $user_id = $_SESSION['user_id'];
             // Initialize variables
            $cardType = $cardholderName = $cardNumber = $expirationDate = $cvv = $billingAddress1 = $billingAddress2 = $city = $county = $postalCode = null;

            // Get the user input for card details
            if (isset($_POST['card_type'])) {
                $cardType = mysqli_real_escape_string($conn, $_POST['card_type']);
            }

            if (isset($_POST['cardholder_name'])) {
                $cardholderName = mysqli_real_escape_string($conn, $_POST['cardholder_name']);
            }

            if (isset($_POST['card_number'])) {
                $cardNumber = mysqli_real_escape_string($conn, $_POST['card_number']);
            }

            if (isset($_POST['expiration_date'])) {
                $expirationDate = mysqli_real_escape_string($conn, $_POST['expiration_date']);
            }
            if (isset($_POST['cvv'])) {
                $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
            }
            if (isset($_POST['billing_address1'])) {
                $billingAddress1 = mysqli_real_escape_string($conn, $_POST['billing_address1']);
            }
            if (isset($_POST['billing_address2'])) {
                $billingAddress2 = mysqli_real_escape_string($conn, $_POST['billing_address2']);
            }
            if (isset($_POST['city'])) {
                $city = mysqli_real_escape_string($conn, $_POST['city']);
            }
            if (isset($_POST['county'])) {
                $county = mysqli_real_escape_string($conn, $_POST['county']);
            }
            
            if (isset($_POST['postal_code'])) {
                $postalCode = mysqli_real_escape_string($conn, $_POST['postal_code']);
            }
            // Use the addCardAndBillingDetails function to handle database insertion
            $result = updateCardDetails($conn, $user_id, $cardType, $cardholderName, $cardNumber, 
            $expirationDate, $cvv, $billingAddress1, $billingAddress2, $city, $county, $postalCode);

            if ($result) {
            $successMessage = "Card details updated successfully.";
            header("Location: account.php");
            exit;
            } else {
                $errorMessage = "Error updating card details: " . mysqli_error($conn);
            }
            
        }elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_card_details'])) {
            $errors = array();

            // Check if the user confirmed the deletion so the value = yes
            if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
                $errors = array();
                $user_id = $_SESSION['user_id'];

                $user_id = $_SESSION['user_id'];
                // Use the addCardAndBillingDetails function to handle database insertion
                $result = deleteCardDetails($conn, $user_id);

                if ($result) {
                    echo "Details deleted successfully";
                    header("Location: account.php");
                    exit;
                    } else {
                        $errors[] = "Details are not found";
                    }
                } else {
                    $errors[] = "Deletion not confirmed";
            }
        }
            // Fetch and display added card details
            $addedCardDetails = getAddedCardDetails($conn, $user_id); // Function to fetch the added card details
            if ($addedCardDetails) {
                $cardType = $addedCardDetails['card_type'];
                $cardholderName = $addedCardDetails['cardholder_name'];
                $cardNumber = $addedCardDetails['card_number'];
                $expirationDate = $addedCardDetails['expiration_date'];
                // $cvv = $addedCardDetails['cvv'];
                // $billingAddress1 = $addedCardDetails['billing_address1'];
                // $billingAddress2 = $addedCardDetails['billing_address2'];
                // $city = $addedCardDetails['city'];
                // $county = $addedCardDetails['county'];
                // $postalCode = $addedCardDetails['postal_code'];
            } else {
            // No card details found               
            $errors[] = 'No card deatails found';
            }
    } else {
        // User details not found
       $errors[] = 'User details not found';
    }
    // Check if the form is submitted for card details update
  
    
} else {
    // Redirect the user to the login page or display a message indicating that they need to log in.
    header("Location: login.php");
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<body>
    <!-- User Profile Section -->
    <div class="center-card">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $firstName, ' ' . $lastName;?></h5>
                <p>User ID: CT2023/<?php echo $user_id; ?></p>
                <p>Registration Date: <?php echo date("d/m/Y", strtotime($regDate)); ?></p>
                <?php if (isset($successMessage)) : ?>
                    <div class="alert alert-success">
                        <?php echo $successMessage; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($errorMessage)) : ?>
                    <div class="alert alert-danger">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
                <div class="container">
                    <form method="POST" action="account.php">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $firstName; ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $lastName; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="update_profile">Update Profile</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>


<!-- Display the added card -->
<div class="center-card">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Card Details</h5>
            <?php if ($addedCardDetails !== null): ?>
                <form method="POST" action="account.php" onsubmit="return confirmDeletion()">
                    <p>Card type: <span><?php echo $addedCardDetails['card_type']; ?></span></p>
                    <p>Cardholder name: <span><?php echo $addedCardDetails['cardholder_name']; ?></span></p>
                    <p>Card number: <span><?php echo '**** **** **** ' . substr($addedCardDetails['card_number'], -4); ?></span></p>
                    <p>Expiration date: <span><?php echo date("m/Y", strtotime('01/' . $addedCardDetails['expiration_date'])); ?></span></p>
                    
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> Deleting your card is irreversible. Please confirm below.
                    </div>
                    
                    <!-- Add a checkbox for confirmation -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirm_delete" name="confirm_delete" value="yes">
                        <label class="form-check-label" for="confirm_delete">I confirm that I want to delete my card details.</label>
                    </div>

                    <button type="submit" class="btn btn-danger btn-sm" name='delete_card_details'>Delete Card</button>

                    <!-- Visible text input to display the confirmation message -->
                    <input type="text" name="delete_confirmation" id="delete_confirmation" readonly style="border: none; background-color: transparent;">
                </form>
            <?php else: ?>
                <p>No card details found</p>
            <?php endif; ?>
        </div>
    </div>
</div>
  
      
    <!-- Add Payment Details -->
<div class="center-card">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Add Payment Card</h5>
            <div class="container">
                <form method="POST" action="account.php" name="addCardForm">
                    <!-- Card Information -->
                    <div class="form-group">
                        <label for="card_type">Choose Card</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="card_type" id="visa" value="Visa" required>
                            <label class="form-check-label" for="visa">Visa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="card_type" id="mastercard" value="Mastercard" required>
                            <label class="form-check-label" for="mastercard">Mastercard</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="card_type" id="amex" value="Amex" required>
                            <label class="form-check-label" for="amex">Amex</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cardholder_name">Cardholder Name</label>
                        <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" placeholder="Enter your name as displayed on the card" required>
                    </div>
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Enter your card number" required>
                    </div>
                    <div class="form-group">
                        <label for="expiration_date">Expiration Date</label>
                        <input type="text" class="form-control" id="expiration_date" name="expiration_date" placeholder="MM/YYYY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="Enter your CVV" required>
                    </div>

                    <!-- Billing Information -->
                    <div class="form-group">
                        <label for="billing_address1">Address Line 1</label>
                        <input type="text" class="form-control" id="billing_address1" name="billing_address1" placeholder="Enter billing address line 1" required>
                    </div>
                    <div class="form-group">
                        <label for="billing_address2">Address Line 2</label>
                        <input type="text" class="form-control" id="billing_address2" name="billing_address2" placeholder="Enter billing address line 2">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
                    </div>
                    <div class="form-group">
                        <label for="county">County</label>
                        <input type="text" class="form-control" id="county" name="county" placeholder="Enter county">
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter postal code" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary m-3" name="add_card_billing">Add Card and Billing Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


 <!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .center-card {
        display: flex;
        flex-direction: column; /* Stack elements vertically */
        align-items: center;
        margin-top: 10vh; /* Adjust as needed to move the card down */
    }

    .card {
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
</body>
</html>
<?php include "footer.php"; ?>





