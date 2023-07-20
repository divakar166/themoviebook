<?php
include_once ('../db_config.php');
	if(isset($_POST['dlt'])){
		$movie_id = $_POST['movie_id'];
		
	$query = "DELETE FROM tbl_movies WHERE movie_id = '$movie_id'";
	$result = mysqli_query($db, $query);
	if(!$result){
		exit;
	}
	header("Location: ../movies.php");
	}
?>
 