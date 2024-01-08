<!DOCTYPE html>
<html lang="en">
    <head> 
        <title>Index</title>
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/edit-account.css" rel="stylesheet">
    </head>
    <body> 
        <?php
        include 'actions/fetch-data.php';
        include 'actions/connect-pdo.php'; 
        // $_SESSION['last_action'] = time();
        $email = $_SESSION['user']; 
        try {

            $stmt = $dbh->prepare("SELECT username, image_url FROM users WHERE email=:email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($usersData as $userData) {
                
            }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        ?>
    <nav> 
        <img src="Images/DCA-logo.png" alt="">
        <div class="container">
            <a href="homepage.php">Portal</a>
            <img src="actions/<?php echo $image_path; ?>" alt="">
        </div>
    </nav>
    <div class="error" id="error-message">
                
    </div>
    <section id="details"> 
        <form class="left" action="actions/update_details.php" method="post">
            <h1>User information</h1>
            <p>Here you can edit public information about yourself. This information will be displayed to other users within 5 minutes.</p>
            <div class="input">
                <h1>Username</h1>
                <input type="text" name="Username" id="username-ph" value="<?php echo $user_username;?>" required>
            </div>
            <div class="input">
                <h1>Email</h1>
                <input type="email" name="email" id="email-ph" value="<?php echo $email;?>" required>
            </div> 
            <div class="input">
                <h1>Phone</h1>
                <input type="text" name="phone" id="phone-ph" value="<?php echo $phone;?>" required>
            </div>
            <div class="input">
                <h1>Password</h1>
                <input type="password" id="password" name="password" placeholder="Input initial password or update" required>
            </div>
            <p id="password-strength-message"></p>
            <button type="submit" name="submit">Update Details</button>
        </form>
        <div class="right">
            <h1>Profile photo</h1>
            <div class="image-preview">
            <img <?php
            if (!empty($userData['image_url']) && file_exists('actions/' . $userData['image_url'])) {
                echo 'src="actions/' . $userData['image_url'] . '"';
            } else {
                echo 'src="../Images/default-user.jpg"';
            }
            ?> alt="">
            </div>
            <div id="image-preview">
            <form class="image-upload" method="post" enctype="multipart/form-data" action="actions/image.php">
                <h1>Select image to upload</h1>
                <input type="file" name="image" id="image" onchange="updateSubmitButton()">
                <button type="button" name="submit" id="submitButton" onclick="uploadImage()">Select an image</button>
            </form>
                <script>
                    function updateSubmitButton() {
                        var fileInput = document.getElementById('image');
                        var submitButton = document.getElementById('submitButton');
                    
                        if (fileInput.files.length > 0) {
                            submitButton.innerHTML = 'Upload image';
                            submitButton.type = 'submit';
                        } else {
                            submitButton.innerHTML = 'Select an image';
                            submitButton.type = 'button';
                        }
                    }

                    function uploadImage() {
                        var fileInput = document.getElementById('image');
                    
                        if (fileInput.files.length > 0) {
                            // Perform any additional actions before submitting the form
                            // For example, you might want to validate the file or display a preview
                            // Then submit the form
                            document.querySelector('.image-upload').submit();
                        } else {
                            alert('Please select an image before uploading.');
                        }
                    }
                </script>
            </div>
        </div>
    </section>
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
<script src="js/app.js"></script>
<script>
const passwordInput = document.getElementById('password');
const strengthMessageElement = document.getElementById('password-strength-message');

passwordInput.addEventListener('keyup', checkPasswordStrength);

function checkPasswordStrength() {
  const passwordValue = passwordInput.value;
  const passwordStrength = calculatePasswordStrength(passwordValue);
  displayPasswordStrengthMessage(passwordStrength);
}

function calculatePasswordStrength(password) {
  const minLength = 8;
  const minNumbers = 3;
  const minSpecialChars = 1;

  const numberRegex = /\d/g;
  const specialCharRegex = /[^A-Za-z0-9]/g;

  const hasMinLength = password.length >= minLength;
  const hasMinNumbers = (password.match(numberRegex) || []).length >= minNumbers;
  const hasMinSpecialChars = (password.match(specialCharRegex) || []).length >= minSpecialChars;

  if (hasMinLength && hasMinNumbers && hasMinSpecialChars) {
    return "strong";
  } else {
    return "weak";
  }
}

function displayPasswordStrengthMessage(strength) {
  if (strength === "strong") {
    strengthMessageElement.textContent = " ";
    strengthMessageElement.style.color = "green";
  } else {
    strengthMessageElement.textContent = "Password is weak! It should have at least 8 characters.";
    strengthMessageElement.style.color = "red";
    strengthMessageElement.style.fontSize = "2vh";
  }
}
</script>