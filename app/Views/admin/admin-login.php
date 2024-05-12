<?= $this->extend('layouts/user-layout') ?>



<?= $this->section('content') ?>

<div class="login-box">
  <div class="login-logo">
    <img src="/images/CRLOGO.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width:150px;">
  </div>

<?php if(session()->has('error-login')): ?>
  <div class="alert alert-danger alert-dismissible" role="alert">
    <?= session()->get('error-login') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
  </div>
<?php endif; ?>

<?= form_open('/admin/do-login') ?>
 <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login Your Admin</p>
        <div class="input-group mb-3">
          <input type="text" name="uname" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="pword" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">      
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
     </div>
 </div>
 <div class='mt-3'>For Guest Account, <a href="<?= site_url('/login') ?>">login here</a></div>
<?= form_close() ?>

<?= $this->endSection() ?>