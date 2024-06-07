<?php
use Cake\Core\Configure;
$importType = strtoupper($importLocation->import->type);
//TODO: CSS
//echo $this->Html->css('imports.css?v='.Configure::read("tagVersion"));
echo $this->Html->script('dist/admin_location_review.min.js?v='.Configure::read("tagVersion"));
?>
<div class="import index pl20 pr20">

    <h2>Location Review</h2>
    <p>
        Information on the <?php echo $siteName; ?> side of the tables will be saved to the database for display on the site.<br>
        <?php if ($importType == 'CQP'): ?>
            Once review is completed, the location will be set as active, show, cqp_tier=2, and at least listing_type=Basic on the site.
        <?php elseif ($importType == 'YHN'): ?>
            Once review is completed, the location will be set as active, show, yhn_tier=2, and at least listing_type=Basic on the site.
        <?php else: // CA ?>
            Once review is completed, the location will be marked as active and show.
        <?php endif; ?>
    </p>
    <?php 
    echo $this->Form->create($location);
    ?>
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-wrench"></span> Location '.$location->id, ['controller' => 'locations', 'action' => 'edit', $location->id], ['class' => 'btn btn-default btn-xs', 'escape' => false, 'target' => '_blank']); ?>
        <table class="table table-striped table-bordered table-condensed mt20 col col-md-12">
            <tr>
                <th class="col col-md-2"></th>
                <th class="col col-md-4 text-center"><?= $siteName ?></th>
                <th class="col col-md-1"></th>
                <th class="col col-md-4 text-center"><?= $importType ?> import</th>
            </tr>
            <?php foreach ($fields as $field): ?>
                <?php
                    $reviewNeeded = '';
                    if (!empty($diffs[$field['hh']])) {
                        $diff = current($diffs[$field['hh']]);
                        if ($diff['review_needed']) {
                            $reviewNeeded = 'review-needed';
                        }
                    }
                ?>
                <tr>
                    <th class="<?= $reviewNeeded ?>">
                        <?= ucfirst($field['label']) ?>
                        <?php if (!empty($diffs[$field['hh']])): ?>
                            <?php $diff = current($diffs[$field['hh']]); ?>
                            <br />
                            <small>Changed: <?php echo date('F j, Y', strtotime($diff['created'])); ?></small>
                        <?php endif; ?>
                    </th>
                    <td>
                        <?= $this->Form->control($field['hh'], [
                            'type' => 'text',
                            'label' => false
                        ]) ?>
                    </td>
                    <td class="text-center"><button class="js-copy-left form-control" type="button">&larr;</button></td>
                    <?php
                    if ($field['hh'] == 'phone') {
                        $value = str_replace('-', '', $importLocation->{$field['hh']});
                    } else {
                        $value = $importLocation->{$field['hh']};
                    }
                    $class = (trim($value ?? '') == trim($location->{$field['hh']} ?? '')) ? 'form-control match' : 'form-control different';
                    ?>
                    <td><input disabled class="<?= $class ?>" value="<?= $value ?>" /></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th>
                    <?php echo $externalIdLabel; ?>
                </th>
                <td>
                    <?= $this->Form->control("id_yhn_location", [
                        'label' => false,
                        'disabled' => 'disabled'
                    ]) ?>
                </td>
                <td>
                </td>
                <td>
                    <!-- This is here to keep the javascript happy so the first ID field doesn't get highlighted. -->
                    <input class="form-control match" value="<?= $importLocation->id_external ?>" disabled="disabled" />    
                </td>
            </tr>
            <?php if (Configure::read('isTieringEnabled')): ?>
                <tr>
                    <th>
                        Current Listing Type
                    </th>
                    <td>
                        <?= $this->Form->control('listing_type', [
                            'label' => false,
                            'disabled' => 'disabled'
                        ]) ?>
                    </td>
                    <td>
                    </td>
                    <td>
                        <!-- This is here to keep the javascript happy so the first listing type field doesn't get highlighted. -->
                        <input class="form-control" value="<?= $location->listing_type ?>" type="hidden" />
                    </td>
                </tr>
            <?php endif; ?>
        </table>

        <div class="clearfix"></div>
        <hr>

        <?php if ($importType == 'CQP'): ?>
            <!-- CQP import: Hide provider review and display list of contacts instead -->
            <h4 class="mb5">CQP Contacts</h4>
            <?php $contacts = json_decode($importLocation->notes, true); ?>
            <p>We do not automatically import providers from CQP. Here is a list of contacts associated with the practice (not necessarily this location).</p>
            <table class="table table-striped table-bordered table-condensed">
                <tr>
                    <th>First</th>
                    <th>Last</th>
                    <th>Title</th>
                    <th>Email</th>
                    <th>Office ID?</th>
                </tr>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= empty($contact['ContactFName']) ? '' : $contact['ContactFName'] ?></td>
                        <td><?= empty($contact['ContactLName']) ? '' : $contact['ContactLName'] ?></td>
                        <td><?= empty($contact['ContactTitle']) ? '' : $contact['ContactTitle'] ?></td>
                        <td><?= empty($contact['ContactEmail']) ? '' : $contact['ContactEmail'] ?></td>
                        <td><?= empty($contact['ContactOfficeID']) ? '' : $contact['ContactOfficeID'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <h4 class="mb10">Provider Review</h4>
            <a class="js-add-all">Add All</a>
            <table class="table table-striped table-bordered table-condensed mt20 col col-md-12 provider-table">
                <tr>
                    <th class="col col-md-3"></th>
                    <th class="col col-md-4 text-center"><?= $siteName ?></th>
                    <th class="col col-md-1"></th>
                    <th class="col col-md-4 text-center"><?= $importType ?> import</th>
                </tr>
                <?php $hhProviderIds = []; ?>
                <?php $providerCount = 0; ?>
                <!-- Find all providers existing in our database -->
                <?php foreach ($providers as $provider): ?>
                    <?php
                    $hhProviderIds[] = $provider->id_yhn_provider;
                    $isLinked = false;
                    $importProvider = [];
                    $providerId = $provider->id;
                    $importProviderId = isset($provider->id_yhn_provider) ? $provider->id_yhn_provider : null;
                    if (in_array($importProviderId, $importProviderIds)) {
                        $isLinked = true;
                        $importProvider = $importProviders[$importProviderId];
                    }
                    ?>
                    <tr provider="<?= $provider->id ?>" providerCount="<?= $providerCount ?>">
                        <td colspan='4'>
                            <table class="table-condensed col col-md-12">
                                <tr provider="<?= $provider->id ?>" providerCount="<?= $providerCount ?>">
                                    <td class="col col-md-3 text-center">
                                        <button class="js-link-delete form-control"><i class="glyphicon glyphicon-remove-circle"></i> Delete</button>
                                        <?php if (empty($provider->id_yhn_provider) || !in_array($provider->id_yhn_provider, $importProviderIds)): ?>
                                            <button class="js-link hh-link hidden form-control"><i class="glyphicon glyphicon-link"></i></button>
                                        <?php endif; ?>
                                    </td>
                                    <td colspan=3 class="text-center">
                                        <div class='well import-well'>
                                            <?php if ($isLinked): ?>
                                                <span class="label label-warning"><span class="glyphicon glyphicon-globe"></span><?php echo ' ' . Configure::read('importTag'); ?></span>
                                            <?php elseif (!empty($provider->id_yhn_provider)): ?>
                                                <span class="label label-danger"><span class="glyphicon glyphicon-warning-sign"></span></span>
                                            <?php else: ?>
                                                <span class="label label-success"><span class="glyphicon glyphicon-ok"></span><?php echo ' ' . Configure::read('siteNameAbbr'); ?></span>
                                            <?php endif ?>
                                            <?php echo $provider->first_name.' '.$provider->last_name; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php echo $this->Form->hidden("providers.$providerCount.id_yhn_provider", [
                                    'class' => 'import-data',
                                    'value' => $provider->id_yhn_provider,
                                    'field' => 'id_yhn_provider'
                                ]); ?>
                                <?php echo $this->Form->hidden("providers.$providerCount.id", ['value' => $provider->id]); ?>
                                <?php foreach ($providerFields as $field => $label): ?>
                                    <?php
                                    $reviewNeeded = '';
                                    if (!empty($providerDiffs[$providerId][$field])) {
                                        $diff = current($providerDiffs[$providerId][$field]);
                                        if ($diff['review_needed']) {
                                            $reviewNeeded = 'review-needed';
                                        }
                                    }
                                    $isMatch = (isset($importProvider[$field]) && (trim($provider->{$field}) == trim($importProvider[$field]))) ? true : false;
                                    $class = ($isMatch) ? "linked match" : "linked different";
                                    ?>
                                    <tr providerCount="<?php echo $providerCount; ?>">
                                        <td class="<?php echo 'col col-md-2 '.$reviewNeeded; ?>">
                                            <label class="control-label"><?php echo $label; ?></label>
                                            <?php if (!empty($providerDiffs[$providerId][$field])): ?>
                                                <?php $diff = current($providerDiffs[$providerId][$field]); ?>
                                                <br />
                                                <small>Changed: <?php echo date('F j, Y', strtotime($diff['created'])); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="col col-md-4 text-center">
                                            <?php echo $this->Form->control("providers.$providerCount.$field", [
                                                'label' => false,
                                                'field' => $field,
                                                'value' => trim($provider->{$field}),
                                            ]); ?>
                                        </td>
                                        <td class="col col-md-1"><button class="js-copy-left form-control" type="button">&larr;</button></td>
                                        <td class="col col-md-4 text-center">
                                            <?php if ($isLinked): ?>
                                                <?php echo $this->Form->control("providers.$providerCount.$field", [
                                                    'label' => false,
                                                    'class'=>'form-control import-data '.$class,
                                                    'field' => $field,
                                                    'value' => trim($importProvider[$field]),
                                                    'disabled' => 'disabled'
                                                ]); ?>
                                            <?php else: ?>
                                                <input class="form-control import-data" field="<?= $field ?>" disabled />
                                            <?php endif; ?>
                                        </td>
                                        <td class="col col-md-1 text-center"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                    <?php $providerCount++; ?>
                <?php endforeach; ?>
                <!-- Find all new providers in this import -->
                <?php foreach ($importProviders as $importProvider): ?>
                    <?php
                    if (in_array($importProvider->id_external, $hhProviderIds)) {
                        continue;
                    }
                    ?>
                    <tr providerCount="<?= $providerCount ?>">
                        <td colspan='5'>
                            <table class="table-condensed col col-md-12">
                                <tr providerCount="<?php echo $providerCount; ?>">
                                    <td class="col col-md-3 text-center">
                                        <button class="js-add-provider form-control pull-left" style="width:50%;"><i class="glyphicon glyphicon-arrow-left"></i> Add</button>
                                        <button class="js-link yhn-link form-control pull-right" style="width:50%;"><i class="glyphicon glyphicon-link"></i></button>
                                        <button class="js-link-cancel form-control hidden"><i class="glyphicon glyphicon-ban-circle"></i></button>
                                    </td>
                                    <td colspan=4 class="text-center">
                                        <div class="well import-well">
                                            <span class="label label-warning" style=""><span class="glyphicon glyphicon-globe"></span><?php echo ' ' . Configure::read('importTag'); ?></span>
                                            <?php echo $importProvider->first_name.' '.$importProvider->last_name; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php echo $this->Form->hidden("providers.$providerCount.id_yhn_provider", [
                                    'class' => 'import-data',
                                    'value' => $importProvider->id_external,
                                    'field' => 'id_yhn_provider'
                                ]); ?>
                                <?php foreach ($providerFields as $field => $label): ?>
                                    <?php
                                    $class = "linked different";
                                    ?>
                                    <tr providerCount="<?php echo $providerCount; ?>">
                                        <td class="col col-md-2"><label class="control-label"><?php echo $label; ?></label></td>
                                        <td class="col col-md-4 text-center">
                                            <?php echo $this->Form->control("providers.$providerCount.$field", [
                                                'label' => false,
                                                'field' => $field,
                                                'value' => '',
                                            ]); ?>
                                        </td>
                                        <td class="col col-md-1"><button class="js-copy-left form-control" type="button">&larr;</button></td>
                                        <td class="col col-md-4 text-center">
                                            <?php if (!empty($importProvider->{$field})): ?>
                                                <?php echo $this->Form->control("providers.$providerCount.$field", [
                                                    'label' => false,
                                                    'class'=>'form-control import-data '.$class,
                                                    'field' => $field,
                                                    'value' => trim($importProvider->{$field}),
                                                    'disabled' => 'disabled'
                                                ]); ?>
                                            <?php else: ?>
                                                <input class="form-control" field="<?php echo $field; ?>" disabled />
                                            <?php endif; ?>
                                        </td>
                                        <td class="col col-md-1 text-center"></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php $providerCount++; ?>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <div class="form-actions tar">
            <a href="<?php echo $importIndexReferer; ?>">
                <input type="button" tabindex="1" value="Cancel" class="btn btn-danger btn-lg">
            </a>
            <input type="submit" tabindex="1" value="Complete Review" class="btn btn-primary btn-lg">
        </div>
    </form>
</div>
