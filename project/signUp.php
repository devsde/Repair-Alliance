<?php
    $showAlert=false;
    $emailErr=false;
    $passErr=false;
    $showError=false;

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
      include "dbConnect.php";
      $email=$_POST['email'];
      $pass=$_POST['pass'];
      $cpass=$_POST['cpass'];
      $emailErr  = $passErr = $con_passErr = ""; 
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
        $emailErr ="Invalid email format"; 
      } 
      if(strlen($pass) <= 8){ 
        $passErr ="Password length must be atleast 8 char";
      }
      elseif(!preg_match("#[0-9]+#",$pass)){
        $passErr = "Password must contain atleast 1 number"; 
      }
      elseif(!preg_match("#[A-Z]+#",$pass)){
        $passErr = "Password must contain atleast 1 uppercase"; 
      }
      elseif(!preg_match("#[a-z]+#",$pass)){
        $passErr = "Password must contain atleast 1 lowercase"; 
      } 
      elseif($pass!=$cpass){
        $passErr = "Passwords must match with Confirm Password"; 
      }
    if(!$emailErr && !$passErr){
        $hash=password_hash($pass,PASSWORD_DEFAULT);
        $sql="SELECT * FROM `users` WHERE email='$email'";
        $result=mysqli_query($conn,$sql);
        $rowcount=mysqli_num_rows($result);
        if($rowcount==0){
            $sql= "INSERT INTO `users` (`email`, `password`,`type`,`dateTime`) VALUES ('$email', '$hash','user', current_timestamp())";
            $result=mysqli_query($conn,$sql);
            if($result){
                $showAlert="Successfully Registered an account,Log In to apply for warranty";
            }
            else{
                $showError="Please try again.";
            }


        }
        else{
            $showError="Email-id already exists.";
        }
      }


    }
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Sign Up</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/login.css" id="bootstrap-css"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <?php
    include 'navbar.php';
  ?>
  <?php
  if($showAlert)
  {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    '.$showAlert.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  if($showError)
  {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    '.$showError.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  if($emailErr)
  {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    '.$emailErr.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  if($passErr)
  {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    '.$passErr.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  ?>


<div class="wrapper fadeInDown">
    <div id="formContent">
  
      <div class="fadeIn first">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRuXDEH91lQ9Cb_sAody3gpXwDsJk0sNR9fYA&usqp=CAU" id="icon" alt="User Icon" />
      </div>
  
      <form method="post">
      <input type="text" id="email" class="fadeIn second" name="email" placeholder="email">
      <input type="password" id="pass" class="fadeIn third" name="pass" placeholder="password">
      <input type="password" id="cpass" class="fadeIn third" name="cpass" placeholder="confirm password">

      <input type="submit" class="fadeIn fourth" value="Sign Up" name="signUp">
      </form>
        
  
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>