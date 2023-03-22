<?php
session_start();
include_once ('db_config.php');

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
  
  <!--Favicon-->
  <link rel="shortcut icon" type="image/png" href="images/icon.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.min.css" rel="stylesheet">
  <!-- MDBootstrap Datatables  -->
  <link href="css/addons/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- JQuery UI - Datepicker -->
  <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
  <!--JQuery Toast Plugin CSS-->
  <link rel="stylesheet" type="text/css" href="css/jquery.toast.min.css">

  <style>
    .logo-wrapper-custom{
        margin-top: 10px;
        text-align: center;
        color: white;
        user-select: none;
    }
    .list-group{
        position: relative !important;
        top: -25px !important;
    }
    @media only screen and (min-width: 800px)  {
        .card .table-responsive {
            overflow-x: auto;
        }
    }
    #id_column {
        width: 45px;
        text-align: center;
    }
    .add_new_theatre {
        text-align: center;
    }
</style>
</head>

<body class="grey lighten-4">

  <!--Main Navigation-->
  <?php include ('header.php'); ?>
  <!--Main Navigation-->


  <!--Main layout-->
  <main class="pt-5 mx-lg-5">
    <div class="container-fluid mt-5">

        <!-- Editable table -->
        <div class="card">
            <h3 class="card-header text-center font-weight-bold text-uppercase py-3">Bookings</h3>
            <div class="card-body">
                
                <br>
                <div id="output" class="table-responsive">
                    <table id="table" class="table">
                        <thead class="grey lighten-1">
                            <tr>
                                <th>#</th>
                                <th>Ticket ID</th>
                                <th>Booking Time</th>
                                <th>User ID</th>
                                <th>Movie</th>
                                <th>Theatre</th>
                                <th>Show Date</th>
                                <th>Show Time</th>
                                <th>Category</th>
                                <th>Ticket Count</th>
                                <th>Seat(s)</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $sql = "SELECT A.*, GROUP_CONCAT(A.seat_number ORDER BY A.seat_id ASC) AS seat_number, B.movie_name, C.theatre_name, C.city, E.starting_time FROM tbl_bookings A, tbl_movies B, tbl_theatres C, tbl_shows D, tbl_showtimes E WHERE A.show_id = D.show_id AND B.movie_id = D.movie_id AND C.theatre_id = D.theatre_id AND A.showtime_id = E.showtime_id  GROUP BY A.ticket_id ORDER BY booking_id DESC";
                                $result = mysqli_query($db,$sql);
                                if(mysqli_num_rows($result)>0){
                                    $i=0;
                                    while($row=$result->fetch_assoc()){
                                        $i++;
                                        $show_datetime = strtotime($row['show_date']." ".$row['starting_time']);
                                        $current_datetime = time();
                                        $timeDiff =  $show_datetime - $current_datetime;
                                        echo "<tr>";
                                            echo "<td>{$i}</td>";
                                            echo "<td>{$row['ticket_id']}</td>";
                                            echo "<td>{$row['booking_time']}</td>";
                                            echo "<td>";
                                            if($row['user_id']==0){
                                                echo "None";
                                            }else{
                                                echo $row['user_id'];
                                            }
                                            echo "</td>";
                                            echo "<td>{$row['movie_name']}</td>";
                                            echo "<td>{$row['theatre_name']} - {$row['city']}</td>";
                                            echo "<td>{$row['show_date']}</td>";
                                            echo "<td>".date('h:i A', strtotime($row['starting_time']))."</td>";
                                            echo "<td>{$row['ticket_category']}</td>";
                                            echo "<td>"."Full: {$row['full_seat_count']}"."<br>"."Kids: {$row['kids_seat_count']}"."</td>";
                                            echo "<td>{$row['seat_number']}</td>";
                                            echo "<td>Rs. ".number_format((float)$row['total_amount'], 2, '.', '')."</td>";
                                            echo "<td style='text-align:center'>";
                                                if($row['status'] == '2'){
                                                    echo "<span style='font-weight:bold;color:#c40099'>Sold<br>(&#10003;)</span>";
                                                }else if($row['status'] == '1'){
                                                    if ($timeDiff > 3600){
                                                        echo "<span style='font-weight:bold;color:#017ec6'>Published</span>";
                                                    }else{
                                                        echo "<span style='font-weight:bold;color:#ce0000'>Not sold<br>(&#10007;)</span>";
                                                    }
                                                }else{
                                                    if ($timeDiff > 0){
                                                        echo "<span style='font-weight:bold;color:green'>Booked</span>";
                                                    }else{
                                                        echo "<span style='font-weight:bold;font-size:20px;color:green'>&#10003;</span>";
                                                    }
                                                }
                                                echo "</td>";
                                        echo "</tr>";
                                    }
                                }else{
                                    echo "<tr><td colspan='13' style='padding-left:7px'>No bookings found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Editable table -->

    </div>
  </main>
  <!--Main layout-->


  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- MDBootstrap Datatables  -->
  <script type="text/javascript" src="js/addons/jquery.dataTables.min.js"></script>
  <script src="js/addons/dataTables.bootstrap4.min.js"></script>
  <!-- JQuery UI - Datepicker -->
  <script type="text/javascript" src="js/jquery-ui.js"></script>
  <!-- JQuery Toast Plugin JS-->
  <script src="js/jquery.toast.min.js"></script>
  <!-- Initializations -->
  <script type="text/javascript">
    // Animations initialization
    new WOW().init();
  </script>

<script>
    $(document).ready(function () {
        $('.table').DataTable({
            "ordering": false,
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>

<script>
    $(document).ready(function () {
        //Open Update Modal
        $(document).on("click",".edit_button",function(){
            $('#updateModal').modal('show');
        });
        
        //Open Delete Modal
        $(document).on("click",".delete_button",function(){
            var del = $(this);
            var id = $(this).attr("showID");
            showID_delete = id;

            $('#deleteModal').modal('show');

        });
    });
</script>


<script type="text/javascript">
     function validateFileType(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
        var fileName = document.getElementById("fileName").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){

            //TO DO
        }else{
            alert("Only jpg/jpeg and png files are allowed!");
        }   
    }
   
</script>

<script>
    $(".sidebar-fixed .list-group .list-group-item.item-9").addClass("active");
</script>

</body>

</html>
