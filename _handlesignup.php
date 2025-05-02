<?php


$showalert=false;
$showerror=false;

// echo $_SERVER['REQUEST_METHOD'];

if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    include '_dbconnect.php';
    $name=$_POST['signupname'];
    $email=$_POST['signupemail'];
    $contacts=$_POST['contacts'];
    $address=$_POST['address'];
    $pass=$_POST['signuppassword'];
    $cpass=$_POST['signupcpassword'];
    
    $sql="select * from `users` where User_email='$email'";
    $result=mysqli_query($conn,$sql);
    
    //checking email exists or not
    $nuwrows=mysqli_num_rows($result);
    if($nuwrows>0){
        //$showerror="Email Already Exists";
        header("Location: /Restaurant-Management Website/index.php?userexists=false");
    }else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $addsql="INSERT INTO `users` (`User_name`,`User_email`,`User_pass`,`Contact_info`,`Address`,`Time`) VALUES ('$name','$email','$hash','$contacts','$address',current_timestamp());";
            $result=mysqli_query($conn,$addsql);
            if($result){
                $showalert=true;
                header("Location: /Restaurant-Management Website/index.php?signupsuccess=true");
                exit();
            }
        }else{
            // $showerror="Passwords do not Match";
            header("Location: /Restaurant-Management Website/index.php?signupsuccess=false");
        }
    }

}


?>