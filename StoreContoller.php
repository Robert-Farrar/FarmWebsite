
<?php
class Store{
    public $storeID = 0;
    public $storeLocation = '';
  
    function __construct($storeID,$storeLocation){
        $this->storeID = $storeID;
        $this->storeLocation = $storeLocation;
    
    }    
    public function toJson(){
        $json = json_encode($this);
        return $json;
    }
}
class StoreController{
    public $url ="http://127.0.0.1:8000/";

    function __construct(){
        print("A new SC has been created!\n");
    }
    #Inserts Store
    public function insertStore($storeID,$storeLocation){
        $store = new Store($storeID,$storeLocation);
        $json = $store->toJson();
        $path = $this->url."storeItem/storeID/".$storeID."/storeLocation/".$storeLocation;
        
        print("Path: ".$path." json: ".$json);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        
        $result = curl_exec($ch);

        $data = json_decode($result,false);
        print("Successfully added new item to Store!\n\n");
    }
    
    #Returns ID
    public function getStoreID($storeLocation){
        $path = $this->url."store/storeLocation/".$storeLocation;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$storeLocation);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        $result = curl_exec($ch);
        $data = json_decode($result,true);
        echo("Returned: ".json_encode($data));
        return $data;

    }


}
$sic = new StoreController();
    
    $sic->insertStore(1,"address");
    
    $sic->getStoreID("address");
?>