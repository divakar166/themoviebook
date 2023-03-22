<?php

include_once ('../db_config.php');

$show_id = $_POST['show'];
$showtimeArray = $_POST['showtime'];
$showtime = json_encode($showtimeArray);
$sql_check = "SELECT * FROM tbl_showtimes WHERE show_id = '$show_id' AND starting_time = '$showtime'";
$query_check=mysqli_query($db,$sql_check);
$rowCount_check = mysqli_num_rows($query_check);
if($rowCount_check == 0){
	$sql = "INSERT INTO tbl_showtimes(show_id,starting_time) VALUES('$show_id','$showtime')";
	$result = $db->query($sql);
	if($result){
		echo "Success";
	}else{
		echo "Error";
	}
}else{
	echo "Already";
}



?>