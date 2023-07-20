<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');

if(!isset($_SESSION['admin_id'])) {
    header('location: index.php');
}
$query = "SELECT * FROM tbl_shows";
$result = $db->query($query);
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
    <link rel="stylesheet" href="css/jquery-ui.css">
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
            <li class="active">
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
                <h2 class="font-italic">Shows</h2>
            </div>
            <div class="content-body">
                <button class="btn btn-primary addShow" data-toggle="modal" data-target="#addShowModal" style="position: absolute;z-index: 1;">Add New Show</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="hide">Show ID</th>
                            <th>Movie</th>
                            <th>Theatre</th>
                            <th>Screen</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { 
                            $movieID = $row['movie_id'];
                            $theatreID = $row['theatre_id'];
                            $movie_sql = "SELECT * FROM tbl_movies WHERE movie_id = '$movieID'";
                            $movie_result = mysqli_fetch_assoc($db->query($movie_sql));
                            $theatre_sql = "SELECT * FROM tbl_theatres WHERE theatre_id = '$theatreID'";
                            $theatre_result = mysqli_fetch_assoc($db->query($theatre_sql));
                         ?>
                         <tr>
                            <td><?php echo $i; ?></td>
                            <td class="hide"><?php echo $row['show_id']; ?></td>
                             <td><?php echo $movie_result['movie_name']; ?></td>
                             <td><?php echo $theatre_result['theatre_name'] . ' - ' . $theatre_result['city']; ?></td>
                             <td><?php echo $row['screen']; ?></td>
                             <td><?php echo $row['starting_date']; ?></td>
                             <td><?php echo $row['ending_date']; ?></td>
                             <td><?php echo "<button class='btn btn-secondary edit_btn'><i class='fas fa-pen'></i></button>
                             <button class='btn btn-danger dlt_btn' value={$row['show_id']}><i class='fas fa-trash'></i></button>";?></td>
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="modal fade" id="addShowModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Add New Movie Show</h4>
                </div>
            </div>
            <form action="assets/shows.insert.php" method="post" id="addShowForm">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="movie_id" id="movie" class="form-control">
                            <option value="0">Select Movie</option>
                            <?php echo getMovie($db); ?>
                        </select>
                        <div class="alert-text movie hide">*Please Choose Movie</div>
                    </div>
                    <div class="form-group">
                        <select name="theatre_id" id="theatre" class="form-control hide">
                            <option value="0">Select Theatre</option>
                            <?php echo getTheatre($db); ?>
                        </select>
                        <div class="alert-text theatre hide">*Please Choose Theatre</div>
                    </div>
                        <div class="form-group">
                            <select name="screen" id="screen" class="form-control hide"></select>
                            <div class="alert-text screen hide">*Please Choose Screen</div>
                        </div>
                    <div class="alert-text checkScreen hide" style="text-align: center;">Data Already Exist</div>
                    <div class="row">
                        <div class="form-group col">
                            <input type="text" name="start_date" id="start_date" class="form-control hide" placeholder="Select Start Date">
                            <div class="alert-text s_date hide">*Please Choose Start Date</div>
                        </div>
                        <div class="form-group col">
                            <input type="text" name="end_date" id="end_date" class="form-control hide" placeholder="Select End Date">
                            <div class="alert-text e_date hide">*Please Choose End Date</div>
                        </div>
                    </div>

                    <div class="hide alert-msg" style="color: #f00;text-align: center;"></div>
                </div>
                <div class="modal-footer hide">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary addShowBtn">Add Show</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editShowModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Edit Movie Show</h4>
                </div>
            </div>
            <form action="assets/shows.update.php" id="editShowForm">
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-group">
                        <label>Movie Name</label>
                        <input type="text" class="form-control" id="movie_name" disabled>
                    </div>
                    <div class="form-group">
                        <label>Theatre Name</label>
                        <input type="text" class="form-control" id="theatre_name" disabled>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label>Floor</label>
                            <input type="text" class="form-control" id="edit_floor" disabled>
                        </div>
                        <div class="form-group col">
                            <label>Screen</label>
                            <input type="text" class="form-control" id="edit_screen" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label>Start Date</label>
                            <input type="text" name="edit_startDate" class="form-control" id="edit_startDate">
                            <div class="alert-text startAlert"></div>
                        </div>
                        <div class="form-group col">
                            <label>End Date</label>
                            <input type="text" name="edit_endDate" class="form-control" id="edit_endDate">
                            <div class="alert-text endAlert"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary editShowBtn">Edit Show Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="dltShowModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="assets/shows.delete.php" id="dltShowForm">
                <div class="modal-body">
                    <input type="hidden" name="dltID" id="dltID">
                    <h4>Are You Sure You Want to Delete <span id="dlt_name" class="font-italic"></span> ?</h4>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger dltShowBtn">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
    $(document).ready(function () {
        $('.table').DataTable({
            "lengthMenu":[5],
            "bLengthChange":false
        });
        $('.dataTables_length').addClass('bs-select');
    });
    $(document).on('show.bs.modal',function(){
        $('.addShow').css('z-index','0');  
    });
    $(document).on('hide.bs.modal',function(){
        $('.addShow').css('z-index','9999');
    });
    $('#movie').change(function(){
        $('#theatre').removeClass('hide');
        $('.movie').addClass('hide');
    });
    $('#theatre').change(function(){
        $('.theatre').addClass('hide');
        $('#screen').removeClass('hide');
        var theatreID = $(this).val();
        $.ajax({
            url:'assets/shows.action.php',
            method:'POST',
            data:{getScreen:theatreID},
            success:function(response){
                $('#screen').html(response);
            }
        })
    });
    $('#screen').change(function(){
        $('.screen').addClass('hide');
        var id = $("#theatre").val();
        var floor = $('#floor').val();
        var screen = $(this).val();
        $.ajax({
            url:'assets/shows.action.php',
            method:'POST',
            data:{checkScreen:screen,floor:floor,id:id},
            success:function(response){
                if(response == 'Already'){
                    $('.checkScreen').removeClass('hide');
                    $("#start_date").addClass('hide');
                }else{
                    $('.checkScreen').addClass('hide');
                    $("#start_date").removeClass('hide');
                }
            }
        })
    });
    $('#start_date').change(function(){
        $('#end_date').removeClass('hide');
    });
    $('#start_date,#edit_startDate').datepicker({
        startDate:'+1',
        autoclose:true,
        minDate:"+1d",
        dateFormat:"yy-mm-dd",
        onSelect:function(selected){
            var date = $(this).datepicker('getDate');
            date.setDate(date.getDate() + 7);
            $('#end_date,#edit_endDate').datepicker("option","minDate",date);
            $('.s_date').addClass('hide');
            $('#end_date').removeClass('hide');
        }
    });
    $('#end_date,#edit_endDate').datepicker({
        startDate:'+2',
        autoclose:true,
        minDate:"+9d",
        dateFormat:"yy-mm-dd",
        onClose:function(data){
            $(this).focus();
            $('.e_date').addClass('hide');
            $('#addShowModal .modal-footer').removeClass('hide');
        }
    });
    $('.addShowBtn').on('click',function(e){
        e.preventDefault();
        var data = $('#addShowForm').serialize();
        $.ajax({
            url:"assets/shows.insert.php",
            method:"POST",
            data:data,
            success:function(response){
                console.log(response);
                if(response == 'Success'){
                    $('#addShowModal').modal('hide');
                    $('#success-box').modal('show');
                    $('.success-text').text('Show Added Successfully!');
                    setTimeout( () => {
                        $('#success-box').modal('hide');
                        location.reload();
                    },1500);
                }else if(response == 'Already'){
                    $('.alert-msg').text('Data Already Exist!');
                    $('.alert-msg').removeClass('hide');
                    $("#addShowForm")[0].reset();
                    setTimeout(() => {
                        $('.alert-msg').addClass('hide');
                    },1500)
                }else{
                    $('#addShowModal').modal('hide');
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout( () => {
                        $('#error-box').modal('hide');
                        location.reload();
                    },1500);
                }
            }
        });
    });
    $('.edit_btn').on('click',function(){
        $('#editShowModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        $("#edit_id").val(data[1]);
        $("#movie_name").val(data[2]);
        $("#theatre_name").val(data[3]);
        $("#edit_floor").val(data[4]);
        $("#edit_screen").val(data[5]);
        $("#edit_startDate").val(data[6]);
        $('#edit_endDate').val(data[7]);
    });
    $('.editShowBtn').on('click',function(e){
        e.preventDefault();
        var data = $('#editShowForm').serialize();
        $.ajax({
            url:"assets/shows.update.php",
            method:"POST",
            data:data,
            success:function(response){
                console.log(response);
                if (response == 'StartAlert'){
                    $('.startAlert').text('*Must Be Greater!');
                }else if(response == 'Success'){
                    $('.StartAlert').addClass('hide');
                    $('#editShowModal').modal('hide');
                    $('#success-box').modal('show');
                    $('.success-text').text('Show Edited Successfully!');
                    setTimeout( () => {
                        $('#success-box').modal('hide');
                        location.reload();
                    },1500);
                }else if(response == 'Error'){
                    $('.StartAlert').addClass('hide');
                    $('#editShowModal').modal('hide');
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout( () => {
                        $('#error-box').modal('hide');
                        location.reload();
                    },1500);
                }
            }
        });
    });
    $('.dlt_btn').on('click',function(){
        $('#dltShowModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        $('#dlt_name').text(data[3]);
        $('#dltID').val(data[1]);
    });
    $('.dltShowBtn').on('click',function(e){
        e.preventDefault();
        var data = $('#dltShowForm').serialize();
        $.ajax({
            url:"assets/shows.delete.php",
            method:"POST",
            data:data,
            success:function(response){
                $("#dltShowModal").hide();
                if (response == 'Success') {
                    $('#error-box').modal('show');
                    $('.error-text').text('Deleted Successfully!');
                    setTimeout( () => {
                        $('#error-box').modal('hide');
                        location.reload();
                    },1500);
                }else{
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout( () => {
                        $('#error-box').modal('hide');
                        location.reload();
                    },1500);
                }
            }
        })
    })

</script>
</body>

</html>
