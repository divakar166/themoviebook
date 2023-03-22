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
$verification_code="";

//registering user
if (isset($_POST['register'])) {
    $username=mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $repassword = mysqli_real_escape_string($db, $_POST['repassword']);
    $first_name=mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name=mysqli_real_escape_string($db, $_POST['last_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $mobile = mysqli_real_escape_string($db, $_POST['mobile']);
    $verification_code = mysqli_real_escape_string($db, $_POST['verification_code']);
    
    $query1 = "SELECT * FROM tbl_admins WHERE email = '$email'";

    $results = mysqli_query($db,$query1);

    $query2 = "SELECT * FROM tbl_admins WHERE username = '$username'";

    $results1 = mysqli_query($db,$query2);

    if ((mysqli_num_rows($results)==0) and (mysqli_num_rows($results1)==0)){
        
        $password =md5($password );
        $query = "INSERT INTO tbl_admins (username,password,first_name,last_name,email,mobile,verification_code) VALUES('$username','$password','$first_name','$last_name','$email','$mobile','$verification_code')";
        mysqli_query($db, $query);
        
        header('location: admin.login.php');
   
    }
    else {
        echo "<script>alert('The entered email address or username already exists. Try again with another email address or username.');</script>";
    }      
}

?>