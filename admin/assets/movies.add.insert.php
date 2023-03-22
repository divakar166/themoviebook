<?php
	include_once ('../db_config.php');

    if(isset($_POST['movie_name'])){
		$movie_name = trim($_POST['movie_name']);
		$movie_name = mysqli_real_escape_string($db, $movie_name);

		$year = trim($_POST['movie_year']);
		$year = mysqli_real_escape_string($db, $year);
		
		$category = trim($_POST['movie_category']);
		$category = mysqli_real_escape_string($db, $category);

		$language = trim($_POST['movie_language']);
		$language = mysqli_real_escape_string($db, $language);
		
		$casts = trim($_POST['movie_cast']);
		$casts = mysqli_real_escape_string($db, $casts);
		
		$director = trim($_POST['movie_director']);
	    $director = mysqli_real_escape_string($db, $director);

	    $synopsis = trim($_POST['movie_overview']);
	    $synopsis = mysqli_real_escape_string($db, $synopsis);

	    $poster = trim($_POST['poster']);
	    $banner = trim($_POST['banner']);
	    $trailer = trim($_POST['movie_video_url']);
		
		$release_date = trim($_POST['movie_release']);
		$release_date = mysqli_real_escape_string($db, $release_date);

		$running_time = trim($_POST['movie_runtime']);
		$running_time = mysqli_real_escape_string($db, $running_time);

		$status = trim($_POST['status']);
		$status = mysqli_real_escape_string($db, $status);
     
		$starting_date = trim($_POST['start_date']);
		$start_date = date('Y-m-d',strtotime($starting_date));

		$ending_date = trim($_POST['end_date']);
		$end_date = date('Y-m-d',strtotime($ending_date));

        $query="INSERT INTO tbl_movies (movie_name,year,category,language,casts,director,synopsis,release_date,running_time,poster,banner,trailer_url,status,starting_date,ending_date) VALUES('$movie_name','$year','$category', '$language','$casts','$director','$synopsis','$release_date','$running_time','$poster','$banner','$trailer','1','$start_date','$end_date')";
		
		$result = mysqli_query($db,$query);
		if($result){
			echo 'Success';
		}else{
			echo "Error";
		}
        
	}
?>