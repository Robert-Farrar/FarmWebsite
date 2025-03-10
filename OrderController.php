<?php

class OrderController{
    function getOrderID($customerID, $orderDateCreated){
        $url = "http://127.0.0.1:8000/customerID/".$customerID."/orderDateCreated/".$orderDateCreated;

        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        $data = json_decode($result, false);

        
        return $data;
    }

    function createOrder($customerID, $orderStatus, $orderDateCreated){
        $url = "http://127.0.0.1:8000/customerID/".$customerID."/orderStatus/".$orderStatus."/orderDateCreated/".$orderDateCreated;

        
        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{customerID:".$customerID.",orderStatus:".$orderStatus.",orderDateCreated:".$orderDateCreated."}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

    }

    function getOrders($orderID){
        $url = "http://127.0.0.1:8000/".$orderID;

        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        $result = json_decode($output);

        curl_close($ch);

        $data = [];

        for($i = 0; $i < count($result); $i++){
            $list = new Order();
            $list->orderID = $result[$i]->{'orderID'};
            $list->customerID = $result[$i]->{'customerID'};
            $list->orderStatus = $result[$i]->{'orderStatus'};
            $list->orderDateCreated = $result[$i]->{'orderDateCreated'};

            $data[$i] = $list;
        }

        return $data;
    }



}

class OrderListController{
    function getOrderList($orderID){
        $url = "127.0.0.1:8000/orderID/".$orderID;

        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        $result = json_decode($output);

        curl_close($ch);

        $data = [];

        for($i = 0; $i < count($result); $i++){
            $list = new OrderList();
            $list->orderID = $result[$i]->{'orderID'};
            $list->storeInventoryItemID = $result[$i]->{'storeInventoryItemID'};
            $list->amountSold = $result[$i]->{'amountSold'};

            $data[$i] = $list;
        }

        return $data;
    }

    function createOrderList($orderID, $storeInventoryItemID, $amountSold){
        $url = "http://127.0.0.1:8000/orderID/".$orderID."/storeInventoryItemID/".$storeInventoryItemID."/amountSold/".$amountSold;

        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);
    }
}

//container classes to make it easier to pass info

class Order{

public $orderID;
public $customerID;
public $orderStatus;
public $orderDateCreated;
}

class OrderList{
public $orderID;
public $storeInventoryItemID;
}