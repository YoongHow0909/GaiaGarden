<?php

include 'userheader.php';

// Check if the form is submitted
if (isset($_POST['submitEdit'])) {
    // Database connection
    include 'dblink.php';

    // Retrieve form data

    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Initialize variables
    $imagePath = null;

    // Handle image upload
    if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'image/'; // Directory where the files will be uploaded
        $imagePath = $uploadDir . basename($_FILES['newImage']['name']);
        
        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($_FILES['newImage']['tmp_name'], $imagePath)) {
            // Handle the error condition
            $_SESSION['errorMessage'] = "Error uploading image.";
            header("Location: edit.php?error=true");
            exit();
        }
    }

    // Update the database
    try {
        $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the update statement
        if ($imagePath) {
            // If a new image was uploaded, update all fields including the image path
            $stmt = $conn->prepare("UPDATE login SET email=?, user_address=?, user_phnum=?, user_img=? WHERE user_id=?");
            $stmt->bind_param("sssss", $email, $address, $phone, $imagePath, $userID);
        } else {
            // If no new image was uploaded, update fields except the image path
            $stmt = $conn->prepare("UPDATE login SET email=?, user_address=?, user_phnum=? WHERE user_id=?");
            $stmt->bind_param("ssss", $email, $address, $phone, $userID);
        }

        // Execute the statement
        $stmt->execute();

        // Redirect with success message
        $_SESSION['successMsg'] = "Profile updated successfully!";
        header("Location: edit.php?success=true");
        exit();
    } catch (Exception $e) {
        // Redirect with error message
        $_SESSION['errorMessage'] = $e->getMessage();
        header("Location: edit.php?error=true");
        exit();
    } finally {
        // Close connections
        $stmt->close();
        $conn->close();
    }
} else {
    // Redirect if accessed directly
    header("Location: edit.php");
    exit();
}
?>
