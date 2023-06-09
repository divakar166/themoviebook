<?php
session_start();
include_once ('db_config.php');

$query = "SELECT * from tbl_offers ORDER BY offer_id DESC";
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
  <link href="css/addons/datatables.bootstrap4.min.css" rel="stylesheet">
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
    .add_new_offer {
        text-align: center;
    }
</style>
</head>

<body>

  <!--Main Navigation-->
  <?php include ('header.php'); ?>
  <!--Main Navigation-->


  <!--Main layout-->
  <main class="pt-5 mx-lg-5">
    <div class="container-fluid mt-5">

        <!-- Editable table -->
        <div class="card">
            <h3 class="card-header text-center font-weight-bold text-uppercase py-3">Offers</h3>
            <div class="card-body">
                <?php if($_SESSION['admin_id']=='1'){ ?>
                <a href="offers.add.php"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add New Offer</button></a>
            
                <?php } ?>
                
                <br>
                <div id="output" class="table-responsive">

                    <table id="table" class="table ">
                        <thead class="grey lighten-1">
                            <tr>
                                <th id="row_num_column">No</th>
                                <th id="id_column" class="hide">ID</th>
                                <th class="th-sm">Name</th>
                                <th class="th-sm">Start Date</th>
                                <th class="th-sm">End Date</th>
                                <th class="th-sm">Description</th>
                                <th class="th-sm">Image</th>
                                <th class="th-sm">Banner</th>
                                <?php if($_SESSION['admin_id']=='1'){ ?><th class="th-sm">ACTION</th><?php } ?>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            $i=0;
                            if(mysqli_num_rows($result)){
                            while($row = mysqli_fetch_assoc($result)){
                            $i+=1; ?>
                            <tr>
                                <td id='row_num_column'><?php echo $i;?></td>
                                <td class="hide" id='row_num_column'><?php echo $row['offer_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['start_date']; ?></td>
                                <td><?php echo $row['end_date']; ?></td>
                                <td ><?php
                                    echo strlen($row['description']) >= 110 ? 
                                    substr($row['description'], 0, 100).'...' : 
                                    $row['description'];
                                    ?>
                                </td>
                                <td><?php  echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image']).'" style="height:35%;"/>'; ?></td>
                                <td><?php  echo '<img src="data:image/jpeg;base64,'.base64_encode($row['banner']).'" style="height:20%"/>'; ?></td>
                                <?php if($_SESSION['admin_id']=='1'){ ?>
                                <td id='action_column'><a href="assets/offers.delete.php?offer_id=<?php echo $row['offer_id']; ?>"><button  type='button' class='delete_button'><i class='fa fa-trash'></i></button></a></td>
                                <?php } ?>
                            </tr>
                            <?php }} ?>
                            
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
        $('#table').DataTable({
            "ordering": false,
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>

<script>
    $(".sidebar-fixed .list-group .list-group-item.item-8").addClass("active");
</script>

</body>
</html>