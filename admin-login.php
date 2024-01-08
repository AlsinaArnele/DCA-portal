<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin Login</title>
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <link rel="icon" href="Images/logo.png" type="image/icon type">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/login.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="left">
                <h1>DCA Admin</h1>
                <p>Securely access the Admin Portal and manage DCA user data with ease, efficiency, and the utmost data protection.</p>
                <img src="Images/undraw_mobile_encryption_re_yw3o 2.png" alt="image">
            </div>
            <div class="middle">
                <img src="Images/logo (3).png" alt="">
                <h1>DotConnectAfrica</h1>
            </div>
            <div class="error" id="error-message">
                
            </div>
            <form action="actions/admin-log-in.php" method="post" class="right">
                <h1>Login to your account</h1> 
                <h2>Enter your details to Login</h2>
                <div class="input">
                    <h3>USERNAME</h3>
                    <input type="text" placeholder="&#xF0e0;  Enter Your Username" id="Username" name="Username" style="font-family:Arial, FontAwesome" required>
                </div>
                <div class="input">
                    <h3>PASSWORD</h3>
                    <input type="password" placeholder="&#xF023;  Enter Your Password" id="Password" name="Password" style="font-family:Arial, FontAwesome; color: seagreen;" required>
                </div>
                <div id="google-container">
                <button type="submit">ADMIN LOGIN</button>
                </div>
            </form>
        </div>
    </body>
</html>
<?php
if (isset($_GET['response'])) {
        $response = htmlspecialchars($_GET['response']);
        //handle response
        echo "<script>
        var error = document.getElementById('error-message');
        error.style.display = 'flex';
        error.style.animation = 'slide-down 2s linear';
        error.textContent = '$response';
        </script>";
    }
?>