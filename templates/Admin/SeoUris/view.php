<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeoUri $seoUri
 */

$this->Vite->script('admin_common','admin-vite');
?>
<header class="col-md-12 mt10">
    <div class="panel panel-light">
        <div class="panel-heading">Seo Uris Actions</div>
        <div class="panel-body p10">
            <div class="btn-group">
                <?= $this->Html->link(' Browse', ['action' => 'index'], ['class' => 'btn btn-default bi bi-search']) ?>
                <?= $this->Html->link(' Add', ['action' => 'add'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
                <?= $this->Html->link(' Edit', ['action' => 'edit', $seoUri->id], ['class' => 'btn btn-info bi-pencil']) ?>
                <?= $this->Html->link(' Delete', ['action' => 'delete', $seoUri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoUri->id), 'class' => 'btn btn-danger bi-trash-fill', 'id' => 'deleteBtn']) ?>
            </div>
        </div>
    </div>
</header>
<div class="col-md-12">
    <section class="panel">
        <div class="panel-body">
            <div class="panel-section expanded">
                <h2>Navigation</h2>
                <?= $this->Html->link(' Blacklists', ['controller' => 'seoBlacklists', 'action' => 'index'], ['class' => 'btn btn-default btn-lg rounded-0']) ?>
                <?= $this->Html->link(' Canonical', ['controller' => 'seoCanonicals', 'action' => 'index'], ['class' => 'btn btn-default btn-lg rounded-0']) ?>
                <?= $this->Html->link(' Meta Tags', ['controller' => 'seoMetaTags', 'action' => 'index'], ['class' => 'btn btn-default btn-lg rounded-0']) ?>
                <?= $this->Html->link(' Redirects', ['controller' => 'seoRedirects', 'action' => 'index'], ['class' => 'btn btn-default btn-lg rounded-0']) ?>
                <?= $this->Html->link(' Status Codes', ['controller' => 'seoStatusCodes', 'action' => 'index'], ['class' => 'btn btn-default btn-lg rounded-0']) ?>
                <?= $this->Html->link(' Titles', ['controller' => 'seoTitles', 'action' => 'index'], ['class' => 'btn btn-default btn-lg rounded-0']) ?>
                <div class="row mt20">
                    <div class="column-responsive column-80">
                        <div class="seoUris form content">
                            <h3><?= h($seoUri->id) ?></h3>
                            <table>
                                <tr>
                                    <th>Id</th>
                                </tr>
                                <tr>
                                    <td><?= $seoUri->id ?></td>
                                </tr>
                                <tr>
                                    <th>Uri</th>
                                </tr>
                                <tr>
                                    <td><?= h($seoUri->uri) ?></td>
                                </tr>
                                <tr>
                                    <th>Is Approved</th>
                                </tr>
                                <tr>
                                    <td><?= $seoUri->is_approved ? 'Yes' : 'No'; ?></td>
                                </tr>
                                <tr>
                                    <th>Created</th>
                                </tr>
                                <tr>
                                    <td><?= h($seoUri->created) ?></td>
                                </tr>
                                <tr>
                                    <th>Modified</th>
                                </tr>
                                <tr>
                                    <td><?= h($seoUri->modified) ?></td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <?php if (!empty($seoUri->seo_canonicals)) : ?>
                            <div class="related">
                                <h3>Related Seo Canonicals</h3>
                                <div class="table-responsive">
                                    <table>
                                        <?php foreach ($seoUri->seo_canonicals as $seoCanonicals) : ?>
                                            <tr>
                                                <th>Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoCanonicals->id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Seo Uri Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoCanonicals->seo_uri_id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Canonical</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoCanonicals->canonical) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Is Active</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoCanonicals->is_active) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Created</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoCanonicals->created) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Modified</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoCanonicals->modified) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="actions">
                                                     class="mt20"
                                                    <li>
                                                        <?= $this->Html->link('Edit SEO Canonical', ['controller' => 'SeoCanonicals', 'action' => 'edit', $seoCanonicals->id]) ?>
                                                    </li>
                                                    <li>
                                                        <?= $this->Form->postLink('Delete SEO Canonical', ['controller' => 'SeoCanonicals', 'action' => 'delete', $seoCanonicals->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoCanonicals->id)]) ?>
                                                    </li>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($seoUri->seo_meta_tags)) : ?>
                            <div class="related">
                                <h3>Related Seo Meta Tags</h3>
                                <div class="table-responsive">
                                    <table>
                                        <?php foreach ($seoUri->seo_meta_tags as $seoMetaTags) : ?>
                                            <tr>
                                                <th>Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoMetaTags->id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Seo Uri Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoMetaTags->seo_uri_id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoMetaTags->name) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Content</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoMetaTags->content) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Is Http Equiv</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoMetaTags->is_http_equiv) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Created</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoMetaTags->created) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Modified</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoMetaTags->modified) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="actions">
                                                     class="mt20"
                                                    <li>
                                                        <?= $this->Html->link('Edit SEO MetaTag', ['controller' => 'SeoMetaTags', 'action' => 'edit', $seoMetaTags->id]) ?>
                                                    </li>
                                                    <li>
                                                        <?= $this->Form->postLink('Delete SEO MetaTag', ['controller' => 'SeoMetaTags', 'action' => 'delete', $seoMetaTags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoMetaTags->id)]) ?>
                                                    </li>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($seoUri->seo_redirects)) : ?>
                            <div class="related">
                                <h3>Related Seo Redirects</h3>
                                <div class="table-responsive">
                                    <table>
                                        <?php foreach ($seoUri->seo_redirects as $seoRedirects) : ?>
                                            <tr>
                                                <th>Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Seo Uri Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->seo_uri_id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Redirect</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->redirect) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Priority</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->priority) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Is Active</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->is_active) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Callback</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->callback) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Created</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->created) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Modified</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->modified) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Is Nocache</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoRedirects->is_nocache) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="actions">
                                                     class="mt20"
                                                    <li>
                                                        <?= $this->Html->link('Edit SEO Redirect', ['controller' => 'SeoRedirects', 'action' => 'edit', $seoRedirects->id]) ?>
                                                    </li>
                                                    <li>
                                                        <?= $this->Form->postLink('Delete SEO Redirect', ['controller' => 'SeoRedirects', 'action' => 'delete', $seoRedirects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoRedirects->id)]) ?>
                                                    </li>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($seoUri->seo_status_codes)) : ?>
                            <div class="related">
                                <h3>Related Seo Status Codes</h3>
                                <div class="table-responsive">
                                    <table>
                                        <?php foreach ($seoUri->seo_status_codes as $seoStatusCodes) : ?>
                                            <tr>
                                                <th>Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoStatusCodes->id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Seo Uri Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoStatusCodes->seo_uri_id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status Code</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoStatusCodes->status_code) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Priority</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoStatusCodes->priority) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Is Active</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoStatusCodes->is_active) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Created</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoStatusCodes->created) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Modified</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoStatusCodes->modified) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="actions">
                                                     class="mt20"
                                                    <li>
                                                        <?= $this->Html->link('Edit SEO Status Code', ['controller' => 'SeoStatusCodes', 'action' => 'edit', $seoStatusCodes->id]) ?>
                                                    </li>
                                                    <li>
                                                        <?= $this->Form->postLink('Delete SEO Status Code', ['controller' => 'SeoStatusCodes', 'action' => 'delete', $seoStatusCodes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoStatusCodes->id)]) ?>
                                                    </li>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($seoUri->seo_titles)) : ?>
                            <div class="related">
                                <h3>Related Seo Titles</h3>
                                <div class="table-responsive">
                                    <table>
                                        <?php foreach ($seoUri->seo_titles as $seoTitles) : ?>
                                            <tr>
                                                <th>Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoTitles->id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Seo Uri Id</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoTitles->seo_uri_id) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Title</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoTitles->title) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Created</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoTitles->created) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Modified</th>
                                            </tr>
                                            <tr>
                                                <td><?= h($seoTitles->modified) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="actions">
                                                    <h3 class="mt20">Actions</h3>
                                                    <li>
                                                        <?= $this->Html->link('Edit SEO Title', ['controller' => 'SeoTitles', 'action' => 'edit', $seoTitles->id]) ?>
                                                    </li>
                                                    <li>
                                                        <?= $this->Form->postLink('Delete SEO Title', ['controller' => 'SeoTitles', 'action' => 'delete', $seoTitles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoTitles->id)]) ?>
                                                    </li>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
