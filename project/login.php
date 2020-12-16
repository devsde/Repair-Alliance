<?php
  session_start();
  include 'navbar.php';


   $showError=false;
   $showEmailError=false;
   $showPasswordError=false;


   if(isset($_POST['logIn']))
   {
    $email=$_POST['email'];
    $pass=$_POST['pass'];
     if(strlen($email)==0){
       $showEmailError='Enter Email-Id Field';
     }
     else if(strlen($pass)==0){
       $showPasswordError='Enter Password Field';
     }
     else{
      include "dbConnect.php";
      $category=$_POST['category'];
      $sql="SELECT * FROM `users` WHERE email='$email'";
      $result=mysqli_query($conn,$sql);
      $rowcount=mysqli_num_rows($result);
      if($rowcount==1){
        while($row=mysqli_fetch_assoc($result))
        {
          if(password_verify($pass,$row['password'])){
            $_SESSION['email']=$email;
            $_SESSION['loggedIn']=true;
            $_SESSION['type']=$row['type'];

            if($email=='admin@gmail.com'){
              
            header("location:users.php");
          }
            else{
              setcookie('category', $category, time() + 86400, "/");
              header("location:welcome.php");
            }
          }
          else{
            $showError='Password is incorrect';
          }


        }
      }
      else{
        
          $showError='No email id exists.';
      }
     }
      
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Log In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="css/login.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/companyRegis.css" rel="stylesheet" id="bootstrap-css">
 
  </head>
  <body>
  <?php
  if($showError){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    '.$showError.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  if($showEmailError){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    '.$showEmailError.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  if($showPasswordError){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    '.$showPasswordError.'
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
      <select class="fadeIn second" id="category"  name="category">
        <option value="Audio" class="specialColorOption">Audio</option>
        <option value="Phone" class="specialColorOption">Mobile Phone/Tablet</option>
        <option value="Television" class="specialColorOption">Televesion</option>
        <option value="Laptop" class="specialColorOption">Laptop</option>
        <option value="Others" class="specialColorOption">Others</option>
        </select>
      <input type="submit" class="fadeIn fourth" value="Log In" name="logIn">
      </form>
        
  
    </div>
  </div>

 
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>