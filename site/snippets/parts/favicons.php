<?php
$siteIcon = $site->siteIcon()->toFile();

if (!$siteIcon) {
    $favicon = '';
    $icon = '';
    $appleTouchIcon = '';
} else {
    $favicon = $siteIcon->thumb(['format' => 'ico', 'width' => 32, 'height' => 32])->url();
    $icon = $siteIcon->thumb(['format' => 'svg'])->url();
    $appleTouchIcon = $siteIcon->thumb(['format' => 'png', 'width' => 180, 'height' => 180])->url();
}
?>

<link rel="icon"              href="<?= $favicon ?>" sizes="32x32" type="image/ico">
<link rel="icon"              href="<?= $icon ?>" type="image/svg+xml">
<link rel="apple-touch-icon"  href="<?= $appleTouchIcon ?>" sizes="180x180" type="image/png">
<link rel="shortcut icon"     href="<?= $favicon ?>" type="image/ico">