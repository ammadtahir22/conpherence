<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Conpherence</title>

<!-- Bootstrap -->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0-RC1/css/bootstrap-datepicker3.standalone.min.css'>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/animate.css" rel="stylesheet">
<link href="css/layout.css" rel="stylesheet">
<link href="css/calender.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="css/owl.carousel.min.css" rel="stylesheet">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- Favicons
================================================== -->
<link rel="shortcut icon"type="image/png" href="favicon.png">
<link rel="apple-touch-startup-image" href="/launch.png">
<link rel="apple-touch-icon" href="touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72">
<link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-114x114.png">
</head>
<body>
<!--header-->
<nav class="navbar navbar-default navbar-fixed-top nav_inner header dashboard-header">
  <div class="container"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      <a class="navbar-brand" href="index.html"><img src="images/logo.png" alt="logo"></a></div>
      <a href="#" id="toggle"><span class="top"></span>
		  <span class="middle"></span>
		  <span class="bottom"></span>
		</a>
      <div id="overlay"></div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="menu">
      <ul class="nav navbar-nav" >
      	<li class="active"><a href="index.html" >Home</a></li>
        <li><a href="catagory.html">Categories</a></li>
      	<li class="dropdown nitif">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/bell.png" alt=""><span class="badge">1</span></a>
            <ul class="dropdown-menu scroll-bar">
              <li><div class="dropdown-title">Today</div></li>
              <li class="active">
              	<a href="#">
              		<div class="noti-img">
              			<img src="images/booking-img.png" alt="" />
              		</div>
              		<div class="noti-info">
              			<div class="noti-info-left">
              				<h3>Your Upcoming Booking</h3>
              				<h4>Space Name<span>Location</span></h4>
              			</div>
              			<div class="noti-info-right">
              				<span>4.5<i class="star">★★★★★</i></span>
              				<h4>AED 400</h4>
              				<div class="date">20 to 22 July</div>
              			</div>
              		</div>
              	</a>
              </li>
              <li>
              	<a href="#">
              		<div class="noti-img">
              			<img src="images/booking-img.png" alt="" />
              		</div>
              		<div class="noti-info">
              			<div class="noti-info-left">
              				<h3>Your Upcoming Booking</h3>
              				<h4>Space Name<span>Location</span></h4>
              			</div>
              			<div class="noti-info-right">
              				<span>4.5<i class="star">★★★★★</i></span>
              				<h4>AED 400</h4>
              				<div class="date">20 to 22 July</div>
              			</div>
              		</div>
              	</a>
              </li>
              <li><div class="dropdown-title">22 July 2018</div></li>
	           <li>
	              	<div class="noti-txt">
	              		<span>Conpherence Updated their Terms & Conditions</span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's ...
		      		</div>
	          	</li>
            </ul>
          </li>
        <li class="dropdown user-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="images/hotal-logo.png" alt=""/></a>
            <ul class="dropdown-menu">
              <li><a href="#"><div class="userimg"><img src="images/dash-iconh1.png" alt="" /></div>My account</a></li>
              <li class="active"><a href="#"><div class="userimg"><img src="images/user-menu.png" alt="" /></div>User Settings</a></li>
              <li><a href="#"><div class="userimg"><img src="images/user-menu1.png" alt="" /></div>Account Settings</a></li>
              <li><a href="#"><div class="userimg"><img src="images/user-menu2.png" alt="" /></div>Logout</a></li>
            </ul>
          </li>
      </ul>  
    </div>
    <ul class="navbar-nav book-nav" >
    	
    </ul>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav><!--header-->
<section class="dashboard">
      	<div class="tabbable tabs-left">
      		<aside class="dashboard-sidebar">
				<ul class="nav nav-tabs ">
					<li ><a href="#dashboard" data-toggle="tab"><img src="images/dash-iconh.png" alt="" /><span>Dashboard</span></a></li>
					<li ><a href="#profile" data-toggle="tab"><img src="images/dash-iconh7.png" alt="" /><span>Edit Profile</span></a></li>
					<li "><a href="#venue"data-toggle="tab" ><img src="images/dash-iconh8.png" alt="" /><span>Venue</span></a></li>
					<li><a href="#payment" data-toggle="tab"><img src="images/dash-iconh2.png" alt="" /><span>Payment</span></a></li>
					<li class="active"><a href="#bookings" data-toggle="tab"><img src="images/dash-iconh3.png" alt="" /><span>Bookings</span></a></li>
					<li><a href="#reviews" data-toggle="tab"><img src="images/dash-iconh4.png" alt="" /><span>Reviews</span></a></li>
					<li><a href="#savings" data-toggle="tab"><img src="images/dash-iconh6.png" alt="" /><span>Savings</span></a></li>
				</ul>
			 	<!-- <button class="sidebar-toggle"><span></span></button> -->
			</aside>
    		<div class="tab-content dashboard-wrap">
	         <div class="tab-pane" id="dashboard">
	         </div>
	         <div class="tab-pane" id="profile">
	         	
	         </div>
	         <div class="tab-pane" id="venue">  
	         </div>
	         <div class="tab-pane" id="payment">
	         	<div class="welcome-title full-col">
	         		<h2>Payment</h2>
	         	</div>
	         </div>
	         <div class="tab-pane active booking-flow-summry manual-booking" id="bookings">
	         	<div class="back-to full-col">
						    <a href="hotal-dashboard-booking.html"><img src="images/back.png" alt="">Back to listing page</a>
  					 </div>
	         		<div class="flow-summry">
                          <h3>Add New Booking</h3>
                          <div class="full-col">
                              <h4>Space Info</h4>
                              <div class="form-group group col-xs-4">
                                <select id="location" class="no-b-r b-l-radius">
                                  <option>Add Location</option>
                                </select>
                                <label for="location">Location</label>
                              </div>
                              <div class="form-group group col-xs-8">
                                <select id="spacce" class="b-r-radius">
                                  <option>Westbourne Suite</option>
                                </select>
                                <label for="spacce">Space Name</label>
                              </div>
                          </div>
                          <div class="full-col">
                              <h4>Booking Info</h4>
                              <div class="full-col">
                                <div class="form-group group col-xs-6">
                                  <input type="text"  name=""  placeholder="Name of individual" class="form-control b-l-radius" id="cutomer">
                                  <label for="cutomer">Customer Name</label>
                                </div>
                                <div class="form-group group col-xs-3">
                                  <input type="email"  name=""  placeholder="Enter Email" class="form-control no-b-r no-b-l" id="email">
                                  <label for="email">Email Id</label>
                                </div>
                                <div class="form-group group col-xs-3">
                                  <input type="text"  name="Contact Number"  placeholder="Enter Phone Number" class="form-control b-r-radius" id="cutomer">
                                  <label for="cutomer">Contact Number</label>
                                </div>
                             </div>
                             <div class="full-col">
                                <div class="form-group group col-xs-8">
                                  <input type="text"  name=""  placeholder="Business Startup Meeting" class="form-control b-l-radius" id="meeting">
                                  <label for="meeting">Purpose of Meeting</label>
                                </div>
                                <div class="form-group group col-xs-2 ">
                                  <input type="text" name="date" class="datepicker form-control no-b-r no-b-l" id="start" placeholder="Start Date">
                                  <label for="date">Start Date</label>
                                </div>
                                <div class="form-group group col-xs-2">
                                  <input type="text" name="" placeholder="End Date" class="form-control datepicker end-date b-r-radius" id="end">
                                  <label for="end-date">End Date</label>
                                </div>
                             </div>
                          </div>
                          <div class="manual-booking-left col-xs-6">
                              <h4>Booking Detail Day One</h4>
                                <div class="form-group group col-xs-6">
                                  <input type="text"  name=""  placeholder="Enter date" class="form-control b-l-radius datepicker" id="day-one">
                                  <label for="day-on">Date</label>
                                </div>
                                <div class="form-group group col-xs-3 ">
                                  <input type="text" name="date" class="form-control no-b-r no-b-l" id="start" placeholder="Start Date">
                                  <label for="date">Start Time</label>
                                </div>
                                <div class="form-group group col-xs-3">
                                  <input type="text" name="" placeholder="End Date" class="form-control  b-r-radius">
                                  <label for="end-date">End Time</label>
                                </div>
                          </div>
                          <div class="manual-booking-right col-xs-6">
                            <h4>Booking Detail Day two</h4>
                                <div class="form-group group col-xs-6">
                                  <input type="text"  name=""  placeholder="Enter date" class="form-control b-l-radius datepicker" id="day-two">
                                  <label for="day-two">Date</label>
                                </div>
                                <div class="form-group group col-xs-3 ">
                                  <input type="text" name="date" class="form-control no-b-r no-b-l" placeholder="Start Date">
                                  <label for="date">Start Time</label>
                                </div>
                                <div class="form-group group col-xs-3">
                                  <input type="text" name="" placeholder="End Date" class="form-control b-r-radius">
                                  <label for="end-date">End Time</label>
                                </div>
                          </div>
                          <div class="full-col b-sum-btn-wrap">
                          		<ul class="list-inline col-sm-6">
                                <li ><button type="button" class="btn ani-btn book-step">Save</button></li>
                                <li><button type="button" class="cancle-step">Cancel</button></li>
                                </ul>
                          </div>
                          </div><!-- flow-summry" -->
	         	</div>
	         <div class="tab-pane" id="reviews">
	         	<div class="welcome-title full-col">
	         		<h2>Reviews</h2>
	         	</div>
			  </div>
			  <div class="tab-pane" id="savings">
	         	<div class="welcome-title full-col">
	         		<h2>Savings</h2>
	         	</div>
			  </div>
	         </div>
        	</div>
      </div>
      <!-- /tabs -->
	<div class="clearfix"></div>
</section>
<footer class="footer">
	<div class="container">
		<div class="col-sm-4 col-xs-6 footer-info fade-left-ani">
			<a href="#"><img src="images/footer-logo.png" alt="logo"/></a>
			<ul>
				<li><div class="foot-img"><img src="images/footer-icon.png" alt="" /></div><div class="foot-info"><a href="#">0971 215 02548</a></div></li>
				<li><div class="foot-img"><img src="images/footer-icon1.png" alt="" /></div><div class="foot-info"><a href="mailto:info@conpherence.com">info@conpherence.com</a></div></li>
				<li>
					<div class="foot-img"><img src="images/footer-icon2.png" alt="" /></div><div class="foot-info">Payment options</div>
					<ol>
						<li><a href="#"><img src="images/Capa-1.png" alt=""/></a></li>
						<li><a href="#"><img src="images/Capa-2.png" alt=""/></a></li>
					</ol>
				</li>
			</ul>
		</div>
		<div class="col-sm-2 col-xs-6 footer-link fade-down-ani">
			<ul>
          		<li class="active"><a href="#">About Us</a></li>
          		<li><a href="#">Contact Us</a></li>
          		<li><a href="#">Careers</a></li>
          		<li><a href="#">How it Works</a></li>
          		<li><a href="#">Company account</a></li>
          		<li><a href="#">Strategic Meetings Management</a></li>
        	</ul> 
		</div>
		<div class="col-sm-2 col-xs-6 footer-link fade-down-ani">
			<ul>
          		<li class="active"><a href="#">Blog</a></li>
          		<li><a href="#">News</a></li>
          		<li><a href="#">Terms Of Use</a></li>
          		<li><a href="#">Privacy Policy</a></li>
          		<li><a href="#">Venue Technology</a></li>
          		<li><a href="#">White Paper</a></li>
        	</ul> 
		</div>
		<div class="col-sm-4 col-xs-6 footer-search fade-right-ani">
			<h4>Let’s Stay in Touch</h4>
			<form action="#" method="post">
				<div class="col-xs-7 f-mail no_padding">
					<input type="email" name="email" placeholder="Email Address" class="form-control">
				</div>
				<div class="col-xs-5 f-btn">
						<button type="submit" name="submit" class="get-btn">
							<span>Subscribe</span>
	                        <span></span>
	                        <span></span>
	                        <span></span>
	                        <span></span>
                        </button>
				</div>
			</form>
			<h4>Folloew Us</h4>
			<ul class="social">
          		<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
          		<li><a href="#"><i class="fab fa-twitter"></i></a></li>
          		<li><a href="#"><i class="flaticon-google-plus-symbol google"></i></a></li>
          		<li><a href="#"><i class="flaticon-linkedin-logo linkedin"></i></a></li>
          		<li><a href="#"><i class="flaticon-youtube youtube"></i></a></li>
        	</ul> 
		</div>
	</div><div class="clearfix"></div>
	<div class="footer-btm">
		<div class="container">
			<div class="footer-btm-left col-sm-6">
				<ul>
					<li>© 2018 conpherence.com</a></li>
					<li><a href="#">All Rights Reserved</a></li>
				</ul>
			</div>
			<div class="footer-btm-right col-sm-6">
				<p>Powered by <a href="mailto:bits-global.com"><img src="images/bits.png" alt="" /></a></p>
			</div>
		</div>
	</div>
</footer>
<!-- add card popup -->
<div class="modal fade card-popup" id="cardpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h3>Add New Payment Method</h3>
        <div class="form-group full-field">
			<input type="text" name="" placeholder="Card number" class="form-control">
		</div><!--form-group-->
		<legend>Expires on</legend>
		<div class="form-group half-l-field">
			<select class="selectpicker">
				<option>Month</option>
				<option>Jan</option>
				<option>Fab</option>
			</select>
		</div><!--form-group-->
		<div class="form-group half-r-field">
			<select class="selectpicker">
				<option>Year</option>
				<option>1992</option>
				<option>1993</option>
			</select>
		</div><!--form-group-->
		<div class="form-group half-l-field">
			<input type="text" name="" placeholder="Security Code" class="form-control">
		</div><!--form-group-->
		<div class="form-group half-r-field">
			<select class="selectpicker">
				<option>Currency</option>
				<option>10AED to 20AED</option>
			</select>
		</div><!--form-group-->
		<div class="form-group half-l-field">
			<input type="text" name="" placeholder="First Name" class="form-control">
		</div><!--form-group-->
		<div class="form-group half-r-field">
			<input type="text" name="" placeholder="Last Name" class="form-control">
		</div><!--form-group-->
		<div class="form-group full-field">
			<input type="email" name="" placeholder="Email" class="form-control">
		</div><!--form-group-->
		<div class="form-group full-field">
			<input type="text" name="" placeholder="Billing Address" class="form-control">
		</div><!--form-group-->
		<div class="form-group form-btn half-l-field">
	        <button type="button" class="btn ani-btn">Add Card</button>
	    </div>
	    <div class="form-group form-btn half-r-field">
	        <button type="button" class="btn ani-btn cancle-btn">Cancel</button>
	    </div>
      </div>
    </div>
  </div>
</div>
<!--Lolty Popup-->
<!--Edit popup-->
<div class="modal fade card-popup" id="editpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h3>Add New Payment Method</h3>
        <div class="form-group full-field">
			<input type="text" name="" placeholder="Card number" class="form-control">
		</div><!--form-group-->
		<legend>Expires on</legend>
		<div class="form-group half-l-field">
			<select class="selectpicker">
				<option>Month</option>
				<option>Jan</option>
				<option>Fab</option>
			</select>
		</div><!--form-group-->
		<div class="form-group half-r-field">
			<select class="selectpicker">
				<option>Year</option>
				<option>1992</option>
				<option>1993</option>
			</select>
		</div><!--form-group-->
		<div class="form-group half-l-field">
			<input type="text" name="" placeholder="Security Code" class="form-control">
		</div><!--form-group-->
		<div class="form-group half-r-field">
			<select class="selectpicker">
				<option>Currency</option>
				<option>10AED to 20AED</option>
			</select>
		</div><!--form-group-->
		<div class="form-group half-l-field">
			<input type="text" name="" placeholder="First Name" class="form-control">
		</div><!--form-group-->
		<div class="form-group half-r-field">
			<input type="text" name="" placeholder="Last Name" class="form-control">
		</div><!--form-group-->
		<div class="form-group full-field">
			<input type="email" name="" placeholder="Email" class="form-control">
		</div><!--form-group-->
		<div class="form-group full-field">
			<input type="text" name="" placeholder="Billing Address" class="form-control">
		</div><!--form-group-->
		<div class="form-group form-btn half-l-field">
	        <button type="button" class="btn ani-btn">Save</button>
	    </div>
	    <div class="form-group form-btn half-r-field">
	        <button type="button" class="btn ani-btn cancle-btn">Delete</button>
	    </div>
      </div>
    </div>
  </div>
</div>
<!--Edit popup-->
<div class="modal fade card-popup" id="delpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <!-- <h3>Delete Payment Method</h3> -->
        <p style="text-align: center;"> Are you sure you want delete it</p>
      </div>
    </div>
  </div>
</div>
<!-- add card popup -->
<div class="modal fade card-popup loyalty" id="loyaltypopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h3>Add New Payment Method</h3>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>	
		<ul>
			<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
			<li>Lorem Ipsum has been the industry's standard</li>
			<li>Lorem Ipsum has been the industry's standard</li>
			<li>Lorem Ipsum has been the industry's standard</li>
			<li>Lorem Ipsum has been the industry's standard</li>
			<li>Lorem Ipsum has been the industry's standard</li>
			<li>Lorem Ipsum has been the industry's standard</li>
		</ul>
      </div>
    </div>
  </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-viewport-checker/1.8.8/jquery.viewportchecker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js'></script> 
<script type="text/javascript" src="js/bootstrap.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0-RC1/js/bootstrap-datepicker.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-dateFormat/1.0/jquery.dateFormat.js'></script>
<script type="text/javascript" src="js/slider.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- <script type="text/javascript" src="js/calender.js"></script> -->
<script type="text/javascript">

  $('.datepicker').datepicker({
  format: 'mm/dd/yyyy',
  orientation: 'left bottom',
  autoclose: true,
  startDate: 'date',
  todayHighlight: true
});
</script>
</body>
</html>
