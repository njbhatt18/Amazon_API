<?php
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tests'.DIRECTORY_SEPARATOR.'bootstrap.php';
require_once 'Config.php';
require_once 'Simplexml.php';


use ApaiIO\Request\RequestFactory;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ResponseTransformer\ObjectToArray;
use ApaiIO\Operations\Lookup;
use ApaiIO\Operations\SimilarityLookup;
use ApaiIO\Operations\CartCreate;
use ApaiIO\ApaiIO;
use ApaiIO\Operations\BrowseNodeLookup;
use ApaiIO\Operations\CartAdd;

$conf = new GenericConfiguration();

try {
    $conf
        ->setCountry('de')
        ->setAccessKey(AWS_API_KEY)
        ->setSecretKey(AWS_API_SECRET_KEY)
        ->setAssociateTag(AWS_ASSOCIATE_TAG);
} catch (\Exception $e) {
    echo $e->getMessage();
}
$apaiIO = new ApaiIO($conf);
$convert = new ObjectToArray();

$apaiIO->
$lookup = new Lookup();
$lookup->setItemId('041100004567');
$lookup->setIdType('UPC');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($lookup, $configuration);
$xml = new SimpleXMLElement($formattedResponse);
$json = json_encode($xml);
$array = json_decode($json,TRUE);
//Passing item to another array;
echo "<pre>";
    print_r($array);exit;
    


//$search = new Search();
//$search->setCategory('Blended');
////$search->setActor('Bruce Willis');
//$search->setKeywords('613423211108');
//$search->setPage(3);
//$search->setResponseGroup(array('Large', 'Small'));
//$formattedResponse = $apaiIO->runOperation($search);
    //echo $formattedResponse; //exit;

$xml = new SimpleXMLElement($formattedResponse);
$json = json_encode($xml);
$array = json_decode($json,TRUE);
//Passing item to another array;
echo "<pre>";
    print_r($array);exit;
foreach($array as $key=>$value){
    if($key=='Items'){
        foreach ($value as $key=>$values) {
            if($key=='Item'){
                /*echo "<pre>";
                print_r($values);*/
                $item_array[]=$values;
            }
        }
        //exit;
    }
}
//storing only useful information image, name, price.
foreach($item_array as $key => $value){
    foreach($value as $keys => $values){
        $item_array1[$keys]['image']=$values['LargeImage'];
        $filter=$values['ItemAttributes'];
        if(isset($filter['Title'])){
            $item_array1[$keys]['title']=$filter['Title'];
        }
        if(isset($filter['TradeInValue'])){
            $item_array1[$keys]['amount']=$filter['TradeInValue'];
        }
    }
//    foreach($value as $keys=>$values){
//        if($keys=='LargeImage'){
//            echo $values['URL'];
//        }
//    }
}
    echo "<pre>";
    print_r($item_array1);exit;
// var_dump($formattedResponse);

// $cartCreate = new CartCreate();
// $cartCreate->addItem("B0040PBK32", 1);

// $formattedResponse = $apaiIO->runOperation($cartCreate);

// $cartAdd = new CartAdd();
// $cartAdd->setCartId('280-6695255-7497359');
// $cartAdd->setHMAC('LxQ0BKVBeQTrzFCXvIoa/262EcU=');
// $cartAdd->addItem('B003YL444A', 1);

// $formattedResponse = $apaiIO->runOperation($cartAdd);

// var_dump($formattedResponse);

$conf->setResponseTransformer('\ApaiIO\ResponseTransformer\XmlToDomDocument');

$lookup = new Lookup();
$lookup->setItemId('B0040PBK32');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($lookup, $configuration);

//var_dump($formattedResponse);

$lookup = new SimilarityLookup();
$lookup->setItemId('B0040PBK32');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($lookup);

$conf->setRequest('\ApaiIO\Request\Soap\Request');
$conf->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray');

$lookup = new SimilarityLookup();
$lookup->setItemId('B0040PBK32');
$lookup->setResponseGroup(array('Large', 'Small'));

$formattedResponse = $apaiIO->runOperation($lookup, $conf);

//var_dump($formattedResponse);

$conf->setResponseTransformer(new \ApaiIO\ResponseTransformer\ObjectToArray());
$browseNodeLookup = new BrowseNodeLookup();
$browseNodeLookup->setNodeId(542064);

$formattedResponse = $apaiIO->runOperation($browseNodeLookup, $configuration);

var_dump($formattedResponse);
