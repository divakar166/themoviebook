<?php
	include_once ('../db_config.php');

    if(isset($_POST['save'])){
		$movie_name = trim($_POST['movie_name']);
		$movie_name = mysqli_real_escape_string($db, $movie_name);

		$status = trim($_POST['status']);
		$status = mysqli_real_escape_string($db, $status);

		$movie_id = trim($_POST['movie_id']);
		$movie_id = mysqli_real_escape_string($db, $movie_id);

		$startDate = trim($_POST['startDate']);
		$startDate = mysqli_real_escape_string($db, $startDate);

		$endDate = trim($_POST['endDate']);
		$endDate = mysqli_real_escape_string($db, $endDate);

        $query = "UPDATE tbl_movies SET movie_name = '$movie_name', starting_date = '$startDate',ending_date = '$endDate', `status` = '$status' WHERE movie_id = '$movie_id'";
		$success = mysqli_query($db,$query);
		
		if($success){
			header('Location: ../movies.php');
		}else{
			echo "error";
		}
	}
?>