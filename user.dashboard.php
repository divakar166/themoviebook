<?php
session_start();
include_once ('db_config.php');
include_once ('functions.php');

if(isset($_SESSION['userID']) && !empty($_SESSION['userID']) && !($_SESSION['userID']=='0')) {
    $userID = $_SESSION['userID'];
	$user = "SELECT * FROM tbl_users WHERE `user_id` = '{$_SESSION['userID']}'";
	$user_result = $db->query($user);
	$user_row = $user_result->fetch_assoc();
    $query = "SELECT A.ticket_id, B.movie_name, A.showdate,A.amount,A.payment_status, A.showtime, A.seats, A.screen,C.theatre_name FROM tbl_booking A, tbl_movies B, tbl_theatres C  WHERE A.user_id='$userID' AND A.movie_id=B.movie_id AND A.theatre_id = C.theatre_id";
    $result = $db->query($query);

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	
		<!--JQuery Toast CSS-->
        <link rel="stylesheet" type="text/css" href="css/jquery.toast.min.css">

		<!--Custom Style CSS-->
		<link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
		
		<link rel="shortcut icon" type="image/png" href="images/icon.png">
		
        <title>theMovieBook - <?php echo $user_row['first_name'];?> | Dashboard</title>
        
        <style>
            .navbar {
                background:black !important;
            }
            @media (max-width: 575px){
                #ticketIDForm .form-control {
                    margin-bottom: 15px;
                }
                #ticketIDForm .row {
                    margin-left: 0;
                }
                #ticketIDForm .col-sm-7, .col-sm-3 {
                    padding-left: 0;
                    padding-right: 0;
                }
            }
        </style>

	</head>

	
  <body id="itemid-3">

	<!--Navbar Code - Start-->
    <?php include('header.php'); ?>
    <!--Navbar Code - End-->

	
    <div style="padding-top:85px;padding-bottom:25px;background-color:#ebebeb">
        <div class="container mt-3" style="background:#FFF;">
            <div style="padding:15px 15px 10px"><h1 style="text-align:center; font-size:20px; font-weight:normal; color:#001c8e; font-family:Arial, Helvetica, sans-serif">Welcome <?php echo $user_row['first_name']?>!</h1></div>
		</div>
        <div class="container mt-3" style="background:#FFF;padding-bottom:15px;text-align:center;">
        <p style="padding:5px 0;">Here you'll see all your booking data!</p>
        <div class="content-wrapper">
                
                <table class="table table-hover table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Ticket ID</th>
                        <th>Movie Name</th>
                        <th>Theatre</th>
                        <th>Show</th>
                        <th>Time</th>
                        <th>Seats</th>
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
                                <td><?php echo $row['theatre_name']; ?></td>
                                <td><?php echo getDateDay($row['showdate']); ?></td>
                                <td><?php echo $row['showtime']; ?></td>
                                <td><?php echo $row['seats']; ?></td>
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
	
        
	
	<!--Footer Code - Start-->
	<?php include('footer.php') ?>
	<!--Footer Code - End-->
	
	<!-- Optional JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.toast.min.js"></script>
		
	<script>
        jQuery(document).ready(function(){
            $('#buyTicketModal').on('shown.bs.modal', function () {
                $('#ticket_id').focus();
            });

            $("#ticketDetails").html("");

            $("#ticket_id").on("input", function(){
                $("#ticketDetails").html("");
                $("#invalid").hide();
            })
  
            $("#viewTicket").on("click", function(){
                var ticketID = $("#ticket_id").val();
                if(ticketID != ""){
                    $.ajax({
                        url:'assets/user.dashboard.buyTicket.view_ticket.php',
                        type:'POST',
                        data:'ticketID=' + ticketID,
                        success:function(html){
                            if(html!=""){
                                $("#ticketDetails").html(html);
                            }else{
                                $("#invalid").show();
                            }
                        }
                    });
                }
            });
  
            $('#buyTicketModal').on('hidden.bs.modal', function () {
                $("#ticket_id").val("");
                $("#ticketDetails").html("");
                $("#invalid").hide();
                $("#customerDetails").hide();
                $("#customerDetailsForm")[0].reset();
                $("#ticketIDForm").show();
                $("#confirm").show();
                $("#pay").hide();
                $("#ticketDetails").show();
                $("#errorForm").hide();
                $(".error_code").hide();
            });

            $("#confirm").on("click", function(){
                if($("#ticketDetails").html()!=""){
                    var ticketID = $("#ticket_id").val();
                    $.ajax({
                        url:'assets/user.dashboard.buyTicket.check.php',
                        type:'POST',
                        data:'ticketID=' + ticketID,
                        success:function(success){
                            if(success=="success"){
                                $("#ticketIDForm").hide();
                                $("#confirm").hide();
                                $("#pay").show();
                                $("#ticketDetails").hide();
                                $("#customerDetails").show();

                                $('#customer_name').focus();
                                
                                var remaining_time = 200;
                                document.getElementById("timer").innerHTML = remaining_time;
                                var Timer = setInterval(function(){
                                    remaining_time -= 1;
                                    document.getElementById("timer").innerHTML = remaining_time;
                                    if(remaining_time <= 0){
                                        remaining_time = 0;
                                        clearInterval(Timer);
                                        $("#buyTicketModal").modal("hide");
                                    }
                                    $('#buyTicketModal').on('hidden.bs.modal', function () {
                                        clearInterval(Timer);
                                    });
                                }, 1000);
                            }else{
                                $.toast({
                                    text: "Ticket is unavailable.",
                                    icon: 'error',
                                    position: 'top-center',
                                    hideAfter: 4000,
                                    stack: false,
                                    loader: false
                                });
                            }
                        }
                    }); 
                }
            });

            $("#pay").on("click", function(){
                var customername = jQuery("#customer_name").val();
                var customerphone = jQuery("#customer_mobile").val();
                var customeremail = jQuery("#customer_email").val();
                
                var numberfilter = /^((\+[1-9]{1,10}[ \-]*)|(\([0-9]{2,10}\)[ \-]*)|([0-9]{2,10})[ \-]*)*?[0-9]{3,10}?[ \-]*[0-9]{0,10}?$/;
                var emailfilter = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

                if(customername!="" && customerphone!="" && customeremail!=""){
                    if (!numberfilter.test(customerphone) || customerphone.length!=10) {
                        jQuery("#errorForm").show();
                        jQuery("#errorForm").html("Invalid phone number !");

                    }else{
                        if(!emailfilter.test(customeremail)){
                            jQuery("#errorForm").show();
                            jQuery("#errorForm").html("Invalid email !");
                        }else{
                            jQuery("#errorForm").hide();
                            saveUserData();
                        }
                    }
                }else{
                    jQuery("#errorForm").show();
                    jQuery("#errorForm").html("Fields can not be empty !");
                }
            });

            function saveUserData() {
                if(jQuery('#terms').prop('checked')){
                    jQuery(".error_code").hide();

                    var user_data = $("#customerDetailsForm").serialize();
                    var paymentType = $("input[name='payment_type']:checked").val();
                    window.location = "assets/user.dashboard.buyTicket.payment.php?" + user_data + "&paymentType=" + paymentType;
                
                }else{
                    jQuery(".error_code").show();
                }
            }

            $('#customer_mobile').keyup(function() {
                $(this).val(
                    $(this).val()
                        .replace(/^[^0]*/, '') // Remove starting non-zero characters
                        .replace(/[^\d]*/g, '') // Remove non-digit characters
                    );
                }
            );
		});
	</script>


  </body>
</html>

<?php
}else{
    header('location: index.php');
}
?>