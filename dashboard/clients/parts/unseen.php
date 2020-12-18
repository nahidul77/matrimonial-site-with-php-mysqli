<?php

session_start();

$conn = new mysqli('localhost', 'root', '', 'matrimony');


$receiver = $_SESSION['client_id'];
$sender = $row['request_to'];

$sql = "SELECT COUNT(id) FROM `chats` WHERE message_from ='$sender' AND message_to = '$receiver' AND is_seen = 0 ";

$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_row($result);
$count = $rows[0];
echo $count;
