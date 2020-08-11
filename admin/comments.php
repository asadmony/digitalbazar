<?php
	ob_start();
	include_once '../library/Session.php';
	Session::checkAdminSession();
	Session::init();
	$title="All comments";
	include_once '../classes/comment.php';
	include_once '../library/Database.php';

	$userID = Session::get("usrid");
	$cmnt = new comment();
	if (isset($_GET['delcmnt'])) {
		$id = $_GET['delcmnt'];
		$delcomment = $cmnt->delcommentByID($id);
	}
	$AllComments = $cmnt->getAllComments();
?>
<?php include'header.php' ;?>

    <div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
          <span class="top_location"><a href="dashboard.php">dashboard</a> >  </span>

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
				<th> Institute </th>
				<th> Commenter's Name </th>
				<th> Commenter's Email </th>
				<th> Commenter's Phone No. </th>
				<th> Comment </th>
				<th> Options <br />  </th>
				
			</tr>
		</thead>
		<tbody>
			<?php
				if ($AllComments){
					$i = 1;
					while ($result = $AllComments->fetch_assoc()){
			?>
			<tr>
				<td><?php echo $i ; ?></td>
				<td><a href="product.php?ID=<?php echo $result['conID']; ?>" target="_blank"><?php echo $result['conName']; ?></a></td>
				<td><a href="../institute.php?ID=<?php echo $result['InstituteID']; ?>"><?php echo $result['InstituteName']; ?></a></td>
				<td><?php echo $result['name']; ?></td>
				<td><?php echo $result['email']; ?></td>
				<td><?php echo $result['phone']; ?></td>
				<td><?php echo $result['message'];  ?></td>
				<td> <a href="../product.php?ID=<?php echo $result['conID']; ?>" target="_blank">View</a> || <a onclick="return confirm('Are you sure to delete?')" href="?delcmnt=<?php echo $result['commentID']; ?>">Delete</a></td> 
			</tr>
			<?php $i++; }} ?>
		</tbody>
	</table>
        </div>
      </div>
    </div>
<?php include 'footer.php';?>
