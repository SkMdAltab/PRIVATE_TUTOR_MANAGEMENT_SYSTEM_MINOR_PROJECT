<!DOCTYPE html>
<html>

<head>
    <style>
        /* Center the message both vertically and horizontally */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .message {
            text-align: center;
            padding: 20px;
            border: 2px solid #333;
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET['email']) && isset($_COOKIE['token']) && $_COOKIE['token'] == $_GET['token']) {
        $email = $_GET['email'];
        $expiration_time = time() + 120;
        if($_GET['user_type']=='student'){

            setcookie('email', $email, $expiration_time, '/', '', false, true);
        }else{

            setcookie('emailT', $email, $expiration_time, '/', '', false, true);
        }
        setcookie("token", "", 1, '/');
        // Display the verification success message
        echo '<div class="message">Your email ' . $email . ' is successfully verified. Please go to the registration page and submit your details.</div>';
    } else {
        // Display the verification link expired message
        echo '<div class="message">Verification link expired</div>';
    }
    ?>
</body>

</html>