<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');

if(!isset($_SESSION['admin_id'])) {
    header('location: index.php');
}

$sql = "SELECT A.show_id,A.starting_time,B.screen,C.movie_name,D.theatre_name,D.city FROM tbl_showtimes A,tbl_shows B,tbl_movies C,tbl_theatres D WHERE A.show_id = B.show_id AND B.movie_id = C.movie_id AND B.theatre_id = D.theatre_id GROUP BY A.show_id ORDER BY A.showtime_id DESC";
$result = mysqli_query($db,$sql);

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
    <link href="css/style.css?=<?php echo time(); ?>" rel="stylesheet">
    <link href="css/addons/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
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
                <li>
                    <a href="movies.php">
                        <span>Movies</span>
                    </a>
                </li>
                <li>
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
                <li class="active">
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
                    <h2 class="font-italic">Showtimes</h2>
                </div>
                <div class="content-body">
                    <button class="btn btn-primary addmovie" data-toggle="modal" data-target="#addShowtimeModal" style="position: absolute;z-index: 1;">Add Showtime</button>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th class="hide">Show ID</th>
                            <th>Movie</th>
                            <th>Theatre</th>
                            <th>Showtime(s)</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1; 
                            while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td class="hide"><?php echo $row['show_id']; ?></td>
                                <td><?php echo $row['movie_name']; ?></td>
                                <td><?php echo $row['theatre_name'] . '-' . $row['city'] . ' ( Screen ' . $row['screen'] . ' )'; ?></td>
                                <td><?php echo implode(', ',json_decode($row['starting_time'])); ?></td>
                                <td>
                                    <button class="btn btn-secondary edit_btn"><i class="fas fa-pen"></i></button>
                                    <button class="btn btn-danger dlt_btn"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="js/addons/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/addons/datatables.bootstrap4.min.js"></script>
    <script src="js/axios.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <!-- Add Showtime(s) Modal -->
    <div class="modal fade" tabindex="-1" id="addShowtimeModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Add New Showtime</h4>
                    </div>
                </div>
                <form action="assets/showtimes.insert.php" id="addShowtimeForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Select Show</label>
                            <select name="show" class="form-control" id="show">
                                <option value="0">Select Show</option>
                                <?php echo getShows($db); ?>
                            </select>
                        </div>
                        <div class="form-group time_div hide">
                            <label>Showtime(s)</label>
                            <div class="form-group row time_col">
                                <div class="col">
                                    <input type="time" name="showtime[]" class="form-control">
                                </div>
                                <div class="col-sm-2 add_time_div">
                                    <button type="button" class="btn btn-secondary add_btn"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="alert-text already hide">Data Already Exist!</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary addShowtimeBtn">Add Showtime</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Showtime(s) Modal -->
    <div class="modal fade" id="editShowtimeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Edit Showtime</h4>
                    </div>
                </div>
                <form action="assets/showtimes.update.php" id="editShowtimeForm">
                    <div class="modal-body">
                        <input type="hidden" name="show_id" id="editShowID">
                        <div class="form-group">
                            <label>Show</label>
                            <input type="text" class="form-control" disabled="true" id="edit_show_name">
                        </div>
                        <div class="form-group editTime_div">
                            <label>Showtime(s)</label>
                            <div class="form-group row time_col">
                                <div class="col">
                                    <input type="time" name="editshowtime[]" class="form-control" id="editTime">
                                </div>
                                <div class="col-sm-2 add_time_div">
                                    <button type="button" class="btn btn-secondary edit_add_btn"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary editShowtimeBtn">Edit Showtime</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Showtime(s) Modal -->
    <div class="modal fade" id="dltShowtimeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="assets/showtimes.delete.php" id="dltShowtimeForm">
                    <div class="modal-body">
                        <input type="hidden" name="show_id" id="show_id">
                        <h4>Are You Want to Delete Showtime(s) of <span id="name" class="font-italic"></span></h4>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger dltShowtimeBtn" type="submit">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Success Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="success-box">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <div class="success-text"></div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Error Modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="error-box">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <div class="error-text"></div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>
        </div>
    </div>
<script>
    $('.table').DataTable({
        "lengthMenu":[5],
        "bLengthChange":false
    });
    $('#show').change(function(){
        $('.time_div').removeClass('hide');
        $('.already').addClass('hide');
    });
    $('.add_btn').on('click',function(){
        $('.time_div').append('<div class="form-group row"><div class="col"><input type="time" class="form-control" name="showtime[]"></div><div class="col-sm-2"><button type="button" class="btn btn-secondary minus_btn"><i class="fas fa-minus"></i></button></div></div>');
    });
    $('.edit_add_btn').on('click',function(){
        $('.editTime_div').append('<div class="form-group row"><div class="col"><input type="time" class="form-control" name="editshowtime[]"></div><div class="col-sm-2"><button type="button" class="btn btn-secondary minus_btn"><i class="fas fa-minus"></i></button></div></div>');
    });
    $(document).on('click','.minus_btn',function(){
        $(this).parent().parent().remove();   
    });
    $('.addShowtimeBtn').on('click',function(e){
        e.preventDefault();
        var data = $('#addShowtimeForm').serialize();
        $.ajax({
            url:'assets/showtimes.insert.php',
            method:'POST',
            data:data,
            success:function(response){
                if(response == 'Success'){
                    $('#addShowtimeModal').modal('hide');
                    $('#success-box').modal('show');
                    $('.success-text').text('Showtime(s) Added Successfully!');
                    setTimeout(function(){
                        $('#success-box').modal('hide');
                        location.reload();
                    },2000);
                }else if(response == 'Error'){
                    $('#addShowtimeModal').modal('hide');
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout(function(){
                        $('#error-box').modal('hide');
                    },2000);
                }else{
                    $('.already').removeClass('hide');
                    $('#addShowtimeForm')[0].reset();
                }
            }
        })
    });
    $('.edit_btn').on('click',function(){
        $('#editShowtimeModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        $("#editShowID").val(data[1]);
        $('#edit_show_name').val(data[2] + ' - ' + data[3]);
        var array = data[4].split(',');
        $('#editTime').val(array[0]);
        for (var i = 1; i < array.length; i++) {
            $('.editTime_div').append('<div class="form-group row"><div class="col"><input type="time" class="form-control" name="editshowtime[]" value='+ array[i] +'></div><div class="col-sm-2"><button type="button" class="btn btn-secondary minus_btn"><i class="fas fa-minus"></i></button></div></div>');
        }
    });
    $('.editShowtimeBtn').on('click',function(e){
        e.preventDefault();
        var data = $('#editShowtimeForm').serialize();
        $.ajax({
            url:"assets/showtimes.update.php",
            method:'POST',
            data:data,
            success:function(response){
                console.log(response);
                if(response == 'Success'){
                   $('#editShowtimeModal').modal('hide');
                    $('#success-box').modal('show');
                    $('.success-text').text('Showtime(s) Edited Successfully!');
                    setTimeout(function(){
                        $('#success-box').modal('hide');
                        location.reload();
                    },2000);
                }else if(response == 'Error'){
                    $('#addShowtimeModal').modal('hide');
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout(function(){
                        $('#error-box').modal('hide');
                    },2000);
                }
            }
        })
    })
    $('.dlt_btn').on('click',function(){
        $('#dltShowtimeModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        $('#show_id').val(data[1]);
        $('#name').text(data[2] + ' (' + data[3] + ' )');
    });
    $('.dltShowtimeBtn').on('click',function(e){
        e.preventDefault();
        var data = $('#dltShowtimeForm').serialize();
        $.ajax({
            url:"assets/showtimes.delete.php",
            method:"POST",
            data:data,
            success:function(response){
                if(response == 'Success'){
                    $('#dltShowtimeModal').modal('hide');
                    $('#error-box').modal('show');
                    $('.error-text').text('Showtime(s) Deleted Successfully!');
                    setTimeout(function(){
                        $('#error-box').modal('hide');
                        location.reload();
                    },2000);
                }else{
                    $('#dltShowtimeModal').modal('hide');
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout(function(){
                        $('#error-box').modal('hide');
                    },2000);
                }
            }
        });
    });
</script>


</body>

</html>
