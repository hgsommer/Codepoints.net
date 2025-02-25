<?php
/**
 * @var \Codepoints\Unicode\Plane $plane
 * @var ?\Codepoints\Unicode\Plane $prev
 * @var ?\Codepoints\Unicode\Plane $next
 */

$nav = [];
if ($prev) {
  $nav['prev'] = pl($prev, 'prev');
}
$nav['up'] = sprintf('<a class="ln pl" rel="up" href="%s"><svg width="16" height="16"><svg viewBox="194 97 1960 1960" width="100%%" height="100%%"><use xlink:href="/static/images/unicode-logo-framed.svg#unicode" width="16" height="16"/></svg></svg> %s</a>', url('planes'), __('All Planes'));
if ($next) {
  $nav['next'] = pl($next, 'next');
}

$head_extra = (new \Codepoints\View('partials/head-plane'))(compact('plane', 'prev', 'next'));
include 'partials/header.php'; ?>
<main class="main main--plane">
  <div>
    <figure class="sqfig plfig">
      <?=plimg($plane, 250)?>
      <figcaption><?=_q('Source: Font Last Resort')?></figcaption>
    </figure>
  </div>
  <h1><?=q($title)?></h1>
  <p><?php printf(__('Plane from U+%04X to U+%04X.'), $plane->first, $plane->last)?></p>
  <p><a href="/planes" rel="up"><?=_q('all planes')?></a></p>
<?php if ($prev): ?>
  <p>Prev: <?=pl($prev, 'prev')?></p>
<?php endif ?>
<?php if ($next): ?>
  <p>Next: <?=pl($next, 'next')?></p>
<?php endif ?>
  <?php if (count($plane->blocks)):?>
    <h2><?=_q('Blocks in this plane')?></h2>
    <ol class="tiles">
      <?php foreach ($plane->blocks as $block):?>
        <li><?=bl($block, 'child')?></li>
      <?php endforeach?>
    </ol>
  <?php else:?>
    <p class="info"><?_q('There are no blocks defined in this plane.')?></p>
  <?php endif?>
</main>
<?php include 'partials/footer.php'; ?>
