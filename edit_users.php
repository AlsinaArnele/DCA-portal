<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Users</title>
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/users.css" rel="stylesheet">
        <script src="js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
    <?php
    include 'actions/fetch-admin.php';
    include 'actions/connect.php'; 

    $email = $_GET['email'];

    $sql = "SELECT * FROM services WHERE user_email = '$email'";
    $result = $conn->query($sql);

    $sql3 = "SELECT * FROM users WHERE email = '$email'";
    $result3 = $conn->query($sql3);

    if ($result3->num_rows > 0) {
        $userDetails3 = $result3->fetch_assoc();
        if($userDetails3["image_url"] == ""){
            $image = "../Images/default-user.jpg";
        }else{
            $image = $userDetails3["image_url"];
        }
    }


    if ($result->num_rows > 0) {
    $userDetails = $result->fetch_assoc();

    $checked = $userDetails["slack"];
    $checked1 = $userDetails["leads"];
    $checked2 = $userDetails["hosting"];
    $checked4 = $userDetails["trust"];
    $checked5 = $userDetails["services"];
    $checked6 = $userDetails["DCA-drive"];
    

    if($checked == 1){
        $toggle = "checked";
    }else{
        $toggle = "";
    }
    if($checked1 == 1){
        $toggle1 = "checked";
    }else{
        $toggle1 = "";
    }
    if($checked2 == 1){
        $toggle2 = "checked";
    }else{
        $toggle2 = "";
    }
    if($checked4 == 1){
        $toggle4 = "checked";
    }else{
        $toggle4 = "";
    }
    if($checked5 == 1){
        $toggle5 = "checked";
    }else{
        $toggle5 = "";
    }
    if($checked6 !== null){
        $toggle6 = "checked";
        $drive_service = $checked6;
    }else{
        $toggle6 = "";
    }

    } else {
        echo "<p>No user found with the provided email.</p>";
    }


    $sql2 = "SELECT * FROM drive_services where name = '$drive_service'";
    $result2 = $conn->query($sql2);

    if($result2->num_rows > 0){
        $driveDetails = $result2->fetch_assoc();
        $drive_id = $driveDetails["id"];
        $drive_name = $driveDetails["name"];
        $drive_url = $driveDetails["drive_link"];
    }else{
        $drive_id = "";
        $drive_name = "";
        $drive_url = "";
    }   

    $conn->close();
    ?>
        <section id="main">
            <aside>
                <h1>Dot Connect Africa</h1>
                <div class="container">
                    <img src="Images/admin.jpeg" alt="profile photo">
                    <?php
                    echo '<p>'.$id.'</p>';
                    ?>
                    <div class="icon">
                        <span class="material-symbols-outlined">person</span>
                        <a href="admin-profile.php">Profile</a>
                    </div>
                    <div class="icon-2">
                        <span class="material-symbols-outlined">group</span>
                        <a href="users.php">Users</a>
                    </div>
                    <div class="dropdown">
                            <form action="actions/admin-logout.php">
                                <button type="submit"><span class="material-symbols-outlined">logout</span></button>
                            </form> 
                    </div>
                </div> 
            </aside>
            <div class="main">
                <div class="header">
                    <div>
                        <a href="users.php"><i class="fa-solid fa-arrow-left" style="font-family:Arial, FontAwesome"></i></a>
                        <img src="actions/<?php echo $image;?>" alt="">
                        <?php echo '<p>' . $userDetails3["username"] .'</p>';?>
                    </div> 
                    <div>
                        <h1 id="dateDisplay">date</h1>
                        <button onclick="deleteRow('<?php echo htmlspecialchars($userDetails3["email"]); ?>')">DELETE</button>
                    </div>

                </div>
                <div class="user-details">
                    <div class="info-1">
                        <h3>PROFILE IMAGE</h3>
                        <img src="actions/<?php echo  $image; ?>" alt="">
                    </div>
                    <div class="info-2">
                        <h3>USER ACCOUNT DETAILS</h3>
                        <div class="info-cards">
                            <p>Username</p>
                            <?php
                            echo '<h1>' . $userDetails3["username"] .'</h1>';
                            ?>
                        </div>
                        <div class="info-cards">
                            <p>Email</p>
                            <?php
                            echo '<h1>' . $userDetails3["email"] .'</h1>';
                            ?>
                        </div>
                        <div class="info-cards">
                            <p>Phone Number</p>
                            <?php
                            echo '<h1>' . $userDetails3["phone"] .'</h1>';
                            ?>
                        </div>
                        <div class="info-cards">
                            <p>Creation Date</p>
                            <?php
                            echo '<h1>' . $userDetails3["creation_date"] .'</h1>';
                            ?>
                        </div>
 
                    </div>
                    <div class="info-3">
                        <h3>ACCOUNT STATUS</h3>
                        <h1 id="user-data" onclick="toggleStatus('<?php echo htmlspecialchars($userDetails3["email"]); ?>')"><?php echo $userDetails3["status"];?></h1>
                    </div>
                </div>
                <div class="services">
                    <h2>Services</h2>
                    <div class="container-services" id="servicesForm">
                        <div class="details">
                            <p>DCA Slack Kenya</p>
                            <div class="checkbox-con">
                                <input id="checkboxslack" type="checkbox" <?php echo $toggle?>>
                            </div>
                        </div>
                        <div class="details">
                            <p>Leads Gen</p>
                            <div class="checkbox-con">
                                <input id="checkboxleads" type="checkbox" <?php echo $toggle1?>>
                            </div>
                        </div>
                        <div class="details">
                            <p>Hosting</p>
                            <div class="checkbox-con">
                                <input id="checkboxhosting" type="checkbox" <?php echo $toggle2?>>
                            </div>
                        </div>
                        <div class="details">                            
                            <p>DCA trust</p>
                            <div class="checkbox-con">
                                <input id="checkboxtrust" type="checkbox" <?php echo $toggle4?>>
                            </div>
                        </div>
                        <div class="details">
                            <p>Services</p>
                            <div class="checkbox-con">
                                <input id="checkboxservices" type="checkbox" <?php echo $toggle5?>>
                            </div>
                        </div>
                        <div class="details">
                            <!-- <p>Drive Web</p>
                            <div class="checkbox-con">
                                <input id="checkboxweb" onclick="drive_handler(web)" type="checkbox" <?php echo $toggle6?>>
                            </div> -->
                        </div>
                    </div>
                    <div class="buttonn">
                        <button type="submit" value="Save Changes" onclick="validate()">Save Changes</button>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
<script> 
    function validate() {
        if (document.getElementById('checkboxslack').checked) {
            var slack = 1;
        } else {
            var slack = 0;
        }
        if (document.getElementById('checkboxleads').checked) {
            var leads = 1;
        } else {
            var leads = 0;
        }
        if (document.getElementById('checkboxhosting').checked) {
            var hosting = 1;
        } else {
            var hosting = 0;
        }
        if (document.getElementById('checkboxtrust').checked) {
            var trust = 1;
        } else {
            var trust = 0;
        }
        if (document.getElementById('checkboxservices').checked) {
            var services = 1;
        } else {
            var services = 0;
        }

        var email = '<?php echo $email ?>';

  var data = {
    var1: slack,
    var2: leads,
    var3: hosting,
    var5: trust,
    var6: services,
    var7: email
  };

  //send data via ajax to the php file

  $.ajax({
    url: "actions/update_services.php",
    type: "POST",
    data: data,
    success: function (response) {
        Swal.fire({
            icon: 'success',
            title: 'Success!', 
            text: response 
        });
    },
    error: function (xhr, status, error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: response
        });
    }
});

    }


     function updateDateDisplay() {
    const currentDate = new Date();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = currentDate.toLocaleDateString(undefined, options);

    document.getElementById("dateDisplay").innerText = formattedDate;
}

updateDateDisplay();

function checkStatus() {
    const element = document.getElementById("user-data"); 
            const status = element.innerText.toLowerCase().trim();

            // change color depending on status
            if (status === 'disabled') {
                element.style.color = 'red';
            } else if (status === 'active') {
                element.style.color = 'green';
            }
    }

    checkStatus();

    function deleteRow(email) {
            if (confirm("Do you want to delete this user?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload();
                    }
                };
                //send details of user to delete
                xhr.open('GET', 'actions/delete.php?email=' + encodeURIComponent(email), true);
                xhr.send();
            }
        }
        function toggleStatus(id) {
            if (confirm("Are you sure you want to disable this user?")) {
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "actions/lock.php");

                var input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("name", "id");
                input.setAttribute("value", id);
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();
            }
        }
</script>