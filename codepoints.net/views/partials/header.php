<?php
/**
 * @var string $lang
 * @var string $title
 * @var string $view
 */
?>
<!DOCTYPE html>
<html lang="<?=q($lang)?>" class="<?php
if (isset($_COOKIE['force_mode'])) {
    if ($_COOKIE['force_mode'] === 'dark') {
        echo 'force-dark';
    } elseif ($_COOKIE['force_mode'] === 'light') {
        echo 'force-light';
    }
}
?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
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
<!-- TODO
    <link rel="preload" href="/static/fonts/Literata.woff2" as="font" crossOrigin="anonymous">
    <link rel="preload" href="/static/fonts/Literata-Italic.woff2" as="font" crossOrigin="anonymous">
-->
    <link rel="stylesheet" href="/static/<?=DEBUG? 'src/css/' : ''?>main.css">
    <?php include 'head-multilang.php' ?>
<?php switch($view):
case ('codepoint'):
    include 'head-codepoint.php';
    break;
endswitch ?>
  </head>
  <body>
    <header class="page-header">
<?php include 'main-navigation.php' ?>
    </header>
    <div data-barba="wrapper">
      <div data-barba="container">
