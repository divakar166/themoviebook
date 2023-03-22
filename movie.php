<?php

include_once ('db_config.php');
session_start();
$movie_id = $_GET['movie_id'];
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" type="image/png" href="images/icon.png">
    
    <title>theMovieBook</title>

  </head>

    
  <body>

    <?php include('header.php'); ?>
    <div class="movie">

        <?php
        $sql_movie = "SELECT * FROM tbl_movies WHERE movie_id=$movie_id";
        $result_movie = mysqli_query($db,$sql_movie);
        if(mysqli_num_rows($result_movie) > 0){
            $row_movie = mysqli_fetch_array($result_movie);
        ?>

        <div class="banner">
            <img src="data:image/jpg;base64,<?php echo base64_encode(file_get_contents($row_movie['banner']))?>" alt="<?php echo $row_movie["movie_name"]?>">
            <div class="banner-caption">
                <p><button class="name_btn btn-lg" disabled><?php echo $row_movie['movie_name'];?></button></p>
                <p>
                    <button class="trailer_btn btn" value="'.$row['trailer'].'">WATCH TRAILER</button>
                    <?php if ($row_movie['status']=='1') { ?>
                        <a class="btn-2 btn" style="text-decoration: none;" href="buy_tickets.php?movieID=<?php echo $row_movie['movie_id'];?>" role="button">BUY TICKETS</a>
                    <?php } ?>
                </p>
            </div>
        </div>
        <!--Banner Code - End-->

            
        <div class="container mt-4" style="line-height:22px; font-size: 14px; color: #606978; font-family:sans-serif">
        
            <div class="wrp">
                <h3 class="movie_name_minimal" style="text-align:center; display:none; padding:7px; border-radius:5px; color:#FFF; background:#23241d"><?php echo $row_movie['movie_name'] ?></h3><br>
                <h4>Release Date</h4><h6><?php echo date("d F Y", strtotime($row_movie['release_date']))?></h6><br>
                <h4>Running Time</h4><h6><?php echo $row_movie['running_time']?></h6><br>
                <h4>Language</h4><h6><?php echo $row_movie['language']?></h6><br>
                <h4>Director</h4><h6><?php echo $row_movie['director']?></h6><br>
                <h4>Synopsis</h4><h6><?php echo $row_movie['synopsis']?></h6><br>
                <h4>Casts</h4><h6><?php echo $row_movie['casts']?></h6>
            </div>


            <?php
            $sql_theatres = "SELECT * FROM tbl_theatres where theatre_id IN(select theatre_id from tbl_shows where movie_id=$movie_id)";
            $result_theatres = mysqli_query($db,$sql_theatres);
            if(mysqli_num_rows($result_theatres) > 0){
            ?>
            <div class="available_theatres">
                <h4>Available Theatres</h4>
                <div class="row">
                    <?php while($row_theatres = mysqli_fetch_array($result_theatres)){ ?>
                        <div class="col-md-3 col-sm-4">
                            <div class="theatre">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode(file_get_contents($row_theatres['image']))?>" class="theatre_image">
                                <div class="theatre_bottom_wrap">
                                    <a class="theatre_name" href="theatre.php?theatre_id=<?php echo $row_theatres['theatre_id']?>"><h6><?php echo $row_theatres['theatre_name']?> <br> <?php echo $row_theatres['city'] ?></h6></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            

        </div>

        <?php } ?>

    </div>
    


    <!-- Trailer Modal -->
    <div class="modal fade" id="trailerModal" tabindex="-1" role="dialog" aria-labelledby="trailerModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>        
                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
	<!--Footer Code - Start-->
	<?php include('footer.php') ?>
	<!--Footer Code - End-->

    
    <!-- Optional JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <script>
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

            // Gets the video src from the data-src on each button
            var $videoSrc;
            $('.trailer_btn').click(function() {
                $videoSrc = "//www.youtube.com/embed/" + getId($(this).data( "src" ));
            });

            // when the modal is opened autoplay it  
            $('#trailerModal').on('shown.bs.modal', function (e) {
                // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
                $("#video").attr('src',$videoSrc + "?autoplay=0&amp;modestbranding=1&amp;showinfo=0" ); 
            })
            
            // stop playing the youtube video when I close the modal
            $('#trailerModal').on('hide.bs.modal', function (e) {
                // a poor man's stop video
                $("#video").attr('src',$videoSrc); 
            }) 
        });
    </script>
  
  </body>
</html>