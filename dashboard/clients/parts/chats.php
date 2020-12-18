<?php

session_start();

$conn = new mysqli('localhost', 'root', '', 'matrimony');
require_once '../server/Client.php';
$server = new Client();

$sender = $_SESSION['client_id'];
$receiver = $_SESSION['message_to'];

$sql = "SELECT * FROM `chats` WHERE message_from ='$sender' AND message_to = '$receiver' OR message_from ='$receiver' AND message_to ='$sender' ";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {

        if ($row['message_from'] === $sender && $row['message_to'] === $receiver) {
            echo $message = '<div class="chat chat-right">
                            <div class="chat-body">
                                <div class="chat-bubble">
                                    <div class="chat-content">
                                        <p>' . $row['message_body'] . '</p>
                                        <span class="chat-time">' . $row['message_time'] . '</span>
                                    </div>
                                </div>
                            </div>
                          </div>';
        } else if ($row['message_from'] === $receiver && $row['message_to'] === $sender) {
            echo $message = '<div class="chat chat-left">
                <div class="chat-avatar">
                        <a href="profile.html" class="avatar">
                            <img alt="Jennifer Robinson" src="' . $server->clientIamge_byID($receiver) . '" class="img-fluid rounded-circle">
                        </a>
                        </div>
                            <div class="chat-body">
                                <div class="chat-bubble">
                                    <div class="chat-content">
                                        <p>' . $row['message_body'] . '</p>
                                        <span class="chat-time">' . $row['message_time'] . '</span>
                                    </div>
                                </div>
                            </div>
                          </div>';
        }
    }
} else {
    echo $conn->error;
}