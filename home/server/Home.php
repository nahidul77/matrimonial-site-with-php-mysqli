<?php

class Home {

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'matrimony');
        mysqli_query($this->conn, 'SET CHARACTER SET utf8');
        mysqli_query($this->conn, "SET SESSION collation_connection ='utf8_general_ci'");
    }

    //    packages

    public function package_bronze() {
        $sql = "SELECT * FROM `packages` WHERE package_name = 'Bronze'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function package_silver() {
        $sql = "SELECT * FROM `packages` WHERE package_name = 'Silver'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function package_gold() {
        $sql = "SELECT * FROM `packages` WHERE package_name = 'Gold'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function package_platinum() {
        $sql = "SELECT * FROM `packages` WHERE package_name = 'Platinum'";
        $result = $this->conn->query($sql);
        return $result;
    }

//    send message

    public function send_message($data) {

        $from = $data['message_from'];
        $contact = $data['contact'];
        $subject = $data['subject'];
        $message = $data['message'];

        date_default_timezone_set("Asia/Dhaka");
        $message_id = "message@outside" . date("Y-m-d") . '?' . date("H:i:s");

        $today = date("l ,F j, Y, g:i a");

        if (empty($from)) {
            return $error = "Sorry! Name is required!";
        } elseif (empty($contact)) {
            return $error = "Sorry! Email or phone are required!";
        } elseif (empty($subject)) {
            return $error = "Please choose a title";
        } elseif (empty($message)) {
            return $error = "Please write something";
        } elseif (preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($from), $from)) {
            return $error = 'Tags are not allowed.';
        } elseif (preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($contact), $contact)) {
            return $error = 'Tags are not allowed.';
        } elseif (preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($subject), $subject)) {
            return $error = 'Tags are not allowed.';
        } elseif (preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($message), $message)) {
            return $error = 'Tags are not allowed.';
        } else {

            $sql = "INSERT INTO `messages`(`message_from`, `contact`, `subject`, `message`, `date`, `message_id`) VALUES"
                    . " ('$data[message_from]','$data[contact]','$data[subject]','$data[message]','$today','$message_id')";

            if ($this->conn->query($sql) === TRUE) {
                return $success = "Message received. There will be a feedback very soon. ";
            } else {
                return $this->conn->error;
            }
        }
    }

    public function featured_profile() {
        $sql = "SELECT *FROM `clients` WHERE profile_status = '1' AND status = 1 ORDER BY priority_level DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function featured_profile2() {
        $sql = "SELECT *FROM `clients` WHERE profile_status = '1' AND status = 1 ORDER BY priority_level ASC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function search($data) {
        
        if ($data['religion'] == "Any" && $data['marital_status'] <> "Any") {
            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`,`propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND marital_status = '$data[marital_status]'"
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND profile_status = '1'"
                    . "AND status = 1 ORDER BY priority_level DESC";
        } elseif ($data['religion'] <> "Any" && $data['marital_status'] == "Any") {

            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`, `propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND religion = '$data[religion]'"
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND profile_status = '1'"
                    . "AND status = 1 ORDER BY priority_level DESC";
        } elseif ($data['religion'] == "Any" && $data['marital_status'] == "Any") {

            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`, `propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND profile_status = '1'"
                    . "AND status = 1 ORDER BY priority_level DESC";
        } else {
            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`, `propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND religion = '$data[religion]'"
                    . "AND marital_status = '$data[marital_status]'"
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND profile_status = '1'"
                    . "AND status = 1 ORDER BY priority_level DESC";
        }

        $result = $this->conn->query($sql);
        return $result;
    }

}
