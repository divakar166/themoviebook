<?php

include_once ('../db_config.php');
include_once('../functions.php');

if(isset($_POST['theatre_name'])){
	$name = $_POST['theatre_name'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$mobile = $_POST['telephone'];
	$website = $_POST['website'];
	$screen = $_POST['screen'];
	$status = $_POST['status'];
	$image = 'https://filminformation.com/wp-content/uploads/2020/05/cinemaschembakassery-cinemas-irinjalakuda-thrissur-multiplex-cinema-halls-j8dtanz7ve.jpg';
	
	$sql = "INSERT INTO tbl_theatres(theatre_name,city,address,telephone,website,image,status,screens) VALUES('$name','$city','$address','$mobile','$website','$image','$status','$screen')";
	if(mysqli_query($db,$sql)){
		echo 'Success';
	}else{
		echo 'Error';
	}
}

if(isset($_POST['theatre_dlt'])){
	$id = $_POST['theatre_dlt'];
	$sql = "DELETE FROM tbl_theatres WHERE theatre_id = '$id'";
	if(mysqli_query($db,$sql)){
		echo 'Success';
	}else{
		echo 'Error';
	}
}


if(isset($_POST['theatre_screen'])){
	$id = $_POST['theatre_screen'];
	echo getScreen($db,$id);
}

function getScreen($db,$id){
	$sql = "SELECT * FROM tbl_theatres WHERE theatre_id = '$id'";
	$result = mysqli_query($db,$sql);
	$num = mysqli_num_rows($result);
	$html = '<option value = "0">Select Screen </option>';
	while($row=mysqli_fetch_assoc($result)){
		for ($i=1; $i <= $row['screens'] ; $i++) {
			$html .= '<option value ="'. $i .'">Screen ' . $i . '</option>';
		}
	}
	
	echo $html;
}

if(isset($_POST['category'])){
	$html = '';
	$theatre_id = $_POST['category'];
	$screen = $_POST['cat_screen'];
	$sql_check = "SELECT * FROM tbl_theatre_seat_categories WHERE theatre_id = '$theatre_id' AND screen = '$screen'";
	$result = $db->query($sql_check);
	if(mysqli_num_rows($result) == 0){
		if($screen > 0){
			echo getCategory($db);
		}else{
			echo 'hide';
		}
	}else{
		$catArray = getCategoryArray($db);
		$disabled = [];
		while ($check = mysqli_fetch_assoc($result)){
			$db_array = json_decode($check['category_name']);
			$disabled = array_intersect($catArray, $db_array);
		}
		if($catArray === $disabled){
			echo 'filled';
		}else{
			$html .= '<option value="0">Select Category</option>';
			$disabled_result = array_intersect($catArray, $disabled);
			foreach($disabled_result as $d_r){
				$html .= "<option value='{$d_r}' disabled>{$d_r}</option>";
			}
			$enabled_result = array_diff($catArray, $disabled);
			foreach ($enabled_result as $e_r) {
				$html .= "<option value='{$e_r}'>{$e_r}</option>";
			}
		}
	}
	echo $html;
}


?>
