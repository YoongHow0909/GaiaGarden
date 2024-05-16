<?php
session_start();
 include("header.php"); 
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .bigcontainer {
            border: 5px solid #ccc;
            position: absolute;
            z-index: 1;
            margin-top: -650px;
            margin-left: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .otp-input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
        .otp-input:focus {
            outline: none;
            border-color: #0074D9;
        }
        button {
            background-color: #0074D9;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #005ea3;
        }
        
        .first{
           color: gray; 
        }
        .second{
            color:blue;
            text-align: center;
        }
        
        .ckeck-button{
            margin-top: 30px;
            margin-left:50px; 
        }
        .verify-button{
            margin-left: 50px;
        }
        
        .otp-field{
            margin-left: 40px;
        }
        .reverify{
            color:grey; 
            text-align: center;
        }
        .timer {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Enter OTP</title>
    <!-- Include EmailJS library -->
    <link rel="stylesheet" href="css/newlogin.css">
    <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script>
        // Initialize EmailJS with your user ID
        emailjs.init("GaS785SlSzJRcN9qH");

        // Function to send email using EmailJS
        function sendEmail() {
            // Get the user's email from the session
            var userEmail = '<?php echo $_SESSION["userEmail"]; ?>';
            var otp = '<?php echo $_SESSION["otp"]; ?>'; // Retrieve the OTP from the session
            // Send email using EmailJS
            emailjs.send("service_3h7d27m", "template_4wkl0tx", {
                user_email: userEmail ,// Make sure this matches the placeholder in your EmailJS template
                otp: otp // Assuming 'otp' is the name of the placeholder in your EmailJS template
            })
            .then(function(response) {
                console.log("Email sent successfully", response);
                // Optionally, you can redirect the user to a success page or show a success message
            }, function(error) {
                console.error("Email send failed", error);
                // Optionally, you can display an error message to the user
            });
        }

        // Call the sendEmail function when the page loads
        window.onload = function() {
            sendEmail();
            startTimer(); // Start the timer when the page loads
        };

        
        // Function to start the 5-minute timer
        function startTimer() {
            var minutes = 5;
            var seconds = 0;
            var timerDisplay = document.getElementById("timer");

            var timerInterval = setInterval(function() {
                seconds--;
                if (seconds < 0) {
                    minutes--;
                    seconds = 59;
                }
                if (minutes === 0 && seconds === 0) {
                    clearInterval(timerInterval);
                    // Set OTP as invalid when time is up
                    document.getElementById("otpField1").disabled = true;
                    document.getElementById("otpField2").disabled = true;
                    document.getElementById("otpField3").disabled = true;
                    document.getElementById("otpField4").disabled = true;
                    document.getElementById("otpField5").disabled = true;
                    document.getElementById("otpField6").disabled = true;
                }
                timerDisplay.textContent = "Time remaining: " + minutes + "m " + seconds + "s";
            }, 1000);
        }

        // Function to resend email with OTP
        function resendEmail() {
            // Call the server-side script to resend the email
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "resendOTP.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        alert("OTP resent successfully!");
                    } else {
                        alert("Failed to resend OTP. Please try again.");
                    }
                }
            };
            
            xhr.send();
        }

        // Function to handle input in OTP fields
        function handleOTPInput(fieldIndex, event) {
            var input = event.target;
            if (event.key === 'Backspace' && fieldIndex > 1) { // Check if backspace key is pressed and not in the first field
                var prevField = document.getElementById('otpField' + (fieldIndex - 1));
                if (prevField) {
                    prevField.focus(); // Move focus to the previous field
                    prevField.value = ''; // Clear the value of the previous field
                }
            } else if (event.key !== 'Backspace' && input.value.length === 1) { // Check if a character is input (excluding backspace)
                var nextField = document.getElementById('otpField' + (fieldIndex + 1));
                if (nextField) {
                    nextField.focus(); // Move focus to the next field
                }
            }
        }
    </script>
</head>
<body>
    <img src="image/plant.png" alt="plants" width="100%" height="660px" style="z-index: 0;">
    <div class="bigcontainer">
        <h2>Enter OTP</h2>
        <p class="first">We have sent you a One Time Password to your email.</p><br>
        <p class="second">Please enter OTP:</p>
        <br>
        <div class="timer" id="timer">Time remaining: 5m 0s</div>
        <br>
        <br>
        <form action="verifyOTP.php" method="post">
            <!-- OTP input fields -->
            <div class="otp-field">
                <?php
                for ($i = 1; $i <= 6; $i++) {
                    echo '<input class="otp-input" type="text" id="otpField' . $i . '" name="otpField' . $i . '" maxlength="1" oninput="handleOTPInput(' . $i . ', event)" autocomplete="off">';
                }
                ?>
            </div>
            <br>
            <?php
            $errorMessage = isset($_REQUEST['errorMessage']) ? $_REQUEST['errorMessage'] : null;
            if ($errorMessage !== null) {
                echo '<span class="error" style="bottom: 50px; color:red;text-align: center;">' . $errorMessage . '</span>';
            }
            ?>
            <div class="ckeck-button">
                <button class="Resend-button" type="button" onclick="resendEmail()">Resend OTP</button>
                <button class="verify-button" type="submit">Verify OTP</button>
            </div>
        </form>
        <br>
        <a href="forgot.php"><p class="reverify">Verify with another email</p></a>
    </div>
    <!-- Your HTML content for entering OTP goes here -->
    <?php echo $_SESSION["userEmail"]; ?>
    <?php echo $_SESSION["otp"]; ?>
</body>
<footer>
    <?php include 'footer.php'; ?>
</footer>
</html>
