<header>

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg nav-dark bg-dark">
      <div class="container-fluid">

        <!-- Brand -->
        <div class="navbar-brand">
            <strong style="color: #fff;" class="font-italic"><?php echo strtoupper($_SESSION['username']) ?></strong>
        </div>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <!-- Left -->
          <ul class="navbar-nav mr-auto">

            <div id="nav_list_groups" style="padding:10px">
              <hr style="width:100%; border:0.5px solid white">
              
                <div class="">
                    <!-- <a href="dashboard.php" class="item-0">
                        <i class="fas fa-chart-pie mr-3"></i>Dashboard</a> -->
                    <a href="movies.php" class="item-1">
                        <i class="fas fa-film mr-3"></i>Movies</a>
                    <a href="carousel.php" class="item-7">
                        <i class="fas fa-images mr-3"></i>Carousel</a>
                    <a href="offers.php" class="item-8">
                        <i class="fas fa-tags mr-3"></i>Offers</a>
                    <!-- <a href="dashboard.php" class="item-0">
                        <i class="fas fa-chart-pie mr-3"></i>Dashboard</a> -->
                    <a href="theatres.php" class="item-2">
                        <i class="fas fa-building mr-3"></i>Theatres</a>
                    <a href="theatre_seat_categories.php" class="item-3">
                        <i class="fas fa-table mr-3"></i>Seat Maps</a>
                    <a href="shows.php" class="item-4">
                        <i class="fas fa-calendar-alt mr-3"></i>Shows</a>
                    <a href="showtimes.php" class="item-5">
                        <i class="fas fa-clock mr-3"></i>Showtimes</a>
                    <a href="show_ticket_rates.php" class="item-6">
                        <i class="fas fa-money-bill-alt mr-3"></i>Show Ticket Rates</a>
                    <a href="offers.php" class="item-8">
                        <i class="fas fa-tags mr-3"></i>Offers</a>
                    <a href="bookings.php" class="item-9">
                        <i class="fas fa-ticket-alt mr-3"></i>Bookings</a>
                    <a href="payments.php" class="item-11">
                        <i class="fas fa-coins mr-3"></i>Payments</a>
                    <a href="refunds.php" class="item-10">
                        <i class="fas fa-coins mr-3"></i>Refunds</a>
                </div>
              
              <hr style="width:100%; border:0.5px solid white">
            
            </div>
          </ul>

          <!-- Right -->
          <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
              <a class="nav-link logout-button" href="admin.logout.php">
                Logout
              </a>
            </li>
          </ul>

        </div>

      </div>
    </nav>
    <!-- Navbar -->

    <!-- Sidebar -->
    <div class="sidebar-fixed position-fixed bg-dark">

      <div class="logo-wrapper-custom" style="margin-bottom:35px; font-size:20px">
        <img src="images/logo.png" width="180px" height="40px" class="img-fluid" alt="InstaMovies Private Limited">
      </div>

      <div class="list-group list-group-flush ">
        <a href="movies.php" class="list-group-item item-1">
            <i class="fas fa-film mr-3"></i>Movies</a>
        <a href="carousel.php" class="list-group-item item-7">
            <i class="fas fa-images mr-3"></i>Carousel</a>
        <a href="theatres.php" class="list-group-item item-2">
            <i class="fas fa-building mr-3"></i>Theatres</a>
        <a href="theatre_seat_categories.php" class="list-group-item item-3">
            <i class="fas fa-table mr-3"></i>Seat Maps</a>
        <a href="shows.php" class="list-group-item item-4">
            <i class="fas fa-calendar-alt mr-3"></i>Shows</a>
        <a href="showtimes.php" class="list-group-item item-5">
            <i class="fas fa-clock mr-3"></i>Showtimes</a>
        <a href="show_ticket_rates.php" class="list-group-item item-6">
            <i class="fas fa-money-bill-alt mr-3"></i>Show Ticket Rates</a>
        <a href="offers.php" class="list-group-item item-8">
            <i class="fas fa-tags mr-3"></i>Offers</a>
        <a href="bookings.php" class="list-group-item item-9">
            <i class="fas fa-ticket-alt mr-3"></i>Bookings</a>
        <a href="payments.php" class="list-group-item item-11">
            <i class="fas fa-coins mr-3"></i>Payments</a>
        <a href="refunds.php" class="list-group-item item-10">
            <i class="fas fa-coins mr-3"></i>Refunds</a>
      </div>

    </div>
    <!-- Sidebar -->

</header>

<style>

@media only screen and (min-width: 1200px) {
#nav_list_groups{
  display: none;
}}

#nav_list_groups a{
  color: white;
  padding:10px;
}

#nav_list_groups a:hover{
  color: red;
}

#nav_list_groups a:focus, a:active{
  color: red;
  background-color:none;
}

#nav_list_groups a.waves-effect{
  border-radius: 15px;
}

</style>