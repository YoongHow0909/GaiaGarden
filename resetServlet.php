<?php
session_start();
include('dblink.php'); // Include your database connection file

// Retrieve new password and user email from the request
$newPassword = isset($_POST['new']) ? $_POST['new'] : null;
$confirmPassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : null;
$userEmail = isset($_SESSION['userEmail']) ? $_SESSION['userEmail'] : null;

// Validate new password
if (empty($newPassword) || empty($confirmPassword)) {
    // Passwords cannot be null or empty, redirect back to the reset password page with an error message
    header("Location: PasswordReset.php?NerrorMessage=" . urlencode("Password cannot be empty. Please try again.") . "&CerrorMessage=" . urlencode("Password confirmation cannot be empty. Please try again."));
    exit();
}

if ($newPassword !== $confirmPassword) {
    // Passwords do not match, redirect back to the reset password page with an error message
    header("Location: PasswordReset.php?CerrorMessage=" . urlencode("Passwords do not match. Please try again."));
    exit();
}

if (strlen($newPassword) < 8 || strlen($newPassword) > 15) {
    // Password length is invalid, redirect back to the reset password page with an error message
    header("Location: PasswordReset.php?NerrorMessage=" . urlencode("Password length must be between 8 and 15 characters. Please try again."));
    exit();
}

if (!preg_match('/^[a-zA-Z0-9]+$/', $newPassword)) {
    // Password contains invalid characters, redirect back to the reset password page with an error message
    header("Location: PasswordReset.php?NerrorMessage=" . urlencode("Password can only contain English letters and numbers. Please try again."));
    exit();
}

// Update password in the database
try {
    $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);

    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password using a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE login SET pass = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPassword, $userEmail);
    $rowsUpdated = $stmt->execute();

    if ($rowsUpdated) {
        // Password updated successfully, display success message and redirect to login page
        echo "<script type='text/javascript'>
                alert('Password reset successful. Please login with your new password.');
                window.location.href = 'login.php';
              </script>";
    } else {
        // No rows updated, handle the error (e.g., user not found)
        header("Location: PasswordReset.php?errorMessage=" . urlencode("Failed to update password. Please try again."));
    }
} catch (Exception $e) {
    // Handle database connection or query errors
    error_log($e->getMessage()); // Log the error message
    header("Location: PasswordReset.php?errorMessage=" . urlencode("An error occurred while updating password. Please try again."));
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
