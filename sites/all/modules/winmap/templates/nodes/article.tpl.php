<?php
global $language;
$node = $variables['node'];

?>


<div class="article-page">
  <div class="article-page-container">
      <div class="article-page-title">
        <h1><?php print($node->title); ?></h1>
      </div>
      <div class="article-page-content">
        <?php print(!empty($node->body['und'][0]['value'])?$node->body['und'][0]['value']:''); ?>
      </div>
  </div>
</div>
