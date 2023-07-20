<?php 
include_once ('db_config.php');

session_start();

   $msg = '';

if (isset($_POST['login'])) {
   $email = trim($_POST['email']);
   $password = md5($_POST['password']);
        
        $query = "SELECT * FROM tbl_admins WHERE email = '$email'";

        $results = mysqli_query($db,$query);
        if (mysqli_num_rows($results) > 0){
            $row = mysqli_fetch_array($results);
            if($row['password'] == $password){
                $_SESSION['admin_id']=$row['admin_id'];
                $_SESSION['username']=$row['username'];
                
                header('location: dashboard.php');
            }else{
               $msg = 'Password';
            } 
        }else{
           $msg = 'Email';
        }
}


if(!isset($_SESSION['admin_id'])){

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		
		
		<!--Custom Style CSS-->
		<link rel="stylesheet" type="text/css" href="css/style.min.css?=<?php echo time(); ?>">
		
		<!--Favicon Image-->
		<link rel="shortcut icon" type="image/png" href="images/icon.png">
		
		<title>theMovieBook</title>

    <style>
        body {
          color:white;
          margin: 0;
          padding: 0;
          background: url("images/login_background.jpg");
          background-size: cover;
          font-family: sans-serif;
        }
        .login-page{
          width:450px;
          background-color:rgba(0,0,0,.5);
          border-radius:20px;
          top:50%;
          left:50%;
          position:absolute;
          transform:translate(-50%,-50%);
          padding: 20px 30px;
        } 
    </style>

	</head>


  <body>
    <div class="login">
    
      <form class="login-page" method="POST">
        <h2 style="font-weight:400; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; color: white; font-size:48px; margin-bottom:30px; padding-top:15px; border-bottom: 1px solid #FFF; text-align:center; padding-bottom: 15px;">Login</h2>
        
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Email:</label>
          <div class="col-sm-9">
            <input placeholder="Email" class="form-control" name="email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="The format should be user@something.XXX" required>
          </div>
        </div>
        <div class="row email_error hide">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <p class="alert-text">*Email doesn't exist!</p>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Password:</label>
          <div class="col-sm-9">
            <input placeholder="Password" name="password" class="form-control" type="password" required>
          </div>
        </div>
        <div class="row pwd_error hide">
          <div class="col-sm-3"></div>
          <div class="col-sm-9">
            <p class="alert-text">*Password didn't matched!</p>
          </div>
        </div>

        <hr style="border-top:1px solid #FFF; margin-top:30px">

        <div style="text-align:center;">
          <button class="btn btn-danger btn-lg" type="submit" name="login" style="padding:7px 20px">Login</button>
        </div>
        
      
      </form>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script>
    $msg = <?php echo json_encode($msg); ?>;
    if($msg == ''){
        $('.email_error,.pwd_error').addClass('hide');
    }
    if($msg == 'Email'){
        $('.email_error').removeClass('hide');
        $('.pwd_error').addClass('hide');
    }else if($msg == 'Password'){
        $('.pwd_error').removeClass('hide');
        $('.email_error').addClass('hide');
    }
  </script>
</body>
</html>
            
<?php
}
else{
  header('location:dashboard.php');
}?>