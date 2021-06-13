<?php
session_start(); //starts the session
unset($_SESSION); //unsets the information from the $_SESSION global variable
session_destroy(); //destroys session
session_write_close();
header('Location: index.php'); //redirects to index.php
die; //closes all statements and connection
?>