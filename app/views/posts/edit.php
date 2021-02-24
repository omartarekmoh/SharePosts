<?php require APPROOT . '/views/inc/header.php';?>
  <a href="<?=URLROOT . '/posts'?>" class="btn btn-outline-secondary">
  <i class="fa fa-backward">&nbsp; &nbsp;Back</i>
  </a>
  <div class="card card-body bg-light mt-5">
    <h2>Edit post</h2>
    <form action="<?=URLROOT;?>/posts/edit/<?=$data['id']?>" method="post">

      <div class="form-group mb-2">
        <label for="title">Title: <sup>*</sup></label>
        <input type="text" name="title" class="form-control form-control-lg <?= (!empty($data['title_err']) ? 'is-invalid' : '')?>" value="<?=$data['title']?>">
        <span class="text-danger ms-1"><?=$data['title_err']?></span>
      </div>

      <div class="form-group">
        <label for="body">Body: <sup>*</sup></label>
        <textarea name="body" class="form-control form-control-lg <?= (!empty($data['body_err']) ? 'is-invalid' : '')?>" ><?=$data['body']?></textarea> 
        <span class="text-danger ms-1"><?=$data['body_err']?></span>
      </div>

      <div class="row mt-3">
            <div class="d-grid col-13 me-4">
              <input type="submit" value="Post" class="btn btn-success btn-primary">
            </div>
      </div>
      
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php';?>