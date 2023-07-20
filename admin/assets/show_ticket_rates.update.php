<?php 

include_once ('../db_config.php');

$id = $_POST['edit_show_id'];
$full = $_POST['fullRate'];
$str_full = json_encode($full);
$sql_check = "SELECT * FROM tbl_show_ticket_rates WHERE ticket_rate_id = '$id'";
$sql_result = $db->query($sql_check);
while ($row = mysqli_fetch_assoc($sql_result)) {
	$arr_full = json_decode($row['ticket_rate']);
	if($full === $arr_full){
		echo "Same";
	}else{
		$sql = "UPDATE tbl_show_ticket_rates SET ticket_rate = '$str_full' WHERE ticket_rate_id = '$id'";
		$result = $db->query($sql);
		if($result){
			echo "Success";
		}else{
			echo "Error";
		}
	}
}

?>