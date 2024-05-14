<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoUri $seoUri
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Seo Uri'), ['action' => 'edit', $seoUri->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Seo Uri'), ['action' => 'delete', $seoUri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoUri->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Seo Uris'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Seo Uri'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="seoUris view content">
            <h3><?= h($seoUri->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Uri') ?></th>
                    <td><?= h($seoUri->uri) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($seoUri->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($seoUri->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($seoUri->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Approved') ?></th>
                    <td><?= $seoUri->is_approved ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Seo Canonicals') ?></h4>
                <?php if (!empty($seoUri->seo_canonicals)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Seo Uri Id') ?></th>
                            <th><?= __('Canonical') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($seoUri->seo_canonicals as $seoCanonicals) : ?>
                        <tr>
                            <td><?= h($seoCanonicals->id) ?></td>
                            <td><?= h($seoCanonicals->seo_uri_id) ?></td>
                            <td><?= h($seoCanonicals->canonical) ?></td>
                            <td><?= h($seoCanonicals->is_active) ?></td>
                            <td><?= h($seoCanonicals->created) ?></td>
                            <td><?= h($seoCanonicals->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SeoCanonicals', 'action' => 'view', $seoCanonicals->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SeoCanonicals', 'action' => 'edit', $seoCanonicals->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SeoCanonicals', 'action' => 'delete', $seoCanonicals->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoCanonicals->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Seo Meta Tags') ?></h4>
                <?php if (!empty($seoUri->seo_meta_tags)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Seo Uri Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Is Http Equiv') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($seoUri->seo_meta_tags as $seoMetaTags) : ?>
                        <tr>
                            <td><?= h($seoMetaTags->id) ?></td>
                            <td><?= h($seoMetaTags->seo_uri_id) ?></td>
                            <td><?= h($seoMetaTags->name) ?></td>
                            <td><?= h($seoMetaTags->content) ?></td>
                            <td><?= h($seoMetaTags->is_http_equiv) ?></td>
                            <td><?= h($seoMetaTags->created) ?></td>
                            <td><?= h($seoMetaTags->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SeoMetaTags', 'action' => 'view', $seoMetaTags->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SeoMetaTags', 'action' => 'edit', $seoMetaTags->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SeoMetaTags', 'action' => 'delete', $seoMetaTags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoMetaTags->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Seo Redirects') ?></h4>
                <?php if (!empty($seoUri->seo_redirects)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Seo Uri Id') ?></th>
                            <th><?= __('Redirect') ?></th>
                            <th><?= __('Priority') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Callback') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Nocache') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($seoUri->seo_redirects as $seoRedirects) : ?>
                        <tr>
                            <td><?= h($seoRedirects->id) ?></td>
                            <td><?= h($seoRedirects->seo_uri_id) ?></td>
                            <td><?= h($seoRedirects->redirect) ?></td>
                            <td><?= h($seoRedirects->priority) ?></td>
                            <td><?= h($seoRedirects->is_active) ?></td>
                            <td><?= h($seoRedirects->callback) ?></td>
                            <td><?= h($seoRedirects->created) ?></td>
                            <td><?= h($seoRedirects->modified) ?></td>
                            <td><?= h($seoRedirects->is_nocache) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SeoRedirects', 'action' => 'view', $seoRedirects->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SeoRedirects', 'action' => 'edit', $seoRedirects->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SeoRedirects', 'action' => 'delete', $seoRedirects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoRedirects->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Seo Status Codes') ?></h4>
                <?php if (!empty($seoUri->seo_status_codes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Seo Uri Id') ?></th>
                            <th><?= __('Status Code') ?></th>
                            <th><?= __('Priority') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($seoUri->seo_status_codes as $seoStatusCodes) : ?>
                        <tr>
                            <td><?= h($seoStatusCodes->id) ?></td>
                            <td><?= h($seoStatusCodes->seo_uri_id) ?></td>
                            <td><?= h($seoStatusCodes->status_code) ?></td>
                            <td><?= h($seoStatusCodes->priority) ?></td>
                            <td><?= h($seoStatusCodes->is_active) ?></td>
                            <td><?= h($seoStatusCodes->created) ?></td>
                            <td><?= h($seoStatusCodes->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SeoStatusCodes', 'action' => 'view', $seoStatusCodes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SeoStatusCodes', 'action' => 'edit', $seoStatusCodes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SeoStatusCodes', 'action' => 'delete', $seoStatusCodes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoStatusCodes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Seo Titles') ?></h4>
                <?php if (!empty($seoUri->seo_titles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Seo Uri Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($seoUri->seo_titles as $seoTitles) : ?>
                        <tr>
                            <td><?= h($seoTitles->id) ?></td>
                            <td><?= h($seoTitles->seo_uri_id) ?></td>
                            <td><?= h($seoTitles->title) ?></td>
                            <td><?= h($seoTitles->created) ?></td>
                            <td><?= h($seoTitles->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SeoTitles', 'action' => 'view', $seoTitles->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SeoTitles', 'action' => 'edit', $seoTitles->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SeoTitles', 'action' => 'delete', $seoTitles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoTitles->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
