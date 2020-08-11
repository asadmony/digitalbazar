<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../library/Database.php');
	include_once ($filepath.'/../library/Session.php');
	Session::init();

	//Sign OUT
	if (isset($_GET['action']) && $_GET['action'] == "logout"){
		Session::destroy();
	}

?>
<?php
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: max-age=2592000");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<link rel="icon" type="image/gif/png" href="<?php echo web_root; ?>images/Tlogo.png">
    <title><?php echo $title ; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>user/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>user/css/product.css">
	<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>user/css/register.css">
	<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>user/css/sing_in.css">
	<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>css/contact.css">
	<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>css/searchpage.css">

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
                <a class="navbar-brand logotext" href="<?php echo web_root; ?>">Digital Bazar</a>
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
						<a href="<?php echo web_root; ?>user/dashboard">DASHBOARD</a>
					</li>
					<li>
						<a href="?action=logout">SIGN OUT</a>
					</li>
					<?php }else {?>
                     <li class="padmar">
                        <a href="<?php echo web_root; ?>login">SIGN IN</a>
                    </li>
                    <li>
						<a href="<?php echo web_root; ?>user/register">SIGN UP</a>
					</li>
					<?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
        <!-- /.container -->
    </nav>
