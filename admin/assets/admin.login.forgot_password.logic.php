<?php 
include_once ('db_config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
$n=10; 
function getName($n) { 
	$characters = '0123456789'; 
	$randomString = ''; 

	for ($i = 1; $i <= $n; $i++) { 
		$index = rand(0, strlen($characters) - 1); 
		$randomString .= $characters[$index]; 
	} 

	return $randomString; 
}

?>


<?php 
session_start();
$errors = [];

/*
  Accept email of user whose password is to be reset
  Send email to user to reset their password
*/
if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  // ensure that the user exists on our system
  $query = "SELECT email FROM tbl_admins WHERE email='$email'";
  $results = mysqli_query($db, $query);

  if (empty($email)) {
    echo "<script>alert('Enter your email address!');</script>";
    array_push($errors, "Your email is required");
  }else if(mysqli_num_rows($results) <= 0) {
    echo "<script>alert('Your are not registered with theMovieBook!');</script>";
    array_push($errors, "Sorry, no user exists in our system with that email");
  }
  // generate a unique random token of length 100


  $x = getName(6);
  $query = "UPDATE tbl_admins SET code = '$x' WHERE email='$email'";
  $results = mysqli_query($db, $query);

 
  if (count($errors) == 0) {

    // Send email to user with the token in a link they can click on
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
      $mail->Subject = "Password Recovery - theMovieBook | Admin";
      $content = "We have just received your request to reset the password for your admin account. In order to reset password please use the confirmation code below. If you haven't ask for password reset service just ignore this message.<br>";
      $content .='Confirmation Code: '.$x;
      $mail->MsgHTML($content);
      if(!$mail->Send()) {
        echo "Error while sending Email.";

        header('location:admin.login.forgot_password.php');
      } else {
        header('location: admin.login.forgot_password.reset_password.php?email=' . $email);
      }
    }

    
  }

?>