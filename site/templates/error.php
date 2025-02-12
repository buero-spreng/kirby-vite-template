<?php
/* MAIN SNIPPET * must be loaded in every template */
snippet('page-structure', slots: true)
?>

<?php slot('default') ?>

<div class="container">
    <div class="text m-bottom-md">
        <?= $page->text() ?>
    </div>

    <a class="button" href="/">
        <span class="arrow" data-direction="left"></span> Back to Home
    </a>
</div>

<?php endslot() ?>

<?php endsnippet() ?>