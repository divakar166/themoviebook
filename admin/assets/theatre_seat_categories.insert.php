<?php

include_once ('../db_config.php');

$theatre_id = $_POST['theatre_name'];
$screen = $_POST['theatre_screen'];
$num_of_rows = $_POST['row'];
$num_of_cols = $_POST['col'];
$category_name = $_POST['category'];
$seatsArray = $_POST['seatsArray'];
$num_of_seats = $_POST['seats'];
$sql_check = 0;
$query = "SELECT * FROM tbl_theatre_seat_categories WHERE theatre_id = '$theatre_id' AND screen = '$screen'";
$query_check = mysqli_query($db,$query);
if(mysqli_num_rows($query_check) == 0){
    $num_of_rows = json_encode($_POST['row']);
    $num_of_cols = json_encode($_POST['col']);
    $category_name = json_encode($_POST['category']);
    $sql = "INSERT INTO tbl_theatre_seat_categories (theatre_id,screen,category_name,num_of_rows,num_of_columns,num_of_seats) VALUES('$theatre_id','$screen','$category_name','$num_of_rows','$num_of_cols','$num_of_seats')";
    $result = $db->query($sql);
    $seat_category_id = $db->insert_id;
    if($result){
        $sql_seat_map = "INSERT INTO tbl_seat_maps (seat_category_id,seat_number) VALUES('$seat_category_id','$seatsArray')";
        $seat_result = $db->query($sql_seat_map);
        if($seat_result){
            echo "Success";
        }else{
            echo "Error";
        }
    }else{
        echo 'Error';
    }
}else{
    while ($update = mysqli_fetch_assoc($query_check)) {
        $n_cat = array_merge(json_decode($update['category_name']),$category_name);
        $new_category = json_encode($n_cat);
        $n_row = array_merge(json_decode($update['num_of_rows']),$num_of_rows);
        $new_row = json_encode($n_row);
        $n_col = array_merge(json_decode($update['num_of_columns']),$num_of_cols);
        $new_col = json_encode($n_col);
        $update_sql = "UPDATE tbl_theatre_seat_categories SET category_name = '$new_category',num_of_rows = '$new_row',num_of_columns = '$new_col',num_of_seats = '$num_of_seats' WHERE theatre_id = '$theatre_id' AND floor = '$floor' AND screen = '$screen'";
        $update_result = $db->query($update_sql);
        $seat_category_id = $db->insert_id;
        if($update_result){
            $seat_sql = "UPDATE tbl_seat_maps SET seat_number = '$seatsArray'";
            $seat_result = $db->query($seat_sql);
            if($seat_result){
                echo "Success";
            }else{
                echo "Error";
            }
        }
    }
}



// $sql_check = "SELECT * FROM tbl_theatre_seat_categories WHERE theatre_id = '$theatre_id' AND category_id = '$category_id'";
// $query_check=mysqli_query($db,$sql_check);
// $rowCount_check = mysqli_num_rows($query_check);
// if($rowCount_check == 0){
//     $sql_seat_category = "INSERT INTO tbl_theatre_seat_categories (theatre_id,category_id,category_name,num_of_rows,num_of_columns,num_of_seats) VALUES ('$theatre_id','$category_id','$category_name','$num_of_rows','$num_of_cols','$num_of_seats')";
//     $db->query($sql_seat_category);
//     $seat_category_id = $db->insert_id;

//     for ($x=0; $x<sizeof($seatsArray); $x++) {
//         $seatRowNumbers = explode(',', $seatsArray[$x]);
//         for ($y=0; $y<sizeof($seatRowNumbers); $y++) {
//             $seatNumber = $seatRowNumbers[$y];
//             $sql_seat_map = "INSERT INTO tbl_seat_maps (seat_category_id,seat_number) VALUES ('$seat_category_id','$seatNumber')";
//             $db->query($sql_seat_map);
//             echo "success";
//         }
//     }
// }

?>