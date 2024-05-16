<?php
session_start();

// Database connection details
include 'dblink.php';

// Connect to the database
function connect_db() {
    include 'dblink.php';
    $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Validation functions
function validateName($name) {
    if ($name === null || strlen($name) < 8 || strlen($name) > 15 || !preg_match('/^[a-zA-Z0-9]+$/', $name)) {
        return false;
    }
    return true;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePhoneNumber($phoneNumber) {
    return preg_match('/^\d{10}$/', $phoneNumber);
}

function validateAddress($address) {
    return !empty(trim($address));
}

function validatePassword($password) {
    if ($password === null || strlen($password) < 8 || strlen($password) > 15 || !preg_match('/^[a-zA-Z0-9]+$/', $password)) {
        return false;
    }
    return true;
}

function validateConfirmPassword($password, $confirmPassword) {
    return $password === $confirmPassword;
}

// Form handling
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['pnumber'];
    $address = $_POST['address'];
    $password = $_POST['pass'];
    $confirmPassword = $_POST['cpass'];
    $role = $_POST['role'];

    $isValid = true;

    if (!validateName($name)) {
        $_SESSION['nameErr'] = "Username should be between 8 and 15 characters, contain only letters and numbers, and must be unique.";
        $isValid = false;
    } else {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM LOGIN WHERE NAME = ?");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        if ($count > 0) {
            $_SESSION['nameErr'] = "Username already exists.";
            $isValid = false;
        }
        $stmt->close();
        $conn->close();
    }

    if (!validateEmail($email)) {
        $_SESSION['emailErr'] = "Invalid email format.";
        $isValid = false;
    } else {
        $conn = connect_db();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM LOGIN WHERE EMAIL = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        if ($count > 0) {
            $_SESSION['emailErr'] = "Email already exists.";
            $isValid = false;
        }
        $stmt->close();
        $conn->close();
    }

    if (!validatePhoneNumber($phoneNumber)) {
        $_SESSION['pnumberErr'] = "Invalid phone number.";
        $isValid = false;
    }

    if (!validateAddress($address)) {
        $_SESSION['addressErr'] = "Address is required.";
        $isValid = false;
    }

    if (!validatePassword($password)) {
        $_SESSION['passErr'] = "Password should be between 8 and 15 characters and contain only letters and numbers.";
        $isValid = false;
    }

    if (!validateConfirmPassword($password, $confirmPassword)) {
        $_SESSION['cpassErr'] = "Passwords do not match.";
        $isValid = false;
    }

    if ($isValid) {
        $conn = connect_db();
        $nextUserID = getNextUserID($conn);

        $stmt = $conn->prepare("INSERT INTO LOGIN (USER_ID, NAME, EMAIL, USER_PHNUM, PASS, USER_ADDRESS, TYPE) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssss', $nextUserID, $name, $email, $phoneNumber, $password, $address, $role); 
        $stmt->execute();
        $stmt->close();
        $conn->close();

        echo "<script>alert('Registration successful!'); window.location.href='addStaff.php';</script>";
        exit();
    } else {
        header("Location: addStaff.php");
        exit();
    }
}

function getNextUserID($conn) {
    $query = "SELECT MAX(USER_ID) FROM LOGIN";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $maxUserID = $row['MAX(USER_ID)'];
    if ($maxUserID === null) {
        return 'USE-001';
    } else {
        $lastID = intval(substr($maxUserID, 4));
        return 'USE-' . str_pad($lastID + 1, 3, '0', STR_PAD_LEFT);
    }
}
?>
