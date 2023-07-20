<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');

$query = "SELECT A.ticket_id, B.movie_name, A.showdate,A.amount,A.payment_status, A.showtime, A.seats, A.screen,C.theatre_name, D.first_name,D.last_name FROM tbl_booking A, tbl_movies B, tbl_theatres C, tbl_users D WHERE A.movie_id=B.movie_id AND A.theatre_id = C.theatre_id AND A.user_id = D.user_id ORDER BY ticket_id DESC";
$result = mysqli_query($db, $query);

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
    <link href="css/style.css?=<?php echo time(); ?>" rel="stylesheet">
    <link href="css/addons/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                <li class='active'>
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
                <div class="content-body">
                    <h2 style="position: absolute;z-index: 1;"> Bookings</h2>
                    <table class="table table-hover table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Ticket ID</th>
                        <th>Movie Name</th>
                        <th>Seats</th>
                        <th>Show Date</th>
                        <th>Show Time</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Payment</th>
                    </thead>
                    <tbody>
                        <?php $inc = 1;
                        while($row = mysqli_fetch_assoc($result)){ ?>
                            <tr>
                                <td><?php echo $inc; ?></td>
                                <td><?php echo $row['ticket_id']; ?></td>
                                <td><?php echo $row['movie_name']; ?></td>
                                <td><?php echo $row['seats']; ?></td>
                                <td><?php echo date('D, j M',strtotime($row['showdate'])); ?></td>
                                <td><?php echo $row['showtime']; ?></td>
                                <td><?php echo $row['first_name'].' '. $row['last_name']; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php if($row['payment_status'] == '1'){
                                    echo 'Paid!!';
                                }else{
                                    echo 'Unpaid!!';
                                } ?></td>
                            </tr>
                        <?php $inc++; } ?>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).ready(function () {
            $('.table').dataTable({
                "lengthMenu":[5],
                "bLengthChange":false
            })
        });
        
    </script>
    <script>
        $('.bars').on('click',function(){
            $('#sidebar').toggleClass('active');
        });
    </script>

</body>
</html>