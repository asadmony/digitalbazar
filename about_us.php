<?php
	ob_start();
	$title="ABOUT US";
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/library/Database.php');
	include_once ($filepath.'/library/Session.php');
	
	Session::init();

	
	$login = Session::get("userlog");
	//Sign OUT
	if (isset($_GET['action']) && $_GET['action'] == "logout"){
		Session::destroy();
	}
	
?>

<?php include 'includes/header.php';?>
  <!-- Page Content -->
    
     <div class="container" style="margin: 50px;">
     	<div class="row">
        	<div class="col-lg-6 thumbnail">
           			<div class="col-lg-12">
                    	<font size="+8" color="#00C548" class="pull-left"><i class="fa fa-whatsapp" aria-hidden="true"></i></font> 
                        <p class="call_support">&nbsp;&nbsp;Call Support<br>
                        &nbsp;&nbsp;+88-01516-138655</p>
                    </div>
                    <div class="col-lg-12 thumbnail empad">
                    	<h4>Head Office</h4>
                        <hr>
                        <p>Huse (6/A)<br>
                        	S.P Banglo Lane<br>
                            Malotinagar, Bogra -5800<br>
                            Bangladesh<br>
                            <br>
                            <br>E-mail: support@digitalbazar.info
                        
                        </p>
                    </div>
                 
                    	<div class="col-lg-6 thumbnail empad">
                        	<h4>Branch Office</h4>
                        <hr>
                        <p>Shakpala<br>
                        	Shahajahanpur<br>
                            Bogra -5800<br>
                            Bangladesh<br>
                            <br>
                            <br>E-mail: support@digitalbazar.info
                        
                        </p>
                        </div>
                        <div class="col-lg-6 thumbnail empad">
                        	<h4>Branch Office</h4>
                        <hr>
                        <p>Shakpala<br>
                        	Shahajahanpur<br>
                            Bogra -5800<br>
                            Bangladesh<br>
                            <br>
                            <br>E-mail: support@digitalbazar.info
                        
                        </p>
                        
                        </div>
                    
            </div>
            <div class="col-lg-6 thumbnail">
            	<h4>Any Question ? Send Message to US !</h4>
                <hr>
                <form>
             		   <span>Your Name *</span><br>
                	<input type="text" name="yname">
                    <br>
                    <span>Mobile Number *</span><br>
                    <input type="text" name="mobnum">
                    <br>
                    <span>E-mail Address</span><br>
                    <input type="email" name="email">
                    <br>
                    <span>Subject</span><br>
                    <input type="text" name="subject"><br>
                    <span>Your Questions</span><br>
                    <textarea cols="50" rows="20"></textarea>
                    <br>
                    <input type="submit" value="Submit" class="submit">
                </form>
            </div>
        </div>
     </div>   
  
 <?php include 'includes/footer.php' ; ?>