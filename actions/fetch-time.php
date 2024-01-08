<?php
include 'connect.php';

$records_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

// Get filters data
$search = isset($_GET['time-search']) ? $_GET['time-search'] : '';
$filter = isset($_GET['time-filter']) ? $_GET['time-filter'] : 'date';
$ascending = isset($_GET['ascending-filter']) ? $_GET['ascending-filter'] : 'DESC';

if (!empty($search)) {
    $sql = "SELECT * FROM `sessions` WHERE user_email LIKE '%$search%' OR date LIKE '%$search%' ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
} else {
    $sql = "SELECT * FROM `sessions` ORDER BY $filter $ascending LIMIT $offset, $records_per_page";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="time-section-header" style="border-bottom:1px solid lightgray">';
            echo '<div class="time-in">Time in</div>';
            echo '<div class="time-out">Time out</div>';
            echo '<div class="time-date">Date</div>';
            echo '<div class="time-email">User Email</div>';
            echo '<div class="time-email">Total hours</div>';
        echo '</div>';
        while ($row = $result->fetch_assoc()) {
            $timeIn = strtotime($row["time_in"]);
            $timeOut = strtotime($row["time_out"]);
            
            if ($row["time_out"] == '00:00:00.000000' || $row["time_out"] == null) { //user still logged in
                $durationText = 'Still clocked in';
                $style = 'style="color:red"';
            } else {
                $duration = $timeOut - $timeIn;
                $hours = floor($duration / 3600);
                $minutes = floor(($duration % 3600) / 60);
                $seconds = $duration % 60;
                $durationText = $hours . 'hrs ' . $minutes . 'min ' . $seconds . 's';
                $style = 'style="color:green"';
            }
            
            echo '<div class="time-section" id="item-list">';
            echo '<div class="time-in">' . date("H:i:s", $timeIn) . '</div>';
            echo '<div class="time-out">' . date("H:i:s", $timeOut) . '</div>';
            echo '<div class="time-date">' . date("Y-m-d", strtotime($row['date'])) . '</div>';
            echo '<div class="time-email">' . $row["user_email"] . '</div>';
            echo '<div class="time-duration" '.$style.'>' . $durationText . '</div>';
            echo '</div>';
        }
} else {
    echo "<h1>No data found</h1>";
}

$conn->close();
?>