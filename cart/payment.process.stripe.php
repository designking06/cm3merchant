<??>
<?php
//process Stripe Payment
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
require_once ('vendor/autoload.php');
\Stripe\Stripe::setApiKey("sk_test_vseBDdN0MJB0yp1w8gwhIdX6");
// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];
$stripeAmt = $_POST['amount'];
$description = $_POST['description'];
try{
$charge = \Stripe\Charge::create([
    'amount' => $stripeAmt,
    'currency' => 'usd',
    'description' => $description,
    'source' => $token,
]);
//insert purchase details into database
// -> break $descrption up into array -> implode function
}catch(\Stripe\Error\Card $e){
  //card has been declined
}
?>
