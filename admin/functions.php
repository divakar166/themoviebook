<?php

function getTheatre($db){
	$sql_list = "SELECT * FROM tbl_theatres";
    $result_list = mysqli_query($db, $sql_list);
    while($row = mysqli_fetch_assoc($result_list))
    {
        echo '<option value='.$row['theatre_id'].'>'.$row['theatre_name'].' - '.$row['city'].'</option>' ;
    }
}

function get_ticketID($db,$id){
	$sql = "SELECT A.seat_category_id FROM tbl_theatre_seat_categories A, tbl_shows B WHERE A.theatre_id = B.theatre_id AND A.screen = B.screen AND B.show_id = '$id'";
	$result = mysqli_query($db,$sql);
	while($row = mysqli_fetch_assoc($result)){
		return $row['seat_category_id'];
	}
}


function get_admin_name($db,$id){
	$sql = "SELECT * FROM `tbl_admins` WHERE `admin_id` = '$id'";
	$result = mysqli_query($db,$sql);
	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_assoc($result)){
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
		}
		return $first_name.' '.$last_name;
	}
}

function getTheatreID($db,$name){
	$sql = "SELECT `theatre_id` FROM `tbl_theatres` WHERE `theatre_name` = '$name'";
	$result = mysqli_query($db,$sql);
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$id = $row['theatre_id'];
			return $id;
		}
	}
}

function get_category_name($db,$id){
	$sql = "SELECT * FROM tbl_common_seat_categories WHERE category_id = '$id'";
	$result = $db->query($sql);
	while($row = mysqli_fetch_assoc($result)){
		$name = $row['category_name'];
	}
	return $name;
}

function getMovies($db){
	$sql = "SELECT * FROM tbl_movies";
	$result = $db->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<option value='".$row['movie_id']."'>".$row['movie_name']."</option>";
	}
}

function changeArray($data){
	$assoc = array();
	foreach (array_chunk($data, 2) as $pair) {
		list($key,$value) = $pair;
		$assoc[$key] = $value;
	}
	return $assoc;
}

function getCategory($db){
	$sql = "SELECT * FROM tbl_common_seat_categories";
	$result = mysqli_query($db,$sql);
	echo '<option value="0">Select Category</option>';
	while($row = mysqli_fetch_assoc($result)){
		echo '<option value="'. $row['category_id'] .'">'. $row['category_name'] .'</option>';
	}
}

function getCategoryArray($db){
	$sql = "SELECT category_name FROM tbl_common_seat_categories";
	$result = $db->query($sql);
	$array = [];
	while($row = mysqli_fetch_assoc($result)){
		array_push($array, $row['category_name']);
	}
	return $array;
}

function getMovie($db){
	$sql = "SELECT * FROM tbl_movies";
	$result = $db->query($sql);
	while($row = mysqli_fetch_assoc($result)){
		echo "<option value='{$row['movie_id']}'>{$row['movie_name']}</option>";
	}
}


function getShows($db){
	$sql = "SELECT A.show_id,A.screen,B.movie_name,C.theatre_name,C.city FROM tbl_shows A,tbl_movies B,tbl_theatres C WHERE A.movie_id = B.movie_id AND A.theatre_id = C.theatre_id ORDER BY B.movie_id ASC";
	$result = $db->query($sql);
	while($row = mysqli_fetch_assoc($result)){
		echo "<option value='{$row['show_id']}'>{$row['movie_name']} - {$row['theatre_name']} , {$row['city']} (Screen {$row['screen']} )</option>";
	}
}

?>
