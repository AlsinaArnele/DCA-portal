<?php
include 'connect.php';

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter = isset($_GET['users-filter']) ? $_GET['users-filter'] : 'username';
$ascending = isset($_GET['users-ascending-filter']) ? $_GET['users-ascending-filter'] : 'ASC';

if (!empty($search)) {
    $sql = "SELECT * FROM users WHERE username LIKE '%$search%' OR email LIKE '%$search%' ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
} else {
    $sql = "SELECT * FROM users ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
            echo '<td class="profile-image">' . '<img src="actions/' . $row["image_url"] . '">' . '</td>';
            echo '<td class="name">' . $row["username"] . '</td>';
            echo '<td class="email">' . $row["email"] . '</td>';
            echo '<td class="date">' . $row['creation_date'] . '</td>';
            echo '<td class="status" id="user-data">' . $row["status"] . '</td>';
            echo '<td class="actions">
                    <button onclick="editUser(\'' . $row["email"] . '\')"><span class="material-icons">edit</span></button>
                    <button onclick="toggleStatus(\'' . $row["email"] . '\')"><span class="material-icons">lock</span></button>
                    <button onclick="deleteRow(\'' . $row["email"] . '\')"><span class="material-icons">delete</span></button>
                  </td>';
        echo '</tr>';
    }
} else {
    echo "<tr><td colspan='6'>No data found</td></tr>";
}

$conn->close();
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const statusElements = document.querySelectorAll(".status");

        statusElements.forEach(element => {
            const status = element.innerText.toLowerCase().trim();
            if (status === 'disabled') {
                element.style.color = 'red';
            } else if (status === 'active') {
                element.style.color = 'green';
            }
        });
    });
</script>
