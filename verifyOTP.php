<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the OTP entered by the user from the request
    $enteredOTP = "";
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_POST["otpField" . $i])) {
            $enteredOTP .= $_POST["otpField" . $i];
        }
    }

    // Retrieve the OTP stored in the session
    $storedOTP = isset($_SESSION["otp"]) ? $_SESSION["otp"] : '';
    $userEmail = isset($_SESSION["userEmail"]) ? $_SESSION["userEmail"] : ''; // Retrieve user email from session

    // Print out entered and stored OTP for debugging
    error_log("Entered OTP: " . $enteredOTP);
    error_log("Stored OTP: " . $storedOTP);

    // Compare the entered OTP with the stored OTP
    if ($enteredOTP == $storedOTP) {
        // OTP is valid, perform further actions (e.g., allow user to reset password)
        $_SESSION["userEmail"] = $userEmail;

        header("Location: PasswordReset.php"); // Redirect to password reset page
        exit();
    } else {
        // Invalid OTP, redirect back to enterOTP.php with an error message
        $errorMessage = "Invalid OTP. Please try again.";
        header("Location: enterOTP.php?errorMessage=" . urlencode($errorMessage));
        exit();
    }
} else {
    // Handle the case where the request method is not POST
    header("Location: enterOTP.php");
    exit();
}
?>
