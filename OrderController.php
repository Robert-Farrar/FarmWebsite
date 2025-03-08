<?php

class OrderController{
    function getOrderID($customerID, $orderDateCreated){
        $url = "http://127.0.0.1:8000/customerID".$customerID."/orderDateCreated/".$orderDateCreated;

        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close();

        $data = json_decode($result, false);

        
        return $data->{'orderID'};
    }

    function createOrder($customerID, $orderStatus, $orderDateCreated){
        $url = "http://127.0.0.1:8000/customerID/".$customerID."/orderStatus/".$orderStatus."/orderDateCreated/".$orderDateCreated;

        
        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{customerID:".$customerID.",orderStatus:".$orderStatus.",orderDateCreated:".$orderDateCreated."}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close();

    }

    function getOrder($orderID){
        $url = "http://127.0.0.1:8000/".$orderID;

        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close();

        $data = json_decode($result, false);

           
        $order = new Order();

        $order->orderID = $data->{'orderID'};
        $order->customerID = $data->{'customerID'};
        $order->orderStatus = $data->{'orderStatus'};
        $order->orderDateCreated = $data->{'orderDateCreated'};

        return $order;
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

        curl_close();

        $data = [];

        for($i = 0; $i < count($result); $i++){
            $list = new OrderList();
            $list->orderID = $result[$i]->{'orderID'};
            $list->storeInventoryItemID = $result[$i]->{'storeInventoryItemID'};

            $data[$i] = $list;
        }

        return $data;
    }

    function createOrderList($orderID, $storeInventoryItemID){
        $url = "http://127.0.0.1:8000/orderID/".$orderID."/storeInventoryItemID/".$storeInventoryItemID;

        $ch = curl_init($ch);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close();
    }
}

//container classes to make it easier to pass info

class Order{
$orderID;
$customerID;
$orderStatus;
$orderDateCreated;
}

class OrderList{
$orderID;
$storeInventoryItemID;
}