<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

Configure::load('hhConfigs/config_adminMenu', 'default');
$adminMenu = Configure::read('adminMenu');
?>

<div class="container p-5">
  <div class="row row-cols-1 g-4">
    <?php foreach ($adminMenu as $menuHeader => $menuContents) : ?>
      <div class="col">
        <div class="card">
          <h5 class="card-header bg-primary text-white"><?= $menuHeader ?></h5>
          <div class="card-body">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-2">
            <?php foreach ($menuContents as $itemTitle => $itemContents) : ?>
                <?php if (array_key_exists('items', $itemContents)) : ?>
                  <div class="col dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle w-100 rounded-pill"
                      type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <?= $itemTitle ?>
                    </button>
                    <?php if (!empty($itemContents['items'])) : ?>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <?php foreach ($itemContents['items'] as $subItemTitle => $subItem) : ?>
                            <?php if ($subItemTitle == 'divider' && $subItem === true) : ?>
                              <li><hr class="dropdown-divider"></li>
                            <?php else : ?>
                              <li><a class="dropdown-item" href="<?= $subItem['url'] ?>"><?= $subItemTitle ?></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                      </ul>
                    <?php endif; ?>
                  </div>
                <?php else : ?>
                  <div class="col">
                    <a class="btn btn-outline-secondary w-100 rounded-pill"
                      href="<?= $itemContents['url'] ?>"
                      role="button"
                    >
                      <?= $itemTitle ?>
                    </a>
                  </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>