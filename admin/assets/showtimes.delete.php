<?php

include_once ('../db_config.php');
$id = $_POST['show_id'];
$sql = "DELETE FROM tbl_showtimes WHERE show_id = '$id'";
$result = $db->query($sql);
if($result){
	echo 'Success';
}else{
	echo 'Error';
}
?>