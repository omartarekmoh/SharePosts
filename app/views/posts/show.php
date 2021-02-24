<?php require APPROOT . '/views/inc/header.php';?>
  <?php flash('post_message')?>
  <?php flash('comment_message')?>
  <?php flash('delete_message')?>
  <a href="<?=URLROOT . '/posts'?>" class="btn btn-outline-secondary">
  <i class="fa fa-backward">&nbsp; &nbsp;Back</i>
  </a>
  <br>

  <h1 class="display-3"><?=$data['post']->title?></h1>
  <div class="bg-secondary text-white p2 mb-3">
  <p class="lead">
    Written by <?=$data['user']->name;?> on <?=date('Y-m-d h:i:s A', strtotime($data['post']->created_at))?><p>
  </div>
  <p class='lead' style="font-size: 21px;"><?= $data['post']->body?></p>

  <?php if($data['post']->user_id == $_SESSION['user_id'] || $_SESSION['user_id'] == 1) : ?>
    <hr>
    <a href="<?= URLROOT ?>/posts/edit/<?=$data['post']->id?>" class="btn btn-outline-secondary">Edit</a>

    <form class="pull-right" action="<?=URLROOT?>/posts/delete/<?=$data['post']->id?>" method="post">
      <input type="submit" value="Delete" class="btn btn-danger">
    </form>
  <?php endif; ?>

  <form action="<?=URLROOT?>/posts/show/<?=$data['post_id']?>" method="POST">
    <h1 class="display-5 mt-3">Add comment</h1>
    

    <div class="form-group mb-2 mt-3">
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
              <input type="submit" value="Add" class="btn btn-success btn-primary">
            </div>
      </div>

  </form>

  <?php foreach($data['comments'] as $post) : ?>
    <div class="card card-body mb-3 mt-3">
      <h4 class="card-title display-5"><?=$post->title?></h4>
      <div class="bg-light p-2 mb-3">
        Written by <?= $post->name;?> on <?= date('Y-m-d h:i:s A', strtotime($post->postCreated));?>
      </div>
      <p class="card-text lead" style="font-size: 24px;"><?=$post->body;?></p>
    </div>
    <?php if($post->user_id == $_SESSION['user_id'] || $_SESSION['user_id'] == 1) : ?>
    <div class="mb-3">
      <hr>
      <a href="<?= URLROOT ?>/comments/edit/<?=$data['post']->id?>/<?=$post->id?>" class="btn btn-outline-secondary">Edit</a>

      <form class="pull-right" action="<?=URLROOT?>/comments/delete/<?=$data['post']->id?>/<?=$post->id?>" method="post">
        <input type="submit" value="Delete" class="btn btn-danger">
      </form>
    </div>
    <?php endif; ?>
  <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php';?>