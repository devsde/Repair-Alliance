<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" style="color: blanchedalmond;">HD Repair's</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

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