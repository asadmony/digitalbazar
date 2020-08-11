<?php
	ob_start();
	$title="List of Your Products and Services";
	include_once '../classes/comment.php';
	include_once '../helpers/Format.php';
	include_once '../library/Database.php';
	include_once '../library/Session.php';
	Session::checkUserSession();
	Session::init();
	$userID = Session::get("usrid");
	$cmnt = new comment();
	if (isset($_GET['delcmnt'])) {
		$id = $_GET['delcmnt'];
		$delcomment = $cmnt->delcommentByID($id);
	}
	$Comments = $cmnt->getCommentsByuserID($userID);
?>
<?php include'includes/dheader.php' ;?>

    <div class="container-fluid"  style=" margin-top: 50px;">
      <div class="row">
        
        <?php include 'includes/dsidemenu.php';?>
		
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard">dashboard</a> >  </span>

          <br>
          <hr>
          <h4 class="add_product"> Comments on Products or Services</h4>
          <br>
		 <?php
		if (isset($delcomment)) {
			echo $delcomment;
		}
	?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th> Serial no. </th>
				<th> Commented on  </th>
				<th> Commenter's Name </th>
				<th> Commenter's Email </th>
				<th> Commenter's Phone No. </th>
				<th> Comment </th>
				<th> Options <br />  </th>
				
			</tr>
		</thead>
		<tbody>
			<?php
				if ($Comments){
					$i = 1;
					while ($result = $Comments->fetch_assoc()){
			?>
			<tr>
				<td><?php echo $i ; ?></td>
				<td><a href="<?php echo web_root; ?>product-<?php echo $result['conID']; ?>" target="_blank"><?php echo $result['conName']; ?></a></td>
				<td><?php echo $result['name']; ?></td>
				<td><?php echo $result['email']; ?></td>
				<td><?php echo $result['phone']; ?></td>
				<td><?php echo $result['message'];  ?></td>
				<td> <a href="<?php echo web_root; ?>product-<?php echo $result['conID']; ?>" target="_blank">Reply</a> || <a onclick="return confirm('Are you sure to delete?')" href="?delcmnt=<?php echo $result['commentID']; ?>">Delete</a></td> 
			</tr>
			<?php $i++; }} ?>
		</tbody>
	</table>
        </div>
      </div>
    </div>
    <footer class="modal-footer footer">
    <div class="container">
    	 <div class="row">
             <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="float:left;">
                                <a href="#">Our Team&nbsp;</a>|
                                <a href="#">Advertise&nbsp;</a>|
                                <a href="#">Blog&nbsp;</a>|
                                <a href="contact.html">Contact&nbsp;</a>|

                        </div>
                    <div class="col-lg-6  col-md-6 col-sm-12 col-xs-12 copyright">
                       <a  href="#" class="pull-right" alt="Napster" title="Napster">&copy;Digital Bazar 2016 | All rights reserved</a>
                </div>
            </div>
          </div>
    </footer>
  </body>
</html>
