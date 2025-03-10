
<?php
function base64url_encode($s) {
    return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
}

function base64url_decode($s) {
    return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
}
class Item{
    public $storageID = 0;
    public $itemName = "";
    public $itemDescription= '';
    public $itemQuantity = 0;
    public $itemImage = '';
    public $itemImageType = '';
    function __construct($storageID,$itemName,$itemDescription,$itemQuantity,$itemImage,$itemImageType){
        $this->storageID = $storageID;
        $this->itemName = $itemName;
        $this->itemDescription= $itemDescription;
        $this->itemQuantity = $itemQuantity;
        $this->itemImage= $itemImage;
        $this->itemImageType = $itemImageType;
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
    public function createWareHouseItem($storageID,$itemName,$itemDescription,$itemQuantity,$itemImagePath){

        $type = pathinfo($itemImagePath, PATHINFO_EXTENSION);
        $data = file_get_contents($itemImagePath);
        $itemImage = base64url_encode($data);
     
        $item = new Item($storageID,$itemName,$itemDescription,$itemQuantity,$itemImage,$type);
        $json = $item->toJson();

        
        
        $path = $this->url."wareHouseItem/storageID/".$storageID."/itemName/".$itemName."/itemDescription/".$itemDescription."/itemQuantity/".$itemQuantity."/itemImage/".$itemImage."/itemImageType/".$type;
        echo $path;
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$path);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        
        $result = curl_exec($ch);

        $data = json_decode($result,true);
        print("Successfully added new item to StoreInventory!");
        return $data;
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
        $data = json_encode($data);
        echo($data['itemID']['itemName']);
        $data['itemImage'] = base64url_decode($data['itemImage']);
        return $data;

    }

    public function updateWareHouseItemQuantity($itemID,$itemQuantity){
        $item = new UpdateItem($itemID,$itemQuantity);
        $json = $item->toJson();

        
        
        $path = $this->url."wareHouseItem/itemID/".$itemID."/itemQuantity/".$itemQuantity;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($json));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ch);
        $data = json_decode($result,true);
        $data = json_encode($data);
        echo("returned: ".$data['itemID']['itemName']);
        
        return $data;
    }
}


$whic = new WareHouseInventoryController();

$lettucePath = '/home/user/Documents/WareHouseInventory/Lettuce.png';
$whic->createWareHouseItem(12,'Lettuce','Lettuce Grown on our farm!',20,$lettucePath);
?>
