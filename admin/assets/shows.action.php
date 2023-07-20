<?php

include_once ('../db_config.php');

if(isset($_POST['getScreen'])){
	$id = $_POST['getScreen'];
	$sql = "SELECT * FROM tbl_theatres WHERE theatre_id = '$id'";
	$result = $db->query($sql);
	$html = '';
	$html .= "<option value='0'>Select Screen</option>";
	while ($row = mysqli_fetch_assoc($result)) {
		for ($i=1; $i <= $row['screens'] ; $i++) { 
			$html .= "<option value='{$i}'>Screen {$i}</option>";
		}
	}
	echo $html;
}
if (isset($_POST['checkScreen'])) {
	$screen = $_POST['checkScreen'];
	$id = $_POST['id'];
	$sql = "SELECT * FROM tbl_shows WHERE theatre_id = '$id'  AND screen = '$screen'";
	$result = $db->query($sql);
	if(mysqli_num_rows($result) != 0){
		echo "Already";
	}else{
		echo 'Nothing';
	}
}
if(isset($_POST['dltShow'])){
	$id = $_POST['dltID'];
	$sql = "DELETE FROM tbl_shows WHERE show_id = '$id'";
	$result = $db->query($sql);
	if($result){
		echo "Success";
	}else{
		echo "Error";
	}
}

?>