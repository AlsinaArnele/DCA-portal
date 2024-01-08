<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Log In</title>
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/login.css" rel="stylesheet">
    </head>
    <body>
        <div class="container"> 
            <div class="left">
                <h1>DotConnectAfrica Group Portal</h1>
                <p> Seamlessly manage services and privileges on our portal for unparalleled control and convenience in your work journey.</p>
                <img src="Images/DCA-logo.png" alt="image">
            </div>
            <div class="middle">
                <img src="Images/DCA-logo.png" alt="">
                <h1>DotConnectAfrica</h1>
            </div> 
            <div class="error" id="error-message">
                
            </div>
            <form action="actions/log-in.php" method="post" class="right">
                <h1>Login to your account</h1>
                <div class="input">
                    <h3>EMAIL ADDRESS</h3>
                    <input type="text" placeholder="&#xF0e0;  Enter Your Email" id="Email" name="Email" style="font-family:Arial, FontAwesome" required>
                </div>
                <div class="input">
                    <h3>PASSWORD</h3>
                    <input type="hidden" id="logTime" name="time">
                    <input type="password" placeholder="&#xF023;  Enter Your Password" id="Password" name="Password" style="font-family:Arial, FontAwesome;" required>
                </div>
                <button type="submit" class="submit-button">LOGIN</button>
                <!-- <a href="google-login.php"><img src="Images/google.png" alt=""></a> -->
                <p>New here?<a href="signup.php">Register</a></p>
                <p>Forgot password?<a href="forgot.php">Reset</a></p>
                <img class="right-img" src="Images/undraw_mobile_encryption_re_yw3o 2.png" alt="image">
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
<script>
    var logTime = document.getElementById('logTime');
    var today = new Date();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    logTime.value = time;

    function reDirect(page) {
        window.location.href = page + ".php";
    }
</script>