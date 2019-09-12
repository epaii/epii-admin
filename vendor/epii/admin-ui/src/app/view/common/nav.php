<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-<?php echo $_ui_["app_theme"]; ?> navbar-light border-bottom navbar-fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav list-group wstabs" id="wstabs">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php echo $_ui_["navlist"]; ?>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-reload" href="#">
                <i class="fa fa-refresh"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fa fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>