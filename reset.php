
<?php
if (!isset($_GET['token'])) {
    $myMessage = "Invalid token.";
    header("Location: forgot.php?response=" . urlencode($myMessage));
    exit();
}
$token = $_GET['token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest"> 
    <link rel="stylesheet" href="css/reset.css">
</head>
<body>
    <div class="error" id="error-message">
                
    </div>
    <div class="nav">
        <img src="Images/logo (3).png" alt="">
        <h1>DotConnectAfrica</h1>
    </div>

    <h1>Reset Password</h1>
    <form class="container" action="actions/update.php" method="post">
            <div class="input">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <input type="hidden" name="token" value="<?php echo $token;?>">
            </div>
            <div class="input">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm-password">
            </div>
            <button type="button" onclick="isPasswordSecure()">Reset</button>
            <a href="index.php">Back to login</a>
        </form>
        <div class="error" id="error-message">
    <script>
        function isPasswordSecure() {
            var passwordInput = document.getElementById('password');
            var confirmPasswordInput = document.getElementById('confirm-password');
            var error = document.getElementById('error-message');
            
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            const hasNumber = /\d/;
            const hasSpecialChar = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/;
            const hasUppercase = /[A-Z]/;
            const hasLowercase = /[a-z]/;
            
            if (
                hasNumber.test(password) &&
                hasSpecialChar.test(password) &&
                hasUppercase.test(password) &&
                hasLowercase.test(password) &&
                password === confirmPassword
            ) {
                error.style.display = 'none';
                error.style.animation = 'none';
                error.textContent = '';
                document.querySelector('form').submit();
            } else {
                error.style.display = 'flex';
                error.style.animation = 'slide-down 2s linear';
                error.textContent = 'Password does not meet security criteria or passwords don\'t match.';
            }
        }
    </script>
</body>
</html>
<?php
if (isset($_GET['response'])) {
        $response = htmlspecialchars($_GET['response']);
        echo "<script>
        var error = document.getElementById('error-message');
        error.style.display = 'flex';
        error.style.animation = 'slide-down 2s linear';
        error.textContent = '$response';
        </script>";
    }
?>
<script>
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm-password");
    const hasNumber = /\d/;
    const hasSpecialChar = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/;
    const hasUppercase = /[A-Z]/;
    const hasLowercase = /[a-z]/;

    function checkPassword() {
        const password = passwordInput.value;

        if (
                hasNumber.test(password) &&
                hasSpecialChar.test(password) &&
                hasUppercase.test(password) &&
                hasLowercase.test(password)
            ) {
                passwordInput.style.outline = "2px solid green";
            }
        else {
            passwordInput.style.outline = "2px solid red";
        }
    }
    passwordInput.addEventListener("input", checkPassword);

    
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (password === confirmPassword) {
            passwordInput.style.outline = "2px solid green";
            confirmPasswordInput.style.outline = "2px solid green";
        } else {
            confirmPasswordInput.style.outline = "2px solid red";
        }
    }
    confirmPasswordInput.addEventListener("input", checkPasswordMatch);
</script>