<?php

class Client {

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'matrimony');
        mysqli_query($this->conn, 'SET CHARACTER SET utf8');
        mysqli_query($this->conn, "SET SESSION collation_connection ='utf8_general_ci'");
    }

//    activity
//    function location: parts/topnav.php

    public function last_seen_at() {
        $clientid = $_SESSION['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $datetime = date("l ,F j, Y, g:i:s a");

        $sql = "UPDATE `login_activity` SET `last_seen_at`='$datetime' , `activity_time`= NOW() WHERE client_id = '$clientid' ORDER BY id DESC limit 1";

        if ($this->conn->query($sql) === TRUE) {

        } else {
            return $this->conn->error;
        }
    }

//function location: middleware.php

    public function logged_out() {
        $clientid = $_SESSION['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $datetime = date("l ,F j, Y, g:i:s a");

        $sql = "UPDATE `login_activity` SET `logged_out_at`='$datetime' WHERE client_id = '$clientid' ORDER BY id DESC limit 1";

        if ($this->conn->query($sql) === TRUE) {
            header('location: logout.php');
        } else {
            return $this->conn->error;
        }
    }

    public function last_activity($client_id) {
        $clientid = $_SESSION['client_id'];
        $sql = "SELECT `last_seen_at` FROM `login_activity` WHERE client_id = '$client_id' ORDER BY id DESC limit 1";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['last_seen_at'];
        }
    }

    public function is_active($person) {

        $sql = "SELECT `activity_time` FROM `login_activity` WHERE client_id = '$person' AND activity_time >= NOW() - INTERVAL 3 MINUTE ORDER BY id DESC limit 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return '<span class="status online"></span>';
        } else {
            return '<span class="status offline"></span>';
        }
    }

//    data
    public function viewData() {

        $clientid = $_SESSION['client_id'];
        $sql = "SELECT *FROM `clients` WHERE client_id = '$clientid' ";

        $data = $this->conn->query($sql);
        return $data;
    }

    public function updateProfile($data) {

        $clientid = $_SESSION['client_id'];
        $directory = '../gallery/propic/clients/';


        if ($_FILES['propic']['name'] == "") {
            $propic = $_SESSION['oldpic'];
        } else {
            $propic = $directory . basename($_FILES['propic']['name']);
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
        }


        $sql = "UPDATE `clients` SET"
                . "`first_name`='$data[first_name]',"
                . "`last_name`='$data[last_name]',"
                . "`birthday`='$data[birthday]',"
                . "`gender`='$data[gender]',"
                . "`email`='$data[email]',"
                . "`religion`='$data[religion]',"
                . "`marital_status`='$data[marital_status]',"
                . "`age`='$data[age]',"
                . "`nationality`='$data[nationality]',"
                . "`interest`='$data[interest]',"
                . "`hobby`='$data[hobby]',"
                . "`blood_group`='$data[blood_group]',"
                . "`smoking`='$data[smoking]',"
                . "`father_name`='$data[father_name]',"
                . "`mother_name`='$data[mother_name]',"
                . "`father_status`='$data[father_status]',"
                . "`mother_status`='$data[mother_status]',"
                . "`total_member`='$data[total_member]',"
                . "`family_type`='$data[family_type]',"
                . "`about_family`='$data[about_family]',"
                . "`permanent_address`='$data[permanent_address]',"
                . "`present_address`='$data[present_address]',"
                . "`country`='$data[country]',"
                . "`division`='$data[division]',"
                . "`postal_code`='$data[postal_code]',"
                . "`state`='$data[state]',"
                . "`current_country`='$data[current_country]',"
                . "`current_city`='$data[current_city]',"
                . "`education_details`='$data[education_details]',"
                . "`education`='$data[education]',"
                . "`professional_sector`='$data[professional_sector]',"
                . "`profession`='$data[profession]',"
                . "`income`='$data[income]',"
                . "`height`='$data[height]',"
                . "`weight`='$data[weight]',"
                . "`physical_condition`='$data[physical_condition]',"
                . "`biography`='$data[biography]',"
                . "`username`='$data[username]',"
                . "`password`='$data[password]',"
                . "`propic`='$propic',"
                . "`profile_status`='1'"
                . "WHERE client_id = '$clientid'";

        if ($this->conn->query($sql) === TRUE) {
            $success = "<script type='text/javascript'>alert('DATA RECEIVED SUCCESSFULLY');document.location='profile.php';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function searchProfiles($data) {

        $client_id = $_SESSION['client_id'];

        if ($data['religion'] == "Any" && $data['marital_status'] <> "Any") {
            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`,`propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND marital_status = '$data[marital_status]'"
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND client_id <> '$client_id'"
                    . "AND profile_status = '1'"
                    . "AND status = 1 ORDER BY priority_level DESC";
        } elseif ($data['religion'] <> "Any" && $data['marital_status'] == "Any") {

            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`, `propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND religion = '$data[religion]'"
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND client_id <> '$client_id'"
                    . "AND profile_status = '1'"
                    . "AND status = 1 ORDER BY priority_level DESC";
        } elseif ($data['religion'] == "Any" && $data['marital_status'] == "Any") {

            $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`, `propic` FROM `clients`"
                    . " WHERE country = '$data[country]' "
                    . "AND gender = '$data[gender]' "
                    . "AND age >= '$data[age_from]'"
                    . "AND age <= '$data[age_to]'"
                    . "AND client_id <> '$client_id'"
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
                    . "AND client_id <> '$client_id'"
                    . "AND profile_status = '1'"
                    . "AND status = 1 ORDER BY priority_level DESC";
        }

        $result = $this->conn->query($sql);
        return $result;
    }

//    Clients
    public function all_clients() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT `first_name`, `last_name`,`gender`,`client_id`,`religion`, `marital_status`, `age`, `state`, `current_country`, `current_city`, `profession`,`height`,`weight`, `biography`,`propic` FROM `clients` WHERE client_id <> '$client_id' AND profile_status = 1 AND status = 1";

        $result = $this->conn->query($sql);
        return $result;
    }

    public function getClientData() {

        $clientID = $_GET['client_id'];
        $viwer = $_SESSION['client_id'];



        $sql = "SELECT *FROM `clients` WHERE client_id = '$clientID'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function be_visitor() {
        $visited_to = $_GET['client_id'];
        $visited_by = $_SESSION['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $today = date("l ,F j, Y, g:i:s a");

        $sql = "SELECT * FROM `profile_visitor` WHERE visited_by='$visited_by' ORDER BY id DESC limit 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['visited_to'] == $visited_to) {

                } else {
                    $sql = "INSERT INTO `profile_visitor`(`visited_by`, `visited_to`, `visited_at`) "
                            . "VALUES ('$visited_by','$visited_to','$today')";
                    if ($this->conn->query($sql)) {

                    } else {
                        return $this->conn->error;
                    }
                }
            }
        } else {
            $sql = "INSERT INTO `profile_visitor`(`visited_by`, `visited_to`, `visited_at`) "
                    . "VALUES ('$visited_by','$visited_to','$today')";
            if ($this->conn->query($sql)) {

            } else {
                return $this->conn->error;
            }
        }
    }

    public function increase_view() {
        $visited_to = $_GET['client_id'];
        $visited_by = $_SESSION['client_id'];

        $sql = "SELECT * FROM `profile_visitor` WHERE visited_by='$visited_by' AND visited_to='$visited_to' AND id = (SELECT id FROM `profile_visitor` ORDER BY id DESC limit 1)";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {

        } else {
            $sql = "SELECT * FROM `mutual_requests` WHERE request_from = '$visited_by' AND request_to = '$visited_to' AND ( request_status = 1 OR is_accepted = 1 ) OR request_from = '$visited_to' AND request_to = '$visited_by' AND ( request_status = 1 OR is_accepted = 1 )";
            if ($result->num_rows > 0) {

            } else {
                $query = "UPDATE `premium` SET `profile_viewed`= profile_viewed +  1 WHERE client_id = '$visited_by' AND status = 1 ORDER BY id DESC limit 1";
                if ($this->conn->query($query) === TRUE) {

                } else {

                }
            }
        }
    }

    public function clientName_byID($client_id) {
        $sql = "SELECT `first_name`, `last_name` FROM `clients` WHERE client_id = '$client_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['first_name'] . ' ' . $row['last_name'];
        }
    }

    public function clientIamge_byID($client_id) {
        $sql = "SELECT `propic` FROM `clients` WHERE client_id = '$client_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['propic'];
        }
    }

//    verifications

    public function contact_varification() {
        $client_id = $_SESSION['client_id'];
        $code = $_POST['verification_code'];
        $pass = '123456';

        if ($code == "") {
            return $error = "The code is required";
        } elseif ($code <> $pass) {
            return $error = "The code you entered does not match!";
        } else {
            $sql = "UPDATE `clients` SET `contact_status`= 1 WHERE client_id = '$client_id' ";
            if ($this->conn->query($sql)) {
                header("Location: verify-contact.php");
            } else {
                return $this->conn->error;
            }
        }
    }

    public function accountVarification_nid($data) {
        $client_id = $_SESSION['client_id'];

        $directory1 = '../gallery/NID/front/';
        $directory2 = '../gallery/NID/back/';

        $filename1 = $_FILES['nid_front']['name'];
        $filename2 = $_FILES['nid_back']['name'];
        $maxsize = 5242880;

        if (file_exists($directory1 . $filename1) || file_exists($directory2 . $filename2)) {
            $error = "File name exists.Please rename the file name or choose different file.";
            return $error;
        } elseif ($_FILES['nid_front']['name'] == "") {

            $error = "Front image is required!";
            return $error;
        } elseif ($_FILES['nid_back']['name'] == "") {

            $error = "Front image is required!";
            return $error;
        } elseif ($_FILES['nid_front']['size'] > $maxsize || $_FILES['nid_back']['size'] > $maxsize) {

            $error = "One or both image are too large in size. Max allowed size is 5 MB!";
            return $error;
        } elseif (!preg_match("/\.(png|jpg|jpeg)$/", $filename1, $filename2)) {
            $error = "File type is not allowed!";
            return $error;
        } else {


            $front = $directory1 . basename($_FILES['nid_front']['name']);
            $back = $directory2 . basename($_FILES['nid_back']['name']);

            date_default_timezone_set("Asia/Dhaka");
            $id = "verification@nid#" . date("d-m-Y") . '?' . date("H:i:s");

            $today = date("l ,F j, Y, g:i a");

            $sql = "INSERT INTO `verification`(`client_id`,`verification_id`, `verification_type`, `nid_front`, `nid_back`, `date`) "
                    . "VALUES ('$client_id','$id','nid','$front','$back','$today')";

            if ($this->conn->query($sql) === TRUE) {

                $sql = "UPDATE `clients` SET `verification_request`= 1 WHERE client_id = '$client_id' ";
                if ($this->conn->query($sql)) {
                    header("Location: verify-account.php");
                } else {
                    return $this->conn->error;
                }
                move_uploaded_file($_FILES['nid_front']['tmp_name'], $front);
                move_uploaded_file($_FILES['nid_back']['tmp_name'], $back);
            }
        }
    }

    public function accountVarification_passport($data) {
        $client_id = $_SESSION['client_id'];

        $directory = '../gallery/passport/';


        $filename = $_FILES['passport_image']['name'];

        $maxsize = 5242880;
        if (file_exists($directory . $filename)) {
            $error = "File name exists.Please rename the file name or choose different file.";
            return $error;
        } elseif ($_FILES['passport_image']['name'] == "") {

            $error = "Image is required!";
            return $error;
        } elseif ($_FILES['passport_image']['size'] > $maxsize) {

            $error = "Image is too large in size. Max allowed size is 5 MB!";
            return $error;
        } elseif (!preg_match("/\.(png|jpg|jpeg)$/", $filename)) {
            $error = "File type is not allowed!";
            return $error;
        } else {


            $passport_image = $directory . basename($_FILES['passport_image']['name']);

            date_default_timezone_set("Asia/Dhaka");
            $id = "verification@passport#" . date("d-m-Y") . '?' . date("H:i:s");

            $today = date("l ,F j, Y, g:i a");

            $sql = "INSERT INTO `verification`(`client_id`,`verification_id`,`verification_type`,`passport_image`,`date`) "
                    . "VALUES ('$client_id','$id','passport','$passport_image','$today')";

            if ($this->conn->query($sql) === TRUE) {

                $sql = "UPDATE `clients` SET `verification_request`= 1 WHERE client_id = '$client_id' ";
                if ($this->conn->query($sql)) {
                    header("Location: verify-account.php");
                } else {
                    return $this->conn->error;
                }
                move_uploaded_file($_FILES['passport_image']['tmp_name'], $passport_image);
            }
        }
    }

    public function try_again() {
        $client_id = $_SESSION['client_id'];
        $sql = "UPDATE `clients` SET `verification_failed`= 0,`failed_cause`= '' WHERE client_id = '$client_id' ";
        if ($this->conn->query($sql) === TRUE) {
            header("Location:verify-account.php");
        } else {
            return $this->conn->error;
        }
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
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `clients` WHERE client_id <> '$client_id' AND profile_status = 1 AND status = 1";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_sent_requests() {
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `mutual_requests` WHERE request_from = '$client_id' AND request_status = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_received_requests() {
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `mutual_requests` WHERE request_to = '$client_id' AND request_status = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_requested_ones() {
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `mutual_requests` WHERE request_from = '$client_id' AND is_accepted = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_accepted_ones() {
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `mutual_requests` WHERE request_to = '$client_id' AND is_accepted = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_contact_requests() {
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `contact_requests` WHERE requested_to = '$client_id' AND request_status = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_requests_for_phone() {
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `contact_requests` WHERE requested_to = '$client_id' AND requested_for = 'phone' AND request_status = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_requests_for_email() {
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `contact_requests` WHERE requested_to = '$client_id' AND requested_for = 'email' AND request_status = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function ViewActiveClients() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT `first_name`, `last_name`,`gender`,`age`,`current_country`,`current_city`,`propic`,`religion`,`client_id`,`status` FROM `clients` WHERE client_id <> '$client_id' AND profile_status = 1 AND status = 1 ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function featured_maleProfiles() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT *FROM `clients` WHERE gender = 'Male' AND client_id <> '$client_id' AND profile_status = '1' AND status = 1 ORDER BY priority_level DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function featured_FemaleProfiles() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT *FROM `clients` WHERE gender = 'Female' AND client_id <> '$client_id' AND profile_status = '1' AND status = 1 ORDER BY priority_level DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function total_unread_message() {
        $client_id = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `notifications` WHERE notification_to = '$client_id' AND notification_type = 'Message' AND is_seen = 0 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

//    Requests

    public function send_request($data) {
        $client_id = $_SESSION['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $datetime = date("l ,F j, Y, g:i a");
        $date = date("d-m-Y");
        $id = "request@" . date("d-m-Y") . '?' . date("H:i:s");

        $sql = "INSERT INTO `mutual_requests`(`request_id`, `request_from`, `request_to`, `request_date`, `request_time`, `request_status`) VALUES "
                . "('$id','$client_id','$data[request_to]','$date','$datetime',1)";

        if ($this->conn->query($sql) === TRUE) {
            $sql = "UPDATE `premium` SET `request_sent`= request_sent + 1 WHERE client_id = '$client_id' AND status = 1 ORDER BY id DESC limit 1";
            if ($this->conn->query($sql) === TRUE) {
                $success = "<script type='text/javascript'>alert('REQUEST SENT!');document.location='';</script>";
                return $success;
            } else {
                return $message = 'ERROR:' . $this->conn->error;
            }
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function sent_requests() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT *FROM `mutual_requests` WHERE request_from = '$client_id' AND request_status = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function received_requests() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT *FROM `mutual_requests` WHERE request_to = '$client_id' AND request_status = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function accept_button() {
        $request_to = $_SESSION['client_id'];
        $request_from = $_GET['client_id'];
        $sql = "SELECT `request_from` FROM `mutual_requests` WHERE request_to = '$request_to' AND request_from = '$request_from' AND request_status = 1";

        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['request_from'];
        }
    }

    public function accepted($person) {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT `request_to` FROM `mutual_requests` WHERE request_from = '$client_id' AND request_to = '$person' AND is_accepted = 1 OR request_from = '$person' AND request_to = '$client_id' AND is_accepted = 1";

        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['request_to'];
        }
    }

    public function mutual() {
        $request_to = $_SESSION['client_id'];
        $request_from = $_GET['client_id'];
        $sql = "SELECT `request_from` FROM `mutual_requests` WHERE request_to = '$request_to' AND request_from = '$request_from' AND is_accepted = 1 OR request_to = '$request_from' AND request_from = '$request_to' AND is_accepted = 1 ";

        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['request_from'];
        }
    }

    public function request_status($request_to) {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT `request_to` FROM `mutual_requests` WHERE request_from = '$client_id' AND request_to = '$request_to' AND request_status = 1";

        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['request_to'];
        }
    }

    public function cancel_request($data) {
        $client_id = $_SESSION['client_id'];
        $sql = "UPDATE `mutual_requests` SET `request_status`= 0 , `is_accepted`= 0 ,`is_cancelled`= 1 WHERE request_to = '$data[client_id]' AND request_from = '$client_id' OR request_to = '$client_id' AND request_from = '$data[client_id]'";

        if ($this->conn->query($sql) === TRUE) {
            $success = "<script type='text/javascript'>alert('CANCELLED!');document.location='';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function accept_requestGET() {
        $request_to = $_SESSION['client_id'];
        $request_from = $_GET['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $time = date("l ,F j, Y");

        $sql = "UPDATE `mutual_requests` SET `accepted_time`= '$time' ,`request_status`= 0 , `is_accepted`= 1 WHERE request_to = '$request_to' AND request_from = '$request_from' AND request_status = 1";

        if ($this->conn->query($sql) === TRUE) {
            $sql = "UPDATE `premium` SET `request_sent`= request_sent + 1 WHERE client_id = '$request_to' AND status = 1 ORDER BY id DESC limit 1";
            if ($this->conn->query($sql) === TRUE) {
                $success = "<script type='text/javascript'>alert('Request Accepted!');document.location='';</script>";
                return $success;
            } else {
                return $message = 'ERROR:' . $this->conn->error;
            }
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function accept_requestPOST($data) {
        $request_to = $_SESSION['client_id'];
        $request_from = $data['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $time = date("l ,F j, Y");

        $sql = "UPDATE `mutual_requests` SET `accepted_time`= '$time' , `request_status`= 0 , `is_accepted`= 1 WHERE request_to = '$request_to' AND request_from = '$request_from' AND is_cancelled = 0 ";

        if ($this->conn->query($sql) === TRUE) {
            $sql = "UPDATE `premium` SET `request_sent`= request_sent + 1 WHERE client_id = '$request_to' AND status = 1 ORDER BY id DESC limit 1";
            if ($this->conn->query($sql) === TRUE) {
                $success = "<script type='text/javascript'>alert('Request Accepted!');document.location='requests.php';</script>";
                return $success;
            } else {
                return $message = 'ERROR:' . $this->conn->error;
            }
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function requested_ones() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT * FROM `mutual_requests` WHERE request_from = '$client_id' AND is_accepted = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function accepted_ones() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT * FROM `mutual_requests` WHERE request_to = '$client_id' AND is_accepted = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

//    Chats

    public function send_message($data) {
        $message_from = $_SESSION['client_id'];

        $date = date("d-m-Y");
        $time = date("l ,F j, Y, g:i a");
        $id = "message@chat#" . date("d-m-Y") . '?' . date("H:i:s");
        $key = "notification@" . date("d-m-Y") . '?' . date("H:i:s");

        $message = $data['message'];

        if (empty($message)) {

        } elseif (preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($message), $message)) {
            return $message_to;
        } else {

            $sql = "INSERT INTO `chats`(`message_id`, `message_from`, `message_to`, `message_body`, `message_date`, `message_time`) VALUES "
                    . "('$id','$message_from','$data[message_to]','$data[message]','$date','$time') ";

            if ($this->conn->query($sql)) {
                $sql = "UPDATE `chats` SET `is_seen`= 1 WHERE message_from ='$data[message_to]' AND message_to = '$message_from'";
                if ($this->conn->query($sql)) {
                    $sql = "UPDATE `premium` SET `message_sent`= message_sent + 1 WHERE client_id = '$message_from' AND status = 1 ORDER BY id DESC limit 1";
                    if ($this->conn->query($sql) === TRUE) {
                        $sql = "INSERT INTO `notifications`(`notification_id`, `notification_to`, `notification_from`, `notification_type`,`notification_about`,`notification_time`) VALUES "
                                . "('$key','$data[message_to]','$message_from','Message','Sent you a new message.','$time')";

                        if ($this->conn->query($sql) === TRUE) {

                        } else {
                            return $message = 'ERROR:' . $this->conn->error;
                        }
                    } else {
                        return $message = 'ERROR:' . $this->conn->error;
                    }
                } else {
                    return $this->conn->error;
                }
            } else {
                return $this->conn->error;
            }
        }
    }

    public function chat_data() {
        $sender = $_SESSION['client_id'];
        $receiver = $_GET['message_to'];

        $sql = "SELECT * FROM `chats` WHERE message_from ='$sender' AND message_to = '$receiver' OR message_from ='$receiver' AND message_to ='$sender' ";
        $result = $this->conn->query($sql);
        return $result;
    }

//    contact-requests

    public function phone_request_status() {
        $requested_by = $_SESSION['client_id'];
        $requested_to = $_GET['client_id'];

        $sql = "SELECT * FROM `contact_requests` WHERE requested_by = '$requested_by' AND requested_to = '$requested_to' AND requested_for = 'phone' AND is_cancelled = 0";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function email_request_status() {
        $requested_by = $_SESSION['client_id'];
        $requested_to = $_GET['client_id'];

        $sql = "SELECT * FROM `contact_requests` WHERE requested_by = '$requested_by' AND requested_to = '$requested_to' AND requested_for = 'email' AND is_cancelled = 0";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function send_contact_request($data) {

        $requested_by = $_SESSION['client_id'];
        $requested_to = $_GET['client_id'];
        $id = "request@" . date("d-m-Y") . '?' . date("H:i:s");
        $datetime = date("l ,F j, Y, g:i:s a");

        $sql = "INSERT INTO `contact_requests`(`request_id`, `requested_by`, `requested_to`, `requested_for`, `request_datetime`, `request_status`) VALUES"
                . " ('$id','$requested_by','$requested_to','$data[requested_for]','$datetime', 1)";

        if ($this->conn->query($sql) === TRUE) {
            $success = "<script type='text/javascript'>alert('Request Sent!');document.location='';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function phone_requests() {
        $requested_to = $_SESSION['client_id'];

        $sql = "SELECT * FROM `contact_requests` WHERE requested_to = '$requested_to' AND requested_for = 'phone' AND request_status = 1 ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function email_requests() {
        $requested_to = $_SESSION['client_id'];

        $sql = "SELECT * FROM `contact_requests` WHERE requested_to = '$requested_to' AND requested_for = 'email' AND request_status = 1 ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function accept_contact_requests($data) {
        $sql = "UPDATE `contact_requests` SET `request_status`= 0 ,`is_accepted`= 1 WHERE request_id = '$data[request_id]'";

        if ($this->conn->query($sql) === TRUE) {
            $success = "<script type='text/javascript'>alert('Request Accepted!');document.location='';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function cancel_contact_requests($data) {
        $sql = "UPDATE `contact_requests` SET `request_status`= 0 ,`is_cancelled`= 1 WHERE request_id = '$data[request_id]'";

        if ($this->conn->query($sql) === TRUE) {
            $success = "<script type='text/javascript'>alert('Request Cancelled!');document.location='';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

//    purchase package

    public function purchase_package($data) {

        $client_id = $_SESSION['client_id'];

        if ($data['package_name'] == 'Bronze') {
            $rank = 1;
        } elseif ($data['package_name'] == 'Silver') {
            $rank = 2;
        } elseif ($data['package_name'] == 'Gold') {
            $rank = 3;
        } elseif ($data['package_name'] == 'Platinum') {
            $rank = 4;
        }

        date_default_timezone_set("Asia/Dhaka");

        $starting = date("Y-m-d");
        $starting_datetime = date("l ,F j, Y ");

        $ending = date('Y-m-d', strtotime($starting . ' + 30 days'));
        $ending_datetime = date('l ,F j, Y ', strtotime($starting_datetime . ' + 30 days'));

        $sql = "SELECT `message_limit`, `view_limit`, `request_limit` FROM `packages` WHERE package_name = '$data[package_name]'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $message_limit = $row['message_limit'];
            $view_limit = $row['view_limit'];
            $request_limit = $row['request_limit'];
        }

        $query = "INSERT INTO `premium`(`client_id`, `package_name`, `initiated_at`,`initiated_datetime`, `validate_to`,`validate_datetime`, `message_limit`,`view_limit`, `request_limit` ) VALUES "
                . "('$client_id','$data[package_name]','$starting','$starting_datetime','$ending','$ending_datetime','$message_limit','$view_limit','$request_limit')";
        if ($this->conn->query($query) === TRUE) {
            $sql = "UPDATE `clients` SET `priority_level`='$rank',`payment_status`='1' WHERE client_id = '$client_id'";
            if ($this->conn->query($sql) === TRUE) {
                $sql = "UPDATE `premium` SET `status`= 0 WHERE client_id = '$client_id' AND id < (SELECT id FROM `premium` WHERE client_id = '$client_id' AND status = 1 ORDER BY id DESC limit 1) ";
                if ($this->conn->query($sql) === TRUE) {
                    $success = "<script type='text/javascript'>alert('ok!');document.location='';</script>";
                    return $success;
                } else {

                }
            }
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function premium_data() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT * FROM `premium` WHERE client_id = '$client_id' AND status = 1 ORDER BY id DESC limit 1 ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function all_premium_data() {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT * FROM `premium` WHERE client_id = '$client_id' ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function package_expiration() {
        $client_id = $_SESSION['client_id'];

        date_default_timezone_set("Asia/Dhaka");

        $sql = "SELECT validate_to FROM `premium` WHERE client_id = '$client_id' ORDER BY id DESC limit 1 ";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $validate_to = $row['validate_to'];
            }
        } else {
            $validate_to = date("Y-m-d");
        }

        $today = date("Y-m-d");

        if ($today > $validate_to) {
            $sql = "UPDATE `premium` SET status = 0 WHERE client_id = '$client_id' ORDER BY id DESC limit 1 ";

            if ($this->conn->query($sql) === TRUE) {
                $sql = "UPDATE `clients` SET payment_status = 0 , priority_level = 0 WHERE client_id = '$client_id' AND status = 1";
                if ($this->conn->query($sql) === TRUE) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

//    notifications

    public function message_seen($person) {
        $client_id = $_SESSION['client_id'];
        $sql = "UPDATE `notifications` SET `is_seen`= 1 WHERE notification_to = '$client_id' AND notification_from = '$person'";
        if ($this->conn->query($sql) === TRUE) {

        } else {

        }
    }

    public function message_notification(){
        $client_id = $_SESSION['client_id'];

        $sql = "SELECT * FROM `notifications` WHERE notification_to = '$client_id' AND is_seen = 0 ORDER BY id DESC ";
        $result = $this->conn->query($sql);
        return $result;
    }

}
