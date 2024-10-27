<?php

  global $language;
  $term = $variables['term'];

  $articles = array();
  $article_query = new EntityFieldQuery();
  $article_query->entityCondition('entity_type', 'node')
    ->entityCondition('bundle', 'article')
    ->propertyCondition('status', 1)
    ->fieldCondition('field_tx_article', 'tid', $term->tid, '=')
    ->propertyOrderBy('created', 'DESC');

  $result = $article_query->execute();
  if (isset($result['node'])) {
    $article_nids = array_keys($result['node']);
    $articles = entity_load('node', $article_nids);
  }

?>
