<?php
include_once ('db_config.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
function getName($n) {
  $characters = '0123456789';
  $randomString = '';

  for ($i = 0; $i < $n; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $randomString .= $characters[$index];
  }

  return $randomString;
}



$username="";
$password="";
$repassword="";
$first_name="";
$last_name="";
$email="";
$mobile="";
$x="";

//registering user
if (isset($_POST['register'])) {
    $username=mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $repassword = mysqli_real_escape_string($db, $_POST['repassword']);
    $first_name=mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name=mysqli_real_escape_string($db, $_POST['last_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $mobile = mysqli_real_escape_string($db, $_POST['mobile']);



    $query1 = "SELECT * FROM tbl_users WHERE email = '$email'";

    $results = mysqli_query($db,$query1);

    $query2 = "SELECT * FROM tbl_users WHERE username = '$username'";

    $results1 = mysqli_query($db,$query2);

    if ((mysqli_num_rows($results)==0) and (mysqli_num_rows($results1)==0)){
        $x=getName(5);

        $password =md5($password );
        $query = "INSERT INTO tbl_users (username,password,first_name,last_name,email,mobile,status,code)
                VALUES('$username','$password','$first_name','$last_name','$email','$mobile','inactive','$x')";

        if(mysqli_query($db, $query)){
          $_SESSION['email'] = $email;
          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->Mailer = "smtp";
          $mail->SMTPDebug  = 1;
          $mail->SMTPAuth   = TRUE;
          $mail->SMTPSecure = "tls";
          $mail->Port       = 587;
          $mail->Host       = "smtp.gmail.com";
          $mail->Username   = "themoviebook91@gmail.com";
          $mail->Password   = "civqjzmgiezirigt";
          $mail->IsHTML(true);
          $mail->AddAddress("$email");
          $mail->SetFrom("support@theMovieBook.com", "theMovieBook");
          $mail->AddReplyTo("support@theMovieBook.com", "Reply");
          $mail->Subject = "User Registration - Verification";
          $content = "Thanks for creating an account with theMovieBook! Please verify your account by using the verification code below.<br>";
          $content .='Verification Code: '.$x;
          $mail->MsgHTML($content);
          if(!$mail->Send()) {
            echo "Error while sending Email.";
            var_dump($mail);

            header('location:register.php');
          } else {
            header('location: register.verification.php?email=' . $email);
          }
        }



    }
    else {
      echo "<script>alert('The entered email address or username already exists. Try again with another email address or username.');</script>";
    }
}

?>
