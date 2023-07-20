<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');

$query = "SELECT * from tbl_movies ORDER BY movie_id DESC";
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
    <title>theMovieBook - Admin | Movies</title>
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
                <li class="active">
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
                    <h2 class="font-italic">Movies</h2>
                </div>
                <div class="content-body">
                    <button class="btn btn-primary addmovie" data-toggle="modal" data-target="#searchMovieModal" style="position: absolute;z-index: 1;">Add Movie</button>
                    <table class="table table-hover table-bordered">
                    <thead>
                        <th>#</th>
                        <th class="hide">ID</th>
                        <th>Name</th>
                        <th class="hide">Category</th>
                        <th>Release Date</th>
                        <th>Running Time</th>
                        <th class="hide">Start Date</th>
                        <th class="hide">End Date</th>
                        <th>Release Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $inc = 1;
                        while($row = mysqli_fetch_assoc($result)){ ?>
                            <tr>
                                <td><?php echo $inc; ?></td>
                                <td class="hide"><?php echo $row['movie_id']; ?></td>
                                <td><?php echo $row['movie_name']; ?></td>
                                <td class="hide"><?php $row['category']; ?></td>
                                <td><?php echo date('d-M-Y',strtotime($row['release_date'])); ?></td>
                                <td><?php echo $row['running_time']; ?></td>
                                <td class="hide"><?php echo $row['starting_date']; ?></td>
                                <td class="hide"><?php echo $row['ending_date']; ?></td>
                                <td><?php if($row['status'] == '1'){
                                    echo 'Show Running!!';
                                }else{
                                    echo 'Show Closed!!';
                                } ?></td>
                                <td>
                                    <button class="edit_button btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="delete_button btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
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
        $(document).on('show.bs.modal',function(){
            $('.addmovie').css('z-index','0');  
        });
        $(document).on('hide.bs.modal',function(){
            $('.addmovie').css('z-index','9999');
        })
        
    </script>
    <div class="modal fade" tabindex="-1" role="dialog" id="editMovieModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="assets/movies.edit.update.php" method="post" id="editMovieForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="movie_id" id="edit_id">
                        <div class="form-group">
                            <input type='text' id="edit_name" class="form-control" name="movie_name"   title="Three or more letter" required>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <input type="text" name="startDate" id="edit_startDate" class="form-control" placeholder="Enter Start Date">
                            </div>
                            <div class="form-group col">
                                <input type="text" name="endDate" id="edit_endDate" class="form-control" placeholder="Enter End Date">
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="status" name="status">
                                <option value="1" for="status">Active</option>
                                <option value="0" for="status">InActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="save" class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="dltMovieModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="assets/movies.delete.php" method="post" id="dltMovieForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <h3>Are You Want to Delete?</h3>
                            <input type="hidden" name="movie_id" id="dlt_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="dlt" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="searchMovieModal">
      <div class="modal-dialog" role="document">
    	<div class="modal-content">
            <div class="modal-body">
                <form id="searchForm">
                    <div class="form-group">
                        <input type="text" class="searchBox form-control" placeholder="Search Movies here" id="searchText">
                    </div>
                </form>
                <div class="container">
                    <div id="movies" class="row"></div>
                </div>
            </div>
          </div>
    	</div>
      </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addMovieModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="assets/movies.add.insert.php" method="post" id="addMovieForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col">
                                <label> Movie Name</label>
                                <input type="text" name="movie_name" id="movie_name" class="form-control">
                            </div>
                            <div class="form-group col">
                                <label>Year</label>
                                <input type="text" name="movie_year" id="movie_year" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Category</label>
                                <input type="text" name="movie_category" id="movie_category" class="form-control">
                            </div>
                            <div class="form-group col">
                                <label>Language</label>
                                <input type="text" name="movie_language" id="movie_language" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Casts</label>
                            <input type="text" name="movie_cast" id="movie_cast" class="form-control">
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Director</label>
                                <input type="text" name="movie_director" class="form-control" id="movie_director">
                            </div>
                            <div class="form-group col">
                                <label>Release Date</label>
                                <input type="text" name="movie_release" class="form-control" id="movie_release">
                            </div>
                        </div>
                        <input type="hidden" name="poster" id="movie_poster">
                        <input type="hidden" name="banner" id="movie_banner">
                        <input type="hidden" name="movie_overview" id="movie_overview">
                        <input type="hidden" name="movie_video_url" id="movie_video_url">
                        <div class="row">
                            <div class="form-group col">
                                <label>Run Time</label>
                                <input type="text" name="movie_runtime" class="form-control" id="movie_runtime">
                            </div>
                            <div class="form-group col">
                                <label>Status</label>
                                <input type="text" name="status" class="form-control" id="movie_status">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label>Starting Date</label>
                                <input type="text" name="start_date" class="form-control" id="start_date" autocomplete="off">
                            </div>
                            <div class="form-group col">
                                <label>End Date</label>
                                <input type="text" name="end_date" class="form-control" id="end_date" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-dark" data-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-primary" name="addMovie" type="submit">Add Movie</button>
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
        $('.bars').on('click',function(){
            $('#sidebar').toggleClass('active');
        });
        function movieSelected(id) {
            var api = '5ec279387e9aa9488ef4d00b22acc451';
            var settings = {
                  "async": true,
                  "crossDomain": true,
                  "url": 'https://api.themoviedb.org/3/movie/' + id +'?api_key=' +api,
                  "method": "GET"
                }
            $.ajax(settings).done(function(response){
                $('#searchMovieModal').modal('hide');
                $('#addMovieModal').modal('show');
                $('#movie_name').val(response.original_title);
                $('#movie_year').val(response.release_date.slice(0,4));
                let categories = '';
                for (var i = response.genres.length - 1; i >= 0; i--) {
                    categories = categories + response.genres[i].name;
                    categories = categories + ', ';
                }
                $('#movie_category').val(categories.substring(0,categories.length - 2));
                let language = '';
                for (var i = response.spoken_languages.length - 1; i >= 0; i--) {
                    language = language + response.spoken_languages[i].name;
                    language = language + ', ';
                }
                $('#movie_language').val(language.substring(0,language.length - 2));
                $('#movie_release').val(response.release_date);
                var casts = {
                    "async":true,
                    "crossDomain":true,
                    "url":'https://api.themoviedb.org/3/movie/' + id + '/credits?api_key=' + api,
                    "method":"GET" 
                }
                var video_url = {
                    "async":true,
                    "crossDomain":true,
                    "url":'http://api.themoviedb.org/3/movie/' + id + '?api_key=' + api + '&append_to_response=videos',
                    "method":"GET"
                }
                $('#movie_poster').val('https://image.tmdb.org/t/p/w185_and_h278_bestv2' + response.poster_path);
                $('#movie_banner').val('https://image.tmdb.org/t/p/original' + response.poster_path);
                $('#movie_runtime').val(response.runtime + ' Minutes');
                $("#movie_status").val(response.status);
                $('#movie_overview').val(response.overview);
                let cast_name = '';
                $.ajax(casts).done(function(cast){
                    var a = 0;
                    for (var i = 0; i <= cast.cast.length - 1; i++) {
                        cast_name = cast_name + cast.cast[i].name;
                        cast_name = cast_name + ', ';
                        a++;
                        if(a == 4){
                            break;
                        }
                    }
                    $('#movie_cast').val(cast_name.substring(0,cast_name.length - 2));
                    for (var i = cast.crew.length - 1; i >= 0; i--) {
                        if(cast.crew[i].job == 'Director'){
                            $('#movie_director').val(cast.crew[i].name);
                        }
                    }
                });
                $.ajax(video_url).done(function(video){
                    console.log(video);
                    for (var i = 0; i < video.videos.results.length; i++) {
                        if(video.videos.results[i].type == 'Trailer'){
                            var trailer = 'https://www.youtube.com/watch?v=' + video.videos.results[i].key;
                            $('#movie_video_url').val(trailer);
                        }
                    }
                });

            })
        }
        $('#start_date,#edit_startDate').datepicker({
            startDate:'+1',
            autoclose:true,
            minDate:"+1d",
            dateFormat:"yy-mm-dd",
            onClose:function(data){
                $(this).focus();
            }
        });
        $('#end_date,#edit_endDate').datepicker({
            startDate:'+2',
            autoclose:true,
            minDate:"+8d",
            dateFormat:"yy-mm-dd",
            onClose:function(data){
                $(this).focus();
            }
        });
    </script>
<script>
    $('#addMovieForm').on('submit',function(e){
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url:"./assets/movies.add.insert.php",
            method:"POST",
            data:data,
            success:function(response){
                console.log(response);
                $('#addMovieModal').modal('hide');
                if(response == 'Success'){
                    $('#success-box').modal('show');
                    $('.success-text').text('Movie Added Successfully!');
                    setTimeout(function(){
                        $('#success-box').modal('hide');
                        location.reload();
                    },2000);
                }else if(response == 'Error'){
                    $('#error-box').modal('show');
                    $('.error-text').text('Error Occured!');
                    setTimeout(function(){
                        $('#error-box').modal('hide');
                        $('#searchForm')[0].reset();
                        $('#addMovieForm')[0].reset();
                    },2000);
                }
            }
        })
    })
    $('.edit_button').on('click',function(){
        $('#editMovieModal').modal('show');
        $tr = $(this).closest('tr');
		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();
        $('#edit_id').val(data[1]);
        $('#edit_name').val(data[2]);
        $('#edit_startDate').val(data[6]);
        $('#edit_endDate').val(data[7]);
    });
    $('.delete_button').on('click',function(){
        $('#dltMovieModal').modal('show');
        $tr = $(this).closest('tr');
		var data = $tr.children('td').map(function(){
			return $(this).text();
		}).get();
        $('#dlt_id').val(data[1]);
    });
</script>
</body>
</html>