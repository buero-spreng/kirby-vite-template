<nav class="menu">
  <ul class="menu__list">
    <?php foreach ($site->children() as $item): ?>
      <li class="menu__item <?= $item->isActive() ? 'active' : '' ?>">
        <a href="<?= $item->url() ?>">
          <?= $item->title() ?>
        </a>
      </li>
    <?php endforeach ?>
  </ul>
</nav>