<?php
//check whether stripe token is not empty
if(!empty($_POST['stripeToken'])){
    //get token, card and user info from the form
    $token  = $_POST['stripeToken'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $card_num = $_POST['card_num'];
    $card_cvc = $_POST['cvc'];
    $card_exp_month = $_POST['exp_month'];
    $card_exp_year = $_POST['exp_year'];
    //include Stripe PHP library
    require_once('vendor/autoload.php');
    //set api key
    $stripe = array(
      "secret_key"      => "sk_test_vseBDdN0MJB0yp1w8gwhIdX6",
      "publishable_key" => "pk_test_qUgFXuTWbRNMy9wX7V8qIitR"
    );
    \Stripe\Stripe::setApiKey($stripe['secret_key']);
    //add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'email' => $email,
        'source'  => $token
    ));
    //make following information dynamic to the form
    //company information
    $orgName = $_POST['name'];
    $orgEmail = $_POST['email'];
    $orgLogin = $_POST['uid'];
    $orgKey = $_POST['pwd'];
    //item information
    $itemName = "CM3 Merchant (1 year)";
    //item number can be company code + product id
    $itemNumber = "CCA667121";
    $itemPrice = 248700;
    //orderid can be company code + product id + date + random 3 digits
    $compCode = "CCA667";
    $productID = "121";

    $currency = "usd";
    $date = date("Ymd");
    $rand3 = rand(100, 999);
    $orderID = "{$compCode}{$productID}{$date}{$rand3}";

    //charge a credit or a debit card
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $itemPrice,
        'currency' => $currency,
        'description' => $itemName,
        'metadata' => array(
            'order_id' => $orderID
        )
    ));

    //retrieve charge details
    $chargeJson = $charge->jsonSerialize();

    //check whether the charge is successful
    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
        //order details
        $amount = $chargeJson['amount'];
        $balance_transaction = $chargeJson['balance_transaction'];
        $currency = $chargeJson['currency'];
        $status = $chargeJson['status'];
        $date = date("Y-m-d H:i:s");

        //include database config file
        include_once 'dbConfig.php';

        //insert tansaction data into the database
        $sql = "INSERT INTO orders(name,email,card_num,card_cvc,card_exp_month,card_exp_year,item_name,item_number,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES('".$name."','".$email."','".$card_num."','".$card_cvc."','".$card_exp_month."','".$card_exp_year."','".$itemName."','".$itemNumber."','".$itemPrice."','".$currency."','".$amount."','".$currency."','".$balance_transaction."','".$status."','".$date."','".$date."')";
        $insert = $db->query($sql);
        $last_insert_id = $db->insert_id;

        //if order inserted successfully
        if($last_insert_id && $status == 'succeeded'){
            $statusMsg = "<h2>The transaction was successful.</h2><h4>Order ID: {$last_insert_id}</h4>";
            //order successful, insert organization info into database, then forward to admin or login page

            if($insert){}else{}
        }else{
            $statusMsg = "Transaction has been failed";
        }
    }else{
        $statusMsg = "Transaction has been failed";
    }
}else{
    $statusMsg = "Form submission error.......";
}

//show success or error message
echo $statusMsg;
