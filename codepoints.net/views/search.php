<?php
/**
 * @var ?\Codepoints\Unicode\SearchResult $search_result
 * @var list<\Codepoints\Unicode\Codepoint> $alt_result
 * @var ?\Codepoints\Router\Pagination $pagination
 * @var bool $wizard
 * @var string $q
 */

include 'partials/header.php' ?>
<main class="main main--search"<?php if ($search_result):?> data-count="<?=q((string)$search_result->count())?>"<?php endif ?>>
  <h1><?=_q($title)?></h1>

  <?php if ($search_result && $search_result->count()): ?>
    <?php if ($search_result->count() > 16): ?>
        <p><a href="#searchform"><?=_q('Jump to the search form')?></a></p>
    <?php endif ?>
    <ol class="tiles">
      <?php foreach ($search_result as $codepoint): ?>
        <?php if (! $codepoint) { continue; } ?>
        <li><?=cp($codepoint)?></li>
      <?php endforeach ?>
    </ol>
    <?=$pagination?>
  <?php elseif (count($alt_result)): ?>
    <p><?=_q('The following codepoints match:')?></p>
    <ol class="tiles">
      <?php foreach ($alt_result as $codepoint): ?>
        <li><?=cp($codepoint)?></li>
      <?php endforeach ?>
    </ol>
  <?php endif ?>

  <?php if (isset($blocks) && $blocks): ?>
    <p><?php printf(count($blocks) === 1? __('%s block matches %s:') : __('%s blocks match %s:'), '<strong>'.count($blocks).'</strong>', '<strong>'.q($q).'</strong>')?><p>
    <ol class="tiles">
      <?php foreach ($blocks as $block): ?>
        <li><?=bl($block)?></li>
      <?php endforeach ?>
    </ol>
  <?php endif ?>

  <p id="searchform">
    <?=_q('Search for code points:')?>
  </p>
<?php if ($wizard): ?>
  <?php if ($search_result): ?>
    <p><a href="?"><?=_q('Try “Find My Codepoint” again.')?></a></p>
  <?php else: ?>
    <p><?=_q('You search for a specific character? Answer the following questions and we try to figure out candidates.')?></p>
  <?php endif ?>
  <cp-wizard></cp-wizard>
<?php else: ?>
  <?php include 'partials/form-fullsearch.php' ?>
<?php endif ?>
  <ol>
    <li>
      <?=_q('Choose properties of code points to search for.')?>
      <?=_q('The easiest is the “free search” field where you can place any information that you have.')?>
      <?=_q('We will then try our best to match code points with it.')?>
    </li>
    <li><?=_q('If you know a part of the actual Unicode name enter it in the “name” field.')?></li>
    <li>
      <?=_q('Click a button with a ≡ icon to restrict the search to certain properties only.')?>
      <?=_q('A dialog opens with possible options.')?>
    </li>
    <li>
      <?=_q('Click a button with a * icon to enforce a specific yes/no property.')?>
      <?=_q('Click again to search for code points <em>without</em> this property and a third time to reset the search again.')?>
    </li>
    <li><?=_q('Click “search” to start the search.')?></li>
  </ol>
  <p>
    <?=_q('On code point detail pages you can click the values in the property description to be guided to a search page that shows code points with the same property.')?>
  </p>

</main>
<?php include 'partials/footer.php' ?>
