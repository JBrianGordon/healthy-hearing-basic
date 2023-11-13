<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CaCallGroup $caCallGroup
 */
 
use \App\Model\Entity\CaCallGroup;
use \App\Model\Entity\CaCall;
use Cake\Routing\Router;
?>
<div class="container-fluid site-body fap-cities">
	<div class="row">
		<div class="backdrop-container">
			<div class="backdrop backdrop-gradient backdrop-height"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="clear"></div>
				<header class="col-md-12 mt10">
					<div class="panel panel-light">
						<div class="panel-heading">Ca Call Groups Actions</div>
						<div class="panel-body p10">
							<div class="btn-group">
								<?= $this->Html->link(__(' Edit'), ['action' => 'edit', $caCallGroup->id], ['class' => 'btn btn-info bi bi-pencil-fill']) ?>
								<?= $this->Form->postLink(__(' Delete'), ['action' => 'delete', $caCallGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroup->id), 'class' => 'btn btn-danger bi bi-trash']) ?>
								<?= $this->Html->link(__(' Inbound Call'), ['controller' => 'CaCalls', 'action' => 'edit'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
								<?= $this->Html->link(__(' Calls from clinic'), ['controller' => 'CaCalls', 'action' => 'clinic_lookup'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
								<?= $this->Html->link(__(' Quick Pick'), ['controller' => 'CaCalls', 'action' => 'quick_pick'], ['class' => 'btn btn-success bi bi-plus-lg']) ?>
								<?= $this->Html->link(__(' Outbound Calls'), ['action' => 'outbound'], ['class' => 'btn btn-default bi bi-megaphone-fill']) ?>
								<?= $this->Html->link(__(' Calls'), ['controller' => 'CaCalls', 'action' => 'index'], ['class' => 'btn btn-default']) ?>
								<?= $this->Html->link(__(' Call Groups'), ['action' => 'index'], ['class' => 'btn btn-default']) ?>
							</div>
						</div>
					</div>
				</header>						
				<div class="col-md-12">
					<section class="panel">
						<div class="panel-body">
							<div class="panel-section expanded">					
								<h2>View Call Group</h2>
								<?= $this->Form->control('data[CaCallGroup][id]', ['type' => 'hidden', 'value' => $caCallGroup->id, 'id' => 'CaCallGroupId']) ?>
								<?= $this->Form->control('data[CaCallGroup][location_id]', ['type' => 'hidden', 'value' => $caCallGroup->id, 'id' => 'CaCallGroupId']) ?>
								<?= $this->Form->control('data[CaCallGroup][is_prospect_override]', ['type' => 'hidden', 'value' => $caCallGroup->is_prospect_override, 'id' => 'CaCallGroupIsProspectOverride']) ?>
								<div class="table-responsive">
						            <table class="table table-striped table-bordered table-condensed">
							            <tr>
								            <th class="tar">Group ID</th>
								            <td><?= h($caCallGroup->id) ?></td>
							            </tr>
						                <tr>
						                    <th class="tar">Status</th>
						                    <td><?= CaCallGroup::$statuses[$caCallGroup->status] ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Clinic</th>
						                    <td>
                                                <? if ($caCallGroup->has('location')): ?>
                                                    <?= $this->Html->link($caCallGroup->location->title, $caCallGroup->location->hh_url) ?><br>
                                                    <?= $caCallGroup->location->address ?> <?= $caCallGroup->location->address_2 ?><br><?= $caCallGroup->location->city ?> <?= $caCallGroup->location->state ?> <?= $caCallGroup->location->zip ?><br><?= $caCallGroup->location->phone ?><br><?= $caCallGroup->location->landmarks ?>
                                                <?php endif; ?>
						                    </td>
						                </tr>
						                <tr>
							                <th class="tar">Calls</th>
							                <td>
								                <table class="table table-bordered table-condensed">
									                <tbody>
										                <tr>
											                <th>ID</th>
															<th>Call time</th>
															<th>Duration</th>
															<th>Agent</th>
															<th>Call type</th>
										                </tr>
											            <?php foreach ($caCallGroup->ca_calls as $caCalls) : ?>
											                <tr>
																<td><?= $caCalls->id ?></td>
																<td>
																	<?php $startTimeEastern = $caCalls->start_time->setTimezone('America/New_York'); ?>
																	<?php echo $startTimeEastern->format('m/d/Y'); ?><br>
																	<?php echo $startTimeEastern->format('g:i a T'); ?>
																</td>
																<td><?= gmdate('H:i:s', $caCalls->duration) ?></td>
																<td><?= $this->App->getUserName($caCalls->user_id) ?></td>
																<td><?= CaCall::$callTypes[$caCalls->call_type] ?></td>
											                </tr>
											            <?php endforeach; ?>
									                </tbody>
								                </table>
							                </td>
						                <tr>
							                <th class="tar">Notes</th>
											<td>
												<div class="notes">
													<div class="single_note">
														<table cellpadding="0" cellspacing="0">
															<tbody>
																<?php foreach ($caCallGroup->ca_call_group_notes as $caCallGroupNotes) : ?>
																	<tr>
																		<td class="note_who"><?= $this->App->getUserName($caCallGroupNotes->user_id) ?></td>
																		<td class="status"><?= CaCallGroup::$statuses[$caCallGroupNotes->status] ?></td>
																		<td class="when"><?= dateTimeCentralToEastern($caCallGroupNotes->created) ?></td>
																		<td class="delete">
																			<?= $this->Form->postLink(__('Delete'), ['controller' => 'ca_call_group_notes', 'action' => 'delete', $caCallGroupNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $caCallGroup->id), 'class' => 'btn btn-danger btn-xs']) ?>	
																		</td>
																	</tr>
																	<tr>
																		<td colspan="3" class="body"><?= $caCallGroupNotes->body ?></td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>
											</td>
						                </tr>
						                <tr>
						                    <th class="tar">Refused to give name?</th>
						                    <td><?= $caCallGroup->refused_name ? __('Yes') : __('No'); ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Caller First Name</th>
						                    <td><?= h($caCallGroup->caller_first_name) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Caller Last Name</th>
						                    <td><?= h($caCallGroup->caller_last_name) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Self?</th>
						                    <td><?= $caCallGroup->is_patient ? __('Yes') : __('No'); ?></td>
						                </tr>
						                <?php if(!$caCallGroup->is_patient) : ?>
							                <tr>
							                    <th class="tar">Patient First Name</th>
							                    <td><?= h($caCallGroup->patient_first_name) ?></td>
							                </tr>
							                <tr>
							                    <th class="tar">Patient Last Name</th>
							                    <td><?= h($caCallGroup->patient_last_name) ?></td>
							                </tr>
							            <?php endif; ?>
						                <tr>
						                    <th class="tar">Caller Phone</th>
						                    <td><?= h($caCallGroup->caller_phone) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Email</th>
						                    <td><?= h($caCallGroup->email) ?></td>
						                </tr>
						                <tr>
							                <th class="tar">Topic</th>
							                <td>
												<?php
													$topics = [];
													$allTopics = array_merge(CaCallGroup::$col1Topics, CaCallGroup::$col2Topics);
													foreach ($allTopics as $topicKey => $label) {
														if ($caCallGroup[$topicKey]) {
															$topics[] = $label;
														}
													}
													echo implode(',<br>', $topics);
												?>
						                </tr>
						                <tr>
						                    <th class="tar">Prospect</th>
						                    <td><?= h($caCallGroup->prospect) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Prospect Override</th>
						                    <td><?= $caCallGroup->is_prospect_override ? __('Yes') : __('No'); ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Front Desk Name</th>
						                    <td><?= h($caCallGroup->front_desk_name) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Score</th>
						                    <td><?= h($caCallGroup->score) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Appt Date/Time</th>
						                    <td><?= h($caCallGroup->appt_date) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Next Scheduled Date/Time</th>
						                    <td><?= h($caCallGroup->scheduled_call_date) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Final Score Date/Time</th>
						                    <td><?= h($caCallGroup->final_score_date) ?></td>
						                </tr>
						                <?php if($caCallGroup->question_visit_clinic) : ?>
							                <tr>
							                    <th class="tar">Question Visit Clinic</th>
							                    <td><?= h($caCallGroup->question_visit_clinic) ?></td>
							                </tr>
							                <tr>
							                    <th class="tar">Question What For</th>
							                    <td><?= h($caCallGroup->question_what_for) ?></td>
							                </tr>
							                <tr>
							                    <th class="tar">Question Purchase</th>
							                    <td><?= h($caCallGroup->question_purchase) ?></td>
							                </tr>
							                <tr>
							                    <th class="tar">Question Brand</th>
							                    <td><?= h($caCallGroup->question_brand) ?></td>
							                </tr>
							                <tr>
							                    <th class="tar">Question Brand Other</th>
							                    <td><?= h($caCallGroup->question_brand_other) ?></td>
							                </tr>
						                <?php endif; ?>
						                <tr>
						                    <th class="tar">Needs supervisor review</th>
						                    <td><?= $caCallGroup->is_review_needed ? __('Yes') : __('No'); ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Appointment request form</th>
						                    <td><?= $caCallGroup->is_appt_request_form ? __('Yes') : __('No'); ?></td>
						                </tr>
						                <tr>
						                	<th class="tar">Traffic source</th>
						                    <td><?= h($caCallGroup->traffic_source) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Traffic medium</th>
						                    <td><?= h($caCallGroup->traffic_medium) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Call count</th>
						                    <td><?= $this->Number->format($caCallGroup->ca_call_count) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Voicemail followup count</th>
						                    <td><?= $this->Number->format($caCallGroup->vm_outbound_count) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Clinic followup count</th>
						                    <td><?= $this->Number->format($caCallGroup->clinic_followup_count) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Consumer followup count</th>
						                    <td><?= $this->Number->format($caCallGroup->patient_followup_count) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Clinic survey count</th>
						                    <td><?= $this->Number->format($caCallGroup->clinic_outbound_count) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Patient survey count</th>
						                    <td><?= $this->Number->format($caCallGroup->patient_outbound_count) ?></td>
						                </tr>
						                <tr>
						                    <th class="tar">Id Xml File</th>
						                    <td><?= h($caCallGroup->id_xml_file) ?></td>
						                </tr>
						            </table>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
