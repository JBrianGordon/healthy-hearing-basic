<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

Configure::load('hhConfigs/config_adminMenu', 'default');
$adminMenu = Configure::read('adminMenu');
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
		  <div class="row row-cols-1 g-4">
			<div class="col-md-12 mt20">
				<section class="panel">
					<div class="panel-body">
						<div class="panel-section expanded">
							<div class="admin-panels">
								<div class="tar pb20">
									<div class="btn-group">
										<button class="btn btn-default dropdown-toggle" data-bs-toggle="dropdown">Logged in as [<?= $this->Identity->get('username') ?>]&nbsp;<span class="caret"></span></button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
											<li><a class="dropdown-item" href="/logout"><span class="glyphicon glyphicon-share"></span> Logout</a></li>
										</ul>
									</div>
								</div>
								<div class="clearfix"></div>
							    <?php foreach ($adminMenu as $menuHeader => $menuContents) : ?>
							      <div class="col panel panel-primary">
							        <div class="card">
							          <h5 class="card-header bg-primary text-white panel-heading"><?= $menuHeader ?></h5>
							          <div class="card-body">
							            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-2 w-100 mx-auto">
							            <?php foreach ($menuContents as $itemTitle => $itemContents) : ?>
							                <?php if (array_key_exists('items', $itemContents)) : ?>
							                  <div class="col dropdown">
							                    <button class="btn btn-default dropdown-toggle w-100 rounded-pill"
							                      type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
							                      aria-expanded="false"
							                    >
							                      <?php if (!empty($itemContents['icon'])): ?>
							                        <?= '<i class="'.$itemContents['icon'].'"></i> ' ?>
							                      <?php endif; ?>
							                      <?= $itemTitle ?>
							                    </button>
							                    <?php if (!empty($itemContents['items'])) : ?>
							                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							                        <?php foreach ($itemContents['items'] as $subItemTitle => $subItem) : ?>
							                            <?php if ($subItemTitle == 'divider' && $subItem === true) : ?>
							                              <li><hr class="dropdown-divider"></li>
							                            <?php else : ?>
							                              <li>
							                                <a class="dropdown-item" href="<?= $subItem['url'] ?>">
							                                  <?php if (!empty($subItem['icon'])): ?>
							                                    <?= '<i class="'.$subItem['icon'].'"></i> ' ?>
							                                  <?php endif; ?>
							                                  <?= $subItemTitle ?>
							                                </a>
							                              </li>
							                            <?php endif; ?>
							                        <?php endforeach; ?>
							                      </ul>
							                    <?php endif; ?>
							                  </div>
							                <?php else : ?>
							                  <div class="col">
							                    <a class="btn btn-default w-100 rounded-pill"
							                      href="<?= $itemContents['url'] ?>"
							                      role="button"
							                    >
							                      <?php if (!empty($itemContents['icon'])): ?>
							                        <?= '<i class="'.$itemContents['icon'].'"></i> ' ?>
							                      <?php endif; ?>
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
								<div class="tac mt-3"><?= Configure::read('tagVersion') ?></div>
							</div>
						</div>
					</div>
				</section>
			</div>
		  </div>
		</div>
	</div>
</div>