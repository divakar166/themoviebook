<?php

include_once ('../db_config.php');

$showID = $_POST['edit_id'];
$s_date = $_POST['edit_startDate'];
$starting_date = date("Y-m-d",strtotime($s_date));
$e_date = $_POST['edit_endDate'];
$ending_date = date("Y-m-d",strtotime($e_date));
$sql = "SELECT * FROM tbl_shows WHERE show_id = '$showID'";
$result = $db->query($sql);
while($row = mysqli_fetch_assoc($result)){
	if($row['starting_date'] >= $starting_date){
		echo "StartAlert";
	}else{
		$update_sql = "UPDATE tbl_shows SET starting_date = '$starting_date', ending_date = '$ending_date' WHERE show_id = '$showID'";
		$update_result = $db->query($update_sql);
		if($update_result){
			echo "Success";
		}else{
			echo "Error";
		}
	}
}

?>