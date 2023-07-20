<?php 

include_once ('../db_config.php');

if(isset($_POST['url'])){
	$id = $_POST['url'];
	$sql = "SELECT * FROM tbl_movies WHERE movie_id = '$id'";
	$result = $db->query($sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$url = $row['banner'];
		echo $url;
	}
}


?>