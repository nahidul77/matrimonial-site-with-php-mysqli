<?php

class Server {

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'matrimony');
    }

    public function registration($data) {

        $directory = '../../dashboard/gallery/propic/clients/';
        $propic = $directory . basename($_FILES['propic']['name']);

        if (file_exists($directory . $propic)) {
            $error = "Iamge name exists.Please rename the file name or choose different file.";
            return $error;
        } else {
            date_default_timezone_set("Asia/Dhaka");
            $client_id = "client@" . date("Y-m-d") . '?' . date("H:i:s");
            $joining = date("d-m-Y");

            $year = date("Y");
            $month = date("F");
            $day = date('l');

            $sql = "INSERT INTO `clients`(`first_name`, `last_name`, `birthday`, `gender`, `phone`, `email`, `client_id`, `username`, `password`, `propic`, `joining_date`, `day`, `month`, `year`) VALUES"
                    . " ('$data[first_name]','$data[last_name]','$data[birthday]','$data[gender]','$data[phone]','$data[email]','$client_id','$data[username]','$data[password]','$propic','$joining','$day','$month','$year')";

            if ($this->conn->query($sql) === TRUE) {
                move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
                $success = '<span style="color:green">REGISTATION COMPLETED SUCCESSFULLY.</span>DO YOU WNAT TO <a href="../../login/client/">LOGIN?</a> ';
                return $success;
            } else {
                return $message = '<span style="color:red">ERROR:' . $this->conn->error . '</span>';
            }
        }
    }

}
