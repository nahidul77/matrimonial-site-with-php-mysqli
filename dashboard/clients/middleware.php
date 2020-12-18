<?php

session_start();

require_once './server/Client.php';
$server = new Client();

$server->logged_out();