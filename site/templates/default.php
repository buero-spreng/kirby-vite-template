<?php
/* MAIN SNIPPET * must be loaded in every template */
snippet('page-structure', slots: true)
?>

<?php slot('head') ?>
<!-- Add stylesheets or other elements that you want to link to in the head -->
<?php endslot() ?>

<?php slot('header') ?>
<!-- Add elements that should be displayed in the <header> -->
<?php endslot() ?>

<?php slot('default') ?>

<h1><?= $page->title() ?></h1>

<?php endslot() ?>

<?php slot('footer') ?>
<!-- Add elements that should be displayed in the <main> -->
<?php endslot() ?>

<?php slot('foot') ?>
<!-- Add elements that should be displayed right before the end of the </body> -->

<?php endslot() ?>

<?php endsnippet() ?>
