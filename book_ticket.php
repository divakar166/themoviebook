<?php
    session_start();

    include_once ('db_config.php');
    include_once ('functions.php');
    if(isset($_GET['ticket_id'])){
        echo $_GET['ticket_id'];
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

    <!--Favicon Image-->
    <link rel="shortcut icon" type="image/png" href="images/icon.png">
    
    <title>theMovieBook</title>

</head>
<body>

    <div class="ticket_payment" >
        
    </div>

	<script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.toast.min.js"></script>
</body>
</html>