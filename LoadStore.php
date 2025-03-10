<?php
include("/home/user/Documents/WareHouseInventory/WareHouseInventoryContoller.php");
include("/home/user/Documents/StoreInventory/StoreInventoryContoller.php");

function loadStore($storeID,$sic,$whic){
    $storeItems = $sic->loadStoreInventoryItems($storeID);
    $storeItemInfo = [];
    foreach($storeItems as $x){
        #echo $x["itemID"]."\n";
        $itemInfo = $whic->getItem($x["itemID"]);
        $storeItemInfo[] = array("storeID" => $storeID, "itemID" => $x['itemID'],
                                "inStock" => $x['inStock'],"storeItemQuantity" => $x['storeItemQuantity'],
                                "itemName" => $itemInfo['itemName'], "itemDescription" => $itemInfo['itemDescription'],
                                'itemImagePath' => $itemInfo['itemImagePath']);
        
    }
    return $storeItemInfo;
}

$storeID = 1;
$sic = new StoreInventoryController();
$whic = new WareHouseInventoryController();
$storeItems = loadStore(1,$sic,$whic);
echo var_dump($storeItems);