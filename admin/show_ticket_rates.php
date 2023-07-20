<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');
if(!isset($_SESSION['admin_id'])) {
    header('location: index.php');
}

$sql = "SELECT A.ticket_rate_id,A.show_id,A.category,A.ticket_rate,B.screen,C.movie_name,D.theatre_name,D.city,E.category_name FROM tbl_show_ticket_rates A,tbl_shows B,tbl_movies C,tbl_theatres D,tbl_theatre_seat_categories E WHERE A.show_id = B.show_id AND B.movie_id = C.movie_id AND B.theatre_id = D.theatre_id  AND A.category = E.category_name GROUP BY A.show_id ORDER BY A.ticket_rate_id DESC";
$query = $db->query($sql);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>theMovieBook - Admin | Show Ticket Rates</title>
    <link rel="shortcut icon" type="image/png" href="images/icon.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css?=<?php echo time(); ?>" rel="stylesheet">
    <link href="css/addons/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/jquery-ui.css">
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

            <li>
                <a href="showtimes.php">
                    <span>Showtimes</span>
                </a>
            </li>
            <li  class="active">
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
                <h2 class="font-italic">Show Ticket Rates</h2>
            </div>
            <div class="content-body">
                <button class="btn btn-primary addmovie" data-toggle="modal" data-target="#addTicketRateModal" style="position: absolute;z-index: 1;">Add Ticket Rates</button>
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th class="hide">Show ID</th>
                        <th>Movie</th>
                        <th>Theatre</th>
                        <th class="hide">Category</th>
                        <th class="hide">Adult Rates</th>
                        <th>Category,Rates</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $i =1; 
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td class="hide"><?php echo $row['ticket_rate_id']; ?></td>
                            <td><?php echo $row['movie_name']; ?></td>
                            <td><?php echo $row['theatre_name'] . ' - ' . $row['city'] . ' ( Screen ' . $row['screen'] . ' )' ; ?></td>
                            <td class="hide">
                                <?php echo $cat = $row['category_name']; ?>
                            </td>
                            <td class="hide">
                               <?php echo $full = $row['ticket_rate'];  ?>
                            </td>
                            <td>
                                <button class="btn btn-primary viewRatesBtn">View</button>
                            </td>
                            <td>
                                <button class="btn btn-secondary edit_Btn"><i class="fas fa-pen"></i></button>
                                <button class="btn btn-danger dlt_Btn"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php
                        $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addTicketRateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Add Show Ticket Rate</h4>
                </div>
            </div>
            <form action="assets/show_ticket_rates.insert.php" id="addTicketRateForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Show</label>
                        <select name="shows" id="shows" class="form-control">
                            <option value="0">Select Show</option>
                            <?php getShows($db); ?>
                        </select>
                    </div>
                    <div class="alert-text cat_return hide" style="text-align: center;">Data Not Available <br> To Add New <a href="theatre_seat_categories.php">click here</a></div>
                    <div class="alert-text cat_already hide" style="text-align: center;">Data Already Exist!</div>
                    <div id="category_details"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary addTicketRateBtn">Add Ticket Rates</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="viewRatesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h4>View Ticket Rates</h4>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><b>Movie</b></label>
                    <div id="view_movieName" class="font-italic "></div>
                </div>
                <div class="form-group">
                    <label><b>Show</b></label>
                    <div id="view_showName" class="font-italic"></div>
                </div>
                <div class="form-group">
                    <label ><b>Ticket Rates</b></label>
                    <table class="table-bordered">
                        <thead>
                            <th class="p-2">Category</th>
                            <th class="p-2">Rate</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td style='padding:0; user-select:none'>
                                    <table align='center' style='margin:0; width:100%' class="category_field">
                                        
                                    </table>
                                </td>
                                <td style='padding:0; user-select:none'>
                                    <table align='center' style='margin:0; width:100%' class="rate_field">
                                        
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="editRatesModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Edit Ticket Rates</h4>
                </div>
            </div>
            <form action="assets/show_ticket_rates.update.php" id="editRatesForm">
                <div class="modal-body">
                    <input type="hidden" name="edit_show_id" id="edit_show_id">
                    <div class="form-group">
                        <label><b>Movie</b></label>
                        <div class="edit_movieName font-italic"></div>
                    </div>
                    <div class="form-group">
                        <label><b>Show</b></label>
                        <div class="edit_showName font-italic"></div>
                    </div>
                    <div id="edit_categoryDetails">
                        
                    </div>
                    <div class="alert-text edit_same hide" style="text-align: center;">Please Change Any Data to proceed!</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary editRatesBtn" type="submit">Edit Ticket Rates</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="dltTicketModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="assets/show_ticket_rates.action.php">
                <div class="modal-body">
                    <div class="form-group">
                        <h3>Are You Want to Delete?</h3>
                        <input type="hidden" name="dltID" id="dltID">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger dltTicketBtn" type="button">Delete</button>
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

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="js/addons/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/addons/datatables.bootstrap4.min.js"></script>
<script src="js/jquery-ui.js"></script>


<script>
    $('.table').DataTable({
        "lengthMenu":[5],
        "bLengthChange":false
    });
    function get_category_name(cat){
        var a = cat;
        $.ajax({
            url:'assets/show_ticket_rates.action.php',
            method:'POST',
            data:{cat:a},
            success:function(response){
                console.log(response);
            }
        })
        return a;
    }
    $('#shows').change(function(){
        $('.cat_return').addClass('hide');
        var category = $('#shows').val();
        $.ajax({
            url:'assets/show_ticket_rates.action.php',
            method:'POST',
            data:{category:category},
            success:function(response){
                if(response == 'None'){
                    $('.cat_return').removeClass('hide');
                    $('.cat_already').addClass('hide');
                    $('#category_details').empty();
                }else if(response == 'Already'){
                    $('.cat_already').removeClass('hide');
                    $('.cat_return').addClass('hide');
                    $('#category_details').empty();
                }else{
                    $('.cat_already').addClass('hide');
                    var arr = jQuery.parseJSON(response);
                    window.array = arr;
                    $('#category_details').empty();
                    for (var i = 0; i < arr.length; i++) {
                        $('#category_details').append('<div class="form-group"><input type="text" name="category[]" readonly  class="form-control" value="'+ get_category_name(arr[i]) +'"></div><div class="row"><div class="form-group col"><label>Ticket Rate</label><input type="number" class="form-control" id="fullRate'+ i +'" name="fullRate[]" placeholder="Rs. 0.00"><div class="alert-text fullAlert'+ i +' hide">Please Enter Amount</div></div></div></div>')
                    }
                }
            }
        })
    });
    function validate(length){
        var arr = length;
        var check = 0;
        for (var i = 0; i < arr; i++) {
            if($("#fullRate" + i).val().length == 0){
                $(".fullAlert" + i).removeClass('hide');
                $("#fullRate" + i).focus();
                return false;
                break;
            }else{
                $(".alert-text").addClass('hide');
                    check +=1;
                    if(check == arr){
                        return true;
                    }
                    continue;
            }
        }
    }
    $('.addTicketRateBtn').on('click',function(e){
        e.preventDefault();
        var data= $('#addTicketRateForm').serialize();
        if(validate(window.array.length)){
            $.ajax({
                url:'assets/show_ticket_rates.insert.php',
                method:"POST",
                data:data,
                success:function(response){
                    $("#addTicketRateModal").modal('hide');
                    if(response == 'Success'){
                        $('#success-box').modal('show');
                        $('.success-text').text('Ticket Rates Added Successfully!');
                        setTimeout(function(){
                            $('#success-box').modal('hide');
                            location.reload();
                        },2000);
                    }else if(response == 'Error'){
                        $('#error-box').modal('show');
                        $('.error-text').text('Error Occured!');
                        setTimeout(function(){
                            $('#error-box').modal('hide');
                            $('#addTicketRateForm')[0].reset();
                        },2000);
                    }
                }
            });
        }
    });
    $('.viewRatesBtn').on('click',function(){
        $("#viewRatesModal").modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        console.log(data)
        $('.category_field,.rate_field').empty();
        $('#view_movieName').text(data[2]);
        $('#view_showName').text(data[3]);
        var cat = jQuery.parseJSON(data[4]);
        var full = jQuery.parseJSON(data[5]);
        for (var i = 0; i < cat.length; i++) {
            $('.category_field').append('<tr><td class="p-2">'+ cat[i] +'</td></tr>');
        }
        for (var j = 0; j < full.length; j++) {
            $('.rate_field').append('<tr><td class="p-2">Rs. '+ full[j] +'.00</td></tr>');
        }
    });
    $(".edit_Btn").on('click',function(){
        $("#editRatesModal").modal('show');
        $("#edit_categoryDetails").empty();
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        $('#edit_show_id').val(data[1]);
        $('.edit_movieName').text(data[2]);
        $('.edit_showName').text(data[3]);
        var cat = $.parseJSON(data[4]);
        var full = $.parseJSON(data[5]);
        window.length = cat.length;
        for (var i = 0; i < cat.length; i++) {
            $('#edit_categoryDetails').append('<div class="form-group"><input type="text" name="category[]" readonly  class="form-control" value="'+ cat[i] +'"></div><div class="row"><div class="form-group col"><label>Full Ticket Rate</label><input type="number" class="form-control" id="fullRate'+ i +'" name="fullRate[]" placeholder="Rs. 0.00"><div class="alert-text fullAlert'+ i +' hide">Please Enter Amount</div></div></div></div>');
        }
        for (var j = 0; j < full.length; j++) {
            $('#fullRate' + j).val(full[j]);
        }
    });
    $('.editRatesBtn').on('click',function(e){
        e.preventDefault();
        var data = $('#editRatesForm').serialize();
        if(validate(window.length)){
            $.ajax({
                url:"assets/show_ticket_rates.update.php",
                method:"POST",
                data:data,
                success:function(response){
                    if(response == 'Same'){
                        $(".edit_same").removeClass('hide');
                    }else if(response == 'Success'){
                        $("#editRatesModal").modal('hide');
                        $(".edit_same").addClass('hide');
                        $('#success-box').modal('show');
                        $('.success-text').text('Ticket Rates Edited Successfully!');
                        setTimeout(function(){
                            $('#success-box').modal('hide');
                            location.reload();
                        },2000);
                    }else{
                        $("#editRatesModal").modal('hide');
                        $(".edit_same").addClass('hide');
                        $('#error-box').modal('show');
                        $('.error-text').text('Error Occured!');
                        setTimeout(function(){
                            $('#error-box').modal('hide');
                        },2000);
                    }
                }
            });
        }
    });
    $('.dlt_Btn').on('click',function(){
        $('#dltTicketModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        $("#dltID").val(data[1]);
    });
    $('.dltTicketBtn').on('click',function(e){
        e.preventDefault();
        var dlt = $("#dltID").val();
        $.ajax({
            url:"assets/show_ticket_rates.action.php",
            method:"POST",
            data:{ticket_dlt:dlt},
            success:function(response){
                $('#dltTicketModal').modal('hide');
                if(response == 'Success'){
                    $('#error-box').modal('show');
                    $('.error-text').text('Ticket Rates Deleted Successfully!');
                    setTimeout(function(){
                        $('#error-box').modal('hide');
                        location.reload();
                    },2000);
                }else{
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
