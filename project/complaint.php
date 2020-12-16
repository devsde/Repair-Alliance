<?php
    include 'dbConnect.php';
    session_start();
    if(!(isset($_SESSION['loggedIn']))||$_SESSION['loggedIn']!=true||$_SESSION['email']!='admin@gmail.com'){
        header('location:login.php');
        exit;
    }
    if(isset($_POST["delete"])){
        $ticketIdDelete=$_POST["ticketIdDelete"];
        $sqlProceed="DELETE FROM `complaint` WHERE `complaint`.`ticketId` ='$ticketIdDelete'";
        $resultDelete=mysqli_query($conn,$sqlProceed);
  
    }
    if(isset($_POST["proceed"])){
        $ticketIdProceed=$_POST["ticketIdProceed"];
        $emailProceed=$_POST["emailProceed"];
        $sqlProceed="SELECT * FROM `notification` WHERE ticketId='$ticketIdProceed' AND email='$emailProceed' AND stat='Proceeded'";
        $result1=mysqli_query($conn,$sqlProceed);
        $rowcount=mysqli_num_rows($result1);
        if($rowcount==0){
            $sqlInsertProceed="INSERT INTO `notification` (`ticketId`, `email`, `stat`, `time`) VALUES ('$ticketIdProceed', '$emailProceed', 'Proceeded', current_timestamp())";
            $resultProceed=mysqli_query($conn,$sqlInsertProceed);
        }


    }
    if(isset($_POST["solved"])){
        $ticketIdSolved=$_POST["ticketIdSolved"];
        $emailSolved=$_POST["emailSolved"];
        $sqlSolved="SELECT * FROM `notification` WHERE ticketId='$ticketIdSolved' AND email='$emailSolved' AND stat='Solved'";
        $result2=mysqli_query($conn,$sqlSolved);
        $rowcount2=mysqli_num_rows($result2);
        if($rowcount2==0){
            $sqlInsertSolved="INSERT INTO `notification` (`ticketId`, `email`, `stat`, `time`) VALUES ('$ticketIdSolved', '$emailSolved', 'Solved', current_timestamp())";
            $resultSolved=mysqli_query($conn,$sqlInsertSolved);
        }
  
    }
  ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Complaint</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">


  </head>
  <body>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="complaint.php" method="post">
        <input type="hidden" id="ticketIdDelete" name="ticketIdDelete">

            <h4>Are you sure you want to delete</h4>
            <div class="text-center mt-5">
        <button type="submit" class="btn btn-primary" name="delete">Delete</button>
    </div>


        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Proceed -->
<div class="modal fade" id="proceedModal" tabindex="-1" aria-labelledby="proceedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="proceedModalLabel">Send Proceeded Notification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="complaint.php" method="post">
          <input type="hidden" id="ticketIdProceed" name="ticketIdProceed">
          <input type="hidden" id="emailProceed" name="emailProceed">

              <div class="text-center mt-5">
          <button type="submit" class="btn btn-primary" name="proceed">Send Notification</button>
      </div>
  
  
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Solved -->
<div class="modal fade" id="solvedModal" tabindex="-1" aria-labelledby="solvedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="solvedModalLabel">Send Solved Notification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="complaint.php" method="post">
          <input type="hidden" id="ticketIdSolved" name="ticketIdSolved">
          <input type="hidden" id="emailSolved" name="emailSolved">

              <div class="text-center mt-5">
          <button type="submit" class="btn btn-primary" name="solved">Send Notification</button>
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
  <br>
  <br>


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
       <th scope="col">Status Of Company</th>
       <th scope="col">Action</th>
       <th scope="col">Send Notification</th>

    </tr>
  </thead>
  <tbody>
    <?php
    include 'dbConnect.php';
    $sql="SELECT * FROM `complaint`";
    $result=mysqli_query($conn,$sql);
    $sno=1;
    while($row=mysqli_fetch_assoc($result)){
        // include 'dbConnect.php';
        $ticketId=$row['ticketId'];
        $email=$row['email'];
        $sql1="SELECT * FROM `notification` WHERE ticketId='$ticketId' AND email='$email' AND stat='Proceeded'";
        $sql2="SELECT * FROM `notification` WHERE ticketId='$ticketId' AND email='$email' AND stat='Solved'";
        $result1=mysqli_query($conn,$sql1);
        $rowcount1=mysqli_num_rows($result1);
        $result2=mysqli_query($conn,$sql2);
        $rowcount2=mysqli_num_rows($result2);
        $proceedNotificationExist=$rowcount1==1;
        $solvedNotificationExist=$rowcount2==1;
        if($proceedNotificationExist==true&&$solvedNotificationExist==false){
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
            <td><button class='delete btn btn-sm btn-sm btn-danger' id=".$row['ticketId'].">Del</button>
            </td>
            <td> <button class='proceeded btn btn-sm btn-sm btn-success'id=".$row['ticketId']." >Proceeded</button> <button class='solved btn btn-sm btn-sm btn-primary' id=".$row['ticketId'].">Solved</button>
            </td>
    
      
          </tr>";
          
        }
        elseif($proceedNotificationExist==false&&$solvedNotificationExist==true){
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
            <td><button class='delete btn btn-sm btn-sm btn-danger' id=".$row['ticketId'].">Del</button>
            </td>
            <td> <button class='proceeded btn btn-sm btn-sm btn-primary'id=".$row['ticketId']." >Proceeded</button> <button class='solved btn btn-sm btn-sm btn-success' id=".$row['ticketId'].">Solved</button>
            </td>
    
      
          </tr>";
        }
        elseif($proceedNotificationExist==false&&$solvedNotificationExist==false){
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
            <td>  <button class='delete btn btn-sm btn-sm btn-danger' id=".$row['ticketId'].">Del</button>
            </td>
            <td> <button class='proceeded btn btn-sm btn-sm btn-primary'id=".$row['ticketId']." >Proceeded</button> <button class='solved btn btn-sm btn-sm btn-primary' id=".$row['ticketId'].">Solved</button>
            </td>
    
      
          </tr>";
        }
        else{
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
            <td> <button class='delete btn btn-sm btn-sm btn-danger' id=".$row['ticketId'].">Del</button>
            </td>
            <td> <button class='proceeded btn btn-sm btn-sm btn-success'id=".$row['ticketId']." >Proceeded</button> <button class='solved btn btn-sm btn-sm btn-success' id=".$row['ticketId'].">Solved</button>
            </td>
    
      
          </tr>";
        }

      $sno++;
    }
    ?>
    </tbody>
</table>



  
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
            ticketIdDelete.value=e.target.id;
            $('#deleteModal').modal('toggle');



        });
       });


    </script>
        <script>
       proceedNoti=document.getElementsByClassName('proceeded');
       Array.from(proceedNoti).forEach((element)=>{
        element.addEventListener("click",(e)=>{
            tr=e.target.parentNode.parentNode;
            emailProceed.value=tr.getElementsByTagName("td")[3].innerText;
            ticketIdProceed.value=e.target.id;
            $('#proceedModal').modal('toggle');



        });
       });


    </script>
        <script>
       solvedNoti=document.getElementsByClassName('solved');
       Array.from(solvedNoti).forEach((element)=>{
        element.addEventListener("click",(e)=>{
            tr=e.target.parentNode.parentNode;
            emailSolved.value=tr.getElementsByTagName("td")[3].innerText;
            ticketIdSolved.value=e.target.id;
            $('#solvedModal').modal('toggle');



        });
       });


    </script>
  </body>
</html>