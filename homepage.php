<?php
include 'actions/session-check.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Home Page</title>
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/index.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="js/app.js"></script>
    </head>
    <body>
    <nav>
        <img src="Images/DCA-logo.png" alt="">
        <div class="container">
        <?php
    include 'actions/connect-pdo.php';

    $email = $_SESSION['user'];

    try {
        $stmt = $dbh->prepare("SELECT slack, `DCA-drive`, leads, hosting, trust, services FROM services WHERE user_email=:email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt2 = $dbh->prepare("SELECT id, image_url, username, email, phone, `password` FROM users WHERE email=:email");
        $stmt2->bindParam(':email', $email);
        $stmt2->execute();
        $usersData2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($usersData as $userDat) {
            // echo "<a class='status'>" . $userDat['username'] . "</a>";
        }

        // Define services with their corresponding URLs
        $services = [
            'slack' => ['Visit Workspace', 'https://dotconnectafr-n359656.slack.com/'],
            'leads' => ['Visit platform', 'https://app.leadsgorilla.net/'],
            'hosting' => ['Visit site', 'https://yakocloud.com/'],
        ];
        $dcatrust = [
            'DCA Academy' => 'https://waridi.online/https://dotconnectafrica.org/DCAAcademy/',
            'Fem Power' => 'https://missdotafrica.digital/',
            'Webforum' => 'https://webforum.dotconnectafrica.org/'
        ];
            foreach ($usersData2 as $userData2) {
                // echo "<a class='status'>" . $userData['username'] . "</a>";
            }
            } catch (PDOException $e) {
                die("Database error: " . $e->getMessage());
            } 
        ?>

        <img src="actions/<?php 
        if ($userData2['image_url'] !== null) {
            echo $userData2['image_url'];
        }else{
            echo "../Images/default-user.jpg";
        }
        ?>" alt="">
            <div>
                <button id="settings" onclick="displaySettings()"><span id="more" class="material-symbols-outlined" style="color: white;">settings</span></button>
            </div> 
            <script>
                function displaySettings(){
                var settings = document.getElementById('settings-logout');
                if(settings.style.display == 'flex'){
                settings.style.display = 'none';
                }
                else{
                        settings.style.display = 'flex';
                    }
            }
            </script>
            <div id="settings-logout">
                <a href="edit-account.php">Settings</a>
                <form id="logout-form" action="actions/logout.php" method="POST">
                    <button type="submit" id="logout-button">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <section id="hero">
        <h1>DotConnectAfrica</h1>
    </section>
    <section id="services">
        <?php
        foreach ($usersData as $userData) {
            foreach ($services as $key => $service) {
                // $image = ;
                echo "<div class='cards' id='tohide'>";
                echo "<img src='Images/$key.png' alt='$key'>";
                if($userData[$key] == 1) {
                    ${"myjs$key"} = $service[0];
                    $mylinkkey = "$service[1]";
                    echo "<div class='inner-card'>";
                    echo "<h1>DCA $key</h1>";
                    echo "<p>Access this service.<br/></p>";
                    echo "</div>";
                    echo "<div class='button'><a href='$mylinkkey' target='_blank' rel='noopener'>${"myjs$key"}</a></div>";
                }
                else {
                    ${"myjs$key"} = "Not Authorized!";
                    ${"mylink$key"} = "";
                    echo "<div class='inner-card'>";
                    echo "<h1>DCA $key</h1>";
                    echo "<p>Unauthorized<br/></p>";
                    echo "</div>";
                    echo "<div class='button'><a href='${"mylink$key"}' target='_blank' rel='noopener'>${"myjs$key"}</a></div>";
                }
                echo "</div>";
            }

            $drive_access = ($userData['DCA-drive'] !== null) ? $userData['DCA-drive'] : 'null';
            $myjs5 = ($userData['DCA-drive'] !== null) ? 'Not Authorized!' : $drive_access;
            }
            echo "<div class='cards' id='tohide'>";
            echo "<img src='Images/drive.png' alt='drive'>";
            if ($drive_access !== 'null') {
                echo "<div class='inner-card'>";
                echo "<h1>DCA Drive</h1>";
                echo "<p>Unauthorized.<br/></p>";
                echo "</div>";
            } else {
                echo "<div class='inner-card'>";
                echo "<h1>DCA Drive</h1>";
                echo "<p>Access this service.<br/></p>";
                echo "</div>";
            }
            echo "<div class='button'><a href='' target='_blank' rel='noopener'>${"myjs5"}</a></div>";
            echo "</div>";

            echo "<div class='cards' id='tohide'>";
            echo "<img src='Images/trust.png' alt='trust'>";
            
                echo "<div class='inner-card'>";
                echo "<h1>DCA Trust</h1>";
                echo "<p>Access this service.<br/></p>";
                echo "</div>";
                echo "<div class='button'>";
                foreach ($dcatrust as $key => $value) {
                    echo "<a href='$value' target='_blank' rel='noopener'>$key</a>";
                }
                echo "</div>";
            echo "</div>";

            echo "<div class='cards'>
            <img src='Images/DCA services.png' alt='services'>
            <div class='inner-card'>
                <h1>DCA Services</h1>
                <p>Get to know <br/>what we offer our clients.</p>
            </div>
            <div class='button'>
                <a href='https://yakocloud.com/' target='_blank' rel='noopener'>Yako Cloud</a>
                <a href='https://waridi.online/' target='_blank'  rel='noopener'>Waridi Online</a>
                <a href='https://shebnks.mobi/' target='_blank' rel='noopener'>SheBnks</a>
                <a href='https://digitalmarketing.yakocloud.com/' target='_blank' rel='noopener'>Digital Marketing</a>
            </div>
        </div>";
        ?>
    </section>
    <footer>
        <div class="footer-info">
            <a href="https://dotconnectafrica.org/contact-us/" target='_blank' rel='noopener'>Contacts</a>
            <a href="https://dotconnectafrica.org/about/privacy-policy/" target='_blank' rel='noopener'>Privacy policy</a>
        </div>
        <div class="footer-info">
            <h2>&copy; <a href="https://dotconnectafrica.org" target='_blank' rel='noopener' style="color: white;text-decoration:none;">DotConnectAfrica</a></h2>
        </div>
        <div class="footer-card">
            <a href="https://www.instagram.com/dotconnectafrica/" target='_blank' rel='noopener' class="socialContainer containerOne">
              <svg class="socialSvg instagramSvg" viewBox="0 0 16 16"> <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path> </svg>
            </a>

            <a href="https://twitter.com/dot_africa" target='_blank' rel='noopener' class="socialContainer containerTwo">
              <svg class="socialSvg twitterSvg" viewBox="0 0 16 16"> <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path> </svg>              </a>

            <a href="https://www.linkedin.com/company/dotconnectafrica-org" target='_blank' rel='noopener' class="socialContainer containerThree">
              <svg class="socialSvg linkdinSvg" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
            </a>
        </div>
    </footer>
    </body>
</html>
<script>
    function myAlert(type){
        if(type == 'drive'){
            <?php echo $myjs5;?>
        }
        else if(type == 'slack'){
            <?php echo $myjs;?>
        }
        else if(type == 'leads'){
            <?php echo $myjs1;?>
        }
        else if(type == 'hosting'){
            <?php echo $myjs2;?>
        }
        else if(type == 'trust'){
            <?php echo $myjs3;?>
        }
    }

    function enlargeView(){
        var view = document.getElementById('myframe');
        view.style.width = '80vw';

        var tohide = document.getElementById('tohide');
        tohide.style.display = 'none';

        var backarrow = document.getElementById('backarrow');
        backarrow.style.display = 'flex';
        backarrow.addEventListener('click', function(){
            view.style.width = '50vw';
            tohide.style.display = 'block';
            backarrow.style.display = 'none';
        });
    }
    
</script>

