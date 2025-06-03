<?php
require '../config/connection.php';

$sql = "
    SELECT u.username, us.score, us.completed_at 
    FROM user_scores us
    JOIN users u ON us.user_id = u.id
    ORDER BY us.score DESC
    LIMIT 10
";

$result = $connection->query($sql);
$scores = [];

while ($row = $result->fetch_assoc()) {
    $scores[] = $row;
}

echo json_encode($scores);
$connection->close();
?>