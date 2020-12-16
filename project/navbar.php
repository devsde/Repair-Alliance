<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" style="color: blanchedalmond;">Repair Alliance</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <?php
      if(isset($_SESSION['loggedIn'])&&$_SESSION['loggedIn']==true&&$_SESSION['email']!='admin@gmail.com'){
          echo'<li class="nav-item">
          <a class="nav-link" href="welcome.php">Register A Complaint <span class="sr-only">(current)</span></a>
        </li>';
        echo'<li class="nav-item">
        <a class="nav-link" href="yourTickets.php">Your Tickets<span class="sr-only">(current)</span></a>
      </li>';
      echo'<li class="nav-item">
        <a class="nav-link" href="notification.php">Notifications<span class="sr-only">(current)</span></a>
      </li>';
      }
      ?>

      <?php
      if(!isset($_SESSION['loggedIn'])){
          echo ' <li class="nav-item">
          <a class="nav-link" href="home.php">Home</a>
        </li>
          <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="signUp.php">Sign Up</a>
      </li>
      <li class="dropdown">
      <a href="#" class="dropdown-toggle mt-2 ml-2" data-toggle="dropdown" >
         Company 
         <b class="caret"></b>
      </a>
      <ul class="dropdown-menu" role="listbox">
         <li><a href="companyRegistration.php" role="option">Registration</a></li>
         <li><a href="companyLogin.php" role="option">Login</a></li>
      </ul>
   </li>';
      }
      ?>
       <?php
      if(isset($_SESSION['loggedIn'])&&$_SESSION['loggedIn']==true&&$_SESSION['email']=='admin@gmail.com'){
          echo'<li class="nav-item">
          <a class="nav-link" href="users.php">Users</a>
        </li>';
        echo'<li class="nav-item">
        <a class="nav-link" href="complaint.php">Compliants</a>
      </li>';
      }
      ?>
     
      <?php
      if(isset($_SESSION['loggedIn'])&&$_SESSION['loggedIn']==true){
          echo'<li class="nav-item">
          <a class="nav-link" href="logOut.php">Log Out</a>
        </li>';
      }
      ?>
      </ul>
    
  </div>
</nav>