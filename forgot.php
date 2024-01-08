<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Forgot Password</title>
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/forgot.css" rel="stylesheet">
    </head> 
    <body>
        <div class="middle">
            <img src="Images/DCA-logo.png" alt="">
            <h1>DotConnectAfrica</h1>
        </div>
        <div class="error" id="error-message">
                
        </div>
        <h1>Please Input Your Email Address</h1>
        <form action="actions/reset.php" method="post" class="main" id="verificationForm">
            <input type="text" name="one">
            <button type="submit">Reset Password</button>
        </form>
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
    