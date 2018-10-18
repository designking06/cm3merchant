<?php
require 'inc/merchant.required.php';
//set page
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(isset($_GET['compID'])){
    $compID = $_GET['compID'];
    $_SESSION['compID'] = $compID;
    getusercompanyinfo($_SESSION['compID']);
}
?>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<?php
if(isset($_POST['neworder'])){
if(empty($_POST['newcustname']) AND !empty($_POST['existingcustname'])){
$custname = $_POST['existingcustname'];
}
if(!empty($_POST['newcustname']) AND empty($_POST['existingcustname'])){
$custname = $_POST['newcustname'];
}
if(!empty($_POST['newcustname']) AND !empty($_POST['existingcustname'])){
echo "Please Make Sure one field is empty!";
}
$notes  = $_POST['notes'];
$i = 1;
$order['$i'] = array(
  'orderid'=>$i,
  'custname' => $custname,
  'notes'=>$notes
);
echo "id:".$order['$i']['orderid']."<br>";
echo "Name: ".$order['$i']['custname']."<br>";
if(empty($_POST['product'])){
  $product = NULL;
  echo "No Products Sold?<br>";
}else{
  $product = $_POST['product'];
  foreach($product as $product=>$value){
  global $i;
    $productqty = $_POST[$value];
    $order['$i']['product'] = array(
        'id'=>$value,
        'qty' => $productqty
    );
    echo "Product:".$order['$i']['product']['id']." Qty:";
    echo $order['$i']['product']['qty']."<br>";
    $i++;
}
}
echo "Notes: ".$order['$i']['notes']."<br>";
}
?>
<!--Retrieve Head info -->
<div id="body" class="w3-light-grey" style="max-width:100%;padding-bottom: 20px;">
  <!-- Navbar -->
  <?php getDashHeader(); ?>
  <!-- Navbar on small screens -->
  <!-- End Navbars -->
  <!-- Start Page Content -->
      <header class="" style="padding-top:40px;padding-bottom:50px;">
        <div class="container w3-white w3-card w3-padding">
              <div class="row text-center">
                  <div class="col-sm-12"><img src="../media/images/ccaBlue.png" class="w3-image" style=""/></div>
              </div>
              <!-- Welcome user & display general company information -->
              <div class="row text-center">
                <div class="col-sm-12">
                    <?php echo $_SESSION['compname'];?>
                  </div>
              </div>
        </div>
      </header>
    <div class="container w3-card w3-white w3-padding">
        <div class="row">
            <div class="col-sm-6">
                <div class="col-sm-8"><h4>Customers</h4></div>
                <div class="col-sm-4"><button class="btn w3-small">New</button></div>
                <div class="col-sm-12 w3-border-bottom">
                    crawley@email
                </div>
                <div class="col-sm-12 w3-border-bottom">
                    crawley@email
                </div>

            </div>
            <div class="col-sm-6">Sales</div>
        </div>
    </div>
        <?php //echo $groupMember_Insert_Error; ?>
        <div class="container w3-white w3-card w3-padding">
            <h2 class="w3-text-blue">New Sale</h2>
                <form id="custform" method="post">
                    <h3>1. Customer</h3>
                    <div class="w3-margin">
                        <h4>A) New Customer?</h4>
                        <p class="w3-small">Enter Their Name</p>
                        <input type="text" name="newcustname" class="form-control" placeholder="name" value="">
                        <br><h4>OR</h4><br>
                        <h4>B) Existing Customer?</h4>
                        <p class="w3-small">Choose Customer From List</p>
                        <select name="existingcustname" form="custform" class="form-control">
                          <option value="">None/Not Listed</option>
                          <option value="volvo">Volvo</option>
                          <option value="saab">Saab</option>
                          <option value="opel">Opel</option>
                          <option value="audi">Audi</option>
                        </select>
                    </div>
                         <hr>
                    <h3>2. What Was Purchased?</h3>
                    <p>Check Products From List & Specify Quantity Sold</p>
                    <div class="dropdown">
                      <button class="btn btn-primary dropdown-toggle form-control" type="button" data-toggle="dropdown">Choose Product</button>
                      <ul class="dropdown-menu form-control row" style="height:100px;overflow-y:auto;">
                        <!-- select all company products from table -->
                          <!-- How will you keep track of how many of each were sold?-->
                            <?php displayProductsInListWithCheckbox($_SESSION['compID']);?>
                      </ul>
                    </div>
                    <br>
                    <h4>3. Notes</h4>
                    <textarea class="form-control" name="notes"></textarea><br>
                    <input type="submit" name="neworder" value="Submit Sale" class="form-control w3-green">
                </form>
            <br>
            <?php
            $order1 = array(
                'name'=>'Caleb',
                'items'=>array(
                    'id'=>'123',
                    'name'=>'toothbrush',
                    'price'=>(int)2000
                ),
                'notes' => 'nothing'
            );
            //print_r($order1['items']);



getMtFooter();?>
