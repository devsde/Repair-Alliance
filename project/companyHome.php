<?php
    include 'dbConnect.php';
    session_start();
    if(!isset($_SESSION['loggedIn'])||$_SESSION['loggedIn']!=true){
        header('location:companyLogin.php');
        exit;
    }
    if(isset($_POST["update"])){
      $updateTicketId=$_POST['ticketIdEdit'];
      $statusEdit=$_POST['statusEdit'];
      $sqlUpdate="UPDATE `complaint` SET `status` = '$statusEdit' WHERE `complaint`.`ticketId` = '$updateTicketId'";
      $resultUpdate=mysqli_query($conn,$sqlUpdate);
    }
  ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Company Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
 
  </head>
  <body>
  <!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit The Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="companyHome.php" method="post">
              <input type="hidden" id="ticketIdEdit" name="ticketIdEdit">
                    <div class="form-group">
                <label for="statusEdit">Status</label>
                <select class="form-control" id="statusEdit" name="statusEdit">
                <option>Not Proceeded</option>
                <option>Proceeded</option>
                <option>Solved</option>
                </select>
            </div>
            <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary" name="update">Update</button>

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
        include 'companyNavbar.php';
      ?>
  <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Sno</th>
      <th scope="col">Ticket No</th>
      <th scope="col">FName</th>
      <th scope="col">LName</th>
      <th scope="col">Email</th>
      <th scope="col">City</th>
      <th scope="col">State</th>
      <th scope="col">Zip</th>
      <th scope="col">PickUp Address</th>
      <th scope="col">Name Of Company</th>
      <th scope="col">Product</th>
      <th scope="col">Problem Description</th>
      <th scope="col">Purchased date</th>
       <th scope="col">Date And Time</th>
       <th scope="col">Status</th>
       <th scope="col">Edit Ticket Status</th>

    </tr>
  </thead>
  <tbody>

    <?php
    include 'dbConnect.php';
    $nameOfCompany=$_SESSION['nameOfCompany'];
    $sql="SELECT * FROM `complaint` WHERE nameOfCompany='$nameOfCompany'";
    $result=mysqli_query($conn,$sql);
    $sno=1;
    while($row=mysqli_fetch_assoc($result)){
      
      echo "<tr>
      <th scope='row'>".$sno."</th>
      <td>".$row['ticketId']."</td>
      <td>".$row['fName']."</td>
      <td>".$row['lName']."</td>
      <td>".$row['email']."</td>
      <td>".$row['city']."</td>
      <td>".$row['state']."</td>
      <td>".$row['zip']."</td>
      <td>".$row['pickupAddress']."</td>
      <td>".$row['nameOfCompany']."</td>
      <td>".$row['type']."</td>
      <td>".$row['problemDescription']."</td>
      <td>".$row['purchaseDate']."</td>
      <td>".$row['time']."</td>
      <td>".$row['status']."</td>
      <td> <button class='edit btn btn-sm btn-sm btn-primary'id=".$row['ticketId']." >Edit</button> 
      </td>


    </tr>";


      $sno++;
    }
    ?>
    </tbody>
</table>




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
       edits= document.getElementsByClassName('edit');
       Array.from(edits).forEach((element)=>{
           element.addEventListener("click",(e)=>{
               tr=e.target.parentNode.parentNode;
               status=tr.getElementsByTagName("td")[12].innerText;
               statusEdit.value=status;
               ticketIdEdit.value=e.target.id;
               $('#editModal').modal('toggle');

           });

       });
    </script>

  </body>
</html>