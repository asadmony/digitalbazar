<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../../library/Database.php');
	include_once ($filepath.'/../../library/Session.php');
	Session::init();
	
	//Sign OUT
	if (isset($_GET['action']) && $_GET['action'] == "logout"){
		Session::destroy();
	}
	
?>
<?php
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Some time in the past
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
  header("Cache-Control: no-store, no-cache, must-revalidate"); 
  header("Cache-Control: post-check=0, pre-check=0", false); 
  header("Pragma: no-cache"); 
?>
<!DOCTYPE HTML>
<html lang="en-US">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
		<meta name="google-site-verification" content="gNcdlQy2wnRjMCt0UyVTvZdlCqUCQiLDlsbBVqtiEYo" />
    <meta name="author" content="">
    <meta Http-Equiv="Cache" content="no-cache">
<meta Http-Equiv="Pragma-Control" content="no-cache">
<meta Http-Equiv="Cache-directive" Content="no-cache">
<meta Http-Equiv="Pragma-directive" Content="no-cache">
<meta Http-Equiv="Cache-Control" Content="no-cache">
<meta Http-Equiv="Pragma" Content="no-cache">
<meta Http-Equiv="Expires" Content="0">
<meta Http-Equiv="Pragma-directive: no-cache">
<meta Http-Equiv="Cache-directive: no-cache">
	<link rel="icon" type="image/gif/png" href="images/Tlogo.png">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" type="text/css" href="css/admin_details.css">
	<link rel="stylesheet" type="text/css" href="css/details.css">
	<link rel="stylesheet" type="text/css" href="css/product.css">
	<link rel="stylesheet" type="text/css" href="css/register.css">
	<link rel="stylesheet" type="text/css" href="css/sing_in.css">
	<link rel="stylesheet" type="text/css" href="../css/contact.css">
	<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="stylesheet" type="text/css" href="../css/searchpage.css">
	<link rel="stylesheet" href="../css/crop.css" />
    <link rel="stylesheet" href="../css/jquery.Jcrop.min.css" type="text/css" />
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script src="../js/jquery.Jcrop.min.js"></script>
</head>
<body>


<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top topnav" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand logotext" href="../">Digital Bazar</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="padmar">
                    </li>
					<?php
						$id = Session::get("id");
						$userlogin = Session::get("usrlgn");
						if ($userlogin == true){
							
						
					?>
					<li>
						<a href="dashboard.php">DASHBOARD</a>
					</li>
					<li>
						<a href="?action=logout">SIGN OUT</a>
					</li>
					<?php }else {?>
                     <li class="padmar">
                        <a href="sign_in.php">SIGN IN</a>
                    </li>
                    <li>
						<a href="register.php">SIGN UP</a>
					</li>
					<?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
        <!-- /.container -->
    </nav>
