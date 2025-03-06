<?php
error_reporting(E_ALL);
require_once "CustomerController.php";

session_start();

$_SESSION['customerID'];


if(isset($_REQUEST['action'])){
    $action = $_REQUEST['action'];
}
else{
    include "login.php";
    exit;
}

if($action == "login"){
   $controller = new CustomerController();
    $username = $_POST['username'];
    $password = $_POST['passwrd'];
   $id = $controller->checkCustomerCredentials($username, $password);
   echo $id;

   if(isset($id)){
    $_SESSION['customerID'] = $id;
    header("Location:home.php");
   }
   else{
    header("Location:index.php");
   }

}

else if($_SESSION['customerID'] !== NULL){
    exit;
}

else{
    include "login.php";
}
?>
