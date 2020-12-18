<?php

class Login {

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'matrimony');
    }

    public function adminLogin($data) {

        $sql = "SELECT *FROM `admin` WHERE username = '$data[username]' AND password = '$data[password]'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['status'] == 0) {
                    return $message = '<center><span style="color:red">Sorry! You are not authorized!</span></center>';
                } else {
                    $adminid = $row['admin_id'];
                    $_SESSION['admin_id'] = $adminid;
                    header('location:../../dashboard/admin/index.php');
                }
            }
        } else {
            return $message = '<center><span style="color:red">Incorrect Login Details!</span></center>';
        }
    }

    public function clientLogin($data) {

        $sql = "SELECT *FROM `clients` WHERE username = '$data[username]' AND password = '$data[password]'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['status'] == 0) {
                    return $message = '<center><span style="color:red">Sorry! You are not authorized!</span></center>';
                } else {

                    $clientid = $row['client_id'];

                    date_default_timezone_set("Asia/Dhaka");
                    $datetime = date("l ,F j, Y, g:i:s a");

                    $sql = "INSERT INTO `login_activity`(`client_id`, `logged_in_at`) VALUES ('$clientid','$datetime')";
                    if ($this->conn->query($sql) === TRUE) {
                        
                        $_SESSION['client_id'] = $clientid;
                        header('location:../../dashboard/clients/index.php');
                        
                    } else {
                        return $message = '<center><span style="color:red;">Sorry! Something went wrong!</span></center>';
                    }
                }
            }
        } else {
            return $message = '<center><span style="color:red;">Incorrect Login Details!</span></center>';
        }
    }

}
