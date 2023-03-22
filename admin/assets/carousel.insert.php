<?php
include_once ('../db_config.php');

$movie_id = $_POST['movie_id'];
$image = $_POST['carousel'];

$sql_check = "SELECT * FROM tbl_carousel WHERE movie_id = '$movie_id'";
$query_check=mysqli_query($db,$sql_check);
$rowCount_check = mysqli_num_rows($query_check);
if($rowCount_check == 0){
    $sql = "INSERT INTO tbl_carousel (movie_id,carousel_image) VALUES ('$movie_id','$image')";
    $db->query($sql);
    echo "success";
}

?>