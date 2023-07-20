<?php if($_GET['id']){
    $id = $_GET['id']; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment</title>
    <style>
        body{
            width: 100vw;
            height: 100vh;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            margin: 0;
            padding: 0;
        }
        p{
            font-size:20px;
            margin: 0;
        }
        .hide{
            display:none;
        }
    </style>
</head>
<body>
    <p id='success'>Transaction is in processing...</p>
    <p id='redirect'>Please do not go back!</p>
    <div class="loader">
        <img draggable="false" width='50px' src="images/loading.gif">
    </div> 
</body>

<script src="js/jquery.min.js"></script>
<script>
    var id = <?php echo $id; ?>;
    $(document).ready(function(){
        setInterval(() => {
            $('.loader').addClass('hide');
            $("#success").html('Payment was successful!');
            $('#redirect').html('Redirecting...')
            setInterval(()=>{
                window.location.href = './ticket.php?id='+id;
            },1000)
        }, 3000);
    })
</script>

</html>


<?php } ?>