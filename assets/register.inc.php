<?php
include_once ('db_config.php');
session_start();

$username="";
$password="";
$repassword="";
$first_name="";
$last_name="";
$email="";
$mobile="";

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
        $password =md5($password );
        $query = "INSERT INTO tbl_users (username,password,first_name,last_name,email,mobile)
                VALUES('$username','$password','$first_name','$last_name','$email','$mobile')";

        if(mysqli_query($db, $query)){
          echo
          "<script>
              alert('Successfully registered with theMovieBook!');
              window.location.href = './login.php';
          </script>";
        }
    }
    else {
      echo "<script>alert('The entered email address or username already exists. Try again with another email address or username.');</script>";
    }
}

?>
