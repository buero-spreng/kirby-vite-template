<?php

/**
 *  Gallery – with glide.js
 * 
 *  Builds on: 
 * 
 *  "assets/scss/components/gallery.scss"
 *      "node_modules/@glidejs/glide/src/assets/sass/glide.core.scss"

 *  "site/snippets/blocks/gallery.php"

 *  "site/snippets/components/glide.php"
 *      "node_modules/@glidejs/glide/dist/glide.min.js"
 */


use Kirby\Cms\Html;

/** @var \Kirby\Cms\Block $block */
$caption = $block->caption();
$crop = $block->crop()->isTrue();
$ratio = $block->ratio()->or('auto');

// Set the default ratio to 3/2 if it is 'auto'
$ratio = ($ratio == 'auto') ? '3/2' : $ratio;

$galleryImages = $block->images()->toFiles();

// Generate a unique identifier for each block
$uniqueId = 'block_' . uniqid();

?>

<div id="<?= $uniqueId ?>" class="block block-type-<?= $block->type() ?> grid-span-16" <?= ($ratio != 'auto') ? Html::attr(['data-ratio' => $ratio, 'data-crop' => $crop], null, ' ') : '' ?>>
    <div class="glide | gallery-container">

        <div class="glide__track" data-glide-el="track">
            <div class="glide__slides | gallery-slider">
                <?php foreach ($galleryImages as $image) : ?>
                    <figure class="glide__slide | gallery-item">
                        <img src="<?= $image->url() ?>" alt="" loading="lazy">
                    </figure>
                <?php endforeach ?>
            </div>
        </div>

        <div class="glide__arrows | arrows-nav" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left | arrow" data-orientation="left" data-glide-dir="<"></button>
            <button class="glide__arrow glide__arrow--right | arrow" data-orientation="right" data-glide-dir=">"></button>
        </div>

        <div class="glide__bullets | bullets-nav" data-glide-el="controls[nav]">
            <?php foreach ($galleryImages as $index => $image) : ?>
                <button class="glide__bullet | nav-bullet" data-glide-dir="=<?= $image->indexOf() ?>"></button>
            <?php endforeach ?>
        </div>

    </div>


</div>

<script>
    /** Applies the data-ratio to the gallery */

    // Wrap the gallery logic in a function
    function initGallery(galleryId) {
        // Get the gallery element
        let gallery = document.getElementById(galleryId);

        // Get the value of the data-ratio attribute
        let dataRatio = gallery.getAttribute('data-ratio');

        // Check if data-ratio is set and valid
        if (dataRatio && /^\d+\/\d+$/.test(dataRatio)) {
            // Set the aspect-ratio CSS property for the gallery
            gallery.style.aspectRatio = dataRatio;

            // Select all elements with the class "gallery-item" inside the gallery
            let galleryItems = gallery.querySelectorAll('.gallery-item');

            // Set the aspect-ratio CSS property for each gallery item
            galleryItems.forEach(item => {
                item.style.aspectRatio = dataRatio;
            });
        }
    }

    // Call the function to initialize each gallery
    initGallery('<?= $uniqueId ?>');
</script>