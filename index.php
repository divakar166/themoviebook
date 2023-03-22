<?php
  session_start();
  include_once ('db_config.php');
  date_default_timezone_set("Asia/Kolkata");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="css/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="css/movies_slider.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
	<link rel="shortcut icon" type="image/png" href="images/icon.png">
	<title>theMovieBook</title>
	<style>
		a{
			text-decoration:none;
			color:#fff;
		}
		a:hover{
			text-decoration:none;
			color:#fff;
		}
	</style>

	</head>


<body>

	<?php include('header.php');
	
	function make_query($db){
		$query = "SELECT A.movie_id, A.carousel_image, B.movie_name,B.trailer_url FROM tbl_carousel A, tbl_movies B WHERE A.movie_id = B.movie_id ORDER BY A.id ASC";
		$result = mysqli_query($db, $query);
		return $result;
	}

	function make_slide_indicators($db){
		$output = '';
		$count = 0;
		$result = make_query($db);
		if(mysqli_num_rows($result)>0) {
			while($row = mysqli_fetch_array($result))
			{
				if($count == 0){
					$output .= '<li data-target="#carouselExampleIndicators" data-slide-to="'.$count.'" class="active"></li>';
				}else{
					$output .= '<li data-target="#carouselExampleIndicators" data-slide-to="'.$count.'"></li>';
				}
				$count = $count + 1;
			}
		}
		return $output;
	}


	function make_slides($db){
		$output = '';
		$count = 0;
		$result = make_query($db);
		if(mysqli_num_rows($result)>0) {
			while($row = mysqli_fetch_array($result))
			{
				if($count == 0){
						$output .= '<div class="carousel-item active">';
				}else{
						$output .= '<div class="carousel-item">';
				}
				$output .= '
				<div><img class="d-block" width="700px" src="'.$row['carousel_image'].'" alt="'.$row["movie_name"].'" /></div>
				<div class="carousel-caption d-none d-md-block">
					<p>
					<button class="name_btn btn-lg" disabled>'.$row['movie_name'].'</button>
					</p>
					<p>
						<button class="trailer_btn btn-lg btn" value="'.$row['trailer_url'].'">WATCH TRAILER</button>
						<button class="btn-2 btn-lg btn" value="'.$row['movie_id'].'"><a class="btn-booking" href="buy_tickets.php?movieID='.$row['movie_id'].'">Buy Tickets</a></button>
					</p>
					</div>
				</div>';
				$count = $count + 1;
			}
		}
		return $output;
	}
	?>

	<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" data-interval="60000000">
			<ol class="carousel-indicators">
					<?php echo make_slide_indicators($db); ?>
			</ol>

			<div class="carousel-inner">
					<?php echo make_slides($db); ?>
				</div>

			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<img src="images/buttons/prev_button_1.png">
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<img src="images/buttons/next_button_1.png">
			</a>
	</div>


		<?php
			$sql_nowshowing = "SELECT * FROM tbl_movies WHERE `status` = 1 AND DATEDIFF(starting_date, NOW())<=0";
			$result_nowshowing = mysqli_query($db,$sql_nowshowing);
			$rowCount_nowshowing = mysqli_num_rows($result_nowshowing);
			if($rowCount_nowshowing>0) {
		?>

		<div class="now_showing">
			<div class="container mt-3">
				<div class="row">
					<div class="col-md-12 showingTitle">
						<h1>Now Showing</h1>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="owl-carousel owl-theme" style="padding: 0 70px;">
						<?php while($row_nowshowing = $result_nowshowing->fetch_assoc()){
						?>

						<div class="item">
							<div class="card">
								<a href="movie.php?movie_id=<?php echo $row_nowshowing['movie_id'];?>">
									<?php 
									echo '<img class="card-img-top" src="'.$row_nowshowing['poster'].'">';
									?>
								</a>
								<div class="card-body">
									<a class="movie_name" href="movie.php?movie_id=<?php echo $row_nowshowing['movie_id'];?>"><h5><?php echo $row_nowshowing['movie_name'] ?></h5></a>
									<a class="btn btn-booking btn-danger" href="buy_tickets.php?movieID=<?php echo $row_nowshowing['movie_id'] ?>">Buy Tickets</a>
								</div>
							</div>
						</div>

						<?php } ?>

						</div>
					</div>
				</div>

			</div>
		</div>

		<?php } ?>

		<?php
		$sql_upcoming = "SELECT * FROM tbl_movies WHERE DATEDIFF(starting_date, NOW())>0";
		$result_upcoming = mysqli_query($db,$sql_upcoming);
		$rowCount_upcoming = mysqli_num_rows($result_upcoming);
		if($rowCount_upcoming>0) {
		?>

		<div class="upcoming_movies" style="padding-bottom:15px">
			<div class="container mt-3">
				<div class="row">
					<div class="col-md-12 showingTitle">
						<h1>Upcoming Movies</h1>
					</div>
				</div>


			<div class="container">
				<div class="row">
					<div class="owl-carousel owl-theme" style="padding: 0 70px;">
						<?php while($row_upcoming = $result_upcoming->fetch_assoc()){
						?>

						<div class="item">
							<div class="card">
								<a href="movie.php?movie_id=<?php echo $row_upcoming['movie_id'];?>">
									<?php 
									echo '<img class="card-img-top" src="'.$row_upcoming['poster'].'">';
									?>
								</a>
								<div class="card-body">
									<a class="movie_name" href="movie.php?movie_id=<?php echo $row_upcoming['movie_id'];?>">
										<h5><?php echo $row_upcoming['movie_name'] ?></h5>
									</a>
									<a class="btn btn-booking btn-danger <?php 
									if($row_upcoming['release_status']=!'Released'){echo 'disabled';} ?>" <?php if($row_upcoming['status']=='1'){echo 'href="buy_tickets.php?movieID='.$row_upcoming['movie_id'].'"';}?>><?php if($row_upcoming['status']==0){echo 'Tickets not available!';}else{echo 'Buy Tickets';} ?></a>
								</div>
							</div>
						</div>

						<?php } ?>

					</div>
				</div>
			</div>

		</div>
		</div>

		<?php } ?>

	<?php include('footer.php') ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
	<script src="js/owl.carousel.js"></script>
	<script src="js/bootstrap.min.js"></script>


	<script>
		$('.owl-carousel').owlCarousel({
			loop:false,
			margin:10,
			nav:true,
			navText: ["<img src='images/buttons/prev_button.png'>","<img src='images/buttons/next_button.png'>"],
			dots:false,
			mouseDrag:false,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:3
				},
				1000:{
					items:4
				}
			}
		})
	</script>


<!-- <script>
	var owl = $('.owl-carousel');
	owl.owlCarousel();
	$('.nextButton').click(function(){
		owl.trigger('next.owl.carousel');
	})

	$('.prevButton').click(function(){
		owl.trigger('prev.owl.carousel', [300])
	})
</script> -->


	<script>
		$(".header_wrapper .main_menu_wrapper .item-1").addClass("active");
		$(".site-footer .bottom-footer .footer-item-1").addClass("active");
		$(document).ready(function() {
			function getId(url) {
				var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
				var match = url.match(regExp);
				if (match && match[2].length == 11) {
					return match[2];
				} else {
					return 'error';
				}
			}

			var $videoSrc;
			$('.trailer_btn').click(function() {
				$('#trailerModal').modal("show");
				$videoSrc = "//www.youtube.com/embed/" + getId($(this).val());
			});

			$('#trailerModal').on('shown.bs.modal', function (e) {
				$("#video").attr('src',$videoSrc + "?autoplay=0&amp;modestbranding=1&amp;showinfo=0" );
			})
			$('#trailerModal').on('hide.bs.modal', function (e) {
				$videoSrc = "";
				$("#video").attr('src',$videoSrc);
			})
		});
	</script>

	<div class="modal fade" id="trailerModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
