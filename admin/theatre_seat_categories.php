<?php
session_start();
include_once ('db_config.php');
include('functions.php');

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
  <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/addons/datatables.bootstrap4.min.css" rel="stylesheet">
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/addons/jquery.dataTables.min.js"></script>
  <script src="js/addons/dataTables.bootstrap4.min.js"></script>
  <style media="screen">
    .modal{
      overflow-y: scroll;
    }
    #seat_map{
        height: 100%;
        width: 100%;
        position: relative;
        display: flex;
        justify-content: center;
    }
    .btn_div{
        width: 100%;
        display: flex;
        justify-content: center;
    }
  </style>
</head>

<body >

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
            <li  class="active">
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
                <h2 class="font-italic">Seat Maps</h2>
            </div>
            <div class="content-body">
                <button class="btn btn-primary addSeatMap" data-toggle="modal" data-target="#addSeatMapModal" style="position: absolute;z-index: 9999;">Add Seat Map</button>
                <table id="seat_category_table" class="table" style="margin-top:10px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="hide">ID</th>
                            <th>Theatre</th>
                            <th>Screen</th>
                            <th>No. of Seats</th>
                            <th>Seat Map</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM tbl_theatre_seat_categories ";
                            $result = mysqli_query($db,$sql);
                            $i = 0;
                            while($row= mysqli_fetch_assoc($result)){
                                $theatreID = $row['theatre_id'];

                                $sql_theatre = "SELECT * FROM tbl_theatres WHERE theatre_id = '$theatreID'";
                                $result_theatre = $db->query($sql_theatre);
                                $row_theatre = $result_theatre->fetch_assoc();
                                $seats = json_decode($row['num_of_seats']);
                                $sumSeats =  array_sum($seats);
                                $i++;

                                echo "<tr>";
                                    echo "<td id='row_num_column'>{$i}</td>";
                                    echo "<td id='id_column' class='hide'>{$row['seat_category_id']}</td>";
                                    echo "<td>{$row_theatre['theatre_name']} - {$row_theatre['city']}</td>";
                                    echo "<td>{$row['screen']}</td>";
                                    echo "<td id='seat_column'>{$sumSeats}</td>";
                                    echo "<td id='seat_map_column'><button id='view_btn' class='btn btn-secondary' value='{$row['seat_category_id']}' >View</button></td>";
                                    echo "<td id='action_column'><button class='delete_button btn btn-danger' seatCategoryID='{$row['seat_category_id']}'><i class='fa fa-trash'></i></button></td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="addSeatMapModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form method="post" id="seatMapForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col">
                            <select name="theatre_name" id="theatre_name" class="form-control">
                                <option value="0">Select Theatre</option>
                                <?php
                                echo getTheatre($db);
                                ?>
                            </select>
                        </div>
                        <div class="form-group col">
                            <select name="theatre_screen" id="screen" class="form-control hide">
                            </select>
                        </div>
                    </div>
                    <div class="filled-text hide" style="color: #f00;text-align: center;">Already Exist, Please Choose Another Option!</div>
                    <input type="hidden" name="seats" id="seats">
                    <div class="row parent">
                        <div class="col child hide">
                            <div class="form-group">
                                <select name="category[]" id="category" class="form-control">
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="form-group col">
                                    <select name="row[]" id="row" class="form-control">
                                        <option value="0">Select Row</option>
                                        <?php for ($r=1; $r <= 20 ; $r++) { 
                                            echo '<option value="'.$r.'">'.$r.'</option>';
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <select name="col[]" id="col" class="form-control">
                                        <option value="0">Select Column</option>
                                        <?php for ($c=1; $c <= 20 ; $c++) { 
                                            echo '<option value="'.$c.'">'.$c.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hide" id="selectAdd">
                        <div class="form-group">
                            <button class="btn btn-primary selectAddBtn">Add More Category</button>
                        </div>
                    </div>
                    <div id="form_submission" class="hide" align="center">
                        <button type="button" class="btn btn-secondary" id="proceed_button">Proceed</button>
                    </div>
                    <div id="seat_map"></div>
                </div>
                <div class="modal-footer hide">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary addSeatMapBtn">Add Seat Map</button>
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

<div class="modal fade" id="viewSeatMapModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <form method="POST" action="assets/theatre_seat_categories.view.seat_map.php" id="view_seat_category_form">
                    <input type="hidden" name="seatCategoryID" id="viewTheatreID">
                    <div class="row">

                        <div class="form-group col">
                            <label for="theatre_view_label">Theatre:</label>
                            <div>
                                <input type="text" id="theatre_view" name="theatre_view" class="form-control" style="text-align:center;" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group col">
                            <label for="screen_label">Screen :</label>
                            <div>
                                <input type="text" id="screen_view" name="screen_view" class="form-control" style="text-align:center;" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group col">
                            <label for="num_of_seats_view_label">No. of Seats:</label>
                            <div >
                                <input type="text" id="num_of_seats_view" name="num_of_seats_view" class="form-control" style="text-align:center;" disabled="disabled">
                            </div>
                        </div>

                    </div>
                    <div class="btn_div">
                        <button class="btn btn-secondary viewSeatMapBtn">View Seat Map</button>
                    </div>
                </form>
            </div>

            <div id="view_seat_map" align="center">
            </div>
            <div class="modal-footer hide">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteSeatModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" name="d_id" id="deleteID">
                <h4>Are You Sure Want to Delete <span id="t_name" class="font-italic"></span>,<span id="t_floor" class="font-italic"></span>,<span class="font-italic">Screen </span><span id="t_screen" class="font-italic"></span></h4>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-danger deleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('show.bs.modal',function(){
        $('.addSeatMap').css('z-index','0');
    });
    $(document).on('hide.bs.modal',function(){
        $('.addSeatMap').css('z-index','9999');
    });
    $('#seat_category_table').DataTable({
        "ordering": false,
        "lengthMenu":[5],
        "bLengthChange":false
    });
    $('.dataTables_length').addClass('bs-select');
    $('#theatre_name').change(function(){
      let value = $(this).val();
      $('#screen').removeClass('hide');
      $.ajax({
        url:"./assets/theatres.action.php",
        method:"POST",
        data:{theatre_screen:value},
        success:function(response){
          $('#screen').html(response);
        }
      })
    });
    $('#screen').change(function(){
        var screen = $(this).val();
        var theatre_id = $("#theatre_name").val();
        $.ajax({
            url:"assets/theatres.action.php",
            method:"POST",
            data:{category:theatre_id,cat_screen:screen},
            success:function(response){
                if(response == 'hide'){
                    $('.child').addClass('hide');
                    $('.filled-text').text('Please Choose Any Screen!');
                }else if(response == 'filled'){
                    $('.child').addClass('hide');
                    $('.filled-text').removeClass('hide');
                    $('.filled-text').text('Already Exist, Please Choose Another Option!');
                }else{
                    $('.filled-text').addClass('hide');
                    $('.child').removeClass('hide');
                    $('#category').html(response);
                }
            }
        });
    });
    $('#category').change(function(){
        $('#selectAdd').removeClass('hide');
    });
    $('#col').change(function(){
      $('#form_submission').removeClass('hide');
    });
    $('#row,#col').change(function(){
        $('#addSeatMapModal .modal-footer').addClass('hide');
    })
    $('.selectAddBtn').on('click',function(e){
        e.preventDefault();
        var value = $('#category').val();
        var el = $('.child').clone();
        $('#category').removeAttr('id');
        $('.child').removeClass('child');
        $('.parent').append(el);
        $('#category option[value="'+value+'"]').prop('disabled','true');
        var enabled = $('#category option:not(:disabled)');
        if(enabled.length == 2){
            $('.selectAddBtn').addClass('hide');
        }
    });
    //Fetch and View Seat Map
    $("#proceed_button").click(() => {
        $('#addSeatMapModal .modal-footer').removeClass('hide');
        if($("#seatMapForm")[0].checkValidity()) {
            $.ajax({
                url:"assets/theatre_seat_categories.seat_map.php",
                type:"post",
                data:$("#seatMapForm").serialize(),
                success:function(seatMap){
                    $('#seat_map').html(seatMap);
                }
            });
        }
        else {
            $("#seatMapForm")[0].reportValidity();
        }
    });

    $('.addSeatMapBtn').on('click',(e) => {
        e.preventDefault();
        var array = $('#seatsArray').val();
        var data = $('#seatMapForm').serialize() + "&seatsArray=" + array;
        $.ajax({
            url:"assets/theatre_seat_categories.insert.php",
            method:"POST",
            data:data,
            success:function(response){
                $('#addSeatMapModal').modal('hide');
                $('#seatMapForm')[0].reset();
                if(response == 'Success'){
                    $('#success-box').modal('show');
                    $('.success-text').text('Seat Map Added Successfully!');
                    setTimeout(function(){
                        $('#success-box').modal('hide');
                        console.log($('#col').val());
                        location.reload();
                    },2000);
                }else{
                    console.log(response)
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout(function(){
                        $('#error-box').modal('hide');
                        location.reload();
                    },2000);
                }
            }
        })
    });

    //Reset form on closing modal
    $('#addSeatMapModal').on('hidden.bs.modal', () => {
        $('#seat_map').html("");
    });
    
    $(document).on('click','#view_btn',function() {
        $('#viewSeatMapModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        console.log(data);
        $('#viewTheatreID').val(data[1]);
        $('#theatre_view').val(data[2]);
        $('#floor_view').val(data[3]);
        $('#screen_view').val(data[4]);
        $('#num_of_seats_view').val(data[5]);
    });
    $('.viewSeatMapBtn').on('click',(e) => {
        e.preventDefault();
        var data = $('#view_seat_category_form').serialize();
        $.ajax({
            url:"assets/theatre_seat_categories.view.seat_map.php",
            method:"POST",
            data:data,
            success:function(response){
                $('#view_seat_map').html(response);
                $('#viewSeatMapModal .modal-footer').removeClass('hide');
            }
        })
    });
    $(document).on('click','.delete_button',function() {
        $('#deleteSeatModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        $('#deleteID').val(data[1]);
        $('#t_name').text(data[2]);
        $('#t_floor').text(data[3]);
        $('#t_screen').text(data[4]);
    });
    $('.deleteBtn').on('click',(e) =>{
        e.preventDefault();
        var id = $('#deleteID').val();
        $.ajax({
            url:"assets/theatre_seat_categories.delete.php",
            method:"POST",
            data:{d_id:id},
            success:function(response){
                $("#deleteSeatModal").modal('hide');
                if(response == 'Success'){
                    $('#success-box').modal('show');
                    $('.success-text').text('Seat Map Deleted Successfully!');
                    setTimeout(function(){
                        $('#success-box').modal('hide');
                        location.reload();
                    },2000);
                }else{
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout(function(){
                        $('#error-box').modal('hide');
                        location.reload();
                    },2000);
                }
            }
        })
    })
</script>



</body>

</html>
