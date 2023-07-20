<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');

if(!isset($_SESSION['admin_id'])) {
    header('location: index.php');
}
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>theMovieBook - Admin | Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="images/icon.png">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/addons/datatables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>
<div class="wrapper" style="width: 100vw;height: 100vh;">
    <nav id="sidebar">

        <ul class="list-unstyled components">
            <li class="main-text">
                <img src="./images/logo.png" width="180px" alt="">
            </li>
            <li class="admin_name">
                <h4><?php echo get_admin_name($db,$_SESSION['admin_id']); ?></h4>
            </li>
            <li >
                <a href="movies.php">
                    <span>Movies</span>
                </a>
            </li>
            <li class="active">
                <a href="carousel.php">
                    <span>Carousel</span>
                </a>
            </li>
            <li>
                <a href="theatres.php">
                    <span>Theatres</span>
                </a>
            </li>
            <li>
                <a href="theatre_seat_categories.php">
                    <span>Seat Maps</span>
                </a>
            </li>
            <li>
                <a href="shows.php">
                    <span>Shows</span>
                </a>
            </li>

            <li>
                <a href="showtimes.php">
                    <span>Showtimes</span>
                </a>
            </li>
            <li>
                <a href="show_ticket_rates.php">
                    <span>Show Ticket Rates</span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="bookings.php">
                    <span>Bookings</span>
                </a>
            </li>
        </ul>

    </nav>
    <div id="content">
        <nav class="navbar bg-dark">
            <span class="bars" id="sidebarCollapse"><i class="fas fa-bars"></i>
            </span>
            <h4>theMovieBook</h4>
            <a href="admin.logout.php" class="signout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </nav>
        <div class="content-wrapper">
            <div class="content-header">
                <h2 class="font-italic">Carousel</h2>
            </div>
            <div class="content-body">
                <button class="btn btn-primary addCarousel" data-toggle="modal" data-target="#addCarouselImageModal" style="position: absolute;z-index: 9999;">Add Carousel</button>
                <div id="output" class="table-responsive">
                    
                </div>
            </div>
        </div>
    </div>
</div>
    


<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/addons/jquery.dataTables.min.js"></script>
<script src="js/addons/dataTables.bootstrap4.min.js"></script>
<div class="modal fade" id="addCarouselImageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCarouselImageModalLongTitle">New Carousel Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="add_carousel_image_form" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="movie_label" class="col-sm-3 col-form-label">Movie:</label>
                        <div class="col-sm-9">
                            <select id="movie" name="movie" class="form-control" required="required">
                                <option value="0" selected>Select Movie</option>
                                <?php
                                    echo getMovies($db);
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3">Preview</label>
                        <div class="image hide col-sm-9">
                            <img id="show_image" src="" height="390px" width="280px">
                            <input type="hidden" name="carousel" id="save_image">
                            <input type="hidden" name="movie_id" id="id">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
                    <input type="submit" class="btn btn-primary" id="insert" value="Save"/>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteCarouselImageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCarouselImageModalLongTitle">Confirm</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this carousel image?
                This process cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close_delete" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="delete_confirm">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="viewCarouselModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <h6>Movie Name</h6>
                    <h4 id="view_movie"></h4>
                </div>
                <div>
                    <h6>Image</h6>
                    <img src="" id="view_image" height="390px" width="280px">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#movie').on('change',function(){
        var id = $(this).val();
        $.ajax({
            url:"assets/carousel.action.php",
            method:"POST",
            data:{url:id},
            success:function(response){
                $('.image').removeClass('hide');
                $('#show_image').attr("src",response);
                $('#save_image').val(response);
            }
        });
        $('#id').val(id);
    })
    $(document).ready(function () {   
        $(document).on('show.bs.modal',function(){
            $('.addCarousel').css('z-index','0');  
        });
        $(document).on('hide.bs.modal',function(){
            $('.addCarousel').css('z-index','9999');
        }) 
        //Fetching table data from mysql
        function fetch_table_data(){
            $.ajax({
                url:"assets/carousel.table.php",
                method:"POST",
                success: function(data){
                    $("#output").html(data);
                }
            });
        }
        fetch_table_data();
        $("#add_carousel_image_form").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url:"assets/carousel.insert.php",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                processData: false,
                success:function(d){
                    $("#addCarouselImageModal").modal('hide');
                    fetch_table_data();
                }
            });
        });
        $(document).on('click','.view_button',function(){
            $("#viewCarouselModal").modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();
            $('#view_movie').text(data[1]);
            var url = data[3];
            $("#view_image").attr("src",url);
        })
        //Reset form on closing modal
        $('#addCarouselImageModal').on('hidden.bs.modal', function() {
            $("#add_carousel_image_form")[0].reset();
        });

        var ID_delete = "";
        //Delete a row from table
        $(document).on("click",".delete_button",function(){
            var id = $(this).attr("ID");
            ID_delete = id;
            $('#deleteCarouselImageModal').modal('show');
        });

        //Confirm deleting a row from table
        $("#delete_confirm").click(function() {
            $.ajax({
                url:"assets/carousel.delete.php",
                type:"post",
                data:{id:ID_delete},
                success:function(){
                    $('#deleteCarouselImageModal').modal('hide');
                    fetch_table_data();
                }
            });
        })
    });
</script>


</body>

</html>
