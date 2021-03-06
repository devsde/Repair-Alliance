<?php
   $showError=false;
   if($_SERVER['REQUEST_METHOD']=='POST')//isset($_POST['logIn'])
   {
      include "dbConnect.php";
      $email=$_POST['email'];
      $pass=$_POST['pass'];
      $sql="SELECT * FROM `companyregistration` WHERE email='$email'";
      $result=mysqli_query($conn,$sql);
      $rowcount=mysqli_num_rows($result);
      if($rowcount==1){
        while($row=mysqli_fetch_assoc($result))
        {
          if(password_verify($pass,$row['password'])){
            session_start();
            $_SESSION['loggedIn']=true;
            $_SESSION['type']=$row['type'];
            $_SESSION['nameOfCompany']=$row['nameOfCompany'];

            header("location:companyHome.php");

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

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Log In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="css/login.css" rel="stylesheet" id="bootstrap-css">
 
  </head>
  <body>
  <?php
    include 'navbar.php';
  ?>
  <?php
  if($showError){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    '.$showError.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }

  ?>
  
  <div class="wrapper fadeInDown">
    <div id="formContent">
  
      <div class="fadeIn first">
        <img src="data:image/png;base64,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" style="height:200px;width:200px;" id="icon" alt="User Icon"/>

      </div>
      <br>
      <form method="post">
      <input type="text" id="email" class="fadeIn second" name="email" placeholder="email">
      <input type="password" id="pass" class="fadeIn third" name="pass" placeholder="password">
      <br>
      <br>
      <input type="submit" class="fadeIn fourth" value="Log In" name="logIn">
      </form>
        
  
    </div>
  </div>


    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>