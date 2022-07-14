<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location[]|\Cake\Collection\CollectionInterface $locations
 */

use Cake\Core\Configure;
use App\Model\Entity\Location;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

$siteNameAbbr = Configure::read('siteNameAbbr');
?>
<div class="locations index content">
    <?= $this->Html->link(__('New Location'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Locations CRM') ?></h3>
    <?= $this->element('pagination') ?>
    <?= $this->element('admin_locations_search') ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th>
                        <?= $this->Paginator->sort('id') ?>
                        <?php if (Configure::read('isTieringEnabled')): ?>
                            <br><?= $this->Paginator->sort('listing_type') ?>
                        <?php endif; ?>
                        <?php if (Configure::read('isYhnImportEnabled')): ?>
                            <br><?= $this->Paginator->sort('is_cq_premier', 'CQ Premier') ?>
                            <br><?= $this->Paginator->sort('is_iris_plus', 'CQ Iris+') ?>
                        <?php endif; ?>
                    </th>
                    <th>
                        <?php if (Configure::read('isTieringEnabled')): ?>
                            <?= $this->Paginator->sort('oticon_tier', 'OTI'); ?>
                            <?= $this->Paginator->sort('yhn_tier', 'YHN'); ?><br>
                        <?php endif; ?>
                        <?php if (Configure::read('isCqpImportEnabled')): ?>
                            <?= $this->Paginator->sort('cqp_tier', 'CQP'); ?>
                        <?php endif; ?>
                        <?= $this->Paginator->sort('is_hh', $siteNameAbbr); ?><br>
                        <?= $this->Paginator->sort('is_retail', 'Retail'); ?>
                    </th>
                    <th>
                        <?= $this->Paginator->sort('is_active', 'Active');?><br />
                        <?= $this->Paginator->sort('is_show', 'Show');?><br />
                        <?php if (Configure::read('isTieringEnabled')): ?>
                            <?= $this->Paginator->sort('is_grace_period', 'Grace');?>
                        <?php endif; ?>
                    </th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th>
                        <?= $this->Paginator->sort('title');?><br>
                        <?= $this->Paginator->sort('address');?> 
                        <?= $this->Paginator->sort('city');?> 
                        <?= $this->Paginator->sort('state', ucfirst(Configure::read('stateLabel')));?> 
                        <?= $this->Paginator->sort('zip', ucfirst(Configure::read('zipLabel')));?>
                    </th>
                    <th>
                        <?= $this->Paginator->sort('phone'); ?><br>
                        <?= $this->Paginator->sort('is_call_assist', 'Call Assist');?>
                    </th>
                    <th>
                        <?= $this->Paginator->sort('last_contact_date', 'Last Contact'); ?><br>
                        <?= $this->Paginator->sort('completeness', 'Complete');?><br>
                        <?= $this->Paginator->sort('reviews_approved', 'Reviews'); ?>
                    </th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($locations as $location): ?>
                <tr>
                    <td>
                        <span class="badge bg-primary"><?= $location->id; ?></span><br />
                        <?php if (Configure::read('isTieringEnabled')): ?>
                            <?php echo $this->Clinic->badgeListingType($location->listing_type); ?><br>
                        <?php endif; ?>
                        <?php if (Configure::read('isYhnImportEnabled')): ?>
                            <?php if (!empty($location->is_cq_premier)): ?>
                                <span class='badge bg-info label-cqp'>CQ Premier</span><br>
                            <?php endif; ?>
                            <?php if (!empty($location->is_iris_plus)): ?>
                                <span class='badge bg-danger label-earq'>CQ Iris+</span><br>
                            <?php endif; ?>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if (!empty($location->is_yhn)): ?>
                            <?php if (Configure::read('isYhnImportEnabled')): ?>
                                <span class='badge bg-danger label-yhn'>YHN <?php echo $location->yhn_tier; ?></span><br>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($location->is_oticon): ?>
                            <span class='badge bg-oticon label-oticon'>OTI
                            <?php if (Configure::read('isTieringEnabled')): ?>
                                <?php echo $location->oticon_tier; ?>
                            <?php endif; ?>
                            </span><br>
                        <?php endif; ?>
                        <?php if (Configure::read('isCqpImportEnabled')): ?>
                            <?php if (!empty($location->is_cqp)): ?>
                                <span class='badge bg-info label-cqp'>CQP <?php echo $location->cqp_tier; ?></span><br>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($location->is_hh)): ?>
                            <span class='badge bg-primary label-hh'><?php echo $siteNameAbbr; ?></span><br>
                        <?php endif; ?>
                        <?php if (!empty($location->is_retail)): ?>
                            <span class='badge bg-primary'>Retail</span><br>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $location->is_active ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Active</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> Inactive</span>"; ?><br />
                        <?php echo $location->is_show ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Show</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> No Show</span>"; ?>
                        <?php if (Configure::read('isTieringEnabled')): ?>
                            <?php if ($location->oticon_tier == 3): ?>
                                <br />
                                <?php echo $location->is_grace_period ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Grace</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> No Grace</span>"; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $this->Admin->inlineAjax("Location.priority", $location); ?>
                    </td>
                    <td>
                        <?= $location->title ?><br />
                        <?= $location->address.', '.$location->city.' '.$location->state.', '.$location->zip; ?>
                    </td>
                    <td nowrap>
                        <?= formatPhoneNumber($location->phone) ?><br>
                        <?php echo $location->is_call_assist ? "<span class='badge bg-success'><span class='glyphicon glyphicon-ok'></span> Call Assist</span>" : "<span class='badge bg-danger'><span class='glyphicon glyphicon-remove'></span> Not Call Assist</span>"; ?>
                    </td>
                    <td>
                        <?php
                        if ($location->last_contact_date) {
                            echo date('m/d/Y', strtotime($location->last_contact_date)).'<br>';
                        }
                        ?>
                        <?= $location->completeness ?><br>
                        <?= $this->Clinic->badgeReview($location->reviews_approved) ?>
                    </td>
                    <td class="actions" nowrap>
                        <div class="btn-group-vertical btn-group-sm">
                            <?= $this->Html->link("<i class='bi bi-wrench'></i> Manage",
                                ['action' => 'edit', $location->id],
                                ['class' => 'btn btn-default', 'escape' => false]) ?>
                            <?= $this->Html->link(__('View'),
                                ['action' => 'view', 'prefix' => false, $location->id],
                                ['class' => 'btn btn-default']) ?>
                            <?php /*= $this->Html->link(__('Clinic Edit'),
                                ['action' => 'edit', 'prefix' => 'clinic', $location->id],
                                ['class' => 'btn btn-default']) */ ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('pagination') ?>
    <?php
    // TODO: Update this when jquery is installed. This will allow certain fields (like priority) to be editable from index page. 
    //echo $this->element('inline_ajax');
    ?>
</div>
