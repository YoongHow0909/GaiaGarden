<?php
include 'dblink.php'; 

function isValidEmail($email) {
    // Implement email validation logic
    // Return true if email is valid, false otherwise
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to generate OTP
function generateOTP() {
    // Generate a random 6-digit OTP
    $otp = mt_rand(100000, 999999);
    return $otp;
}

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email entered by the user
    $email = $_POST["email"];

    if (isValidEmail($email)) {
        // Establish database connection
        $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        // Check if email exists in the database
        $stmt = $conn->prepare("SELECT * FROM login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email found, generate OTP
            $otp = generateOTP();

            // Start session
            session_start();
            $_SESSION["otp"] = $otp;
            $_SESSION["userEmail"] = $email;

            // Redirect to enterOTP.php
            header("Location: enterOTP.php");
            exit();
        } else {
            // Email not found
            $errorMessage = "Your email does not exist.";
            header("Location: forgot.php?error=" . urlencode($errorMessage));
            exit();
        }

        
    } else {
        // Invalid email format
        header("Location: forgot.php?error=invalidemail");
        exit();
    }
    
}
?>
