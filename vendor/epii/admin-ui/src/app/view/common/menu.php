<aside class="main-sidebar sidebar-<?php echo $_ui_["app_left_theme"]; ?>-<?php echo $_ui_["app_left_selected_theme"]; ?> elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $_ui_["site_url"]; ?>" class="brand-link bg-<?php echo $_ui_["app_left_top_theme"]; ?>">
        <img src="<?php echo $_ui_["site_logo_show"]; ?>"
             alt="<?php echo $_ui_["site_name_show"]; ?>"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $_ui_["site_name_show"]; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo $_ui_["user_avatar"]; ?>" class="img-circle elevation-2"
                     alt="<?php echo $_ui_["user_name"]; ?>">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $_ui_["user_name"]; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <?php echo $_ui_["menulist"]; ?>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
