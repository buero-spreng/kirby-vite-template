<?php
$siteIcon = $site->siteIcon()->toFile();
if ($siteIcon):
    $png32  = $siteIcon->thumb(['format' => 'png', 'width' => 32,  'height' => 32]);
    $png180 = $siteIcon->thumb(['format' => 'png', 'width' => 180, 'height' => 180]);
?>
<link rel="icon"             href="<?= $siteIcon->url() ?>"  type="image/svg+xml">
<link rel="icon"             href="<?= $png32->url() ?>"     sizes="32x32" type="image/png">
<link rel="apple-touch-icon" href="<?= $png180->url() ?>"    sizes="180x180">
<?php endif ?>
