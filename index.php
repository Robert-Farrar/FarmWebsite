<?php
error_reporting(E_ALL);
ini_set('display_errors', "1");
require_once "CustomerController.php";
require_once "OrderController.php";

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

   if(isset($id)){
    $_SESSION['customerID'] = $id;
    include "home.php";
   }
   else{
    header("Location:index.php");
   }

}
else if($action == "add"){
    $controller = new CustomerController();
    $username = $_POST['username'];
    $password = $_POST['passwrd'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $customerAddress = $_POST['customerAddress'];
    $phoneNumber = $_POST['phoneNumber'];

    $controller->insertCustomer($username, $password, $fullName, $email, $customerAddress, $phoneNumber);

    header("Location:index.php");

}

else if($_SESSION['customerID'] !== NULL and $_REQUEST['action'] == "history"){
    $id = $_SESSION['customerID'];
    $controller = new OrderController();

    $orders = $controller->getOrders($id);

    include "OrderHistory.php";
    exit;
}
else if($SESSION['customerID'] !== NULL and $_REQUEST['action'] == "checkout"){
    include "Checkout.php";
    exit;
}

else{
    
    include "login.php";
}
?>
