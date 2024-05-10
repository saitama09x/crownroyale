<?= $this->extend('layouts/user-layout') ?>



<?= $this->section('content') ?>

<div class="login-box">
<div class="login-logo">
  <a href="../../index2.html">Admin</a>
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
      <p class="login-box-msg">Sign in to start your session</p>
        <div class="input-group mb-3">
          <input type="text" name="uname" class="form-control" placeholder="Email">
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
<?= form_close() ?>

<?= $this->endSection() ?>