<head>
<title>CCA Template</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<!-- Stripe JavaScript library -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  //set your publishable key
  Stripe.setPublishableKey('pk_test_qUgFXuTWbRNMy9wX7V8qIitR');
  //callback to handle the response from stripe
  function stripeResponseHandler(status, response) {
      if (response.error) {
          //enable the submit button
          $('#payBtn').removeAttr("disabled");
          //display the errors on the form
          $(".payment-errors").html(response.error.message);
      } else {
          var form$ = $("#paymentFrm");
          //get token id
          var token = response['id'];
          //insert the token into the form
          form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
          //submit form to the server
          form$.get(0).submit();
      }
  }
  $(document).ready(function() {
      //on form submit
      $("#paymentFrm").submit(function(event) {
          //disable the submit button to prevent repeated clicks
          $('#payBtn').attr("disabled", "disabled");

          //create single-use token to charge the user
          Stripe.createToken({
              number: $('.card-number').val(),
              cvc: $('.card-cvc').val(),
              exp_month: $('.card-expiry-month').val(),
              exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);

          //submit from callback
          return false;
      });
  });
</script>
<html lang="en">
    <body class="">
      <!-- navigation-->
      <div role="navigation" class="w3-card w3-white w3-margin-bottom">
        <ul class="nav flex-column flex-sm-row justify-content-center">
          <li class="nav-item flex-sm-fill">
            <a class="nav-link active disabled" href="http://cagency.net" target="_blank"><b>CCA Home</b></a>
          </li>
          <li class="nav-item flex-sm-fill dropdown" data-toggle="dropdown">
            <a class="nav-link dropdown-toggle disabled" href="#">Explore</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#" style="color:#c2a23a;">The Stage</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item w3-text-blue" href="#">CM3</a>
            </div>
          </li>
          <li class="nav-item flex-sm-fill">
            <a class="nav-link disabled" href="#">Deals(disabled)</a>
          </li>
        </ul>
      </div>
      <div class="container w3-white" style="min-height:1100px;">
        <div class="container-fluid text-center w3-padding">
          <div class="row"><div class="col-sm-12 text-center"><h1 class="w3-text-blue">Crawley Creative Management System</h1></div></div>
          <hr>
          <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8"><p class="lead">The revolutionary management app,
              created to help anyone faced with making decisions. Take advantage of our statistics capabilities,
              storage space, customer service, client management and more.</p>
            </div>
            <div class="col-sm-2"></div>
          </div>
          <hr>
          <div class="row"><div class="col-sm-12"><h2>Register For:</h2></div></div>
          <div class="row">
            <div class="col-sm-6">
              <div class="w3-card-2 w3-margin" style="min-height:350px;">
              <div class="w3-padding w3-blue"><h2>CM3 Creator</h2></div>
              <ul class="w3-ul" style="min-height:350px;">
                <li class="w3-padding-16">Blogs</li>
                <li class="w3-padding-16">Music</li>
                <li class="w3-padding-16">Videos</li>
                <li class="w3-padding-16"><b>Group Collaboration</b></li>
                <li class="w3-padding-16"><b>The Stage Access</b></li>
                <li class="w3-padding-24"></li>
                <li class="w3-padding-16"></li>
              </ul>
              <div class="w3-padding"><button class="btn" onclick="document.getElementById('creatorForm').style.display='block'">Sign Up</button></div>
            </div>
          </div>
            <div class="col-sm-6">
              <div class="w3-card-2 w3-margin" style="min-height:350px;">
              <div class="w3-padding w3-green"><h2>CM3 Merchant</h2></div>
              <ul class="w3-ul" style="min-height:350px;">
                <li class="w3-padding-16">Advertise</li>
                <li class="w3-padding-16">Blogs</li>
                <li class="w3-padding-16"><b>Expenses & Revenue Management</b></li>
                <li class="w3-padding-16"><b>Inventory Management</b></li>
                <li class="w3-padding-16"><b>Manage & Sell Products</b></li>
                <li class="w3-padding-16">Website Integration</li>
                <li class="w3-padding-16"></li>
              </ul>
              <div class="w3-padding"><button class="btn" onclick="document.getElementById('companyForm').style.display='block'">Sign Up</button></div>
            </div>
          </div>
          </div>
          <div id="creatorForm" class="w3-modal" style="display:none;">
            <div class="w3-modal-content container w3-padding-64">
              <div class="row">
                <div class="col-sm-12 text-right">
                  <button class="btn w3-red" onclick="document.getElementById('creatorForm').style.display='none'">Close</button>
                </div>
              </div>
        </div>
        </div>
          <div id="companyForm" class="w3-modal" style="display:none;">
            <div class="w3-modal-content container w3-padding-64">
              <div class="row">
                <div class="col-sm-12 text-right">
                  <button class="btn w3-red" onclick="document.getElementById('companyForm').style.display='none'">Close</button>
                </div>
                <div class="col-sm-3"></div>
              <div class="col-sm-6">
                  <!-- display errors returned by createToken -->
                  <span class="payment-errors"></span>
                  <!-- stripe payment form -->
                  <form action="submit.php" method="POST" id="paymentFrm">
                      <p>
                          <label>Organzation Name</label>
                          <input type="text" name="name" size="50" class="form-control"/>
                      </p>
                      <p>
                          <label>Email</label>
                          <input type="text" name="email" size="50" class="form-control"/>
                      </p>
                      <p><label>Company Login Name</label>
                        <input type="text" name="uid" placeholder="username" class="form-control">
                      </p>
                      <p>
                        <label>Company Login Code</label>
                      <input type="password" name="pwd" placeholder="password" class="form-control">
                    </p><hr>
                    <div class="alert alert-success">You're Almost Done</div>
                    <h3>Payment Details</h3>
                      <p>
                          <label>Card Number</label>
                          <input type="text" name="card_num" size="20" autocomplete="off" class="card-number" class="form-control"/>
                      </p>
                      <p>
                          <label>CVC</label>
                          <input type="number" name="cvc" size="4" autocomplete="off" class="card-cvc" class="form-control"/>
                      </p>
                      <p>
                          <label>Expiration (MM/YYYY)</label>
                          <input type="number" name="exp_month" size="2" max="12" min="01" class="card-expiry-month"/>
                          <span> / </span>
                          <input type="number" name="exp_year" size="4" max="2050" min="2018" class="card-expiry-year"/>
                      </p>
                      <button type="submit" id="payBtn" class="btn btn-primary">Submit Payment</button>
                  </form>
            </div>
            <div class="col-sm-3"></div>
            </div>
        </div>
        </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      </body>
      <style>
      body{
        background-image:url('images/bg_cca.svg');width:100%;
        background-attachment: fixed;
        background-position: top;
        background-repeat: no-repeat;
        background-size: cover;
      }
      </style>
    </html>
