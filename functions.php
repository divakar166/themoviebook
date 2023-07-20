<?php 


function getMovies($db){
    $sql_list = "SELECT * FROM tbl_movies";
    $result_list = mysqli_query($db, $sql_list);
    while($row = mysqli_fetch_assoc($result_list))
    {
        echo '<option value='.$row['movie_id'].'>'.$row['movie_name'].'</option>' ;
    }
}

function getMovieName($db,$id){
    $sql = "SELECT * FROM tbl_movies WHERE movie_id = '$id'";
    $result = mysqli_query($db,$sql);
    while($row = mysqli_fetch_assoc($result)){
        echo $row['movie_name'];
    }
}

function getMoviePoster($db,$id){
    $sql = "SELECT * FROM tbl_movies WHERE movie_id = '$id'";
    $result = mysqli_query($db,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $img_data = $row['poster'];
    }
    return $img_data;
}

function getTheatreName($db,$id){
    $sql = "SELECT * FROM tbl_theatres WHERE theatre_id = '$id'";
    $result = mysqli_query($db,$sql);
    while($row = mysqli_fetch_assoc($result)){
        echo $row['theatre_name'] .' '.$row['city'];
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

function getTicketRates($db,$cat,$id){
    $sql = "SELECT * FROM tbl_show_ticket_rates WHERE ticket_category_id='$id'";
    $result = $db->query($sql);
    while($row = mysqli_fetch_assoc($result)){
        $category = json_decode($row['category']);
        $rates = json_decode($row['ticket_rate']);
    }
    for ($i=0; $i < count($category); $i++) { 
        if($category[$i] == $cat){
            return $rates[$i];
        }
    }
}

function getSeatCatID($db,$theatreID,$screen){
    $sql = "SELECT * FROM tbl_theatre_seat_categories WHERE theatre_id='$theatreID' AND screen='$screen'";
    $result = $db->query($sql);
    while($row = mysqli_fetch_assoc($result)){
        return $row['seat_category_id'];
    }
}

function getBookTickets($db,$date,$time,$showID,$movieID,$theatreID){
    $arr = [];
    $sql = "SELECT * FROM tbl_booking WHERE showdate='$date' AND showtime='$time' AND show_id='$showID' AND movie_id='$movieID' AND theatre_id='$theatreID' ";
    $result = $db->query($sql);
    if($result){
        $row_count=mysqli_num_rows($result);
        if ($row_count > 0){
            while ($row = mysqli_fetch_assoc($result)){
                array_push($arr,$row['seats']);
            }
            echo implode(',',$arr);
        }else{
            echo 'none';
        }
    }
}

function convertTime($db,$time){
    $int_time = (int)filter_var($time);
    $hours = intdiv($int_time,60).'HR '. ($int_time % 60) . 'MIN' ;
    echo $hours;
}

function getDateDay($date){
    $d = strtotime($date);
    echo date('D, j M',$d);
}

?>