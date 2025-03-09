
<?php
class Item{
    private $itemID = 0;
    public $storageID = 0;
    public $itemName = "";
    public $itemDescription= '';
    public $itemQuantity = 0;
    public $itemImagee = '';
    function __construct($itemID,$storageID,$itemName,$itemDescription,$itemQuantity,$itemImage){
        $this->itemID = $itemID;
        $this->storageID = $storageID;
        $this->itemName = $itemName;
        $this->itemDescription= $itemDescription;
        $this->itemQuantity = $itemQuantity;
        $this->itemImage= $itemImage;
    }    
    public function toJson(){
        #$data = array('storeItemID' => null, 'storeID' => $this->storeID, 'itemID' => $this->itemID, 'inStock' => $this -> inStock, 'storeItemQuantity' => $this -> storeItemQuantity);
        $json = json_encode($this);
        return $json;
    }
}
class UpdateItemQty{
    private $itemID = 0;
    public $itemQuantity = 0;
    function __construct($itemID,$itemQuantity){
        $this->itemID = $itemID;
        $this->itemQuantity = $itemQuantity;
    }    
    public function toJson(){
        #$data = array('storeItemID' => null, 'storeID' => $this->storeID, 'itemID' => $this->itemID, 'inStock' => $this -> inStock, 'storeItemQuantity' => $this -> storeItemQuantity);
        $json = json_encode($this);
        return $json;
    }
}
class WareHouseInventoryController{
    public $url ="http://127.0.0.1:8000/";

    function __construct(){
        print("A new WHIC has been created!\n");
    }
    #
    public function createWareHouseItem($itemID,$storageID,$itemName,$itemDescription,$itemQuantity,$itemImage){
        $item = new Item($itemID,$storageID,$itemName,$itemDescription,$itemQuantity,$itemImage);
        $json = $item->toJson();
        $path = $this->url."wareHouseItem/itemID/".$itemID."/storageID/".$storageID."/itemName/".$itemName."/itemDescription/".$itemDescription."/itemQuantity/".$itemQuantity."/itemImage/".$itemImage;
        
        print("Path: ".$path." json: ".$json);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        
        $result = curl_exec($ch);

        $data = json_decode($result,false);
        print("Successfully added new item to StoreInventory!");
    }
    
    #Returns dictionary
    public function getItem($itemID){
        $path = $this->url."warehouse/itemID"."/".$itemID;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$itemID);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ch);
        $data = json_decode($result,true);
        echo(json_encode($data));
        return $data;

    }

    public function updatWareHouseItemQuantity($itemID,$itemQuantity){
        $item = new UpdateItem($itemID,$itemQuantity);
        $json = $item->toJson();

        $path = $this->url."wareHouseItem/itemID/".$itemID."/itemQuantity/".$itemQuantity;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ch);
        $data = json_decode($result,true);
        echo("returned: ".json_encode($data));
        return $data;
    }
}
$whic = new WareHouseInventoryController();
?>