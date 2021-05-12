<style>
.testest{
    background-color: #ffffff;
    border-radius: 10px;
    color: black !important;
}
</style>
<body class="theme-darkblue">
    <!-- Page Loader -->

    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
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

                    <li>
                        <!--
                        <a href="javascript:void(0);" class="js-search" data-toggle="modal" data-target="#studentsearch_modal">
                        SEARCH STUDENT
                        </a>
                        -->
                        
                        <a href="javascript:void(0);" class="js-search testest" onclick="searchstudent_modal(1)">
                        <i class="material-icons" style="vertical-align: middle;margin-right: 5px;">search</i> SEARCH STUDENT
                        </a>
                    </li>
                    <li><a href="<?php echo base_url(); ?>index.php/Admin/logout" class="js-search" data-close="true">LOGOUT</a></li>

                </ul>

            </div>

        </div>
    </nav>
    <!-- #Top Bar -->