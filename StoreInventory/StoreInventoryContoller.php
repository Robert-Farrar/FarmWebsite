<?php
class Item{
    public $storeID = 0;
    public $itemID = 0;
    public $inStock = '';
    public $storeItemQuantity = 0;
    function __contruct($storeID,$itemID,$inStock,$storeItemQuantity){
        $this->storeID = $storeID;
        $this->itemID = $itemID;
        $this->inStock = $inStock;
        $this->storeItemQuantity = $storeItemQuantity;
    }    
    function toJson(){
        return json_decode($this);
    }
}
class StoreInventoryController{
    public $url ="http://127.0.0.1:8000/";

    function __contruct(){
        print("A new SIC has been created!\n");
    }
    function InsertStoreItem($storeID,$itemID,$inStock,$storeItemQuantity){
        $item - new Item($storeID,$itemID,$inStock,$storeItemQuantity);
        $ch = curl_init($ch);
        curl_setopt($ch, CURLOPT_URL, $url."storeItem/");
        curl_setopt($ch,CURLOPT_POSTFIELDS,$item.toJson());
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        
        $result = curl_exec($ch);

        $data = json_decode($result,false);
        print($data);
    }
}
    $sic = new StoreInventoryController();
    $sic.InsertStoreItem(1,1,'y',5);
?>