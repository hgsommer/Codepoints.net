<?php
/**
 * @var ?array $nav
 */
?>
<cp-navigation>
  <a href="<?=q(url(''))?>" rel="start" aria-label="<?=q('go to the homepage')?>">
    <svg width="16" height="16"><use href="/static/images/icon.svg#icon"/></svg>
    <span class="title"><?=_q('Home')?></span>
  </a>
<?php
if (! isset($nav) || ! $nav) {
  $nav = [];
} ?>
<?= array_key_exists('prev', $nav) ? $nav['prev'] : '<a href="/search">
  <cp-icon icon="magnifying-glass" width="16" height="16"></cp-icon>
  <span class="title">'.__('Search').'</span></a>' ?>
<?= array_key_exists('up', $nav) ? $nav['up'] : '<a href="/planes">
  <svg width="16" height="16"><svg viewBox="194 97 1960 1960" width="100%" height="100%"><use href="'.static_url('images/unicode-logo-framed.svg#unicode').'" width="16" height="16"/></svg></svg>
  <span class="title">'.__('All Planes').'</span></a>' ?>
<?= array_key_exists('next', $nav) ? $nav['next'] : '<a href="/random">
  <cp-icon icon="shuffle" width="16" height="16"></cp-icon>
  <span class="title">'.__('Random').'</span></a>' ?>
</cp-navigation>
