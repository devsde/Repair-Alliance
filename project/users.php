<?php
    session_start();
    include 'dbConnect.php';
    if(!(isset($_SESSION['loggedIn']))||$_SESSION['loggedIn']!=true||$_SESSION['email']!='admin@gmail.com'){
        header('location:login.php');
        exit;
    }

    if(isset($_POST["delete"])){
        $emailIdDelete=$_POST["emailIdDelete"];
        $sqlDelete="DELETE FROM `users` WHERE `users`.`email` ='$emailIdDelete'";
      $resultDelete=mysqli_query($conn,$sqlDelete);

    }
  ?>

<!doctype html>
<html lang="en">
  <head>
    <title>User</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">


  </head>
  <body>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="users.php" method="post">
            <input type="hidden" id="emailIdDelete" name="emailIdDelete">
            <h4>
                Are you sure you want to delete.
            </h4>
            <div class="text-center">
        <button type="submit" class="text-center btn btn-primary" name="delete">Delete</button>

            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <?php
    include 'navbar.php';
  ?>


  <div class="container mt-5" >
  <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Sno</th>
      <th scope="col">Email-Id</th>
      <th scope="col">Password</th>
      <th scope="col">Date And Time</th>

    <th scope="col">Actions</th>

    </tr>
  </thead>
  <tbody>
    <?php
    include 'dbConnect.php';
    $sql="SELECT * FROM `users`";
    $result=mysqli_query($conn,$sql);
    $sno=1;
    while($row=mysqli_fetch_assoc($result)){
        echo "<tr>
        <th scope='row'>".$sno."</th>
        <td>".$row['email']."</td>
        <td>".$row['password']."</td>
        <td>".$row['dateTime']."</td>

        <td> <button class='delete btn btn-sm btn-primary' id=".$row['email'].">Delete</button>
        </td>
  
      </tr>";
      $sno++;
    }
    ?>
    
 

  </tbody>
</table>
  </div>


  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready( function () {
    $('#myTable').DataTable();
    });
    </script>
    <script>
        deletes=document.getElementsByClassName('delete');
       Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
            emailIdDelete.value=e.target.id;
            $('#deleteModal').modal('toggle');



        });
       });

    </script>
  </body>
</html>