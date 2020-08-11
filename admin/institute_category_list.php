<?php
	ob_start();
	include_once '../library/Session.php';
	Session::CheckAdminSession();
	Session::init();
	include_once '../classes/category.php';
	$cat = new category();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ncat'])) {
		$instCatName = $_POST['catName'];
		$insertCat = $cat->instCatIns($instCatName);
	}
	//for deleting catagory
	if (isset($_GET['delcat'])) {
		$id = $_GET['delcat'];
		$delcat = $cat->delinstcatById($id);
	}
?>
<?php
	$title="CATEGORIES - digitalbazar.info";
	include 'header.php';
?>
<div class="container-fluid" style="margin-top: 0px; padding-top: 0px;">
      <div class="row">
        <?php include 'menu.php';?>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 dash_content">
        <a href="dashboard.php">dashboard</a> > 
		<br>
          <hr>
		<div class="catagory">
            <?php
	if (isset($insertCat)){
		echo $insertCat;
	}
?>

<div>
	<h2>Category List</h2>
		<div class="container">
    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#newcat">Add New Category</button>

 
    <div class="modal fade" id="newcat" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter New Category</h4>
        </div>
        <div class="modal-body">
			<form action="" method="post">
				<input type="text" name="catName" placeholder="enter category name" class="medium" />
				<br />
				<input type="submit" name="ncat" value="save" />
			</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div> <br />
	<table width="70%">
		<thead>
			<tr>
				<th>Serial No.</th>
				<th>Category Name</th>
				<th>Sub-Category </th>
				<th>Action</th>
			</tr>
		</thead>
		<?php
			if(isset($delcat)){
				echo $delcat;
			}
			//for edit category

			$getcat = $cat->getAllinstCat();
			if ($getcat){
				$i = 0;
				while($result = $getcat->fetch_assoc()){
					$i++;
			?>
		<tbody>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $result['InstituteCategoryName']; ?></td>
				<td>
					<a href="instsubcategory.php?ID=<?php echo $result['InstituteCategoryID'];?>">View all</a>
				</td>
				<td> <a href="instcatedit.php?catID=<?php echo $result['InstituteCategoryID'];?>" >Edit</a> || <a onclick="return confirm('Are you sure to delete?')" href="?delcat=<?php echo $result['InstituteCategoryID'];?>">Delete</a> ||  </td>
			</tr>
		<?php }}else {
			echo "There are no category added!";
		}?>
		</tbody>
	</table>
</div>
	


          </div>
		
		
		
      </div>
    </div>
	</div>

<?php include 'footer.php';?>