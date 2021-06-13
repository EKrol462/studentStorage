<?php 
session_start(); //starts the session 
ob_start();
?>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://kit.fontawesome.com/abf295177c.js" crossorigin="anonymous"></script>
<title>Welcome To Student Storage</title>
</head>
<body>
    
<?php
if( isset($_SESSION["userid"])){ //determines the session's userid

    $localuserid = $_SESSION["userid"];
  
    $servername = "localhost";
    $dbusername = "studeage_admin";
    $dbpassword = "admin";
    $databasename = "studeage_users"; 
    
    $conn = new mysqli($servername, $dbusername, $dbpassword,$databasename);
    $loggedin = true; 
}
?>    
    

<div class="btn-group">
  <button type="button" class="btn btn-primary btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #FFC15E; color: black">
    <?php echo $_SESSION["email"]; ?>
 <i class="fas fa-caret-down"></i></button>
  <div class="dropdown-menu" style="background-color: #FFC15E;">
    <a class="dropdown-item" href="#">User Settings</a>
    <a class="dropdown-item" href="#">Support</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="logout.php">Log Out</a>
  </div>
</div>
    

<div class="container-fluid">
<div class="row">
    
    <div class="col">
        
    </div>
<div class="text-center">
   <img src ="logo.png" class="img-fluid" alt="Student Storage"></img>
   </div>
   <div class="col">
     
   </div>
   
</div>
   </div>    
    

<?php
if ($loggedin == true)
 {
?>

<div class="container">
<div class="col">
<div class="custom-file">
<form method="post" enctype="multipart/form-data">
<input type="file" class="form-control w-100" name="file[]" id="file" multiple>
<input type="submit" class="btn" name="submitFile" style="background-color: FFC15E;" value="Upload">
</form>
</div>
</div>
</div>

<?php
$filedirectory = "userStorage/User_$localuserid/";
if (isset($_POST['delete'])) {
    unlink($filedirectory . DIRECTORY_SEPARATOR . $_POST['file']);
}

if (isset($_POST['download'])) {
    
    $fileToDownload = $_POST['file'];
    $fileToDownload = "$filedirectory$fileToDownload";
    // header('Content-Disposition: attachment; filename="userStorage/User_1/Capture.PNG"');
    header('Location: ' . $fileToDownload);
    
}

$files = array_diff(scandir($filedirectory), ['..', '.']);
?>
<div class="container">
<div class="row row-cols-2">
    
<?php
foreach ($files as $file) {
    
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if($ext == "jpg" or $ext == "jpeg" or $ext == "png" or $ext == "bmp" or $ext == "gif") {
        $icon = "far fa-image";
    } elseif($ext == "docx" or $ext == "doc" or $ext == "txt") {
        $icon = "fas fa-file-word";
    } elseif($ext == "pdf") {
        $icon = "fas fa-file-pdf";
    } elseif($ext == "pptx" or $ext == "pptm" or $ext == "ppsx" ) {
        $icon = "fas fa-file-powerpoint";
    } elseif($ext == "xlsx" or $ext == "xls" or $ext == "ods" or $ext == "cvs") {
       $icon = "fas fa-file-excel";
    } elseif($ext == "html" or $ext == "php" or $ext == "py" or $ext == "js" or $ext == "cs" or $ext == "cp" or $ext == "java") {
        $icon = "fas fa-file-code";
    } elseif($ext == "mpeg-4" or $ext == "mp4" or $ext == "wmv" or $ext == "avi" or $ext == "mkv" or $ext == "flv" or $ext == "mov") {
        $icon = "fas fa-file-video";
    }
    else {
        $icon = "fas fa-file";
    }
    
    echo "
            
            <div class= 'col-lg-2'>
            <div class= 'row offset-md-2' >
            <form action='' method='POST'>
            <input type='hidden' name='file' value='{$file}'>
            <span style='font-size: 116px;'>
            <button type='submit' name='download' value='Download'>
            <i class='$icon'></i></button>
            </span>
            <a href='$filedirectory$file' style= 'text-align: center'>{$file}</a> <br>
            <button type='submit' class='btn btn-danger' name='delete' value='Delete File'>
            <i class='fas fa-trash'></i></button>
            </div>
            </input>
        </form>
         </div>
    ";
}
Shares
?>
</div>
</div>
 
<?php 


if(isset($_POST["submitFile"])){
 
 // Count total files
 $countfiles = count($_FILES['file']['name']);

 // Looping all files
 for($i=0;$i<$countfiles;$i++){
  $filename = $_FILES['file']['name'][$i];
 
  // Upload file
  if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $filedirectory.'/'.$filename))
  {
      echo "Your file Has been uploaded";
      header('Location: userStorage.php');
  } else {
  echo "Error uploading file";
  }
 }
} r

?>

<?php 
}//end if logged statement statement
else {
    echo "User is not logged in!";
    header('Location: index.php'); 
}

ob_end_flush();
?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<style>

body {
    background-color: #114B5F;
}

button {
    color: white;
    border-style: none;
    background-color: #114B5F;
}

.center {
    justify-content: center;
}
button:hover {
    color: #FFC15E;
}

a {
    color: #FFC15E;
    text-decoration: none;
}

a:hover {
    color: #FFC15E;
    text-decoration: none;
}

.dropdown-item:hover {
    background-color: white;
}

</style>


</html>
    