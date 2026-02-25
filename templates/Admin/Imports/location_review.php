<?php
use Cake\Core\Configure;
$importType = strtoupper($importLocation->import->type);
//TODO: CSS
echo $this->Html->css('admin/imports.css?v='.Configure::read("tagVersion"));
$this->Vite->script('admin_location_review','admin-vite');
?>
<header class="col-md-12 mt10">
	<div class="panel panel-light">
		<div class="panel-heading">Imports Actions</div>
		<div class="panel-body p10">
			<div class="btn-group">
				<?= $this->Html->link(" Dashboard", ['controller' => 'import_locations', 'action' => 'index'], ['class' => 'btn btn-default bi bi-speedometer', 'escape' => false]) ?>
			</div>
		</div>
	</div>
</header>						
<div class="col-md-12">
	<section class="panel">
		<div class="panel-body">
			<div class="panel-section expanded">
				<h2>Location Review</h2>
                <div class="import index pl20 pr20">

                    <p>
                        Information on the <?= $siteName ?> side of the tables will be saved to the database for display on the site.<br>
                        <?php if ($importType == 'CQP'): ?>
                            Once review is completed, the location will be set as active, show, cqp_tier=2, and at least listing_type=Basic on the site.
                        <?php elseif ($importType == 'YHN'): ?>
                            Once review is completed, the location will be set as active, show, yhn_tier=2, and at least listing_type=Basic on the site.
                        <?php else: // CA ?>
                            Once review is completed, the location will be marked as active and show.
                        <?php endif; ?>
                    </p>
                    <?= $this->Form->create($location)?>
                        <?= $this->Html->link('<span class="bi bi-wrench"></span> Location '.$location->id, ['controller' => 'locations', 'action' => 'edit', $location->id], ['class' => 'btn btn-default btn-xs', 'escape' => false, 'target' => '_blank']) ?>
                        <table class="table table-striped table-bordered table-condensed mt20">
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th class="text-center"><?= $siteName ?></th>
                                    <th></th>
                                    <th class="text-center"><?= $importType ?> import</th>
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
                                                <small>Changed: <?= date('F j, Y', strtotime($diff['created'])) ?></small>
                                            <?php endif; ?>
                                        </th>
                                        <td>
                                            <?= $this->Form->text($field['hh'], [
                                                'label' => false,
                                                'class' => 'w-100'
                                            ]) ?>
                                        </td>
                                        <td class="text-center"><button class="js-copy-left form-control w-100" type="button">&larr;</button></td>
                                        <?php
                                        if ($field['hh'] == 'phone') {
                                            $value = str_replace('-', '', $importLocation->{$field['hh']});
                                        } else {
                                            $value = $importLocation->{$field['hh']};
                                        }
                                        $class = (trim($value ?? '') == trim($location->{$field['hh']} ?? '')) ? 'form-control match w-100' : 'form-control different w-100';
                                        ?>
                                        <td><input disabled class="<?= $class ?>" value="<?= $value ?>" /></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th>
                                        <?= $externalIdLabel ?>
                                    </th>
                                    <td>
                                        <?= $this->Form->control("id_yhn_location", [
                                            'class' => 'w-100',
                                            'label' => false,
                                            'disabled' => 'disabled'
                                        ]) ?>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <!-- This is here to keep the javascript happy so the first ID field doesn't get highlighted. -->
                                        <input class="form-control match w-100" value="<?= $importLocation->id_external ?>" disabled="disabled" />    
                                    </td>
                                </tr>
                                <?php if (Configure::read('isTieringEnabled')): ?>
                                    <tr>
                                        <th>
                                            Current Listing Type
                                        </th>
                                        <td>
                                            <?= $this->Form->control('listing_type', [
                                                'class' => 'w-100',
                                                'label' => false,
                                                'disabled' => 'disabled'
                                            ]) ?>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <!-- This is here to keep the javascript happy so the first listing type field doesn't get highlighted. -->
                                            <input class="form-control w-100" value="<?= $location->listing_type ?>" type="hidden" />
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
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
                            <table class="table table-striped table-bordered table-condensed mt20 provider-table">
                                <tr>
                                    <th class="w-25"></th>
                                    <th style="width:33.33333%"><?= $siteName ?></th>
                                    <th></th>
                                    <th class="text-center" style="width:33.33333%"><?= $importType ?> import</th>
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
                                    <tr provider="<?= $provider->id ?>" providerCount="<?= $providerCount ?>" class="provider-tr">
                                        <td colspan='4'>
                                            <table class="table-condensed border-0">
                                                <tbody>
                                                    <tr provider="<?= $provider->id ?>" providerCount="<?= $providerCount ?>">
                                                        <td class="text-center border-0 w-25 p0">
                                                            <button type="button" class="js-link-delete form-control bi bi-x-circle w-100"> Delete</button>
                                                            <?php if (empty($provider->id_yhn_provider) || !in_array($provider->id_yhn_provider, $importProviderIds)): ?>
                                                                <button type="button" class="js-link hh-link hidden form-control bi bi-link-45deg"></button>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td colspan=3 class="text-center border-0 p0">
                                                            <div class='well import-well'>
                                                                <?php if ($isLinked): ?>
                                                                    <span class="badge bg-warning bi bi-globe2"><?= ' ' . Configure::read('importTag') ?></span>
                                                                <?php elseif (!empty($provider->id_yhn_provider)): ?>
                                                                    <span class="badge bg-danger"><span class="bi bi-cone-striped"></span></span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-success bi bi-check"><?= ' ' . Configure::read('siteNameAbbr') ?></span>
                                                                <?php endif ?>
                                                                <?= $provider->first_name.' '.$provider->last_name ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?= $this->Form->hidden("providers.$providerCount.id_yhn_provider", [
                                                        'class' => 'import-data',
                                                        'value' => $provider->id_yhn_provider,
                                                        'field' => 'id_yhn_provider'
                                                    ]) ?>
                                                    <?= $this->Form->hidden("providers.$providerCount.id", ['value' => $provider->id]) ?>
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
                                                        <tr providerCount="<?=  $providerCount ?>">
                                                            <td class="border-0 p0 <?= $reviewNeeded ?>">
                                                                <label class="control-label w-100 tal"><?= $label ?></label>
                                                                <?php if (!empty($providerDiffs[$providerId][$field])): ?>
                                                                    <?php $diff = current($providerDiffs[$providerId][$field]); ?>
                                                                    <br />
                                                                    <small>Changed: <?= date('F j, Y', strtotime($diff['created'])) ?></small>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center border-0 p0 pl20">
                                                                <?= $this->Form->control("providers.$providerCount.$field", [
                                                                    'label' => false,
                                                                    'required' => false,
                                                                    'field' => $field,
                                                                    'value' => trim($provider->{$field}),
                                                                    'class' => 'w-100',
                                                                    'container' => ['class' => 'mb0']
                                                                ]) ?>
                                                            </td>
                                                            <td class="border-0 p5 pl20"><button class="js-copy-left form-control w-100" type="button">&larr;</button></td>
                                                            <td class="text-center border-0 p0 pl20">
                                                                <?php if ($isLinked): ?>
                                                                    <?= $this->Form->text("providers.$providerCount.$field", [
                                                                        'label' => false,
                                                                        'class'=>'form-control import-data w-100 '.$class,
                                                                        'field' => $field,
                                                                        'value' => trim($importProvider[$field]),
                                                                        'disabled' => 'disabled'
                                                                    ]) ?>
                                                                <?php else: ?>
                                                                    <input class="form-control import-data w-100" field="<?= $field ?>" disabled />
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
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
                                            <table class="table-condensed">
                                                <tr providerCount="<?= $providerCount ?>">
                                                    <td class="text-center">
                                                        <button type="button" class="js-add-provider form-control pull-left bi bi-arrow-left d-inline" style="width:50%;"> Add</button>
                                                        <button type="button" class="js-link yhn-link form-control pull-right bi bi-link-45deg d-inline" style="width:50%;"></button>
                                                        <button type="button" class="js-link-cancel form-control hidden bi bi-x-circle"></button>
                                                    </td>
                                                    <td colspan=4 class="text-center">
                                                        <div class="well import-well">
                                                            <span class="badge bg-warning bi bi-globe-americas" style=""><?= ' ' . Configure::read('importTag') ?></span>
                                                            <?= $importProvider->first_name.' '.$importProvider->last_name ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?= $this->Form->hidden("providers.$providerCount.id_yhn_provider", [
                                                    'class' => 'import-data',
                                                    'value' => $importProvider->id_external,
                                                    'field' => 'id_yhn_provider'
                                                ]) ?>
                                                <?php foreach ($providerFields as $field => $label): ?>
                                                    <?php
                                                    $class = "linked different";
                                                    ?>
                                                    <tr providerCount="<?= $providerCount ?>">
                                                        <td><label class="control-label w-100 tal"><?= $label ?></label></td>
                                                        <td class="text-center">
                                                            <?= $this->Form->control("providers.$providerCount.$field", [
                                                                'class' => 'w-100',
                                                                'label' => false,
                                                                'required' => false,
                                                                'field' => $field,
                                                                'value' => '',
                                                            ]) ?>
                                                        </td>
                                                        <td><button class="js-copy-left form-control w-100" type="button">&larr;</button></td>
                                                        <td class="text-center">
                                                            <?php if (!empty($importProvider->{$field})): ?>
                                                                <?= $this->Form->control("providers.$providerCount.$field", [
                                                                    'label' => false,
                                                                    'class'=>'form-control import-data w-100 '.$class,
                                                                    'field' => $field,
                                                                    'value' => trim($importProvider->{$field}),
                                                                    'disabled' => 'disabled'
                                                                ]) ?>
                                                            <?php else: ?>
                                                                <input class="form-control w-100" field="<?= $field ?>" disabled />
                                                            <?php endif; ?>
                                                        </td>
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
                            <a href="<?= $importIndexReferer ?>">
                                <input type="button" tabindex="1" value="Cancel" class="btn btn-danger btn-lg">
                            </a>
                            <input type="submit" tabindex="1" value="Complete Review" class="btn btn-primary btn-lg">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>