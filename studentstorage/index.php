<?php 
session_start(); //starts the session 
ob_start();
if( isset($_SESSION["userid"])){
    $loggedin = true;
    header('Location: userStorage.php'); 
    
} else {
    $loggedin = false;
}

?>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<title>Welcome To Student Storage</title>
<script src="https://kit.fontawesome.com/abf295177c.js" crossorigin="anonymous"></script>
</head>
<body>
    
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
// define variables and set to empty values
$email = $password = "";
// declare variables to hold error messages for each field
$usernameError = $passwordError = "";

// function to clear userinputs
function clearUserInputs($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} 
    

if(isset($_POST["formSubmit"])){ //allows for sending of information if the Server request method is POST
    if(empty($_POST["email"])){
        $usernameError = "Email is required"; //checks if Username field is not empty
        echo '<script language="javascript">';
        echo 'alert("'.$usernameError.'")';
        echo '</script>';
        $foundErrors = true;
    }
    else{
        $email = clearUserInputs($_POST["email"]); //assigns the email field value to $email
    }
    
    if(empty($_POST["password"])) { //checks if Password field is not empty
        $passwordError = "Password is required";
        echo '<script language="javascript">';
        echo 'alert("'.$passwordError.'")';
        echo '</script>';
        $foundErrors = true;
    }  
     else {
        $password = clearUserInputs($_POST["password"]); //assigns the password field value to $password
    }
    if($foundErrors == false) { //if there are no errors the code below is executed
          //header('Location: userStorage.php'); //redirect on login
        //MySQL database information, saved into PHP variable-    
    $servername = "localhost";
    $dbusername = "studeage_admin";
    $dbpassword = "admin";
    $databasename = "studeage_users"; 

    $conn = new mysqli($servername, $dbusername, $dbpassword,$databasename);
    
    

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    } else {
    
    //executes the login query
            $stmt = $conn->prepare("SELECT * FROM users where email=? and PASSWORD=?"); //Prepares SQL statement to select username and Password from users table
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();
           
    }

if($result->num_rows === 0) {
                $credentialError = "Invalid username or password"; //displays error if stated Username and passsword does not exsist
                
             echo '<script language="javascript">';
             echo 'alert("'.$credentialError.'")';
             echo '</script>';
                
            }
            else{
                echo "Rows: " . $result->num_rows;
                $row = $result->fetch_assoc(); //without the code below to redirect to another website this shows :1
                
                //stores username and userid into the $_SESSION global variable
                $_SESSION["email"] = $row["email"]; 
                $_SESSION["userid"] = $row["id"];
                $loggedin = true;
                
                $localuserid = $_SESSION["userid"];
                $path = "userStorage/User_$localuserid";
                if (!file_exists($path)) {
                mkdir("$path");
                }
                header('Location: userStorage.php'); //redirect on register
        }
            
    }  
}
?>

<div class="container">
	<div class ="container rounded border border-light position-absolute" style="margin: 20px; background-color: FEFEFA;">
		<div class='row row-4'>
		<div class='col border-start'>
			
		</div>  
		<div class="col border-end">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group" >
				<label for="emailInput">Email Address</label>
				<input type="email" placeholder="Email" style="background-color: #f2f2f2" class="form-control" id="emailInput" maxlength="32" name="email" required>
		</div>
		<div class="form-group">
			<label for="passwordInput">Password</label>
			<input type="password" placeholder="Password" style="background-color: #f2f2f2" class="form-control" maxlength="20" name="password" id="passwordInput" required>
		</div>      
			
				<button class="btn" style="margin-top: 20px; background-color: FFC15E;" type="submit" 
				name="formSubmit"value="Submit">Login</button></td> <!-- login form submitt button -->
			 </form>
			 </div>
		</div> 
		<div class="row row-4">
			<div class="col">
				<a data-toggle="collapse" href="#registerExpand" aria-expanded="false" aria-controls="registerExpand">No account? Click here to register! <i class="fas fa-long-arrow-alt-down"></i></a>
			</div> <!-- Col end --> 
		</div>


	  <div class="collapse" id="registerExpand">	
	  	<div class="row">
		    <div class="col">
		        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		            <div class="form-group" >
		                <label for="emailInput">Email Address</label>
		                    <input type="email" placeholder="Email" style="background-color: #f2f2f2" class="form-control " id="emailInput" maxlength="32" name="registerEmail" required>
		            </div>
					<div class="form-group">
						<label for="passwordInput">Password</label>
						<input type="password" placeholder="Password" style="background-color: #f2f2f2" class="form-control " maxlength="20" name="registerPassword" id="passwordInput" required>
					</div>
					<div class="form-group">
						<label for="passwordConfirmInput">Confirm Password</label>
						<input type="password" placeholder="Password" style="background-color: #f2f2f2" class="form-control " maxlength="20" name="registerPasswordConfirm" id="passwordConfirmInput" required>
					</div>      
					<button class="btn" style="margin-top: 20px; background-color: FFC15E;" type="submit" name="registerSubmit"value="Submit">Register</button></td> <!-- Register form submitt button -->
				</form>
	        </div>
	        <div class="col">
	            <p1>Registering is free "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p1>
	        </div>
	    </div>     <!-- collapse end -->
	</div> 
	</div>
</div>	



<br>
<br>

<?php

// define variables and set to empty values
 $registerPassword =  $registerEmail = "";


// declare variables to hold error messages for each field. 
$registerPasswordError =  $registerEmailError = "";
$foundErrors = false;


// if the form has been submitted, AND the method is POST
if(isset($_POST["registerSubmit"])){

        if(empty($_POST["registerPassword"])) {
            $passwordError = "Password is required"; //checks that  the password field is not empty
             echo '<script language="javascript">';
             echo 'alert("'.$passwordError.'")';
             echo '</script>';
            $foundErrors = true;
        } 
         else {
             $registerPassword = clearUserInputs($_POST["registerPassword"]); //assigns the value of the password field to the $password variable
        }
        
        if(empty($_POST["registerPasswordConfirm"])) { //checks that  the password field is not empty
            $passwordError = "Please Confirm Password"; 
             echo '<script language="javascript">';
             echo 'alert("'.$passwordError.'")';
             echo '</script>';
            $foundErrors = true;
        } else {
            $registerPasswordConfirm = clearUserInputs($_POST["registerPasswordConfirm"]);
        }
        
        if($registerPassword != $registerPasswordConfirm){
            $passwordError = "Passwords must match";
             echo '<script language="javascript">';
             echo 'alert("'.$passwordError.'")';
             echo '</script>';
            $foundErrors = true;
        }
        
        if(empty($_POST["registerEmail"])) {
            $emailError = "Email is required"; //checks that  the email field is not empty
            $foundErrors = true;
        }
        else {
            // validate email address
            if(filter_var($_POST["registerEmail"], FILTER_VALIDATE_EMAIL)) {
                $registerEmail = clearUserInputs($_POST["registerEmail"]); //assigns the value of the email field to the $email variable
            }
            else {
                $emailError = "Invalid email address"; 
                $foundErrors = true;
            }
        }

       
    if($foundErrors == false) {
            $servername = "localhost";
            $dbusername = "studeage_admin";
            $dbpassword = "admin";
            $databasename = "studeage_users"; 
        // PHP code to save form data to the MySQL database
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$databasename",
                          $dbusername, $dbpassword);
  //set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO users (PASSWORD, email) 
    VALUES (:PASSWORD, :email)");
    $stmt->bindParam(':PASSWORD', $registerPassword); 
    $stmt->bindParam(':email', $registerEmail);
    $stmt->execute();
    
    
    }  
    catch(PDOException $e)
    {
        $errorkey = "Integrity constraint violation: 1062 Duplicate entry";
        if(strpos($e->getMessage(), $errorkey) > 0) {
            $emailError = "This Email is already registered"; //displays an error message if a Username already exsists in the database
             echo '<script language="javascript">';
             echo 'alert("'.$emailError.'")';
             echo '</script>';
        }
        else {
        echo "Connection failed: " . $e->getMessage();
        }
    } 
} else {
    $conn = null;   
}
    echo "registered $registerEmail";
    $conn = null;
    
     $conn = new mysqli($servername, $dbusername, $dbpassword,$databasename);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    } else {
    
             
    $stmt = $conn->prepare("SELECT * FROM users where email=? and PASSWORD=?"); //Prepares SQL statement to select username and Password from users table
            $stmt->bind_param("ss", $registerEmail, $registerPassword);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $row = $result->fetch_assoc(); //without the code below to redirect to another website this shows :1
            $_SESSION["email"] = $row["email"]; 
            $_SESSION["userid"] = $row["id"];
            $loggedin = true;
           
            $localuserid = $_SESSION["userid"];
            $path = "userStorage/User_$localuserid"; 
      
            if (!file_exists($path)) {
             mkdir("$path");
            echo "Created new directory";
            }
            header('Location: userStorage.php');  
            $conn = null;
            
    }
    
}  //end of POST if               
?>

</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<style>
body {
    background-color: #114B5F;
}
</style>
</html>

<?php
ob_end_flush();
?>

