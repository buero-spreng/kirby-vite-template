<?php
// 1) if they passed something, it must be an object
if (isset($layouts) && !is_object($layouts)) {
  throw new \InvalidArgumentException(
    'Snippet error: $layouts was passed but is not an object (' . gettype($layouts) . ')'
  );
}

// 2) if they didn’t pass it, try your default
if (!isset($layouts)) {
  $layouts = $page->layout();
}

// 3) still not an object? hard fail
if (!is_object($layouts)) {
  throw new \RuntimeException(
    'Snippet error: no valid layouts object available'
  );
}
?>


<div class="layout container">

  <?php foreach ($layouts->toLayouts() as $layout) : ?>

    <div class="layout__row | kb-grid">
      <?php foreach ($layout->columns() as $column) : ?>

        <div class="layout__column <?= kbResponsiveClassesFromFraction($column->width()) ?>">

          <?php foreach ($column->blocks() as $block): ?>
            <div class="block block-type-<?= $block->type() ?>">
              <?= $block ?>
            </div>
          <?php endforeach ?>

        </div>

      <?php endforeach ?>
    </div>


  <?php endforeach ?>

</div>