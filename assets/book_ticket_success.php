<?php

include_once('../db_config.php');

date_default_timezone_set("Asia/Colombo");
$paymentTime = time();
$bookingTime = date('Y-m-d H:i:s',$paymentTime);
if(isset($_POST['movie_id'])){
    $movieID = $_POST['movie_id'];
    $userID = $_POST['user_id'];
    $theatreID = $_POST['theatre_id'];
    $showID = $_POST['show_id'];
    $seat_cat = $_POST['seat_cat'];
    $seats = $_POST['seats'];
    $screen = $_POST['screen'];
    $showdate = $_POST['showdate'];
    $showtime = $_POST['showtime'];
    $amount = $_POST['amount'];
    $payment = True;
    $sql = "SELECT * FROM `tbl_booking` WHERE user_id = '$userID' AND movie_id='$movieID' AND theatre_id='$theatreID' AND show_id='$showID' AND seat_cat='$seat_cat' AND seats='$seats' AND showdate='$showdate' AND showtime='$showtime'";
    $check = $db->query($sql);
    if(mysqli_fetch_row($check) == 0){
        $sql = "INSERT INTO `tbl_booking`(`timestamp`, `user_id`, `movie_id`, `theatre_id`, `show_id`, `seat_cat`, `seats`, `screen`, `showdate`, `showtime`, `amount`, `payment_status`) VALUES ('$bookingTime','$userID','$movieID','$theatreID','$showID','$seat_cat','$seats','$screen','$showdate','$showtime','$amount','$payment')";
        $result = $db->query($sql);
        if($result){
            $sql = "SELECT * FROM tbl_booking WHERE user_id='$userID' AND movie_id = '$movieID' AND show_id = '$showID' AND showdate='$showdate' AND seats = '$seats'";
            $result = $db->query($sql);
            while($row = mysqli_fetch_assoc($result)){
                echo $row['ticket_id'];
            }
        }else{
            echo 'Error';
        }
    }else{
        echo 'Error';
    }
    
}

?>