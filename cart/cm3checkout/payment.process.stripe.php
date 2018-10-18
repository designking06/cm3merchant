<??>
<?php
//process Stripe Payment
// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
require_once ('../vendor/autoload.php');
\Stripe\Stripe::setApiKey("sk_test_vseBDdN0MJB0yp1w8gwhIdX6");
// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];
$stripeAmt = $_POST['amount'];
try{
$charge = \Stripe\Charge::create([
    'amount' => $stripeAmt,
    'currency' => 'usd',
    'description' => "yo",
    'source' => $token,
]);
}catch(\Stripe\Error\Card $e){
  //card has been declined
  echo 'Payment Failed';
}
?>
