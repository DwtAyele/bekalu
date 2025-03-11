<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?= base_url($image); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block"><?php echo session()->get('username'); ?></a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fa fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library menu-open active-->

            <?php foreach ($sidebar[1] as $ca_row) : ?>
                <li class="nav-item">
                    <a href="<?= $ca_row['link'] ?>"<?php if ($page_cat == $ca_row['category']) echo $isactiv;
                                                        else echo $notactiv; ?>>
                        <i class="nav-icon <?= $ca_row['icon'] ?>"></i>
                        <p><?= $ca_row['category'] ?><i class="right fa fa-angle-left"></i> </p>
                    </a> 

                    <ul class="nav nav-treeview">
                        <?php foreach ($sidebar[0] as $row) : ?>
                            <?php if ($row['category_id'] === $ca_row['page_category_id']) : ?>
                                <li class="nav-item">
                                    <a href="<?= base_url($row['page_link']); ?>" <?php if ($page == $row['page']) echo $isactiv;
                                                                                    else echo $notactiv; ?>>
                                        <i class='<?= $row['page_icon'] ?>'></i>
                                        <p><?= $row['page'] ?></p>
                                    </a>
                                </li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </li>
            <?php endforeach ?>

            <li class="nav-header">Others
            </li>

            <li class="nav-item">
                <a href=<?= base_url('signout') ?> class="nav-link">
                    <i class="fa fa-sign-out"></i>
                    <p>
                        Sign out
                    </p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>