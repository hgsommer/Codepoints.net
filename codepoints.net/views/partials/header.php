<?php
/**
 * @var string $lang
 * @var string $title
 * @var string $view
 */
?>
<!DOCTYPE html>
<html lang="<?=q($lang)?>" dir="ltr" class="<?php
if (isset($_COOKIE['force_mode'])) {
    if ($_COOKIE['force_mode'] === 'dark') {
        echo 'force-dark';
    } elseif ($_COOKIE['force_mode'] === 'light') {
        echo 'force-light';
    }
}
if (array_key_exists('embed', $_GET)) {
    echo ' embed';
}
?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?=q($title)?> – Codepoints</title>
<?php if(isset($page_description)): ?>
    <meta name="description" content="<?=q($page_description)?>">
<?php endif ?>
    <meta name="theme-color" content="#660000">
    <link rel="icon" href="/favicon.ico">
    <link rel="icon" href="/static/images/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="mask-icon" href="/static/images/safari-pinned-tab.svg" color="#990000">
    <link rel="search" href="/opensearch.xml" type="application/opensearchdescription+xml" title="Search Codepoints">
    <link rel="author" href="/humans.txt">
    <link rel="preload" href="<?= static_url('src/fonts/Literata.woff2') ?>" as="font" crossOrigin="anonymous">
    <link rel="preload" href="<?= static_url('src/fonts/Literata-Italic.woff2') ?>" as="font" crossOrigin="anonymous">
    <link rel="stylesheet" href="<?= static_url('src/css/main.css') ?>">
    <?php include 'head-multilang.php' ?>
<?php switch($view):
case 'block':
    include 'head-block.php';
    break;
case 'codepoint':
    include 'head-codepoint.php';
    break;
case 'search': ?>
    <?php /* prevent indexing of search pages. We do not want the crawlers
    accessing this page due to the extra resources these renderings cost. */ ?>
    <meta name="robots" content="noindex">
    <script>
    var script_age = <?=json_encode($env['info']->script_age)?>;
    var region_to_block = <?=json_encode($env['info']->region_to_block)?>;
    </script>
    <?php break;
case 'index': ?>
    <link rel="preload" href="<?= static_url('src/images/front_light.webp') ?>" as="image" fetchPriority="high" crossOrigin="anonymous">
    <?php break;
endswitch ?>
  </head>
  <body>
    <div data-barba="wrapper">
      <div data-barba="container">
        <?php include 'main-navigation.php' ?>
