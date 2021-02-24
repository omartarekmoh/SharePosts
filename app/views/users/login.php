<?php require APPROOT . '/views/inc/header.php';?>
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <?php flash('register_success')?>
        <h2>login</h2>
        <p>Please fill in your credentials to login</p>
        <form action="<?=URLROOT;?>/users/login" method="post">

          <div class="form-group mb-2">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?= (!empty($data['email_err']) ? 'is-invalid' : '')?>" value="<?=$data['email']?>">
            <span class="text-danger ms-1"><?=$data['email_err']?></span>
          </div>

          <div class="form-group">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err']) ? 'is-invalid' : '')?>" value="<?=$data['password']?>">
            <span class="text-danger ms-1"><?=$data['password_err']?></span>
          </div>
          
          <div class="row mt-3">
            <div class="d-grid gap-2 col-6 me-4">
              <input type="submit" value="Login" class="btn btn-success btn-primary">
            </div>
            <div class="col d-grid">
              <a href="<?=URLROOT?>/users/register" class="btn btn-outline-secondary">Don't Have an account? Register</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php';?>