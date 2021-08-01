<style>
.search_student_navbar{
    background-color: #ffffff;
    border-radius: 10px;
    color: black !important;
}
.notification-number{
    position:absolute;
    border-radius:50%;
    border:1px solid transparent;
    height:20px;
    width:20px;
    background:gold;
    top:4px;
    right:-2px;
    font-size:12px;
    font-weight:bold;
    justify-content:center;
    align-items:center;
    text-align:center;
    z-index:100;
    color:black;
    padding:auto;
}
.notification-icon{
    vertical-align: middle;
    margin-right: 5px;
    color:white;
    cursor: pointer;
}
.notification-icon:hover{
    color:black;
    
    /* background:black; */
}

.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
  
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 270px;
  max-width:270px;
  /* margin-top:10px; */
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  /* transform:translateY(-50%,0); */
  /* left:-50%; */
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 5px 12px 5px 12px;
  text-decoration: none;
  display: block;
  /* border:1px solid red; */
  border:1px solid #ccc;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}

.notification-info{
    position:relative;
}
.notification-time{
    position:absolute;
    bottom:0;
    right:2px;
    font-size:80%;
    font-weight:bold;
}
.notification-student-name{
    font-weight:bold;
    white-space: nowrap;
    overflow: hidden;
    padding-bottom:5px;
}
.notification-student-message{
    font-size:90%;
    white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
    white-space: -webkit-pre-wrap;          /* Chrome & Safari */ 
    white-space: -pre-wrap;                 /* Opera 4-6 */
    white-space: -o-pre-wrap;               /* Opera 7 */
    white-space: pre-wrap;                  /* CSS3 */
    word-wrap: break-word;                  /* Internet Explorer 5.5+ */
    word-break: break-all;
    white-space: normal;
    margin-left:10px;
    max-height:30px;
}
</style>
<body class="theme-darkblue">
    <!-- Page Loader -->

    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div id="baseurl_link" data-baseurl="<?php echo base_url()?>"></div>
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>

                <a class="navbar-brand" href="index.html">ADMIN - DOSE SYSTEM</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">

                <ul class="nav navbar-nav navbar-right">
                    <li style="position:relative;" class="dropdown">
                        <div class="notification-number">9</div>
                        <br><i class="material-icons js-search notification-icon">notifications</i>
                        <div class="dropdown-content" id="notification-div">
                            <!-- <a href="#" class="notification-info">
                                <div class="notification-student-name">Jhon Norman Fabregas</div><div class="notification-student-message">Hi ask lang po if ano po yung status ng enrollment ko?.</div><span class="notification-time">5 hrs ago</span>
                            </a> -->
                            <!-- <a href="#" class="notification-info">
                            <div class="notification-student-name">Jhon Norman Fabregas</div> has <b>6</b> unread messages<span class="notification-time">5 hrs ago</span>
                            </a>
                            <a href="#" class="notification-info">
                            <div class="notification-student-name">Jhon Norman Fabregas</div> has <b>6</b> unread messages<span class="notification-time">5 hrs ago</span>
                            </a> -->
                        </div>
                    </li>
                    <li>
                        <!--
                        <a href="javascript:void(0);" class="js-search" data-toggle="modal" data-target="#studentsearch_modal">
                        SEARCH STUDENT
                        </a>
                        -->
                        
                        <a href="javascript:void(0);" class="js-search search_student_navbar" onclick="searchstudent_modal(1)">
                        <i class="material-icons" style="vertical-align: middle;margin-right: 5px;">search</i> SEARCH STUDENT
                        </a>
                    </li>
                    <li><a href="<?php echo base_url(); ?>index.php/Admin/logout" class="js-search" data-close="true">LOGOUT</a></li>

                </ul>

            </div>

        </div>
    </nav>
    <!-- #Top Bar -->