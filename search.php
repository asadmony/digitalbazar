<?php 
    ob_start();
    $title="Search";
    include_once 'library/Database.php';
    include_once 'library/Session.php';
    include_once 'helpers/Format.php';
    include_once 'classes/category.php';
    include_once 'classes/institute.php';
    $cat  = new category();
    $db   = new Database();
    $fm   = new Format();
    $inst = new institute();
    Session::init();
    
    $login = Session::get("userlog");
    include 'includes/header.php';
    if (!isset($_GET['what']) || $_GET['what'] == NULL){
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['what']) && isset($_GET['category']) && isset($_GET['division']) ){
        $search   = mysqli_real_escape_string($this->db->link,$_GET['what']);
        $catID    = mysqli_real_escape_string($this->db->link,$_GET['category']);
        $Division = mysqli_real_escape_string($this->db->link,$_GET['division']);
        }
    }else{
        $search = $_GET['what'];
    }
    if(isset($search) ) {
        $q="SELECT DISTINCT p.* 
                    FROM tb_content as p, tb_institute as i
                    WHERE p.InstituteID = i.InstituteID AND p.conName LIKE '%$search%' OR p.body LIKE '%$search%'";
        $allpost = $db->select($q);
    }
    $Insti=$inst->getRandInst();
?>
    <div class="container" style="margin:80px;">
        <div class="row">
            <div class="col-lg-2">
            <form action="" method="get">
            <!--
            <h3>Filtre Result</h3>
            <hr />
            <h4 > Select category</h4>
            <select class="form-control" name="category" id="sel2">
            <option></option>
                <?php /*
                    $getcat = $cat->getAllcontCat();
                if ($getcat){
                while($result = $getcat->fetch_assoc()){
            ?>  
                
            <option value="<?php echo $result['contentCategoryID'];?>" <?php if ($catID == $result['contentCategoryID']){ echo "selected";}?>><?php echo $result['contentCategoryName'];?></option>
            <?php }} */?>
        </select>
            
            <hr />
            <h4>Location</h4>
            <hr>
            <input type="radio" >All<br>
            <input type="radio" name="division" value="Dhaka">Dhaka<br>
            <input type="radio" name="division" value="Chittagong">Chittagong<br>
            <input type="radio" name="division" value="Khulna">Khulna<br>
            <input type="radio" name="division" value="Rajshahi">Rajshahi<br>
            <input type="radio" name="division" value="Rangpur">Rangpur<br>
            <input type="radio" name="division" value="Sylhet">Sylhet<br>
            <hr>
        -->
            </div>
            <div class="col-lg-8">
                <?php
                    if (isset($search)){
                        $placeholder = "value=\"".$search."\"";
                    }else{
                        $placeholder ="placeholder=\"Search keyword\"";
                    }
                ?>
                <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padmar">
                    <input type="text" name="what" class="input-lg searchbox2"  <?php echo $placeholder; ?>  }/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 padmar">
                    <button class="searchbtn padmar searchbox2_btn pull-right" type="submit" ><font size="+1">SEARCH</font>
                    </button>
               <br>

               </div>
          </div>
                </form>
                <br>
                <?php
                    $per_page = 12;
                    if(isset($_GET["page"])){
                            $page = $_GET["page"];
                        }else{
                            $page = 1;
                        }
                    if (isset($allpost) && !empty($allpost)){
                        $total_rows= mysqli_num_rows($allpost);
                        $total_pages= ceil($total_rows/$per_page);
                        $start_form = ($page-1)*$per_page;
                        
                        if(!empty($search) && !empty($catID) && !empty($Division) ) {
        $query="SELECT p.*,i.Division 
                    FROM tb_content as p, tb_institute as i
                    WHERE p.InstituteID = i.InstituteID AND p.catID = '$catID' AND i.Division = '$Division' AND p.conName LIKE '%$search%' OR p.body LIKE '%$search%'
                    ORDER BY p.conID DESC LIMIT $start_form,$per_page";
        $post = $db->select($query);
    }
    elseif(!empty($search) && empty($catID) && !empty($Division) ) {
        $query="SELECT p.*,i.Division 
                    FROM tb_content as p, tb_institute as i
                    WHERE p.InstituteID = i.InstituteID AND p.conName LIKE '%$search%' OR p.body LIKE '%$search%' AND i.Division = '$Division'
                    ORDER BY p.conID DESC LIMIT $start_form,$per_page";
        $post = $db->select($query);
    }
    elseif(!empty($search) && !empty($catID) && empty($Division) ) {
        $query="SELECT p.*,i.Division 
                    FROM tb_content as p, tb_institute as i
                    WHERE p.InstituteID = i.InstituteID AND p.conName LIKE '%$search%' OR p.body LIKE '%$search%' AND p.catID = '$catID'
                    ORDER BY p.conID DESC LIMIT $start_form,$per_page";
        $post = $db->select($query);
    }
    elseif(!empty($search) && empty($catID) && empty($Division) ) {
        $query="SELECT DISTINCT p.* 
                    FROM tb_content as p, tb_institute as i
                    WHERE p.InstituteID = i.InstituteID AND p.conName LIKE '%$search%' OR p.body LIKE '%$search%'
                    ORDER BY p.conID DESC LIMIT $start_form,$per_page";
        $post = $db->select($query);
    }
                        
                        $done = 0;
                        if(!empty($post)){
                            while($result = $post->fetch_assoc()){
                                $details = $fm->textShorten($result['body'], 50);
                    ?>
                                    <a href="<?php echo web_root; ?>product-<?php echo $result['conID']; ?>">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 thumbnail" style="height: auto;">
                                    
                                    <div class="col-lg-4 padmar">
                                   <img src="<?php echo web_root; ?>user/<?php echo $result['image']; ?>" alt="<?php echo $result['conName']; ?>" width="200" height="100" class="img-responsive img-thumbnail" style="float:left;"></div>
                                    <div style="float:right;" class="col-lg-8 padmar"><h4><b><?php echo $result['conName']; ?></b></h4>
                                     <p class="padmar"><?php echo $details ; ?></p>
                                     <br>
                                     <h4 class="padmar">Price: <?php echo $result['price']; ?>/-</h4>
                                     
                                     </div>
                                     </div>
                                     </a>
                    <?php }}}else{ echo "No results found!";} 
                    if($total_rows >= 13){
                    ?>
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?what=<?php echo $search;?>&page=1" > First Page</a></div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-3"><a href="?what=<?php echo $search;?>&page=<?php  if($page-1>0){ echo $page-1; }else{ echo $page; } ?>" > &lt; &lt; Prev Page</a></div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 pagenumber hidden-xs">
                        <ul>    <?php
                if ($page > 2){
                ?>
                <a href="?what=<?php echo $search;?>&page=<?php echo $page-2; ?>"><li><?php echo $page-2; ?></li></a>
                <?php }
                if ($page > 1){
                ?>
                <a href="?what=<?php echo $search;?>&page=<?php echo $page-1; ?>"><li><?php echo $page-1; ?></li></a>
                <?php } ?>
                            <a href="?what=<?php echo $search;?>&page=<?php echo $page; ?>" style="color: #ff9933;"><li ><?php echo $page; ?></li></a>
                            <?php
                            if ($page+1 <= $total_pages){
                            ?>
                            <a href="?what=<?php echo $search;?>&page=<?php echo $page+1; ?>"><li><?php echo $page+1; ?></li></a>
                            <?php }
                            if ($page+2 <= $total_pages){
                            ?>
                            <a href="?what=<?php echo $search;?>&page=<?php echo $page+2; ?>"><li><?php echo $page+2; ?></li></a>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3"><a href="?what=<?php echo $search;?>&page=<?php echo $page+1; ?>"> Next Page &gt;&gt;</a></div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 pull-right" style="text-align:right"><a href="?what=<?php echo $search;?>&page=<?php echo $total_pages ?>"> Last Page</a></div>
                    
                 </div>
                    <?php }?>
                </div>
            <div class="col-lg-2">
            <h4>Related Institutes</h4>
            <hr>
            <?php
                if ($Insti){
                    $i = 0;
                    while ($Institutes = $Insti->fetch_assoc()){
                        $i++;
                        $ln = $fm->cslug($Institutes['InstituteName']);
                    	$link = $ln.'-'.$Institutes['InstituteID'];
                ?>
            <a href="<?php echo web_root; ?>institute/<?php echo $link; ?>">
            
            <div class="thumbnail">
                <img src="<?php echo web_root; ?>user/<?php echo $Institutes['CoverPic']; ?>" class="img-responsive" alt="<?php echo $Institutes['InstituteName']; ?>" />
                <center><h4><a href="<?php echo web_root; ?>institute/<?php echo $link ?>"><?php echo $Institutes['InstituteName']; ?></a></h4></center>
            </div>
            </a>
         
           <?php }} ?>
           <hr>
           <div class="col-xs-12 clo-sm-12 col-md-12 col-lg-12 advertisement">
                <h4>Advertisement</h4>
                <hr>
                <hr>
            </div>
            </div>
            
        </div>
    </div>

<?php include 'includes/footer.php';?>