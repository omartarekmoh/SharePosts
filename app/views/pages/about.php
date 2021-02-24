<?php require APPROOT . '/views/inc/header.php';?>
<div class="text-center">
    <div class="container">
      <h1 class="display-3"><?=$data['title'];?></h1>
      <p class="lead"><?=$data['description'];?></p>
      <p class="lead">Version <strong><?=APPVERSION;?></strong></p>
      <p class="lead">Created by Omar Tarek (:)</strong></p>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php';?>