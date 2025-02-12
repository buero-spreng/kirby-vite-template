<?php

/** @var \Kirby\Cms\Block $block */

use Kirby\Toolkit\Html;
use Kirby\Toolkit\Str;

$alt     = $block->alt();
$caption = $block->caption();
$crop    = $block->crop()->isTrue();
$link    = $block->link();
$ratio   = $block->ratio()->or('auto');
$src     = null;

if ($block->location() == 'web') {
    $src = $block->src()->esc();
} elseif ($image = $block->image()->toFile()) {
    $alt = $alt->or($image->alt());
    $src = $image->url();
}

// Generate a unique identifier for each block
$uniqueId = 'block_' . uniqid();

?>
<?php if ($src): ?>
    <figure id="<?= $uniqueId ?>" class="block block-type-image" <?= ($ratio != 'auto') ? Html::attr(['data-ratio' => $ratio, 'data-crop' => $crop], null, ' ') : '' ?>>
    <?php if ($link->isNotEmpty()): ?>
        <a href="<?= Str::esc($link->toUrl()) ?>">
            <img src="<?= $src ?>" alt="<?= $alt->esc() ?>">
        </a>
    <?php else: ?>
        <img src="<?= $src ?>" alt="<?= $alt->esc() ?>">
    <?php endif ?>

    <?php if ($caption->isNotEmpty()): ?>
        <figcaption>
            <?= $caption ?>
        </figcaption>
    </figure>
<?php endif ?>

<script>
    // Get the figure element
    var figure = document.getElementById('<?= $uniqueId ?>');

    // Get the value of the data-ratio attribute
    var dataRatio = figure.getAttribute('data-ratio');

    // Check if data-ratio is set and valid
    if (dataRatio && /^\d+\/\d+$/.test(dataRatio)) {
        // Set the aspect-ratio CSS property
        figure.style.aspectRatio = dataRatio;
    }
</script>

<?php endif ?>
