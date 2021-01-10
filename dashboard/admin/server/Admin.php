<?php

class Admin {

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'matrimony');
        mysqli_query($this->conn, 'SET CHARACTER SET utf8');
        mysqli_query($this->conn, "SET SESSION collation_connection ='utf8_general_ci'");
    }

    public function adminData() {
        $adminid = $_SESSION['admin_id'];
        $sql = "SELECT *FROM admin WHERE admin_id = '$adminid' AND type='admin'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateAdmin($data) {
        $adminid = $_SESSION['admin_id'];
        $directory = '../gallery/propic/admin/';

        if ($_FILES['propic']['name'] == "") {
            $propic = $_SESSION['oldpic'];
        } else {
            $propic = $directory . basename($_FILES['propic']['name']);
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
        }

        $email = $data['email'];

        if (preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($email), $email)) {
            return $message = 'Tags are not allowed.';
        } else {
            $sql = "UPDATE `admin` SET "
                    . "`first_name`='$data[first_name]',"
                    . "`last_name`='$data[last_name]',"
                    . "`email`='$data[email]',"
                    . "`phone`='$data[phone]',"
                    . "`admin_id`='$data[admin_id]',"
                    . "`username`='$data[username]',"
                    . "`password`='$data[password]',"
                    . "`propic`='$propic'"
                    . " WHERE admin_id = '$adminid'";

            if ($this->conn->query($sql) === TRUE) {
                echo "<script type='text/javascript'>alert('DATA UPDATED SUCCESSFULLY');document.location='profile.php';</script>";
            } else {
                return $message = 'ERROR:' . $this->conn->error;
            }
        }
    }

    

    public function ViewAllClients() {

        $sql = "SELECT `first_name`, `last_name`,`gender`,`age`,`current_country`,`current_city`,`propic`,`joining_date`,`client_id`,`profile_status`,`status` FROM `clients` ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function ViewActiveClients() {

        $sql = "SELECT `first_name`, `last_name`,`gender`,`age`,`current_country`,`current_city`,`propic`,`joining_date`,`client_id`,`status` FROM `clients` WHERE status = 1 ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function ViewBlockedClients() {

        $sql = "SELECT `first_name`, `last_name`,`gender`,`age`,`current_country`,`current_city`,`propic`,`joining_date`,`client_id`,`status` FROM `clients` WHERE status = 0 ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function premiumClients() {

        $sql = "SELECT `first_name`, `last_name`,`gender`,`age`,`current_country`,`current_city`,`propic`,`joining_date`,`client_id`,`status` FROM `clients` WHERE payment_status = 1 ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function clients_byReligion() {

        $religion = $_GET['religion'];

        $sql = "SELECT `first_name`, `last_name`,`gender`,`country`,`propic`,`client_id`,`status` FROM `clients` WHERE religion = '$religion'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function clients_byGender() {

        $gender = $_GET['gender'];

        $sql = "SELECT `first_name`, `last_name`,`gender`,`current_country`,`current_city`,`propic`,`client_id`,`status` FROM `clients` WHERE gender = '$gender'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function ClientDataByID($data) {

        $sql = "SELECT `first_name`, `last_name`,`gender`,`country`,`propic`,`client_id`,`status` FROM `clients` WHERE client_id = '$data[client_id]'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getClientData() {

        $clientID = $_GET['client_id'];
        $sql = "SELECT *FROM `clients` WHERE client_id = '$clientID'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function UpdateClientData($data) {

        $directory = '../gallery/propic/clients/';

        if ($_FILES['propic']['name'] == "") {
            $propic = $_SESSION['oldpic'];
        } else {
            $propic = $directory . basename($_FILES['propic']['name']);
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
        }

        $sql = "UPDATE `clients` SET `first_name`='$data[first_name]',`last_name`='$data[last_name]',`birthday`='$data[birthday]',`gender`='$data[gender]',`address`='$data[address]',`country`='$data[country]',`city`='$data[city]',`state`='$data[state]',`postal_code`='$data[postal_code]',`propic`='$propic',`phone`='$data[phone]',`email`='$data[email]',`username`='$data[username]',`password`='$data[password]' WHERE client_id = '$data[client_id]'";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('DATA UPDATED SUCCESSFULLY');document.location='client-profile.php?client_id=" . $data[client_id] . "';</script>";
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

//    clints.php
    public function ChangeClientStatus($data) {
        $sql = "UPDATE `clients` SET `status`='$data[status]' WHERE client_id = '$data[client_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('UPDATED!');document.location='clients.php';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

//    client-profile.php
    public function ChangeStatus($data) {
        $client_id = $data['client_id'];
        $sql = "UPDATE `clients` SET `status`='$data[status]' WHERE client_id = '$data[client_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            header("location:client-profile.php?client_id=" . $client_id);
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function DeleteClient($data) {
        $sql = "DELETE FROM `clients` WHERE client_id = '$data[client_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Deleted!');document.location='clients.php';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

//    search
    public function searchProfiles($data) {

        if ($data['religion'] == "Any" && $data['marital_status'] <> "Any") {
            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`,`propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND marital_status = '$data[marital_status]'"
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND profile_status = 1";
        } elseif ($data['religion'] <> "Any" && $data['marital_status'] == "Any") {

            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`, `propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND religion = '$data[religion]'"
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND profile_status = 1";
        } elseif ($data['religion'] == "Any" && $data['marital_status'] == "Any") {

            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`, `propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND profile_status = 1";
        } else {
            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`, `propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND religion = '$data[religion]'"
                    . "AND marital_status = '$data[marital_status]'"
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND profile_status = 1";
        }

        $result = $this->conn->query($sql);
        return $result;
    }

//    account verification


    public function verificationRequests() {

        $sql = "SELECT `id`, `first_name`, `last_name`,`gender`,`client_id`, `age`, `current_country`, `current_city`, `propic`,`verification_request`, `status` FROM `clients` WHERE verification_request = 1 AND status = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function verificationData() {

        $client_id = $_GET['client_id'];
        $sql = "SELECT * FROM `verification` WHERE client_id = '$client_id'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function acceptAccount($data) {
        $client_id = $data['client_id'];
        $sql = "UPDATE `clients` SET `account_status`= 1 , `verification_request`= 0 WHERE client_id = '$client_id' ";
        if ($this->conn->query($sql) === TRUE) {
            $sql = "UPDATE `verification` SET `status`= 1 WHERE client_id = '$client_id'";
            if ($this->conn->query($sql) === TRUE) {
                echo "<script type='text/javascript'>alert('Accepted!');document.location='verification-requests.php';</script>";
            } else {
                return $this->conn->error;
            }
        } else {
            return $this->conn->error;
        }
    }

    public function verificationFailed($data) {
        $client_id = $data['client_id'];
        $sql = "UPDATE `clients` SET `verification_failed`= 1 , `verification_request`= 0 ,`failed_cause`= '$data[failed_cause]' WHERE client_id = '$client_id' ";
        if ($this->conn->query($sql) === TRUE) {
            $sql = "DELETE FROM `verification` WHERE client_id = '$client_id'";
            if ($this->conn->query($sql) === TRUE) {
                echo "<script type='text/javascript'>alert('Cancelled!');document.location='verification-requests.php';</script>";
            } else {
                return $this->conn->error;
            }
        } else {
            return $this->conn->error;
        }
    }

    public function total_requests() {
        $query = "SELECT COUNT(id) FROM `clients` WHERE verification_request = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

//    Totals

    public function TotalClients() {
        $query = "SELECT COUNT(id) FROM `clients`";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_clients() {
        $query = "SELECT COUNT(id) FROM `clients`";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_premium_clients() {
        $query = "SELECT COUNT(id) FROM `clients` WHERE payment_status = 1";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_male_clients() {
        $query = "SELECT COUNT(id) FROM `clients` WHERE gender = 'Male'";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_female_clients() {
        $query = "SELECT COUNT(id) FROM `clients` WHERE gender = 'Female'";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_blocked_clients() {
        $query = "SELECT COUNT(id) FROM `clients` WHERE status = 0";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_active_clients() {
        $query = "SELECT COUNT(id) FROM `clients` WHERE status = 1";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_clients_byReligion($religion) {
        $query = "SELECT COUNT(id) FROM `clients` WHERE religion = '$religion' ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_clients_by($gender, $religion) {
        $query = "SELECT COUNT(id) FROM `clients` WHERE gender = '$gender' AND religion = '$religion' ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

//    Packages

    public function create_package($data) {

        $sql = "INSERT INTO `packages`(`package_name`, `price_taka`, `price_usd`,`message_limit`,`view_limit`,`request_limit`, `offer_1`, `offer_2`, `offer_3`, `offer_4`, `offer_5`, `offer_6`, `offer_7`, `offer_8`, `offer_9`, `offer_10`, `publication_status`) VALUES "
                . "('$data[package_name]','$data[price_taka]','$data[price_usd]','$data[message_limit]','$data[view_limit]','$data[request_limit]','$data[offer_1]','$data[offer_2]','$data[offer_3]','$data[offer_4]','$data[offer_5]','$data[offer_6]','$data[offer_7]','$data[offer_8]','$data[offer_9]','$data[offer_10]','$data[publication_status]')";
        if ($this->conn->query($sql) === TRUE) {
            return $message = "Package created successfully.";
        } else {
            return $message = "Package exists.";
        }
    }

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

    public function package_byName() {
        $package_name = $_GET['package_name'];
        $sql = "SELECT * FROM `packages` WHERE package_name = '$package_name'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function update_package($data) {

        $package_name = $_GET['package_name'];

        $sql = "UPDATE `packages` SET "
                . "`package_name`='$data[package_name]',"
                . "`price_taka`='$data[price_taka]',"
                . "`price_usd`='$data[price_usd]',"
                . "`message_limit`='$data[message_limit]',"
                . "`view_limit`='$data[view_limit]',"
                . "`request_limit`='$data[request_limit]',"
                . "`offer_1`='$data[offer_1]',"
                . "`offer_2`='$data[offer_2]',"
                . "`offer_3`='$data[offer_3]',"
                . "`offer_4`='$data[offer_4]',"
                . "`offer_5`='$data[offer_5]',"
                . "`offer_6`='$data[offer_6]',"
                . "`offer_7`='$data[offer_7]',"
                . "`offer_8`='$data[offer_8]',"
                . "`offer_9`='$data[offer_9]',"
                . "`offer_10`='$data[offer_10]',"
                . "`publication_status`='$data[publication_status]'"
                . " WHERE `package_name`='$package_name'";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Updated!');document.location='packages.php';</script>";
        } else {
            return $this->conn->error;
        }
    }

//    messages

    public function total_unreadMessage(){
        $query = "SELECT COUNT(id) FROM `messages` WHERE is_seen = 0 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }


    public function messages_FromOthers() {

        $sql = "SELECT * FROM `messages` WHERE is_client = 0 ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function changeMessage_status($data) {
        $sql = "UPDATE `messages` SET `is_seen`='$data[status]' WHERE message_id = '$data[message_id]'";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Updated!');document.location='message-from-others.php';</script>";
        } else {
            return $this->conn->error;
        }
    }
    
    public function delete_message($data) {
        $sql = "DELETE FROM `messages` WHERE message_id = '$data[message_id]'";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Deleted!');document.location='message-from-others.php';</script>";
        } else {
            return $this->conn->error;
        }
    }

}
