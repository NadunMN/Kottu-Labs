<?php

$amount=3000;
$merchant_id="1229387";
$order_id= uniqid();
$merchant_secret="MjY1MjE1MTEzNTUxOTQ0MzEwMTg5ODU5NzI4MTMzMTUxMTczMDM=";
$currency= "LKR";

$hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        number_format($amount, 2, '.', '') . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);
$array = [];

$array["amount"] = $amount;
$array["merchant_id"] = $merchant_id;
$array["order_id"] = $order_id;
$array["currency"] = $currency;
$array["hash"] = $hash;

$jsonObj = json_encode($array);
echo $jsonObj;
?>