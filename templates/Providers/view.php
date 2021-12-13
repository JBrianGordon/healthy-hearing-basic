<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Provider $provider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Provider'), ['action' => 'edit', $provider->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Provider'), ['action' => 'delete', $provider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $provider->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Providers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Provider'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="providers view content">
            <h3><?= h($provider->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($provider->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Middle Name') ?></th>
                    <td><?= h($provider->middle_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($provider->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Credentials') ?></th>
                    <td><?= h($provider->credentials) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($provider->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($provider->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Micro Url') ?></th>
                    <td><?= h($provider->micro_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Square Url') ?></th>
                    <td><?= h($provider->square_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Thumb Url') ?></th>
                    <td><?= h($provider->thumb_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Url') ?></th>
                    <td><?= h($provider->image_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($provider->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Aud Or His') ?></th>
                    <td><?= h($provider->aud_or_his) ?></td>
                </tr>
                <tr>
                    <th><?= __('Caqh Number') ?></th>
                    <td><?= h($provider->caqh_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Npi Number') ?></th>
                    <td><?= h($provider->npi_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($provider->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $this->Number->format($provider->order) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Yhn Provider') ?></th>
                    <td><?= $this->Number->format($provider->id_yhn_provider) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($provider->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($provider->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $provider->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Show Npi') ?></th>
                    <td><?= $provider->show_npi ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Ida Verified') ?></th>
                    <td><?= $provider->is_ida_verified ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Show License') ?></th>
                    <td><?= $provider->show_license ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($provider->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Licenses') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($provider->licenses)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Import Providers') ?></h4>
                <?php if (!empty($provider->import_providers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Import Id') ?></th>
                            <th><?= __('Id External') ?></th>
                            <th><?= __('Provider Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Aud Or His') ?></th>
                            <th><?= __('Caqh Number') ?></th>
                            <th><?= __('Npi Number') ?></th>
                            <th><?= __('Licenses') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($provider->import_providers as $importProviders) : ?>
                        <tr>
                            <td><?= h($importProviders->id) ?></td>
                            <td><?= h($importProviders->import_id) ?></td>
                            <td><?= h($importProviders->id_external) ?></td>
                            <td><?= h($importProviders->provider_id) ?></td>
                            <td><?= h($importProviders->first_name) ?></td>
                            <td><?= h($importProviders->last_name) ?></td>
                            <td><?= h($importProviders->email) ?></td>
                            <td><?= h($importProviders->aud_or_his) ?></td>
                            <td><?= h($importProviders->caqh_number) ?></td>
                            <td><?= h($importProviders->npi_number) ?></td>
                            <td><?= h($importProviders->licenses) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ImportProviders', 'action' => 'view', $importProviders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ImportProviders', 'action' => 'edit', $importProviders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ImportProviders', 'action' => 'delete', $importProviders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $importProviders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Location Providers') ?></h4>
                <?php if (!empty($provider->location_providers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Location Id') ?></th>
                            <th><?= __('Provider Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($provider->location_providers as $locationProviders) : ?>
                        <tr>
                            <td><?= h($locationProviders->id) ?></td>
                            <td><?= h($locationProviders->location_id) ?></td>
                            <td><?= h($locationProviders->provider_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'LocationProviders', 'action' => 'view', $locationProviders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'LocationProviders', 'action' => 'edit', $locationProviders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'LocationProviders', 'action' => 'delete', $locationProviders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $locationProviders->id)]) ?>
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
