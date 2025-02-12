<?php
/* MAIN SNIPPET * must be loaded in every template */
snippet('page-structure', slots: true)
?>

<?php slot('default') ?>

<h1><?= $page->title() ?></h1>

<?php endslot() ?>

<?php endsnippet() ?>