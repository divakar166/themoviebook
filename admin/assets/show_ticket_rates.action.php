<?php

include_once ('../db_config.php');
if(isset($_POST['category'])){
	$show_id = $_POST['category'];
	$sql_check = "SELECT * FROM tbl_show_ticket_rates WHERE show_id = '$show_id'";
	$query_check = $db->query($sql_check);
	if(mysqli_num_rows($query_check) == 0){
		$sql = "SELECT * FROM tbl_shows WHERE show_id = '$show_id'";
		$result = $db->query($sql);
		while ($row = mysqli_fetch_assoc($result)){
			$theatre_id = $row['theatre_id'];
			$screen = $row['screen'];
			$inner_sql = "SELECT * FROM tbl_theatre_seat_categories WHERE theatre_id = '$theatre_id' AND screen = '$screen'";
			$inner_res = $db->query($inner_sql);
			$inner_return = mysqli_num_rows($inner_res);
			if ($inner_return == 0) {
				echo "None";
			}else{
				while ($inner_row = mysqli_fetch_assoc($inner_res)) {
					$arr =  $inner_row['category_name'];
					echo $arr;
				}
			}
		}
	}else{
		echo 'Already';
	}
}

if(isset($_POST['cat'])){
	$id = $_POST['cat'];
	$sql = "SELECT * FROM `tbl_common_seat_categories` WHERE `category_id` = '$id'";
	$result = $db->query($sql);
	while($row = mysqli_fetch_assoc($result)){
		$name = $row['category_name'];
	}
	echo $name;
}

if(isset($_POST['ticket_dlt'])){
	$id = $_POST['ticket_dlt'];
	$sql = "DELETE FROM tbl_show_ticket_rates WHERE ticket_rate_id = '$id'";
	$result = $db->query($sql);
	if($result){
		echo "Success";
	}else{
		echo 'Error';
	}
}

?>