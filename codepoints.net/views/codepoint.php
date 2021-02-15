<?php include 'partials/header.php'; ?>
<main class="main main--codepoint">
  <figure>
    <?=cpimg($codepoint, 250)?>
  </figure>
  <h1><?=q($codepoint)?> <?=q($codepoint->name)?></h1>
<?php if ($block): ?>
  Block: <?=bl($block)?><br>
<?php endif ?>
Plane: <?=pl($plane)?><br>
<?php if ($prev): ?>
Prev: <?=cp($prev)?><br>
<?php endif ?>
<?php if ($next): ?>
Next: <?=cp($next)?><br>
<?php endif ?>
</main>
<?php include 'partials/footer.php'; ?>
