<?php

session_start();
include_once('../db_config.php');
include_once('../functions.php');
$_SESSION['showID']=$_GET['showID'];
$_SESSION['movieID']=$_GET['movieID'];
$_SESSION['theatreID']=$_GET['theatreID'];
$_SESSION['showDate']=$_GET['showDate'];
$_SESSION['showTimeID']=$_GET['showTimeID'];
$_SESSION['screen'] = $_GET['screen'];
$seatCategoryID = getSeatCatID($db,$_SESSION['theatreID'],$_SESSION['screen']);
$seat_sql = "SELECT * FROM tbl_theatre_seat_categories WHERE seat_category_id = '$seatCategoryID'";
$seat_result = $db->query($seat_sql);
while ($seat = mysqli_fetch_assoc($seat_result)) {
    $categories = json_decode($seat['category_name']);
    $num_of_rows = json_decode($seat['num_of_rows']);
    $num_of_cols = json_decode($seat['num_of_columns']);
    $max_col = max($num_of_cols);
}

if(isset($_SESSION['userID'])){
    $userLogged = True;
    $userID = $_SESSION['userID'];
}else{
    $userLogged = False;
    $userID = 0;
}

$sql = "SELECT * FROM tbl_seat_maps WHERE seat_category_id = '$seatCategoryID'";
$result = $db->query($sql);
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $seatMapArray = json_decode($row['seat_number']);
    }
}

?>

<div class="modal_content_tickets" style="color:#fff">
    <div class="modal-header">
        <h6 class="modal-title"><?php echo getMovieName($db,$_SESSION['movieID']); ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div id="timer" style="font-size:25px;color:red;text-align:center"></div>
    </div>

    <div class="modal-body">
        <!--Modal Body-->
        <form class="first_form">
            <div class="container-fluid" align="center">
                <div class="theatre_name"><?php echo getTheatreName($db,$_SESSION['theatreID']); ?></div>
                <div class="showtime"><?php echo $_SESSION['showTimeID']; ?></div>
                <div id="ticket_id"></div>
                <div id="seat_map">
                    <?php 
                        echo '<div class="hide warning" style="color:red;"></div>';
                        echo '<table class="table seat_map_wrap">';
                        echo '<tbody>';

                            $alpha = range('A', 'Z');
                            for ($cat=0; $cat <= count($categories) - 1; $cat++) {
                                $catName = get_category_name($db,$categories[$cat]);
                                $rate = getTicketRates($db,$categories[$cat],$seatCategoryID);
                                echo '<tr class="category_head"><td colspan="2">' . $catName . ' : ₹ '.$rate.'</td></tr>';
                                if($num_of_cols[$cat] < $max_col){
                                    $tdCheck = true;
                                    $diff = ($max_col - $num_of_cols[$cat]) / 2;
                                    $addup = '';
                                    for ($i=1; $i <= $diff ; $i++) { 
                                        $addup .= '<span class="seat"></span>';
                                    }
                                }else{
                                    $tdCheck = false;
                                }
                                for ($row = $num_of_rows[$cat]; $row >= 1 ; $row--){
                                        echo '<tr class="seat_row">';
                                            echo '<td>';
                                                echo '<div class="seat_row_label">'.$alpha[$num_of_rows[$cat] - $row].'</div>';
                                            echo '</td>';
                                            echo '<td class="seat_row_seats">';
                                                if($tdCheck){
                                                    echo $addup;
                                                }
                                                for ($col = 1; $col <= $num_of_cols[$cat]; $col++){
                                                    $seatNo = $alpha[$num_of_rows[$cat] - $row].$col;
                                                    echo '<span class="seat">';
                                                        echo '<div class="seatDiv">';
                                                            echo '<a i="seat_label" category="'.$catName.'" row_index="'.$row.'" col_index="'.$col.'" rate="'.$rate.'" seatNo="'.$seatNo.'">'.$seatNo.'</a>';
                                                        echo '</div>';
                                                    echo '</span>';
                                                }
                                            echo '</td>';
                                        echo '</tr>';
                                        $last = $alpha[($num_of_rows[$cat] - $row) + 1];
                                }
                                $alpha = range($last,'Z');
                            }
                            echo '<tr>
                                <td colspan="2">
                                    <div class="screen_area">
                                        <span>THEATRE SCREEN</span>
                                    </div>
                                </td>
                            </tr>';
                            echo '</tbody>';
                        echo '</table>';
                        echo '<div id="pay" class="hide pay_btn">Book <span id="ticketCount"></span> Tickets</div>';


                    ?>
                </div>
            </div>
        </form>
        <div class="login_div hide">
            <span style="color:red">You're not logged in!</span>
            <p style="color:red">Please <a href="./login.php">Login</a></p>
        </div>
        <div class="ticket_div hide">
            <div class="ticket">
                <div class="movie_details">
                    <div class="inner_div">
                        <div class="movie_name"></div>
                        <div class="theatre_name"></div>
                        <div class="ticket_details">
                            <div class="date_time" style="width:50%">
                                <div class="date_form" style="color:grey"></div>
                                <div class="time_form"></div>
                            </div>
                            <div class="screen_details" style="width:50%">
                                <div style="color:grey">Screen</div>
                                <div class="audi"></div>
                            </div>
                        </div>
                        <div class="seats_detail">
                            <div style="color:grey">Seats</div>
                            <div class="seats_form"></div>
                        </div>
                    </div>
                    <div class="movie_poster_div">
                        <img src="<?php echo getMoviePoster($db,$_SESSION['movieID']); ?>" alt="" class="movie_poster" style="height:150px;width:100px;">
                    </div>
                </div>
            </div>
            <div class="booking_details" style="text-align:left;paddig:5px;">
                <div class="title">Booking Summary</div>
                <div class="tickets" style="display:flex;justify-content:space-between;">
                    <div class="ticket_summary"></div>
                    <div class="amount_total"></div>
                </div>
                <div class="taxes" style="display:flex;justify-content:space-between;">
                    <div>Taxes & Fees</div>
                    <div class="tax_amount"></div>
                </div>
            </div>
            <div class="total_amount_div" style="display:flex;justify-content:space-between;">
                <div>Total</div>
                <div class="total_amount"></div>
            </div>
            <div id="ticket_id" class="hide"></div>
            <div class="payment_option">Proceed to Pay <span id="pay_amount"></span></div>
        </div>
        <div class="warning_div">
            <div id="warning" style="color:red"></div>
        </div>
    </div>
</div>

<style>
    span a{
        text-decoration:none;
    }
    .seat a.active{
        background:#f09c0b;
    }
    .hide{
        display:none;
    }
    .show{
        display:block;
    }
    .modal_content_tickets .modal-header{
        border-bottom: 2px solid #3e3e3e;
        background-color: #000;
        min-height: 55px;
    }
    .modal_content_tickets .modal-header h6 {
        color: #fff;
        display: inline-block;
        margin-top: 8px;
        user-select: none;
    }
    .modal_content_tickets .close {
        font-size: 38px;
        color: #fff;
        opacity: 1;
        outline:none;
    }
    .modal_content_tickets .modal-body {
        text-align: center;
        background: #000;
    }
    .modal_content_tickets .modal-body .first_form {
        text-align: center;
    }
    .modal_content_tickets .modal-body .first_form .container-fluid {
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
    .modal_content_tickets .modal-body .first_form .form_area_header {
        margin-top: 95px;
        margin-bottom: 15px;
    }
    .modal_content_tickets .modal-body .first_form .form_area_header h5 {
        font-weight: bold;
        font-size: 24px;
        color: #fff;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-size: 26px;
        user-select: none;
    }
    .modal_content_tickets .modal-body .first_form .form_area {
        border: none;
        padding: 10px 10px 0;
        border-radius: 10px;
        color: #fff;
    }
    .modal_content_tickets .modal-body .first_form .form_area .form-row {
        margin: 10px 0;
    }
    .modal_content_tickets .modal-body .first_form .form_area .col-sm-4 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .modal_content_tickets .modal-body .first_form .form_area .col-sm-4 label {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        user-select: none;
    }
    .modal_content_tickets .modal-body .first_form .form_area .col-sm-4 .form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        font-weight: 600;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow:none;
    }
    .modal_content_tickets .modal-body .first_form .form_area .col-sm-4 .ticket_count {
        border: 1px solid #ccc;
        border-radius: 4px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        font-weight: 600;
        font-size: 14px;
        color: #000;
        padding: 4px 15px;
        width: 100%;
        margin: 0 auto;
        background: #ccc;
        line-height: 24px;
        user-select: none;
    }
    .modal_content_tickets .modal-body .first_form .form_area hr{
        border-top: 1px solid #232323;
    }
    .modal_content_tickets .modal-body .first_form .form_area .col-sm-12 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .modal_content_tickets .modal-body .first_form .form_area .firstbtn {
        background-color: #ad0b0b;
        border-radius: 38px;
        color: #fff;
        display: block;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-size: 20px;
        font-weight: 700;
        outline: medium none;
        padding: 8px 25px;
        transition: all 150ms ease-in-out 0s;
        width: 100%;
        margin-top: 15px;
        border: none !important;
        box-shadow: none !important;
    }
    .modal_content_tickets .modal-body .first_form .form_area .firstbtn:hover {
        background-color: #d30f0f !important;
        box-shadow: none !important;
    }
    .modal_content_tickets .modal-body .first_form .form_area .firstbtn:focus{
        background-color:#9b0c0c !important;
        box-shadow: none !important;
    }
    .loader {
        margin:0;
        position:fixed;
        top:0;
        left:0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .8);
        text-align:center;
        cursor: wait;
        user-select: none;
        z-index: 2000;
        display: none;
    }
    .loader img {
        margin: 0;
        position: absolute;
        top: 50%;
        left:50%;
        margin-right: -50%;
        transform:translate(-50%, -50%);
        width: 100px;
        height: 100px;
        user-select: none;
    }
    .seat_map_wrap {
        margin-top: 10px;
        margin-bottom: 0;
        border-spacing: 0;
        border-collapse: collapse;
        background-color: transparent;
        display: inline-block;
        text-align: center;
        padding: 2%;
        width: auto;
        max-width: 100%;
    }
    @media only screen and (max-width: 570px) {
    .seat_map_wrap {
        width: 1040px !important;
        max-width: 1040px !important;
    }}
    tbody{
        width: 100%;
        height: 100%;
    }
    .seat_map_wrap .screen_area span {
        background-color: #6b6b6b;
        display: block;
        border-radius: 5px;
        color: #fff;
        position: relative;
        width: 100%;
        padding: 2px 6px;
        margin-top: 10px;
        user-select: none;
    }
    .seat_map_wrap td {
        border-top: none !important;
        padding: 0 !important;
        line-height: 1.42857143;
    }
    .seat_map_wrap td {
        padding: 0;
        vertical-align: middle;
        border-top: none;
    }
    .category_head{
        width: 100%;
        height: 100%;
        font-weight: bold;
    }
    .seat_map_wrap .seat_row_label {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #4c4d4f;
        font-size: 12px;
        margin-right: 6px;
        margin-top: 4px;
        user-select: none;
    }
    .seat_map_wrap .seat {
        float: left;
        margin: 4px 3px;
        width: 24px;
    }
    .seat_map_wrap .seat a {
        display: inline-block;
        font-family: inherit;
        font-size: 10px;
        line-height: 26px;
        box-shadow: 0 0 0 1px #f09c0b inset;
        height: 26px;
        text-align: center;
        width: 26px;
        border-radius: 26%;
        color: transparent;
        cursor: pointer;
        font-weight: bolder;
        text-decoration: none;
        background: #fff9d8;
        user-select: none;
    }
    .seat_map_wrap .seat a:hover {
        color: transparent;
        background: #f5a825;
        text-decoration: none;
        transition: .5s;
    }
    .seat_map_wrap .seat .selected a{
        background: #f5a825;
        text-decoration: none;
        box-shadow: 0 0 0 1px #f5a825 inset;
    }
    .seat_map_wrap .seat .booked a{
        background: grey;
        pointer-events:none;
        text-decoration: none;
        box-shadow: 0 0 0 1px grey inset;
    }
    .seat_map_wrap .seat .booked{
        cursor:not-allowed;
    }
    .seat_map_wrap .seat_column_number {
        float: left;
        margin: 4px 3px;
        width: 24px;
        user-select: none;
    }
    .pay_btn{
        width: 100%;
        background-color:blue;
        padding: 2px 5px;
        cursor: pointer;
    }
    .ticket{
        border:5px solid grey;
        border-style:dotted;
        padding:5px;
    }
    .hr{
        border-top:2px dotted grey;
    }
    .movie_details{
        display: flex;
        text-align:left;
        justify-content:space-between;
        padding-bottom:2px;
    }
    .ticket_details{
        display: flex;
        text-align:left;
    }
    .payment_option{
        width: 100%;
        background:blue;
        color:#fff;
        padding: 5px;
        cursor: pointer;
    }
</style>

<script>
    $(document).ready(function () {
    var selectedSeats = [];
    var amount = 0;
    var cat = [];
    var seats_booked = "<?php echo getBookTickets($db,$_SESSION['showDate'],$_SESSION['showTimeID'],$_SESSION['showID'],$_SESSION['movieID'],$_SESSION['theatreID']); ?>";
    console.log(seats_booked)
    if(seats_booked != 'none'){
        seats_booked = seats_booked.split(",");
        console.log(seats_booked)
        seats_booked.forEach(a => {
            var x = ".seatDiv a[seatno="+a+"]"
            $(x).parent().addClass('booked');
        });
    }
    $(".seatDiv a").click(function() {
        var row_index = $(this).attr("row_index");
        var col_index = $(this).attr("col_index");
        var seatNo = $(this).attr("seatno");
        var rate = parseInt($(this).attr("rate"));
        var category = $(this).attr('category');
        if(cat.length != 0){
            if(cat.includes(category)){
                if(selectedSeats.includes(seatNo)){
                    $(this).parent().toggleClass("selected");
                    selectedSeats = selectedSeats.filter(e => e !== seatNo)
                    amount -= rate;
                }else if(selectedSeats.length < 10){
                    $(this).parent().toggleClass("selected");
                    selectedSeats.push(seatNo);
                    amount += rate;
                }else{
                    $('.warning').html('Maximum 10 seats can be selected.')
                    $('.warning').removeClass('hide')
                    setInterval(() => {
                        $('.warning').addClass('hide');
                    }, 5000);
                }
            }else{
                if(confirm(`Do you want to switch to ${category} - ${rate}`)){
                    $("a").parent().removeClass('selected');
                    selectedSeats = []
                    cat = []
                    cat.push(category)
                    amount = 0
                    if(selectedSeats.includes(seatNo)){
                        $(this).parent().toggleClass("selected");
                        selectedSeats = selectedSeats.filter(e => e !== seatNo)
                        amount -= rate;
                    }else if(selectedSeats.length < 10){
                        $(this).parent().toggleClass("selected");
                        selectedSeats.push(seatNo);
                        amount += rate;
                    }else{
                        $('.warning').html('Maximum 10 seats can be selected.')
                        $('.warning').removeClass('hide')
                        setInterval(() => {
                            $('.warning').addClass('hide');
                        }, 5000);
                    }
                }
            }
        }else{
            cat.push(category)
            if(selectedSeats.includes(seatNo)){
                $(this).parent().toggleClass("selected");
                selectedSeats = selectedSeats.filter(e => e !== seatNo)
                amount -= rate;
            }else if(selectedSeats.length < 10){
                $(this).parent().toggleClass("selected");
                selectedSeats.push(seatNo);
                amount += rate;
            }else{
                $('.warning').html('Maximum 10 seats can be selected.')
                $('.warning').removeClass('hide')
                setInterval(() => {
                    $('.warning').addClass('hide');
                }, 5000);
            }
        }
        if(selectedSeats.length == 0 && amount== 0){
            $('#pay').addClass('hide');
        }else{
            $('#ticketCount').html(selectedSeats.length)
            $('#pay').removeClass('hide');
        }
    });
    $('.pay_btn').click(function(){
        var isUserLogin = "<?php echo $userLogged; ?>";
        if(isUserLogin){
            var userID = "<?php echo $userID; ?>";
            var seats = selectedSeats.sort().toString();
            var totalAmount = amount;
            var movie_id = "<?php echo $_SESSION['movieID']; ?>";
            var theatre_id = "<?php echo $_SESSION['theatreID']; ?>";
            var showDate = "<?php echo $_SESSION['showDate']; ?>";
            var showTime = "<?php echo $_SESSION['showTimeID']; ?>";
            var showID = "<?php echo $_SESSION['showID']; ?>";
            $('.modal-title').html('Complete your booking');
            $('.movie_name').html("<?php echo getMovieName($db,$_SESSION['movieID']); ?>");
            $('.theatre_name').html("<?php echo getTheatreName($db,$_SESSION['theatreID']); ?>");
            $('.date_form').html(showDate)
            $('.time_form').html(showTime)
            $('.seats_form').html(`${cat[0]} - ${selectedSeats.sort().toString()}`)
            var screen = "<?php echo $_SESSION['screen']; ?>";
            $('.audi').html(`Audi ${screen}`);
            $('.ticket_summary').html(`${selectedSeats.length} Tickets`)
            var tax = selectedSeats.length * 25;
            var tax_18 = (tax*18)/100;
            $('.amount_total').html(amount);
            $('.tax_amount').html(tax+tax_18);
            $('.total_amount').html(amount+tax+tax_18);
            $('#pay_amount').html(amount+tax+tax_18);
            $.ajax({
                type:'POST',
                url:'assets/booking_temp_insert.php',
                data:{movie_id:movie_id,user_id:userID,theatre_id:theatre_id,show_id:showID,seat_cat:cat[0],seats:seats,screen:screen,showdate:showDate,showtime:showTime,amount:amount+tax+tax_18},
                success:function(e){
                    console.log(e)
                    if(e == 'Error'){
                        console.log(e)
                    }else{
                        $('.first_form').addClass('hide');
                        $('.ticket_div').removeClass('hide');
                        $('#ticket_id').html(e);
                        var timer = 60*10,minutes,seconds;
                        setInterval(() => {
                            minutes = parseInt(timer/60,10);
                            seconds = parseInt(timer%60,10);
                            minutes = minutes<10 ? "0" + minutes:minutes;
                            seconds = seconds < 10 ? "0" + seconds : seconds;
                            $('.close').addClass('hide')
                            $('#timer').html(minutes + " : " + seconds);
                            if(--timer < 0){
                                $('#timer').html('00:00')
                                window.location.href="./index.php";
                            }
                        }, 1000);
                        $('.payment_option').on('click',function(){
                            var ticket_id = e;
                            $.ajax({
                                type:'POST',
                                url:'assets/book_ticket_success.php',
                                data:{movie_id:movie_id,user_id:userID,theatre_id:theatre_id,show_id:showID,seat_cat:cat[0],seats:seats,screen:screen,showdate:showDate,showtime:showTime,amount:amount+tax+tax_18,ticket_id:ticket_id},
                                beforeSend:function(){
                                    $('.loader').fadeIn(100);
                                },
                                success:function(data){
                                    window.location.href = './process_payment.php?id='+data;
                                }
                            })
                            
                        })
                    }
                }
            })
        }else{
            $('.first_form').addClass('hide');
            $('.login_div').removeClass('hide');
            $('.modal-title').html('User Login!')
        }
        
    })
});
// $(document).ready(function(){
    // var fullTicketCount = Number(document.getElementById('full_ticket_count').value);
    // var totalTicketCount = fullTicketCount;
    // $('#total_ticket_count').html(totalTicketCount);

	// $('#full_ticket_count').change(function(){
	// 	fullTicketCount=Number($(this).val());
    //     totalTicketCount = fullTicketCount;
	// 	$('#total_ticket_count').html(totalTicketCount);
	// });
    
    // $(".firstbtn").on('click',function(){
    //     if(totalTicketCount>0){
    //         $.ajax({
    //             url:'assets/booking_process_seat_map.php',
    //             data:'fullTicketCount=' + fullTicketCount,
    //             beforeSend: function() {
    //                 $(".loader").fadeIn(300);
    //             },
    //             success:function(body){
    //                 $(".loader").fadeOut(300);
    //                 $('.modal-content').html(body);
    //                 $('.close').trigger('focus');
    //             }
    //         });
    //     }else{
    //         $.toast({
    //             text: "Select number of ticket(s), atleast 1 to continue.",
    //             icon: 'error',
    //             position: 'top-center',
    //             hideAfter: 3000,
    //             stack: false,
    //             loader: false
    //         });
    //     }
    // });
    
// });
</script>

<div class="loader">
    <img draggable="false" src="images/loading.gif">
</div> 