<?php

include_once ('../db_config.php');
$id = $_POST['d_id'];
$sql = "DELETE FROM tbl_theatre_seat_categories WHERE seat_category_id = '$id'";
$result = $db->query($sql);
if($result){
	$sql_seat = "DELETE FROM tbl_seat_maps WHERE seat_category_id = '$id'";
	$seat_result = $db->query($sql_seat);
	if($seat_result){
		echo "Success";
	}else{
		echo "Error";
	}
}

?>