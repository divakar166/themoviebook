<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');

if(!isset($_SESSION['admin_id'])) {
    header('location: index.php');
}
$query = "SELECT * FROM tbl_users";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>theMovieBook - Admin | Users</title>
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
                <li class="active">
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
                <h2 class="font-italic">Users</h2>
            </div>
            <div class="content-body">
                <button class="btn btn-primary addShow" data-toggle="modal" data-target="#addShowModal" style="position: absolute;z-index: 1;">Add New Show</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile Number</th>
                            <th class="hide">username</th>
                            <th class="hide">email</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) { 
                         ?>
                         <tr>
                            <td><?php echo $i; ?></td>
                             <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                             <td><?php echo $row['mobile']; ?></td>
                             <td class="hide"><?php echo $row['username']; ?></td>
                             <td class="hide"><?php echo $row['email']; ?></td>
                             <td><?php echo "<button class='btn btn-secondary view_btn'><i class='fas fa-eye'></i></button>";?></td>
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


<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h4>User Details</h4>
                </div>
            </div>
            <form action="#" id="viewUserForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" disabled>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" class="form-control" id="mobile" disabled>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" id="username" disabled>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
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
    $('.view_btn').on('click',function(){
        $('#viewUserModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children('td').map(function(){
            return $(this).text();
        }).get();
        console.log(data)
        $("#name").val(data[1]);
        $("#mobile").val(data[2]);
        $("#username").val(data[3]);
        $("#email").val(data[4]);
    });

</script>
</body>

</html>
