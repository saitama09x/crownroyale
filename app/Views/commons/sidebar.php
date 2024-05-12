<!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= user_info() ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           <?php if(is_admin() || is_manager() || is_client() ): ?>
            <li class="nav-item">
              <a href="<?= site_url('/') ?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
          <?php endif; ?>
          <?php if(is_admin()): ?>
          <li class="nav-item">
            <a href="<?= site_url('/clients') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Clients
              </p>
            </a>
          </li>
          <?php endif; ?>
          <?php if(is_admin() || is_manager()): ?>
          <li class="nav-item">
            <a href="<?= site_url('/projects') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Projects
              </p>
            </a>
          </li>
          <?php endif; ?>
          <?php if(is_installer() || is_admin() || is_manager()): ?>
          <li class="nav-item">
            <a href="<?= site_url('/tasks') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Tasks
              </p>
            </a>
          </li>
          <?php endif; ?>
          <?php if(is_admin()): ?>
          <li class="nav-item">
            <a href="<?= site_url('/users') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <?php endif; ?>
          <?php if(is_admin() || is_client() ): ?>
           <li class="nav-item">
            <a href="<?= site_url('/payments') ?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Payments
              </p>
            </a>
          </li>
          <?php endif; ?>
          <li class="nav-item">
            <a href="<?= site_url('/logout') ?>" class="nav-link">              
              <p>
                Logout
              </p>
            </a>
          </li>
          <!-- <li class="nav-header">MISCELLANEOUS</li> -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->