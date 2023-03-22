<?php
include_once ('../db_config.php');

$movie_id = $_POST['movie_id'];
$theatre_id = $_POST['theatre_id'];
$screen = $_POST['screen'];
$s_date = $_POST['start_date'];
$starting_date = date('Y-m-d',strtotime($s_date));
$e_date = $_POST['end_date'];
$ending_date = date('Y-m-d',strtotime($e_date));

$sql_check = "SELECT * FROM tbl_shows WHERE theatre_id = '$theatre_id' AND movie_id = '$movie_id' AND screen = '$screen'";
$query_check=mysqli_query($db,$sql_check);
$rowCount_check = mysqli_num_rows($query_check);
if($rowCount_check == 0){
    $sql = "INSERT INTO tbl_shows (theatre_id,movie_id,screen,starting_date,ending_date) VALUES ('$theatre_id','$movie_id','$screen','$starting_date','$ending_date')";
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