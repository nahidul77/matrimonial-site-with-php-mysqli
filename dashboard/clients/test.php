<?php
 $conn = new mysqli('localhost', 'root', '', 'matrimony');

$sql = "INSERT INTO `clients`(`first_name`, `last_name`, `birthday`, `gender`, `phone`, `email`, `client_id`, `religion`, `marital_status`, `age`, `nationality`, `interest`, `hobby`, `blood_group`, `smoking`, `father_status`, `mother_status`, `total_member`, `family_type`, `about_family`, `permanent_address`, `present_address`, `country`, `division`, `postal_code`, `state`, `current_country`, `current_city`, `education_details`, `education`, `professional_sector`, `profession`, `income`, `height`, `weight`, `physical_condition`, `biography`, `username`, `password`, `propic`, `joining_date`,`profile_status`) VALUES"
        . " ('Emma','Islam','26/04/94','Women','01521493074','emma@gmail.com','client@1234','Islam','Unmarried','25','Bangladeshi','X','x','0+','Non-smoker','Employed','Employed','4','Joint','asdasd dsaas','sadsadas dsad','asd asd asa','Bangladesh','Dhaka','2050','xxx','Bangladesh','Dhaka','emma1','1','xxx','xxx','xxx','0')";

if($conn->query($sql) === TRUE){
    echo 'INserted';
}else{
    echo $conn->error;
}