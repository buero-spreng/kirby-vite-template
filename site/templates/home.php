<?php
/* MAIN SNIPPET * must be loaded in every template */
snippet('page-structure', slots: true)
?>

<?php slot('default') ?>

<div class="container">
    <h1><?= $page->title() ?></h1>
</div>

<?php endslot() ?>

<?php endsnippet() ?>