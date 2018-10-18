<?php
require_once('../require.php');
if(!isset($_SESSION['badpass'])){
  $_SESSION['badpass'] = (int)0;
  $submit = '';
}else{
  $submit = '';
  if($_SESSION['badpass'] >= (int)5){
    $submit = 'disabled';
  }
}
if(isset($_POST['loginSub'])){
    $usuname = $_POST['uname'];
    $uspwd = $_POST['pwd'];
    loginuserMerchant($usuname,$uspwd);
}
?>
<?php
?>
 <div id="body" class="container-fluid" style="width:100%;padding-bottom: 20px;">
    <header class="container">
         <div class="text-center" style="width:100%;margin-top:20px;height:90px;">
             <div style="w3-padding"><img id="#ccaLogo" src="../media/images/ccawg.svg" class="w3-image" style="height:90px;"/></div>
       </div>
       <div class="row" style="text-align:center; margin-top: 15px;">
            <div class="col-sm-12">
                <h3 class="w3-text-green">CM3 Merchant</h3>
                <h2 class="w3-jumbo w3-text-blue">Welcome</h2>
                <h3 class="w3-text-grey">Please sign in.</h3>
           </div>
       </div>
       <div class="row w3-margin text-center">
         <div class="col-sm-1"></div>
         <div class="col-sm-5">
             <a href="../admin/"><div class="w3-blue w3-padding">CREATOR LOGIN</div></a>
           </div>
         <div class="col-sm-5">
             <a href="../merchant/"><div class="w3-border w3-border-green w3-padding">MERCHANT LOGIN</div></a>
           </div>
         <div class="col-sm-1"></div>
       </div>
       <div class="row">
           <div class="container">
             <div style="max-width:80%; margin:auto;">
               <div class="w3-white w3-border w3-border-green w3-opacity" style="min-height:175px;">
                   <h3 class="w3-padding text-left">
                       The revolutionary management app, created to help anyone faced with making decisions.<br>Take advantage of our statistics capabilities, storage space, customer service, client management and more.
                   </h3>
               </div>
             </div>
             </div>
       </div>
    </header>
<!-- END HEADER -->
<!-- LOGIN -->
         <div class="row">
           <div class="container">
             <div style="max-width:70%;margin:auto;">
             <div class="row">
               <div id="" class="col-sm-12 text-center">
                 <h3 class="w3-text-red">
                     <?php if(isset($_GET['alert'])){ echo $_GET['alert'];}?>
                   </h3>
               </div>
             </div>
<!-- LOGIN HERE -->
                     <div id="form" style="text-align: center; margin-left: 4%; margin-right: 4%; padding-top: 40px;">
                           MERCHANT LOGIN
                           <form method="POST" action="">
                                   <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                             <input id="uid" type="text" class="form-control" name="uname">
                                   </div>
                                   <br><p>ATTENTION: CM3 HAS NO ACCESS TO YOUR PASSWORD, IF YOU LOSE IT, YOU MUST RESET IT.<br> DONT LOSE IT.</p>
                                   <div class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                             <input id="password" type="password" class="form-control" name="pwd" placeholder="Password">
                                   </div>
                                   <br>
                                   <p> You have entered incorrect info <span class="w3-text-red"><?php echo $_SESSION['badpass']; ?></span> out of 5 times</p>
                                   <div class="input-group">
                                            <input id="loginSubmit" type="submit" class="form-control" name="loginSub" value="Log In" <?php echo $submit;?>>
                                   </div>
                           </form>
                     </div>
                    <div class="row">
                        <div class="col-sm-12 text-left"><a href="merchant.register.php"><div class="w3-btn">REGISTER AS A MERCHANT</div></a>
                        </div>
                    </div>
                   </div>
                 </div>
             </div>
</html>
