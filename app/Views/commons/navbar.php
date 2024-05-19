<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <?php if(is_admin()): ?>
          <a href="<?= site_url('/admin') ?>" class="nav-link">Home</a>
        <?php else: ?>
          <a href="<?= site_url('/') ?>" class="nav-link">Home</a>
        <?php endif; ?>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      

      <!-- Messages Dropdown Menu -->
      <?php if(is_client() || is_installer()): ?>
      <!-- Notifications Dropdown Menu -->       
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <?php if(count(notifications()) > 0): ?>
              <span class="badge badge-warning navbar-badge"><?= count(notifications()) ?></span>
            <?php endif ?>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            
            <span class="dropdown-item dropdown-header"><?= count(notifications()) ?> Notifications</span>

            <?php if(count(notifications())): ?>
              <?php foreach(notifications() as $n): ?>
                <div class="dropdown-divider"></div>
                <a href="<?= site_url('notif/info/' . $n->id) ?>" class="dropdown-item">
                  <?= $n->context ?>
                  <span class="float-right text-muted text-sm"><?= $n->date_created ?></span>
                </a> 
              <?php endforeach ?>
            <?php endif; ?>          
        </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->