
<?php
class Item{
    private $storeItemID = null;
    public $storeID = 0;
    public $itemID = 0;
    public $inStock = '';
    public $storeItemQuantity = 0;
    function __construct($storeID,$itemID,$inStock,$storeItemQuantity){
        $this->storeID = $storeID;
        $this->itemID = $itemID;
        $this->inStock = $inStock;
        $this->storeItemQuantity = $storeItemQuantity;
    }    
    public function toJson(){
        #$data = array('storeItemID' => null, 'storeID' => $this->storeID, 'itemID' => $this->itemID, 'inStock' => $this -> inStock, 'storeItemQuantity' => $this -> storeItemQuantity);
        $json = json_encode($this);
        return $json;
    }
}
class StoreInventoryController{
    public $url ="http://127.0.0.1:8000/";

    function __construct(){
        print("A new SIC has been created!\n");
    }
    #
    public function createStoreItem($storeID,$itemID,$inStock,$storeItemQuantity){
        $item = new Item($storeID,$itemID,$inStock,$storeItemQuantity);
        $json = $item->toJson();
        $path = $this->url."storeItem/storeID/".$storeID."/itemID/".$itemID."/inStock/".$inStock."/storeItemQuantity/".$storeItemQuantity;
        
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
    public function getItem($storeID,$itemID){
        $path = $this->url."store/storeID"."/".$storeID."/itemID/".$itemID;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$storeID);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ch);
        $data = json_decode($result,true);
        echo(json_encode($data));
        return $data;

    }
    #Returns list of Dictionaries
    public function loadStoreInventoryItems($storeID){
        $path = $this->url."store/storeID"."/".$storeID;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$storeID);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ch);
        $data = json_decode($result,true);
        echo(json_encode($data));
        return $data;
    }
}
$sic = new StoreInventoryController();
    /* 
    $sic->createStoreItem(1,1,'y',5);
    */
    $storeItems = $sic->loadStoreInventoryItems(1);
    $sic->getItem(1,1)
?>
