<?php
    include_once ('db_config.php');
    
    
    if(isset($_POST['addtheatre'])){
        $theatre_name = trim($_POST['theatre_name']);
        
        $city = trim($_POST['city']);

        $address = trim($_POST['address']);

        $telephone = trim($_POST['telephone']);
        
        $email = trim($_POST['email']);

        
        $image=addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        
        $Facilities = trim($_POST['Facilities']);
        
        $status = trim($_POST['status']);
        /* $admin_id = trim($_POST['admin_id']);
        $admin_id = mysqli_real_escape_string($db, $admin_id); */
        

        // add image
        //$query="INSERT INTO tbl_theatres (theatre_name,city,address,telephone,email,description,image,Facilities,status,admin_id) VALUES('$theatre_name','$city','$address','$telephone','$email','$description','$image','$Facilities','$status','$admin_id')";
        //$res=mysqli_query($db,$query);

        $query="INSERT INTO tbl_theatres (theatre_name,city,address,telephone,email,image,Facilities,status) VALUES('$theatre_name','$city','$address','$telephone','$email','$image','$Facilities','$status')";
        if(mysqli_query($db,$query)){
            echo '<script>alert("inserted")</script>';
            header("location:theatres.php");
        }

    }
?>


 