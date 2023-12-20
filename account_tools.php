<?php

//Functions for the user account 

//Function to add the user's details
function getUserDetails($conn, $userEmail) {
    $query = "SELECT * FROM users WHERE email='$userEmail'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}
//Function to update the user's details
function updateUserProfile($conn, $firstName, $lastName, $email) {
    $query = "UPDATE users SET first_name='$firstName', last_name='$lastName' WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    return $result;
}
//Function to add the user's card details
function addCardAndBillingDetails($conn, $userID, $cardType, $cardholderName, $cardNumber, $expirationDate, $cvv, $billingAddress1, $billingAddress2, $city, $county, $postalCode) {
    $created_at = date("Y-m-d");
    $updated_at = $created_at;
    $deleted_at = date("Y-m-d");
    $expirationDate = date("Y-m-d", strtotime($expirationDate));
    
    $query = "INSERT INTO credit_cards (user_id, card_type, cardholder_name, card_number, expiration_date, 
    cvv, billing_address1, billing_address2, city, county, postal_code, created_at, updated_at, deleted_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "isssssssssssss", $userID, $cardType, $cardholderName, $cardNumber, 
    $expirationDate, $cvv, $billingAddress1, $billingAddress2, $city, $county, $postalCode, $created_at, 
    $updated_at, $deleted_at);

    return mysqli_stmt_execute($stmt);

}

// Function to fetch added card details
function getAddedCardDetails($conn, $user_id) {
    $query = "SELECT * FROM credit_cards WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }

    return null;
}

// Function to update card details in the database
function updateCardDetails($conn, $user_id, $cardType, $cardholderName, $cardNumber, $expirationDate, $cvv,
    $billingAddress1, $billingAddress2, $city, $county, $postalCode)
{
    $query = "UPDATE credit_cards SET card_type=?, cardholder_name=?, card_number=?, expiration_date=?, cvv=?,
    billing_address1=?, billing_address2=?, city=?, county=?, postal_code=? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssssi", $cardType, $cardholderName, $cardNumber, $expirationDate, $cvv,
        $billingAddress1, $billingAddress2, $city, $county, $postalCode, $user_id);
    $result = mysqli_stmt_execute($stmt);

    return $result;
}
//Function to delete the card
function deleteCardDetails($conn, $user_id) {
    $query = "DELETE FROM credit_cards WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    return $result;
}
?>