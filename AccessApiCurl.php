<?php
//PRODUCT MANIPULATIONS
// for Listing Product data(GET method)
$table = 'product';
$productDataId = 'some id';
$tokenid = 'some id';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.restapi.com/api.php?table='.$table.'&access_token='.$token.'&tableuniqueid='.$productDataId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
$output = curl_exec($ch);
echo($output) ;


//For inserting Products
$data = "array (
                ...
               )";
$data_string = json_encode($data);
curl_setopt($ch, CURLOPT_URL, 'http://www.restapi.com/api.php/table/'.$table.'/access_token/'.$token);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string)                                                                       
));       
$output = curl_exec($ch);
echo($output);
curl_close($ch);


//For deleting Products
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.restapi.com/api.php/table/'.$table.'/access_token/'.$token.'/id/'.$productDataId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$output = curl_exec($ch);
echo($output);


//For Updating Products
curl_setopt($ch, CURLOPT_URL, 'http://www.restapi.com/api.php/table/'.$table.'/access_token/'.$token.'/id/'.$productDataId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string)                                                                       
));       
$output = curl_exec($ch); 
echo($output);


// Same Operations for category 
//....

?>
