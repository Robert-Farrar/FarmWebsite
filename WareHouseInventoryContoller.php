
<?php
function url_encode($string){
    $string = base64_encode($string);
    return urlencode(utf8_encode($string));
}

function url_decode($string){
    $string = utf8_decode(urldecode($string));
    return base64_decode($string);
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
class InsertItem{

    public $storageID = 0;
    public $itemName = "";
    public $itemDescription= '';
    public $itemQuantity = 0;
    public $itemImagePath = "";
    function __construct($storageID,$itemName,$itemDescription,$itemQuantity,$itemImagePath){
        $this->storageID = $storageID;
        $this->itemName = $itemName;
        $this->itemDescription= $itemDescription;
        $this->itemQuantity = $itemQuantity;
        $this->itemImagePath = $itemImagePath;
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
    public function createWareHouseItem($storageID,$itemName,$itemDescription,$itemQuantity,$Path){
        $ch = curl_init();
        $itemDescription = urlencode($itemDescription);
        $itemImagePath = url_encode($Path);
        echo $itemImagePath;
        $item = new InsertItem($storageID,$itemName,$itemDescription,$itemQuantity,$itemImagePath);
        
        $json = $item->toJson();
        $json_output = json_decode($json, true); 
        echo $json_output['itemImagePath'];
        
        
        $path = $this->url."wareHouseItem/storageID/".$storageID."/itemName/".$itemName."/itemDescription/".$itemDescription."/itemQuantity/".$itemQuantity."/itemImagePath/{$itemImagePath}";
        #echo $path;
        
        
        curl_setopt($ch,CURLOPT_URL,$path);
       # curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        #curl_setopt($ch,CURLOPT_POST,TRUE);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'From: InsertItem, Error: ' . curl_error($ch);
        }

        $data = json_decode($result,false);
        curl_close($ch);
        echo json_encode($data);
        $info = curl_getinfo($ch);
        echo $info['url'];
      
        return $data;
    }
    
    #Returns dictionary
    public function getItem($itemName){
        $path = $this->url."warehouse/itemName"."/".$itemName;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$itemName);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ch);
        $data = json_decode($result,TRUE);
        $data['itemImagePath'] = url_decode($data['itemImagePath']);
        $data['itemDescription'] = urldecode( $data['itemDescription']);
        return $data;

    }

    public function updateWareHouseItemQuantity($itemID,$itemQuantity){
        $item = new UpdateItemQTY($itemID,$itemQuantity);
        $json = $item->toJson();


        $path = $this->url."wareHouseItem/itemName/".$itemID."/itemQuantity/".$itemQuantity;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ch);
        $data = json_decode($result,true);
        

        echo("returned: ".$data['itemID']['itemName']);
        
        return $data;
    }

}


$whic = new WareHouseInventoryController();

$lettucePath = '/home/user/Documents/WareHouseInventory/Lettuce.png';
#$data = $whic->createWareHouseItem(12,'Lettuce','Lettuce Grown on our farm!',20,$lettucePath);

#$data = $whic->getItem("Lettuce");

$data = $whic->updateWareHouseItemQuantity("Lettuce",10);
echo var_dump($data);
?>
