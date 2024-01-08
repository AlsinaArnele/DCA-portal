<?php
include 'actions/fetch-admin.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <title>Admin Panel</title>
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/site.webmanifest">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="css/users.css" rel="stylesheet">
        <script src="js/app.js"></script>
    </head>
    <body id="users-body">
        <aside id="myaside">
            <span id="close" onclick="toggleSidebarback()" class="material-symbols-outlined">close</span>
                <h1>Dot Connect Africa</h1>
                <div class="container">
                    <img src="Images/admin.jpeg" alt="profile photo">
                    <?php
                    $hour = date('H');
                    if ($hour < 12) {
                        echo '<p>Good morning</p>';
                    } else if ($hour < 17) {
                        echo '<p>Good afternoon</p>';
                    } else {
                        echo '<p>Good evening</p>';
                    }
                    ?>
                    <div class="icon">
                        <span class="material-symbols-outlined">groups</span>
                        <a href="users.php">Users</a>
                    </div>
                    <div class="icon-2">
                        <span class="material-symbols-outlined">schedule</span>
                        <a href="time.php">Time</a>
                    </div>
                    <div class="dropdown">
                            <form action="actions/admin-logout.php">
                                <button type="submit"><span class="material-symbols-outlined">logout</span></button>
                            </form> 
                    </div>
                </div>
        </aside>
        <section id="users-main">
            <div id="user-accounts" class="profile-main">
                <nav>
                    <div onclick="toggleSidebar()" class="burger">
                        <div></div>
                        <div></div>
                        <div></div> 
                    </div>
                    <h3>USER ACCOUNTS</h3>
                    <?php
                    echo '<h1>'.$admin_email.'</h1>';
                    ?>
                </nav>
                <form class="search" action="" method="GET">
                    <input type="text" name="search" placeholder="Search by username or email" >
                    <button type="submit">Search</button> 
                    <select name="users-filter" id="filter">
                        <option value="username" selected>Name</option>
                        <option value="email">Email</option>
                    </select>
                    <select name="users-ascending-filter" id="filter">
                        <option value="ASC" selected>Asc</option>
                        <option value="DESC">Desc</option>
                    </select>
                    <button type="submit">Apply filter</button>
                </form>
                <table class="accounts"> 
                    <tr class="head-tr">
                        <th class="profile-image">Photo</th>
                        <th class="username">Username</th>
                        <th class="email">Email</th>
                        <th class="date">Date Created</th>
                        <th class="status">Status</th>
                        <th class="actions-data">Actions</th>
                    </tr>
                    <?php
                    include 'actions/fetch-table-data.php'; 
                    ?>
                </table>
                <div class="pagination">
                        <?php
                        include 'actions/connect.php';
                        $sql = "SELECT COUNT(*) AS total FROM users";
                        $total_result = $conn->query($sql);
                        $total_row = $total_result->fetch_assoc();
                        $total_users = $total_row['total'];
                        $total_pages = ceil($total_users / $records_per_page);

                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo "<a href='?page=$i'>$i</a>";
                        }
                        ?>
                </div>
            </div>
        </section>
    </body>
</html>
<script>
    function toggleSidebar() {
        var asideElement = document.getElementById("myaside");
        asideElement.style.marginLeft = "0";

    }
    function toggleSidebarback() {
        var asideElement = document.getElementById("myaside");
        asideElement.style.marginLeft = "-40vw";

    }

    function checkStatus() {
    const element = document.getElementById("user-data"); 
            const status = element.innerText.toLowerCase().trim();

            if (status === 'disabled') {
                element.style.color = 'red';
            } else if (status === 'active') {
                element.style.color = 'green';
            }
    }

    checkStatus(); 
    setInterval(checkStatus, 10);

    function editUser(email) {
        if (confirm("Are you sure you want to edit this user?")) {
        const redirectUrl = 'edit_users.php?email=' + encodeURIComponent(email);
        
        window.location.href = redirectUrl;
        }
    }


    function deleteRow(email) {
            if (confirm("Do you want to delete this user?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload();
                    }
                };
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

