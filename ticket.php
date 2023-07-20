<?php
    session_start();

    include_once ('db_config.php');
    include_once ('functions.php');
    include_once ('phpqrcode/qrlib.php');
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT A.ticket_id, B.movie_name, B.language, B.running_time,B.poster, C.address, A.showdate, A.showtime, A.seats, A.seat_cat, A.screen FROM tbl_booking A, tbl_movies B, tbl_theatres C  WHERE A.ticket_id='$id' AND A.movie_id=B.movie_id AND A.theatre_id = C.theatre_id";
        $result = $db->query($sql);
        while($row = mysqli_fetch_assoc($result)){
            $movie_name = $row['movie_name'];
            $lang = $row['language'];
            $time = $row['running_time'];
            $add = $row['address'];
            $showdate = $row['showdate'];
            $showtime = $row['showtime'];
            $poster = $row['poster'];
            $seats = $row['seats'];
            $seat_cat = $row['seat_cat'];
            $screen = $row['screen'];
            $QRData = "Movie: ".$movie_name. ", Showtime: ". $showtime . ", Seat: " . $seats;
            $filename = 'qrcode_'.$id.'.png';
            QRCode::png($QRData,'images/'.$filename,QR_ECLEVEL_L,4);
        }
	
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!--Bootstrap Fullscreen Modal CSS-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap4-modal-fullscreen.min.css">
    <!--JQuery-UI CSS-->
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">

    <!--Owl Carousel CSS-->
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
    
    <!--Custom Style CSS-->
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/movies_slider.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">

    <!--Favicon Image-->
    <link rel="shortcut icon" type="image/png" href="images/icon.png">
    
    <title>theMovieBook</title>
    <style>
        .ticket_container{
            margin: 5rem 10px 10px 10px;
            display: flex;
            justify-content: center;
            align-items:center;
        }
        .ticket_inner{
            width: 600px;
            height: 87vh;
            background-color:#fff;
            padding: 10px;
            border-radius:10px;
        }
        .header{
            font-size:25px;
        }
        .ticket{
            display: flex;
            justify-content: center;
            flex-direction:column;
            margin: 10px 0;
        }
        .ticket .upper{
            display: flex;
            justify-content: space-between;
        }
        .ticket .upper .left .title{
            font-size:2rem;
            font-weight:bold;
            line-height:1;
            padding: 10px 0 5px 0;
        }
        .tags{
            display: flex;
            margin: 10px 0;
        }
        .tag{
            padding: 5px;
            background-color:gray;
            margin: 0px 2px;
            border-radius:5px;
            font-size:14px;
        }
        .address{
            font-size:18px;
            margin: 10px 0;
        }
        .date_day{
            padding: 0 0 0 4px;
        }
        .time{
            font-size:2rem;
        }
        .right .movie_poster img{
            border-radius:10px;
        }
        .middle{
            display: flex;
            justify-content: center;
            align-items:center;
        }
        .below{
            display: flex;
            justify-content: space-between;
        }
        .below .left{
            display: flex;
            justify-content: center;
            flex-direction:column;
        }
        .below .left .screen{
            font-size:2rem;
            font-weight:bold;
        }
        .below .left .seats{
            font-size:2rem;
            font-weight:bold;
        }
        .divider{
            margin: 10px 0;
        }
    </style>

</head>
<body>
    <?php include('header.php'); ?>
    <div class="ticket_container" >
        <?php } ?>
        <div class="ticket_inner">
            <div class="header">Ticket Confirmed <img src="images/checked.png" height='20'> </div>
            <div class="ticket">
                <div class="upper">
                    <div class="left">
                        <div class="title"><?php echo $movie_name; ?></div>
                        <div class="tags">
                            <div class="tag"><?php echo convertTime($db,$time); ?></div>
                            <div class="tag"><?php echo $lang; ?></div>
                        </div>
                        <div class="address"><img src="images/direction.png" height='20' alt="">&nbsp;<?php echo $add; ?></div>
                        <div class="date_day"><?php echo getDateDay($showdate); ?></div>
                        <div class="time"><?php echo $showtime; ?></div>
                    </div>
                    <div class="right">
                        <div class="movie_poster">
                            <img src="<?php echo $poster; ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="middle">
                    <div class="divider">SCAN QR CODE AT CINEMA</div>
                </div>
                <div class="below">
                    <div class="left">
                        <div style="font-size:18px;">Screen</div>
                        <div class="screen">Audi <?php echo $screen; ?></div>
                        <div style="font-size:18px;">Seats</div>
                        <div class="seats"><?php echo $seat_cat.' - '.$seats; ?></div>
                    </div>
                    <div class="right">
                        <div class="qr">
                            <img src="images/<?php echo $filename; ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="booking_id"></div>
            </div>
        </div>
    </div>
    
	<?php include('footer.php') ?>

	<script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.toast.min.js"></script>
</body>
</html>