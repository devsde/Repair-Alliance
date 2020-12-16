<?php
    session_start();
    if(!isset($_SESSION['loggedIn'])||$_SESSION['loggedIn']!=true){
        header('location:login.php');
        exit;
    }
    if($_SESSION['email']=='admin@gmail.com'){
      header('location:users.php');
      exit;
    }
  ?>
<?php
$showAlert=false;
$showError=false;
if($_SERVER['REQUEST_METHOD']=='POST'){
  include "dbConnect.php";
  $email=$_SESSION['email'];
  $fName=$_POST['fName'];
  $lName=$_POST['lName'];
  $city=$_POST['city'];
  $state=$_POST['state'];
  $zip=$_POST['zip'];
  $address=$_POST['address'];
  $nameOfCompany=$_POST['nameOfCompany'];
  $type = $_POST['type'];
  $problemDescription= $_POST['problemDescription'];
  $purchaseDate = date('d-m-Y', strtotime($_POST['purchaseDate']));
  $vFName=strlen($fName)>0;
  $vLName=strlen($lName)>0;
  $vCity=strlen($city)>0;
  $vState=strlen($state)>0;
  $vZip=strlen($zip)>0;
  $vAddress=strlen($address)>0;
  $vType=strlen($type)>0;
  $vProblemDescription=strlen($problemDescription)>0;
  $vPurchaseDate=strlen($purchaseDate)!='01-01-1970';


  if(isset($_FILES['uploadFile'])&&$_FILES["uploadFile"]["error"]=='0'){
  if($vFName&&$vLName&&$vCity&&$vState&&$vZip&&$vAddress&&$vType&&$vProblemDescription&&$vPurchaseDate){
    $maxsize    = 2097152;
    $acceptable = array(
        'application/pdf',
    );

    if(($_FILES['uploadFile']['size'] >= $maxsize) || ($_FILES["uploadFile"]["size"] == 0)) {
        $showError= 'File too large. File must be less than 2 megabytes.';
    }

    if(!in_array($_FILES['uploadFile']['type'], $acceptable) && (!empty($_FILES["uploadFile"]["type"]))) {
    $showError= 'Invalid file type. Only PDF  file type is accepted.';
}

if($showError==false) {
  $ticketId=uniqid();
  $fileName=$ticketId; 
  $tempName=$_FILES["uploadFile"]["tmp_name"];
  $folder="invoice/".$fileName.'.pdf';
  move_uploaded_file($tempName,$folder);
  $sql="INSERT INTO `complaint` (`ticketId`, `fName`, `lName`, `email`,`city`,`state`,`zip`, `pickupAddress`, `nameOfCompany`,`type`, `problemDescription`, `purchaseDate`, `time`,`status`) VALUES ('$ticketId', '$fName', '$lName', '$email','$city','$state','$zip','$address','$nameOfCompany', '$type', '$problemDescription', '$purchaseDate', current_timestamp(),'Not Proceeded')";
  $result=mysqli_query($conn,$sql);
  if($result){
      $showAlert="We have registered your complaint with ticket number ".$ticketId;
  }
  else{
      $showError="Error Registering your Complaint,Please try Again";
  }
}



  }
  else{
    $showError='Please Fill all the fields';
  }
}
else{
  $showError='Please upload your Product Invoice';
}
}
?>
<?php
    $companyName=array();
    include 'dbConnect.php';
    $category=$_COOKIE['category'];
    $sql="SELECT * FROM `companyregistration` WHERE category='$category'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
    array_push($companyName,$row['nameOfCompany']);

    }
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Welcome</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/complaint.css">
    <link rel="stylesheet" href="css/autocom.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
 
  <?php
  include 'navbar.php';
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
  ?>
 
  <div class="text-center  mt-4">
<h3> Register A Complaint</h3>
</div>
<div class="container mt-5">
<div class="wrapper fadeInDown">
    <div id="formContent">
<form action="welcome.php" method="post" autocomplete="off"  enctype="multipart/form-data">
<div class="form-group row" >
  
<label for="staticEmail" class="col-4">Email:</label>
<?php
   $email=$_SESSION['email'];
   echo ' <div class="col">
   <input  readonly class="form-control-plaintext" id="staticEmail" value="'.$email.'">
 </div>';
?>

<div class="form-row container mt-3">
    <div class="col">
      <input type="text" class="form-control" placeholder="First name" name="fName">
    </div>
    <div class="col">
      <input type="text" class="form-control" placeholder="Last name" name="lName">
    </div>
  </div>
  <br>
  <div class="form-row container mt-4">
    <div class="col-4">
      <input type="text" class="form-control" placeholder="City" name="city">
    </div>
    <div class="col-4">
      <input type="text" class="form-control" placeholder="State" name="state">
    </div>
    <div class="col-4">
      <input type="number" class="form-control" placeholder="Zip" name="zip">
    </div>
  </div>
  </div>
  <div class="autocomplete">
    <input type="text" class="form-control" id="myInput" placeholder="Company Name" name="nameOfCompany">
  </div>
  
  
  <br>
  <br>
  <div class="form-group">
    <label for="type">Select Your Product</label>
    <select class="form-control" id="type" name="type">
    <option value="Speaker">Speaker</option>
    <option value="SoundBar">SoundBar</option>
    <option value="Headphone">Headphone</option>
    <option value="Earphone">Earphone</option>
    <option value="Television">Television</option>
    <option value="Mobile Phone">Mobile Phone</option>
    <option value="Tablet">Tablet</option>
    <option value="Laptop">Laptop</option>
    <option value="Others">Others</option>

    </select>
  </div>

<div class="form-group ">
    <label for="address">Enter Pickup Address</label>
    <textarea class="form-control" name="address" id="address" rows="2" ></textarea>
  </div>


  <div class="form-group">
    <label for="problemDescription">Problem Description</label>
    <textarea class="form-control" id="problemDescription" rows="2" name="problemDescription"></textarea>
  </div>
  <br>
  <br>
  <div class="form-row  mt-3" >
    <div class="col-2">
    <label for="purchaseDate">Purchase Date:</label>
    </div>
    <div class="col">
  <input type="date" id="purchaseDate" name="purchaseDate">

    </div>
  </div>
      <br>
      <br>
      <div class="form-row  mt-3">
    <div class="col-2" >
    <label for="img">Select invoice:</label>
    </div>
    <div class="col">
    <input type="file" id="img" name="uploadFile" >
    </div>
  </div>

  <div class="text-center mt-5">
  <button type="submit" class="btn btn-primary " name='submit' >Submit</button>

  </div>
  

</form>
</div>

</div>

</div>
    <script>
    var company=  
    <?php echo json_encode($companyName); ?>;
    function autocomplete(inp, arr) {
  var currentFocus;
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      this.parentNode.appendChild(a);
      for (i = 0; i < arr.length; i++) {
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          b = document.createElement("DIV");
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
              b.addEventListener("click", function(e) {
              inp.value = this.getElementsByTagName("input")[0].value;
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        currentFocus++;
        addActive(x);
      } else if (e.keyCode == 38) { 
        addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}

    autocomplete(document.getElementById("myInput"), company);
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>