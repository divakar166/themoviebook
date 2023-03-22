<?php

include_once ('../db_config.php');

$showtime = json_encode($_POST['editshowtime']);
$show_id = $_POST['show_id'];
$sql = "UPDATE tbl_showtimes SET starting_time = '$showtime' WHERE show_id = '$show_id'";
$result = $db->query($sql);
if($result){
	echo "Success";
}else{
	echo "Error";
}

?>