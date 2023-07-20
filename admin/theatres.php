<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');

$query = "SELECT * from tbl_theatres";
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
    <script src="https://kit.fontawesome.com/7e7438f3ab.js"></script>
     <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/addons/datatables.bootstrap4.min.css" rel="stylesheet">
    <style>
        #searchResult li{
            padding: 2px;
            background: #d5d4d6;
            border-radius: 5px;
            margin: 8px 0;
            list-style: none;
            padding-left: 10px;
            cursor: pointer;
        }
        .place-city{
            padding-top: 2px;
            color: #8a8986;
        }
        .modal{
          overflow-y: scroll;
        }
    </style>
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
              <li>
                  <a href="carousel.php">
                      <span>Carousel</span>
                  </a>
              </li>
              <li class="active">
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
                  <h2 class="font-italic">Theatres</h2>
              </div>
              <div class="content-body">
                    <button class="btn btn-primary addtheatre" data-toggle="modal" data-target="#searchTheatreModal" style="position: absolute;z-index: 9999;">Add Theatre</button>
                    <table class="table" id="table">
                        <thead>
                            <th>#</th>
                            <th class="hide">ID</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Phone_number</th>
                            <th>Website</th>
                            <th>User Ratings</th>
                            <th>Status</th>
                            <th>ACTION</th>
                        </thead>
                        <tbody>
                            <?php
                                $i=0;
                                if(mysqli_num_rows($result)){
                                while($row = mysqli_fetch_assoc($result)){
                                $i+=1; ?>
                            <tr>
                                <td id='row_num_column'><?php echo $i;?></td>
                                <td class="hide" id='id_column'><?php echo $row['theatre_id']; ?></td>
                                <td><?php echo $row['theatre_name']; ?></td>
                                <td><?php echo $row['city']; ?></td>
                                <td><?php echo $row['telephone']; ?></td>
                                <td><?php echo $row['website']; ?></td>
                                <td><?php echo $row['avg_ratings']; ?></td>
                                <td><?php if($row['status'] == '1'){ ?>Active<?php }else { ?>Inactive<?php } ?></td>
                                <td><button class="btn btn-danger" value="<?php echo $row['theatre_id']; ?>" id="dltBtn"><i class="fas fa-trash"></i></button></td>
                            </tr>
                           <?php }} ?>
                        </tbody>
                    </table>
              </div>
          </div>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/addons/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/addons/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            "ordering": false,
            "lengthMenu":[5],
            "bLengthChange":false
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>


<div class="modal fade" tabindex="-1" role="dialog" id="addTheatreModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="assets/theatres.action.php" id="addTheatreForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col">
                            <input type='text' id="name" class="form-control" name="theatre_name"   title="Three or more letter" placeholder="Enter Theatre Name" required>
                        </div>
                        <div class="form-group col">
                            <input type='text' class="form-control" id="city" name="city"   title="Three or more letter" placeholder="Enter Theatre City" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type='text' class="form-control" id="address" name="address"   title="Three or more letter" placeholder="Enter Theatre Address" required>
                    </div>
                    <div class="form-group">
                        <input type='text' class="form-control" name="telephone" id="mobile" placeholder="Enter Mobile Number">
                    </div>
                    <div class="form-group">
                        <input type='text' class="form-control" id="website" name="website" placeholder="Enter Website">
                    </div>
                    <div class="form-group">
                        <label>Screens:</label>
                        <input type="number" class="form-control" name="screen" id="screen" placeholder="Screens">
                    </div>
                    <div class="form-group">
                        <select class="form-control " name="status" required>
                            <option value="1" for="status">Active</option>
                            <option value="0" for="status">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="addtheatre" class="btn btn-primary addTheatreBtn">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="searchTheatreModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h3>Search Theatre</h3>
                <form id="searchForm">
                    <input type="text" id="searchText" class="form-control">
                    <div id="searchResult">
                    </div>
                </form>
                <div class="ok"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="dltModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="asstes/theatre.action.php" method="post" id="dltForm">
                <div class="modal-body">
                    <input type="hidden" name="dltID" id="deleteID">
                    <h3>Are you sure you want to delete this theatre details?</h3>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
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
    $(document).ready(() => {
        $('#searchForm').on('input',(e) => {
            let searchText = $('#searchText').val();
            if(searchText == null){
                console.log(true);
            }
            getResult(searchText);
            e.preventDefault();
        });
    });
    $(document).on('show.bs.modal',function(){
        $('.addtheatre').css('z-index','0');
    });
    $(document).on('hide.bs.modal',function(){
        $('.addtheatre').css('z-index','9999');
    });
    function theatreSelected(id){
        console.log(id);
        $('#searchTheatreModal').modal('hide');
        $('#addTheatreModal').modal('show');
        $('#name').val(id.title);
        $('#city').val(id.address.city);
        $('#address').val(id.address.city + ', ' + id.address.district + ', ' + id.address.county );
        if(id.contacts[0].hasOwnProperty('mobile')){
          $('#mobile').val(id.contacts[0].mobile[0].value);
        }else if(id.contacts[0].hasOwnProperty('phone')){
          $('#mobile').val(id.contacts[0].phone[0].value);
        }else{
          $('#mobile').val('');
        }
        if(id.contacts[0].hasOwnProperty('www')){
          $('#website').val(id.contacts[0].www[0].value);
        }else{
          $('#website').val('');
        }
    }
    function getResult(searchText){
        $.ajax({
            url:'https://discover.search.hereapi.com/v1/discover?at=28.4020,77.8260&q=' + searchText + '&limit=10&apiKey=idG-m8iHh8xs3AONloacGI5Aey8PWdmhEaoswj3ZP0Y&in=countryCode:IND',
            type:'GET',
            beforeSend:function(xhr){
                xhr.setRequestHeader('Accept','application/json');
            },success:function(data){
                let html = '';
                var show = $('#searchResult');
                for (var i = 0; i <= data.items.length - 1; i++) {
                    var d = JSON.stringify(data.items[i]);
                    html += "<li onclick='theatreSelected("+ d +")'>"+ data.items[i].title +"<br><span class='place-city'>" + data.items[i].address.label + "</span></li>";
                }
                show.html(html);
            }
        });
    }

$('#addTheatreForm').on('submit',function(e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url:"assets/theatres.action.php",
            method:"POST",
            data:data,
            success:function(response){
                console.log(response);
                $('#addTheatreModal').modal('hide');
                if(response == 'Success'){
                    $('#success-box').modal('show');
                    $('.success-text').text('Theatre Added Successfully!');
                    setTimeout(function(){
                        $('#success-box').modal('hide');
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
    $('#dltBtn').on('click',function(){
        $('#dltModal').modal('show');
    });
    $('#dltForm').on('submit',function(e){
        e.preventDefault();
        var id = $('#dltBtn').val();
        $.ajax({
          url:"assets/theatres.action.php",
          method:"POST",
          data:{theatre_dlt:id},
          success:function(response){
            $('#dltModal').modal('hide');
            console.log(response);
            if(response == 'Success'){
                $('#success-box').modal('show');
                $('.success-text').text('Theatre Deleted Successfully!');
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
    });
</script>
</body>

</html>
