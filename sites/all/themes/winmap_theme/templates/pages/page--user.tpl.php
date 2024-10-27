<?php
global $user;
$account = user_load($user->uid);
?>

<div class="wrapper">
  <?php include('header.inc'); ?>
    <div id="main-container">
      <?php print render($page['content']); ?>
    </div>
  <?php include('footer.inc'); ?>
</div>
