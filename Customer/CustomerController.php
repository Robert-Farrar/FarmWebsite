<?php
class CustomerController{
function checkCustomerCredentials($username, $password){
    $url = "http://127.0.0.1:8000/username/".$username."/password/".$password;

    $ch = curl_init($ch);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{username:".$username.",password:".$password."}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($result, false);

    return $data->{'customerID'};
}

function insertCustomer($username,$password,$fullName,$email,$customerAddress,$phoneNumber){
    $url = "http://127.0.0.1:8000/username/".$username."/password/".$password."/fullName/".$fullName."/email/".$email."/customerAddress/".$customerAddress."/phoneNumber/".$phoneNumber;

    $ch = curl_init($ch);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{username:".$username.",password:".$password.",fullName:".$fullName.",email:".$email.",customerAddress:".$customerAddress.",phoneNumber:".$phoneNumber."}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    curl_close($ch);

}
}
?>