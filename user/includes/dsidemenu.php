    <nav class="col-lg-3 col-md-3 col-sm-3 hidden-xs navbar navbar-inverse w3-bar-block" role="navigation" style="height: auto;">
        <div class=" dash_menu ">
          <ul >
            <li><a href="dashboard">DASHBOARD</a></li>
            <li><a href="my_profile">>MY PROFILE</a></li>
            <li><a href="../underconstruction">>CONTACT</a></li>
            <li><a href="../underconstruction">>MESSAGE</a></li>
            <li><a href="institute_list">>MY INSTITUTES</a></li>
            <li><a href="../underconstruction">>BOOKMARK</a></li>
            <li><a href="references">>REFERENCES</a></li>
            <li><a href="../underconstruction">>BANK</a></li>
            <li><a href="comments">>COMMENTS</a></li>
          </ul>
        </div>
    </nav>
    <style>
body {
    font-family: "Lato", sans-serif;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 20px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

.sidenav .closebtn {
    top: 0;
    right: 60px;
    font-size: 20px;
    margin-left: 50px;
    color: red;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
    <nav class="hidden-lg hidden-md hidden-sm navbar navbar-inverse w3-bar-block" role="navigation" style="height: 52px; width: 10%;">
       
        <span style="font-size:30px; cursor:pointer; margin-top: 0px; " onclick="openNav()">&#9776;</span>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">X</a>
            <a href="dashboard">DASHBOARD</a>
            <a href="my_profile">>MY PROFILE</a>
            <a href="../under_construction">>CONTACT</a>
            <a href="../under_construction">>MESSAGE</a>
            <a href="institute_list">>MY INSTITUTES</a>
            <a href="../under_construction">>BOOKMARK</a>
            <a href="references">>REFERENCES</a>
            <a href="../under_construction">>BANK</a>
            <a href="comments">>COMMENTS</a>
        </div>
    </nav>
    <script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
</script>
   