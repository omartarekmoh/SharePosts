<?php require APPROOT . '/views/inc/header.php';?>
  <div class="row">
    <div class="col-md-6 mx-auto">
      <div class="card card-body bg-light mt-5">
        <h2>Create An Account</h2>
        <p>Please fill out this form to register</p>
        <form action="<?=URLROOT;?>/users/register" method="post">

          <div class="form-group mb-2">
            <label for="name">Name: <sup>*</sup></label>
            <input type="text" name="name" class="form-control form-control-lg <?= (!empty($data['name_err']) ? 'is-invalid' : '')?>" value="<?=$data['name']?>">
            <span class="text-danger ms-1"><?=$data['name_err']?></span>
          </div>

          <div class="form-group mb-2">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?= (!empty($data['email_err']) ? 'is-invalid' : '')?>" value="<?=$data['email']?>">
            <span class="text-danger ms-1 "><?=$data['email_err']?></span>
          </div>

          <div class="form-group mb-2">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?= (!empty($data['password_err']) ? 'is-invalid' : '')?>" value="<?=$data['password']?>">
            <span class="text-danger ms-1"><?=$data['password_err']?></span>
          </div>

          <div class="form-group">
            <label for="confirm_password">Confirm Password: <sup>*</sup></label>
            <input type="password" name="confirm_password" class="form-control form-control-lg <?= (!empty($data['confirm_password_err']) ? 'is-invalid' : '')?>" value="<?=$data['confirm_password']?>">
            <span class="text-danger ms-1"><?=$data['confirm_password_err']?></span>
          </div>
          
          <div class="row mt-3">
            <div class="d-grid gap-2 col-6 me-5">
              <input type="submit" value="Register" class="btn btn-success btn-primary">
            </div>
            <div class="col d-grid ms-3">
              <a href="<?=URLROOT?>/users/login" class="btn btn-outline-secondary">Have an account? Login</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php';?>