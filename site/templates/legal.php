<?php
/* MAIN SNIPPET * must be loaded in every template */
snippet('page-structure', slots: true)
?>

<?php slot('default') ?>

<div class="legal container">

    <div class="m-bottom-md writer-fields">
        <?= $page->text() ?>
    </div>

</div>

<?php endslot() ?>

<?php endsnippet() ?>