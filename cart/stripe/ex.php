<?php
$compCode = "CCA667";
$productID = "121";
$date = date("Ymd");
$rand3 = rand(100, 999);
$orderID = "{$compCode}{$productID}{$date}{$rand3}";
echo $orderID;
echo "<br>".date("Ymd");
?>


$orgName = $_POST['name'];
$orgEmail = $_POST['email'];
$orgLogin = $_POST['uid'];
$orgKey = $_POST['pwd'];
